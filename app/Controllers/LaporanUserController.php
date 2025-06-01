<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Controllers\BaseController;
use App\Models\LaporanUserModel;


class LaporanUserController extends BaseController
{
    public function index()
    {
        $model = new LaporanUserModel();
        $data['laporan'] = $model->getLaporanPembayaranUser();
        return view('/MainPage/laporan_user', $data);
    }


    public function cetakPdf()
    {
        $userModel = new \App\Models\UserModel();
        $data['users'] = $userModel->findAll(); // ambil semua user

        $html = view('/MainPage/laporan_user_pdf', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('laporan_user.pdf', ['Attachment' => false]); // tampilkan di browser
    }
}
