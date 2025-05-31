<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\NilaiModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanNilai extends BaseController
{
    public function index()
    {
        $laporanModel = new NilaiModel();
        $data['laporan'] = $laporanModel->getLaporanNilai();
        return view('/MainPage/laporan_nilai', $data);
    }


    public function cetakPdf()
    {
        $laporanModel = new \App\Models\NilaiModel();
        $data['laporan'] = $laporanModel->getLaporanNilai();

        // HTML render dari view
        $html = view('/MainPage/laporan_nilai_pdf', $data);

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output file PDF ke browser
        $dompdf->stream('laporan_nilai.pdf', ['Attachment' => false]);
    }
}
