<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Models\PembayaranModel;
use App\Models\DashboardModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class LaporanKeuanganController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        if ($role != 'admin') {
            return redirect()->to('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('pages/laporan-keuangan/index', [
            'title' => 'Laporan Keuangan',
            'current_role' => $role
        ]);
    }

    public function table()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $model = new PembayaranModel();

        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');
        $bulan   = $this->request->getGet('bulan');
        $tahun   = $this->request->getGet('tahun');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $dataPembayaran = $model->getPembayaran(
            $keyword,
            $status,
            $bulan,
            $tahun,
            $perPage
        );

        return view('pages/laporan-keuangan/table', [
            'data_pembayaran'   => $dataPembayaran,
            'pager'              => $model->pager,
            'current_role'      => session()->get('role'),
            'keyword'           => $keyword,
            'status'            => $status,
            'bulan'             => $bulan,
            'tahun'             => $tahun
        ]);
    }

    public function exportExcel()
    {
        $role = session()->get('role');
        if ($role != 'admin') {
            return redirect()->to('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $model = new PembayaranModel();
        $dashboard = new DashboardModel();

        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $dataPembayaran = $model->getPembayaran($keyword, $status, $bulan, $tahun);

        if (!empty($tahun)) {
            $dataPembayaran = array_filter($dataPembayaran, function ($item) use ($tahun) {
                $date = $item['tanggal_pembayaran'] ?? $item['tanggal_pemesanan'] ?? '';
                return date('Y', strtotime($date)) == $tahun;
            });
            $dataPembayaran = array_values($dataPembayaran);
        }
        $filteredTotal = array_sum(array_column($dataPembayaran, 'jumlah_pembayaran'));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        // Set margins
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setBottom(0.5);
        $sheet->getPageMargins()->setLeft(0.5);

        // Define styles
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
                'name' => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];

        $subHeaderStyle = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'name' => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];

        $tableHeaderStyle = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'name' => 'Arial',
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $tableCellStyle = [
            'font' => [
                'size' => 10,
                'name' => 'Arial'
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $totalStyle = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'name' => 'Arial'
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7E6E6']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $footerStyle = [
            'font' => [
                'size' => 9,
                'name' => 'Arial',
                'italic' => true
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT
            ]
        ];

        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'LAPORAN KEUANGAN SEMUA KOST');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Application Identity
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'Sistem Manajemen Kost - E-Kost');
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $periodeText = 'Periode: ';
        if (!empty($bulan) || !empty($tahun)) {
            $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            if (!empty($bulan)) {
                $periodeText .= $namaBulan[intval($bulan)] . ' ';
            }
            if (!empty($tahun)) {
                $periodeText .= $tahun;
            }
        } else {
            $periodeText .= 'Semua Periode';
        }

        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', $periodeText);
        $sheet->getStyle('A3')->applyFromArray($headerStyle);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $row = 4;
        if (!empty($status)) {
            $sheet->setCellValue('A' . $row, 'Status: ' . $status);
            $sheet->getStyle('A' . $row)->applyFromArray($subHeaderStyle);
            $sheet->getRowDimension($row)->setRowHeight(20);
            $row++;
        }
        if (!empty($keyword)) {
            $sheet->setCellValue('A' . $row, 'Kata Kunci: ' . $keyword);
            $sheet->getStyle('A' . $row)->applyFromArray($subHeaderStyle);
            $sheet->getRowDimension($row)->setRowHeight(20);
            $row++;
        }

        // Empty row before table
        $row++;
        $sheet->getRowDimension($row)->setRowHeight(10);

        // Table Headers
        $row++;
        $headers = ['No', 'Tanggal Pembayaran', 'Nama Penyewa', 'No HP', 'Nama Kost', 'Alamat Kost', 'Nomor Kamar', 'Jumlah Pembayaran', 'Status Pembayaran'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $col++;
        }
        $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray($tableHeaderStyle);
        $sheet->getRowDimension($row)->setRowHeight(25);

        // Table Data
        $dataRow = $row;
        $no = 1;
        foreach ($dataPembayaran as $pembayaran) {
            $dataRow++;
            $col = 'A';

            // No
            $sheet->setCellValue($col . $dataRow, $no++);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;

            // Tanggal Pembayaran
            $tanggal = !empty($pembayaran['tanggal_pembayaran'])
                ? date('d/m/Y', strtotime($pembayaran['tanggal_pembayaran']))
                : '-';
            $sheet->setCellValue($col . $dataRow, $tanggal);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;

            // Nama Penyewa
            $sheet->setCellValue($col . $dataRow, $pembayaran['nama'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // No HP
            $sheet->setCellValue($col . $dataRow, $pembayaran['no_hp'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // Nama Kost
            $sheet->setCellValue($col . $dataRow, $pembayaran['nama_kost'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // Alamat Kost
            $sheet->setCellValue($col . $dataRow, $pembayaran['alamat_kost'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // Nomor Kamar
            $sheet->setCellValue($col . $dataRow, $pembayaran['nomor_kamar'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;

            // Jumlah Pembayaran (Format Rupiah)
            $jumlah = $pembayaran['jumlah_pembayaran'] ?? 0;
            $sheet->setCellValue($col . $dataRow, $jumlah);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $col++;

            // Status Pembayaran
            $statusPembayaran = $pembayaran['status_pembayaran'] ?? 'Menunggu';
            $sheet->setCellValue($col . $dataRow, $statusPembayaran);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Set row height
            $sheet->getRowDimension($dataRow)->setRowHeight(20);
        }

        // Total Row
        $totalRow = $dataRow + 1;
        $sheet->mergeCells('A' . $totalRow . ':G' . $totalRow);
        $sheet->setCellValue('A' . $totalRow, 'TOTAL PENDAPATAN');
        $sheet->getStyle('A' . $totalRow . ':I' . $totalRow)->applyFromArray($totalStyle);
        $sheet->setCellValue('H' . $totalRow, $filteredTotal);
        $sheet->getStyle('H' . $totalRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->setCellValue('I' . $totalRow, '');
        $sheet->getRowDimension($totalRow)->setRowHeight(25);

        // Summary Row
        $summaryRow = $totalRow + 1;
        $sheet->mergeCells('A' . $summaryRow . ':I' . $summaryRow);
        $sheet->setCellValue('A' . $summaryRow, 'Jumlah Transaksi: ' . count($dataPembayaran));
        $sheet->getStyle('A' . $summaryRow)->applyFromArray($subHeaderStyle);
        $sheet->getRowDimension($summaryRow)->setRowHeight(20);

        // Footer Information
        $footerRow = $summaryRow + 2;
        $userName = session()->get('nama') ?? 'Admin';
        $tanggalCetak = date('d/m/Y H:i');

        $sheet->setCellValue('A' . $footerRow, 'Tanggal Cetak: ' . $tanggalCetak);
        $sheet->getStyle('A' . $footerRow)->applyFromArray($footerStyle);
        $sheet->getRowDimension($footerRow)->setRowHeight(15);

        $footerRow++;
        $sheet->setCellValue('A' . $footerRow, 'Dicetak Oleh: ' . $userName);
        $sheet->getStyle('A' . $footerRow)->applyFromArray($footerStyle);
        $sheet->getRowDimension($footerRow)->setRowHeight(15);

        // Auto-size columns
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set minimum column widths for better appearance
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(15);  // Tanggal
        $sheet->getColumnDimension('C')->setWidth(25);  // Nama Penyewa
        $sheet->getColumnDimension('D')->setWidth(15);  // No HP
        $sheet->getColumnDimension('E')->setWidth(25);  // Nama Kost
        $sheet->getColumnDimension('F')->setWidth(30);  // Alamat
        $sheet->getColumnDimension('G')->setWidth(12);  // No Kamar
        $sheet->getColumnDimension('H')->setWidth(20);  // Jumlah
        $sheet->getColumnDimension('I')->setWidth(15);  // Status

        // Generate filename
        $filename = 'Laporan_Keuangan_' . date('Ymd_His') . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        // Save Excel file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
