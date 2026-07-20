<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Models\KostModel;
use App\Models\PemilikKostModel;
use App\Models\FasilitasKostModel;
use App\Models\AturanKostModel;

use App\Models\GaleriKostModel;

class KostController extends BaseController
{
    protected $kost;
    protected $fasilitas_kost;
    protected $aturan_kost;
    protected $galeri_kost;

    public function __construct()
    {
        $this->kost = new KostModel();
        $this->fasilitas_kost = new FasilitasKostModel();
        $this->aturan_kost = new AturanKostModel();
        $this->galeri_kost = new GaleriKostModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kost',
        ];

        return view('pages/kost/index', $data);
    }

    public function table()
    {
        $keyword = $this->request->getGet('keyword');
        $tipe    = $this->request->getGet('type');
        $status  = $this->request->getGet('status');
        $perPage = $this->request->getGet('perPage');

        $role = session()->get('role');
        $idUser = session()->get('user_id');
        if ($role === 'pemilik') {
            $pemilikModel = new PemilikKostModel();
            $pemilik = $pemilikModel->where('id_user', $idUser)->first();
            if ($pemilik) {
                $data = [
                    'data_kost' => $this->kost->getKostByPemilik($pemilik['id_pemilik'], $keyword, $tipe, $status, $perPage),
                    'pager'     => $this->kost->pager
                ];
            } else {
                $data = [
                    'data_kost' => [],
                    'pager'     => $this->kost->pager
                ];
            }
        } else {
            $data = [
                'data_kost' => $this->kost->GetKost($keyword, $tipe, $status, $perPage),
                'pager'     => $this->kost->pager
            ];
        }
        return view('pages/kost/table', $data);
    }

    public function Tambah()
    {
        $data = [
            'title'             => 'Tambah Kost',
            'fasilitas'         => $this->fasilitas_kost->findAll(),
            'aturan'            => $this->aturan_kost->findAll(),
        ];
        return view('pages/kost/tambah', $data);
    }

    public function Store()
    {
        $rules = [
            'nama_kost'   => 'required',
            'alamat_kost' => 'required',
            'lokasi_kost' => 'required',
            'type_kost'   => 'required',
            'total_kamar' => 'required|integer|greater_than[0]',
            'id_fasilitas' => 'required',
            'id_aturan'   => 'required',
        ];
        if (!$this->validate($rules)) {
            FlashMessageHelper::setError('Validasi gagal. Mohon periksa input.');
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $db = \Config\Database::connect();
        $db->transBegin();
        $uploadedFiles = [];
        try {
            $namaFoto = "default.png";
            $files = $this->request->getFileMultiple('foto_kost');
            if (!empty($files)) {
                foreach ($files as $index => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $ext = $file->getExtension();
                        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
                            continue;
                        }
                        if ($file->getSize() > 2 * 1024 * 1024) {
                            continue;
                        }
                        $randomName = $file->getRandomName();
                        $file->move(FCPATH . 'uploads/kost/', $randomName);
                        $uploadedFiles[] = $randomName;
                        if ($index === 0) {
                            $namaFoto = $randomName;
                        }
                    }
                }
            }
            $userId = session()->get('user_id');
            $pemilik = (new PemilikKostModel())
                ->where('id_user', $userId)
                ->first();
            if (!$pemilik) {
                throw new \Exception("Data pemilik tidak ditemukan.");
            }
            $insertData = [
                'id_pemilik'   => $pemilik['id_pemilik'],
                'nama_kost'    => $this->request->getPost('nama_kost'),
                'alamat_kost'  => $this->request->getPost('alamat_kost'),
                'lokasi_kost'  => $this->request->getPost('lokasi_kost'),
                'latitude'     => $this->request->getPost('latitude'),
                'longitude'    => $this->request->getPost('longitude'),
                'type_kost'    => $this->request->getPost('type_kost'),
                'total_kamar'  => $this->request->getPost('total_kamar'),
                'foto_kost'    => $namaFoto
            ];

            $insertResult = $this->kost->insert($insertData);
            if (!$insertResult) {
                $modelErrors = $this->kost->errors();
                throw new \Exception("Gagal insert kost: " . implode(', ', $modelErrors));
            }

            $idKost = $this->kost->getInsertID();

            if (!empty($uploadedFiles)) {
                $urutan = 0;
                foreach ($uploadedFiles as $randomName) {
                    $this->galeri_kost->insert([
                        'id_kost'   => $idKost,
                        'nama_file' => $randomName,
                        'urutan'    => $urutan
                    ]);
                    $urutan++;
                }
            }

            $fasilitas = $this->request->getPost('id_fasilitas');
            if (!empty($fasilitas)) {
                foreach ($fasilitas as $idFasilitas) {
                    $db->table('detail_fasilitas_kost')->insert([
                        'id_kost' => $idKost,
                        'id_fasilitas_kost' => $idFasilitas
                    ]);
                }
            }
            $aturan = $this->request->getPost('id_aturan');
            if (!empty($aturan)) {
                foreach ($aturan as $idAturan) {
                    $db->table('detail_aturan_kost')->insert([
                        'id_kost' => $idKost,
                        'id_aturan' => $idAturan
                    ]);
                }
            }
            $db->transCommit();
            FlashMessageHelper::setSuccess('Data kost berhasil ditambahkan. Silakan kelola kamar melalui menu "Kelola Kamar".');
            return redirect()->to(base_url('dashboard/kost'));
        } catch (\Throwable $e) {
            $db->transRollback();
            if (!empty($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    @unlink(FCPATH . 'uploads/kost/' . $file);
                }
            }
            FlashMessageHelper::setError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function detail($id)
    {
        $kostModel = new KostModel();

        $data = [
            'title' => 'Detail Kost',
            'kost'  => $kostModel->getDetailKost($id)
        ];

        return view('pages/kost/detail', $data);
    }

    public function edit($id)
    {
        if (!$this->kost) {
            FlashMessageHelper::setFlashMessage('error', 'Data kost tidak ditemukan.');
            return redirect()->to('dashboard/kost');
        }
        $data = [
            'title' => 'Edit Kost',
            'kost'  => $this->kost->getDetailKost($id),
            'fasilitas' => $this->fasilitas_kost->findAll(),
            'aturan' => $this->aturan_kost->findAll(),
        ];
        return view('pages/kost/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_kost'   => 'required',
            'alamat_kost' => 'required',
            'lokasi_kost' => 'required',
            'type_kost'   => 'required',
            'total_kamar' => 'required|integer|greater_than[0]',
            'id_fasilitas' => 'required',
            'id_aturan'   => 'required'
        ];
        if (!$this->validate($rules)) {
            FlashMessageHelper::setFlashMessage(
                'error',
                'Validasi gagal.'
            );
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $kost = $this->kost->find($id);
        if (!$kost) {
            FlashMessageHelper::setFlashMessage(
                'error',
                'Data kost tidak ditemukan.'
            );
            return redirect()->to('dashboard/kost');
        }
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $data = [
                'nama_kost'   => $this->request->getPost('nama_kost'),
                'alamat_kost' => $this->request->getPost('alamat_kost'),
                'lokasi_kost' => $this->request->getPost('lokasi_kost'),
                'latitude'    => $this->request->getPost('latitude'),
                'longitude'   => $this->request->getPost('longitude'),
                'type_kost'   => $this->request->getPost('type_kost'),
                'total_kamar' => $this->request->getPost('total_kamar')
            ];
            $file = $this->request->getFile('foto_kost');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $namaFoto = $file->getRandomName();
                $file->move(
                    FCPATH.'uploads/kost/',
                    $namaFoto
                );
                $data['foto_kost'] = $namaFoto;
                if (
                    $kost['foto_kost'] != '' &&
                    $kost['foto_kost'] != 'default.png' &&
                    file_exists(FCPATH.'uploads/kost/'.$kost['foto_kost'])
                ) {
                    unlink(
                        FCPATH.'uploads/kost/'.$kost['foto_kost']
                    );
                }
            }
            $this->kost->update($id, $data);
            $db->table('detail_fasilitas_kost')
                ->where('id_kost', $id)
                ->delete();
            $db->table('detail_aturan_kost')
                ->where('id_kost', $id)
                ->delete();
            $fasilitas = $this->request->getPost('id_fasilitas');
            if (!empty($fasilitas)) {
                foreach ($fasilitas as $idFasilitas) {
                    $db->table('detail_fasilitas_kost')
                        ->insert([
                            'id_kost' => $id,
                            'id_fasilitas_kost' => $idFasilitas
                        ]);
                }
            }
            $aturan = $this->request->getPost('id_aturan');
            if (!empty($aturan)) {
                foreach ($aturan as $idAturan) {
                    $db->table('detail_aturan_kost')
                        ->insert([
                            'id_kost' => $id,
                            'id_aturan' => $idAturan
                        ]);
                }
            }
            $db->transCommit();
            FlashMessageHelper::setFlashMessage(
                'success',
                'Data kost berhasil diupdate.'
            );
            return redirect()->to('dashboard/kost');
        } catch (\Throwable $e) {
            $db->transRollback();
            FlashMessageHelper::setFlashMessage(
                'error',
                $e->getMessage()
            );
            return redirect()->back()->withInput();
        }
    }

    public function ajaxTambahFasilitas()
    {
        $nama = $this->request->getPost('nama_fasilitas');
        $deskripsi = $this->request->getPost('deskripsi');

        if (empty($nama) || empty($deskripsi)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama dan deskripsi fasilitas wajib diisi.'
            ]);
        }

        $existing = $this->fasilitas_kost->where('nama_fasilitas', $nama)->first();
        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Fasilitas dengan nama tersebut sudah ada.'
            ]);
        }

        $id = $this->fasilitas_kost->insert([
            'nama_fasilitas' => $nama,
            'deskripsi'      => $deskripsi
        ]);

        if ($id) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Fasilitas berhasil ditambahkan.',
                'csrf_hash' => csrf_hash(),
                'data' => [
                    'id_fasilitas_kost' => $id,
                    'nama_fasilitas'    => $nama,
                    'deskripsi'         => $deskripsi
                ]
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menambahkan fasilitas.'
        ]);
    }

    public function ajaxTambahAturan()
    {
        $nama = $this->request->getPost('nama_aturan');
        $deskripsi = $this->request->getPost('deskripsi_aturan');

        if (empty($nama) || empty($deskripsi)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama dan deskripsi aturan wajib diisi.'
            ]);
        }

        $existing = $this->aturan_kost->where('nama_aturan', $nama)->first();
        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Aturan dengan nama tersebut sudah ada.'
            ]);
        }

        $id = $this->aturan_kost->insert([
            'nama_aturan'      => $nama,
            'deskripsi_aturan' => $deskripsi
        ]);

        if ($id) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Aturan berhasil ditambahkan.',
                'csrf_hash' => csrf_hash(),
                'data' => [
                    'id_aturan'      => $id,
                    'nama_aturan'    => $nama,
                    'deskripsi_aturan' => $deskripsi
                ]
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menambahkan aturan.'
        ]);
    }

    public function Delete($id)
    {
        $kost = $this->kost->find($id);
        if (!$kost) {
            return redirect()->back()->with('error', 'Data kost tidak ditemukan.');
        }
        $db = \Config\Database::connect();
        $db->transStart();
        if (!empty($kost['foto_kost'])) {
            $path = FCPATH . 'uploads/kost/' . $kost['foto_kost'];

            if (file_exists($path)) {
                unlink($path);
            }
        }
        $this->kost->hapusKost($id);
        $db->transComplete();
        if ($db->transStatus() === false) {
            FlashMessageHelper::setFlashMessage('error', 'Gagal mengupdate data kost.');
            return redirect()->back();
        }

        FlashMessageHelper::setFlashMessage('success', 'Data kost berhasil diupdate.');
        return redirect()->to('dashboard/kost');
    }
}
