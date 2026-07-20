<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use App\Models\PemilikKostModel;
use App\Models\KonsumenModel;
use App\Models\KostModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $dashboard = new DashboardModel();

        $data = [
            'title' => 'Dashboard'
        ];

        $role = session()->get('role');
        $idUser = session()->get('user_id');

        switch ($role) {
            case 'admin':
                $data['totalKost']             = $dashboard->getTotalKost();
                $data['totalKamar']            = $dashboard->getTotalKamar();
                $data['kamarTersedia']         = $dashboard->getKamarTersedia();
                $data['permitaanSewaMenunggu'] = $dashboard->getPermitaanSewaMenunggu();
                $data['kamarTerisi']           = $dashboard->getKamarTerisi();
                $data['totalKonsumen']         = $dashboard->getTotalKonsumen();
                $data['totalPenghuni']         = $dashboard->getTotalPenghuni();
                $data['pendapatan']            = $dashboard->getTotalPendapatan();
                $data['pembayaranMenunggu']    = $dashboard->getTotalPembayaranMenunggu();
                break;

            case 'pemilik':
                $pemilikModel = new PemilikKostModel();
                $pemilik = $pemilikModel
                    ->where('id_user', $idUser)
                    ->first();

                if ($pemilik) {
                    $idPemilik = $pemilik['id_pemilik'];
                    $data['totalKost']      = $dashboard->getTotalKostPemilik($idPemilik);
                    $data['totalKamar']     = $dashboard->getTotalKamarPemilik($idPemilik);
                    $data['kamarTersedia']  = $dashboard->getKamarTersediaPemilik($idPemilik);
                    $data['kamarTerisi']    = $dashboard->getKamarTerisiPemilik($idPemilik);
                    $data['totalPenghuni']  = $dashboard->getPenghuniPemilik($idPemilik);
                    $data['pendapatan']     = $dashboard->getPendapatanPemilik($idPemilik);
                } else {
                    $data['totalKost'] = 0;
                    $data['totalKamar'] = 0;
                    $data['kamarTersedia'] = 0;
                    $data['kamarTerisi'] = 0;
                    $data['totalPenghuni'] = 0;
                    $data['pendapatan'] = 0;
                }

                break;

            case 'konsumen':

                $konsumenModel = new KonsumenModel();

                $konsumen = $konsumenModel
                    ->where('id_user', $idUser)
                    ->first();

                $data['kostPopuler'] = $dashboard->getKostPopuler(5);
                $data['mapKost']     = $dashboard->getMapKost();
                $data['filterData'] = $dashboard->getFilterData();
                $data['konsumen'] = $konsumen;
                $data['idKonsumen'] = $konsumen['id_konsumen'] ?? null;

                break;
        }

        return view('pages/index', $data);
    }

    public function searchKost()
    {
        $dashboard = new DashboardModel();
        $keyword = $this->request->getGet('keyword');
        $type_kost = $this->request->getGet('type_kost');
        $min_harga = $this->request->getGet('min_harga');
        $max_harga = $this->request->getGet('max_harga');
        $fasilitas = $this->request->getGet('fasilitas');
        $limit = $this->request->getGet('limit');
        $show_all = $this->request->getGet('show_all') === 'true';
        if (!empty($fasilitas) && is_string($fasilitas)) {
            $fasilitas = explode(',', $fasilitas);
        }

        $results = $dashboard->searchKost(
            $keyword,
            $type_kost,
            $min_harga,
            $max_harga,
            $fasilitas,
            $limit,
            $show_all
        );

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $results,
            'count' => count($results)
        ]);
    }

    public function searchKostByLocation()
    {
        $lat    = (float) $this->request->getGet('lat');
        $lng    = (float) $this->request->getGet('lng');
        $radius = (float) ($this->request->getGet('radius') ?? 5);

        $north = $this->request->getGet('north');
        $south = $this->request->getGet('south');
        $east  = $this->request->getGet('east');
        $west  = $this->request->getGet('west');

        $keyword = $this->request->getGet('keyword');
        $type    = $this->request->getGet('type_kost');
        $min     = $this->request->getGet('min_harga');
        $max     = $this->request->getGet('max_harga');

        $fasilitas = [];

        if ($this->request->getGet('fasilitas')) {
            $fasilitas = explode(',', $this->request->getGet('fasilitas'));
        }

        $dashboard_model = new DashboardModel();

        $data = $dashboard_model->searchKostByLocation(
            $lat,
            $lng,
            $radius,
            $keyword,
            $type,
            $min,
            $max,
            $fasilitas,
            $north,
            $south,
            $east,
            $west
        );

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function getFilterData()
    {
        try {
            $dashboard = new DashboardModel();
            $filterData = $dashboard->getFilterData();

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $filterData
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in getFilterData: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to load filter data',
                'data' => [
                    'types' => [],
                    'fasilitas' => [],
                    'price_range' => null
                ]
            ]);
        }
    }
}
