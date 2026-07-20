<?php

namespace App\Controllers;

use App\Helpers\FlashMessageHelper;
use App\Models\PenghuniModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class LaporanPenyewaController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        if ($role != 'admin') {
            return redirect()->to('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('pages/laporan-penyewa/index', [
            'title' => 'Laporan Penyewa Kost',
            'current_role' => $role
        ]);
    }

    public function table()
    {
        $role = session()->get('role');
        if ($role != 'admin') {
            return redirect()->to('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $model = new PenghuniModel();

        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $perPage = $this->request->getGet('perPage') ?? 10;

        $dataPenghuni = $model->getPenghuni($keyword, $perPage);

        if (!empty($status)) {
            $dataPenghuni = array_filter($dataPenghuni, function ($item) use ($status) {
                return ($item['status_pemesanan'] ?? '') === $status;
            });
            $dataPenghuni = array_values($dataPenghuni);
        }

        return view('pages/laporan-penyewa/table', [
            'data_penghuni' => $dataPenghuni,
            'pager' => $model->pager,
            'current_role' => $role,
            'keyword' => $keyword,
            'status' => $status
        ]);
    }

    public function exportExcel()
    {
        $role = session()->get('role');
        if ($role != 'admin') {
            return redirect()->to('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $model = new PenghuniModel();

        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');

        $dataPenghuni = $model->getAllPenghuni($keyword);

        // Filter by status if specified
        if (!empty($status)) {
            $dataPenghuni = array_filter($dataPenghuni, function ($item) use ($status) {
                return ($item['status_pemesanan'] ?? '') === $status;
            });
            $dataPenghuni = array_values($dataPenghuni);
        }

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set page properties for A4 Landscape
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

        // Report Title - Merged cells A1:J1
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'LAPORAN PENYEWA KOST SEMUA');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Application Identity
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'Sistem Manajemen Kost - E-Kost');
        $sheet->getStyle('A2')->applyFromArray($subHeaderStyle);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Report Period
        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', 'Periode: Semua Periode');
        $sheet->getStyle('A3')->applyFromArray($subHeaderStyle);
        $sheet->getRowDimension(3)->setRowHeight(20);

        // Add filter information if any
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
        $headers = ['No', 'Nama Penyewa', 'No HP', 'Nama Kost', 'Alamat Kost', 'Nomor Kamar', 'Tipe Kamar', 'Harga Sewa', 'Tanggal Masuk', 'Status Penyewaan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $col++;
        }
        $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray($tableHeaderStyle);
        $sheet->getRowDimension($row)->setRowHeight(25);

        // Table Data
        $dataRow = $row;
        $no = 1;
        foreach ($dataPenghuni as $penghuni) {
            $dataRow++;
            $col = 'A';

            // No
            $sheet->setCellValue($col . $dataRow, $no++);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;

            // Nama Penyewa
            $sheet->setCellValue($col . $dataRow, $penghuni['nama'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // No HP
            $sheet->setCellValue($col . $dataRow, $penghuni['no_hp'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // Nama Kost
            $sheet->setCellValue($col . $dataRow, $penghuni['nama_kost'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // Alamat Kost
            $sheet->setCellValue($col . $dataRow, $penghuni['alamat_kost'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // Nomor Kamar
            $sheet->setCellValue($col . $dataRow, $penghuni['nomor_kamar'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;

            // Tipe Kamar
            $sheet->setCellValue($col . $dataRow, $penghuni['nama_tipe_kamar'] ?? '-');
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $col++;

            // Harga Sewa (Format Rupiah)
            $harga = $penghuni['harga_sewa'] ?? 0;
            $sheet->setCellValue($col . $dataRow, $harga);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $col++;

            // Tanggal Masuk
            $tanggalMasuk = !empty($penghuni['tanggal_pemesanan'])
                ? date('d/m/Y', strtotime($penghuni['tanggal_pemesanan']))
                : '-';
            $sheet->setCellValue($col . $dataRow, $tanggalMasuk);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;

            // Status Penyewaan
            $statusPemesanan = $penghuni['status_pemesanan'] ?? '-';
            $sheet->setCellValue($col . $dataRow, $statusPemesanan);
            $sheet->getStyle($col . $dataRow)->applyFromArray($tableCellStyle);
            $sheet->getStyle($col . $dataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Set row height
            $sheet->getRowDimension($dataRow)->setRowHeight(20);
        }

        // Summary Row
        $summaryRow = $dataRow + 1;
        $sheet->mergeCells('A' . $summaryRow . ':J' . $summaryRow);
        $sheet->setCellValue('A' . $summaryRow, 'Jumlah Penyewa: ' . count($dataPenghuni));
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
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set minimum column widths for better appearance
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(25);  // Nama Penyewa
        $sheet->getColumnDimension('C')->setWidth(15);  // No HP
        $sheet->getColumnDimension('D')->setWidth(25);  // Nama Kost
        $sheet->getColumnDimension('E')->setWidth(30);  // Alamat
        $sheet->getColumnDimension('F')->setWidth(12);  // No Kamar
        $sheet->getColumnDimension('G')->setWidth(15);  // Tipe Kamar
        $sheet->getColumnDimension('H')->setWidth(20);  // Harga
        $sheet->getColumnDimension('I')->setWidth(15);  // Tanggal
        $sheet->getColumnDimension('J')->setWidth(15);  // Status

        // Generate filename
        $filename = 'Laporan_Penyewa_Kost_' . date('Ymd_His') . '.xlsx';

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
