<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $DBGroup = 'default';

    public function getTotalKost()
    {
        return $this->db->table('kost')->countAllResults();
    }

    public function getTotalKamar()
    {
        return $this->db->table('kamar')->countAllResults();
    }

    public function getKamarTersedia()
    {
        return $this->db->table('kamar')
            ->where('status_ketersediaan', 'Tersedia')
            ->countAllResults();
    }

    public function getPermitaanSewaMenunggu()
    {
        return $this->db->table('pemesanan')
            ->where('status_pemesanan', 'Menunggu')
            ->countAllResults();
    }

    public function getKamarTerisi()
    {
        return $this->db->table('kamar')
            ->where('status_ketersediaan', 'Terisi')
            ->countAllResults();
    }

    public function getTotalKonsumen()
    {
        return $this->db->table('konsumen')->countAllResults();
    }

    public function getTotalPenghuni()
    {
        return $this->db->table('pemesanan')
            ->where('status_pemesanan', 'Disetujui')
            ->countAllResults();
    }

    public function getTotalPendapatan()
    {
        return $this->db->table('pembayaran')
            ->selectSum('jumlah_pembayaran')
            ->where('status_pembayaran', 'Disetujui')
            ->get()
            ->getRow()
            ->jumlah_pembayaran ?? 0;
    }

    public function getTotalPembayaranMenunggu()
    {
        return $this->db->table('pembayaran')
            ->where('status_pembayaran', 'Menunggu')
            ->countAllResults();
    }

    public function getTotalKostPemilik($idPemilik)
    {
        return $this->db->table('kost')
            ->where('id_pemilik', $idPemilik)
            ->countAllResults();
    }

    public function getTotalKamarPemilik($idPemilik)
    {
        return $this->db->table('kamar')
            ->join('kost', 'kost.id_kost=kamar.id_kost')
            ->where('kost.id_pemilik', $idPemilik)
            ->countAllResults();
    }

    public function getKamarTersediaPemilik($idPemilik)
    {
        return $this->db->table('kamar')
            ->join('kost', 'kost.id_kost=kamar.id_kost')
            ->where('kost.id_pemilik', $idPemilik)
            ->where('status_ketersediaan', 'Tersedia')
            ->countAllResults();
    }

    public function getKamarTerisiPemilik($idPemilik)
    {
        return $this->db->table('kamar')
            ->join('kost', 'kost.id_kost=kamar.id_kost')
            ->where('kost.id_pemilik', $idPemilik)
            ->where('status_ketersediaan', 'Terisi')
            ->countAllResults();
    }

    public function getPenghuniPemilik($idPemilik)
    {
        // Penyewa aktif dihitung dari tabel pemesanan yang statusnya Disetujui
        return $this->db->table('pemesanan')
            ->join('kost', 'kost.id_kost=pemesanan.id_kost')
            ->where('kost.id_pemilik', $idPemilik)
            ->where('status_pemesanan', 'Disetujui')
            ->countAllResults();
    }

    public function getPendapatanPemilik($idPemilik)
    {
        return $this->db->table('pembayaran')
            ->selectSum('jumlah_pembayaran')
            ->join('pemesanan', 'pemesanan.id_pemesanan=pembayaran.id_pemesanan')
            ->join('kost', 'kost.id_kost=pemesanan.id_kost')
            ->where('kost.id_pemilik', $idPemilik)
            ->where('status_pembayaran', 'Disetujui')
            ->get()
            ->getRow()
            ->jumlah_pembayaran ?? 0;
    }

    public function getKostPopuler($limit = 6)
    {
        return $this->db->table('kost')
            ->select("
                kost.id_kost,
                kost.nama_kost,
                kost.alamat_kost,
                kost.lokasi_kost,
                kost.latitude,
                kost.longitude,
                kost.foto_kost,
                kost.type_kost,
                MIN(kamar.harga_sewa) as harga,
                COUNT(DISTINCT kamar.id_kamar) as total_kamar,
                SUM(CASE WHEN kamar.status_ketersediaan='Tersedia' THEN 1 ELSE 0 END) as kamar_tersedia,
                GROUP_CONCAT(DISTINCT fasilitas_kost.nama_fasilitas SEPARATOR ', ') as fasilitas
            ")
            ->join('kamar', 'kamar.id_kost=kost.id_kost', 'left')
            ->join('detail_fasilitas_kost', 'detail_fasilitas_kost.id_kost=kost.id_kost', 'left')
            ->join('fasilitas_kost', 'fasilitas_kost.id_fasilitas_kost=detail_fasilitas_kost.id_fasilitas_kost', 'left')
            ->where('kost.foto_kost IS NOT NULL')
            ->where('kost.foto_kost !=', '')
            ->groupBy('kost.id_kost')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function searchKost($keyword = null, $type_kost = null, $min_harga = null, $max_harga = null, $fasilitas = null, $limit = null, $show_all = false)
    {
        $builder = $this->db->table('kost')
            ->select("
                kost.id_kost,
                kost.nama_kost,
                kost.alamat_kost,
                kost.lokasi_kost,
                kost.latitude,
                kost.longitude,
                kost.foto_kost,
                kost.type_kost,
                MIN(kamar.harga_sewa) as harga,
                COUNT(DISTINCT kamar.id_kamar) as total_kamar,
                SUM(CASE WHEN kamar.status_ketersediaan='Tersedia' THEN 1 ELSE 0 END) as kamar_tersedia,
                GROUP_CONCAT(DISTINCT fasilitas_kost.nama_fasilitas SEPARATOR ', ') as fasilitas
            ")
            ->join('kamar', 'kamar.id_kost=kost.id_kost', 'left')
            ->join('detail_fasilitas_kost', 'detail_fasilitas_kost.id_kost=kost.id_kost', 'left')
            ->join('fasilitas_kost', 'fasilitas_kost.id_fasilitas_kost=detail_fasilitas_kost.id_fasilitas_kost', 'left')
            ->groupBy('kost.id_kost');

        // Search by keyword
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('kost.nama_kost', $keyword)
                ->orLike('kost.alamat_kost', $keyword)
                ->orLike('kost.lokasi_kost', $keyword)
                ->groupEnd();
        }

        // Filter by type
        if (!empty($type_kost)) {
            $builder->where('kost.type_kost', $type_kost);
        }

        // Filter by facilities - use WHERE IN with subquery to avoid HAVING clause issues
        if (!empty($fasilitas) && is_array($fasilitas)) {
            // Filter kosts that have ALL selected facilities
            foreach ($fasilitas as $fasilitas_item) {
                $builder->where("kost.id_kost IN (
                    SELECT detail_fasilitas_kost.id_kost 
                    FROM detail_fasilitas_kost 
                    WHERE detail_fasilitas_kost.id_fasilitas_kost = '{$fasilitas_item}'
                )", null, false);
            }
        }

        // Filter by price range - use HAVING clause for MIN aggregation
        if (!empty($min_harga) && is_numeric($min_harga)) {
            $builder->having('harga >=', $min_harga);
        }
        if (!empty($max_harga) && is_numeric($max_harga)) {
            $builder->having('harga <=', $max_harga);
        }

        // Apply limit unless show_all is true
        if (!$show_all && !empty($limit)) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    public function searchKostByLocation(
        $lat,
        $lng,
        $radius_km = 5,
        $keyword = null,
        $type_kost = null,
        $min_harga = null,
        $max_harga = null,
        $fasilitas = null,
        $north = null,
        $south = null,
        $east = null,
        $west = null
    ) {
        $builder = $this->db->table('kost')
            ->select("
            kost.id_kost,
            kost.nama_kost,
            kost.alamat_kost,
            kost.lokasi_kost,
            kost.latitude,
            kost.longitude,
            kost.foto_kost,
            kost.type_kost,
            MIN(kamar.harga_sewa) as harga,
            COUNT(DISTINCT kamar.id_kamar) as total_kamar,
            SUM(CASE WHEN kamar.status_ketersediaan='Tersedia' THEN 1 ELSE 0 END) as kamar_tersedia,
            GROUP_CONCAT(DISTINCT fasilitas_kost.nama_fasilitas SEPARATOR ', ') as fasilitas,
            (
                6371 * ACOS(
                    COS(RADIANS(" . (float)$lat . "))
                    * COS(RADIANS(kost.latitude))
                    * COS(RADIANS(kost.longitude) - RADIANS(" . (float)$lng . "))
                    + SIN(RADIANS(" . (float)$lat . "))
                    * SIN(RADIANS(kost.latitude))
                )
            ) AS distance
        ")
            ->join('kamar', 'kamar.id_kost = kost.id_kost', 'left')
            ->join('detail_fasilitas_kost', 'detail_fasilitas_kost.id_kost = kost.id_kost', 'left')
            ->join('fasilitas_kost', 'fasilitas_kost.id_fasilitas_kost = detail_fasilitas_kost.id_fasilitas_kost', 'left')
            ->groupBy('kost.id_kost');

        // Filter by bounding box if provided
        if (
            $north !== null &&
            $south !== null &&
            $east !== null &&
            $west !== null
        ) {
            $builder->where('kost.latitude >=', (float)$south);
            $builder->where('kost.latitude <=', (float)$north);
            $builder->where('kost.longitude >=', (float)$west);
            $builder->where('kost.longitude <=', (float)$east);
        } else {
            // Fallback to radius-based search
            $builder->having('distance <=', (float)$radius_km);
        }

        // Filter by keyword
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('kost.nama_kost', $keyword)
                ->orLike('kost.alamat_kost', $keyword)
                ->orLike('kost.lokasi_kost', $keyword)
                ->groupEnd();
        }

        // Filter by type
        if (!empty($type_kost)) {
            $builder->where('kost.type_kost', $type_kost);
        }

        // Filter by facilities
        if (!empty($fasilitas) && is_array($fasilitas)) {
            $builder->whereIn('detail_fasilitas_kost.id_fasilitas_kost', $fasilitas);
        }

        // Filter by min price
        if (!empty($min_harga) && is_numeric($min_harga)) {
            $builder->having('harga >=', (float)$min_harga);
        }

        // Filter by max price
        if (!empty($max_harga) && is_numeric($max_harga)) {
            $builder->having('harga <=', (float)$max_harga);
        }

        try {
            return $builder
                ->orderBy('distance', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'SearchKostByLocation Error: ' . $e->getMessage());
            return [];
        }
    }

    public function getMapKost()
    {
        return $this->db->table('kost')
            ->select('id_kost,nama_kost,latitude,longitude,alamat_kost')
            ->get()
            ->getResultArray();
    }

    public function getFilterData()
    {
        try {
            $types = $this->db->table('kost')
                ->select('type_kost')
                ->where('type_kost IS NOT NULL')
                ->where('type_kost !=', '')
                ->groupBy('type_kost')
                ->orderBy('type_kost', 'ASC')
                ->get()
                ->getResultArray();

            $fasilitas = $this->db->table('fasilitas_kost')
                ->select('id_fasilitas_kost, nama_fasilitas')
                ->orderBy('nama_fasilitas', 'ASC')
                ->get()
                ->getResultArray();

            // Ambil range harga
            $priceRange = $this->db->table('kamar')
                ->select('MIN(harga_sewa) AS min_price, MAX(harga_sewa) AS max_price')
                ->where('harga_sewa >', 0)
                ->get()
                ->getRowArray();

            return [
                'types'       => $types,
                'fasilitas'   => $fasilitas,
                'price_range' => $priceRange
            ];

        } catch (\Throwable $e) {

            log_message('error', 'getFilterData : ' . $e->getMessage());

            return [
                'types'       => [],
                'fasilitas'   => [],
                'price_range' => [
                    'min_price' => 0,
                    'max_price' => 0
                ]
            ];
        }
    }
}
