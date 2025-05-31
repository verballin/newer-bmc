<?php

namespace App\Controllers;

use App\Models\NilaiModel;

class HistoriNilai extends BaseController
{
    public function index()
    {
        $userId = session()->get('id_user');

        $nilaiModel = new NilaiModel();
        $data['nilai'] = $nilaiModel->where('id_user', $userId)->findAll();

        return view('MainPage/historinilai', $data);
    }
}
