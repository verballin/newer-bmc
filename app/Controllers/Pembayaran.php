<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\UserModel;
use App\Models\ProdukModel;

class Pembayaran extends BaseController
{
    private function isAuthorizedUser($user_id_transaksi)
    {
        $session = session();
        $user_id = $session->get('user_id');
        $role = $session->get('role');

        // Admin boleh akses semua, atau user hanya boleh akses miliknya sendiri
        return ($role === 'Admin' || $user_id === $user_id_transaksi);
    }


    public function simpanpembayaran()
    {
        $session = session();
        if ($session->get('login') !== true) {
        return redirect()->to(base_url());
        }

        $model = new PembayaranModel();
        $userModel = new UserModel();
        $produkModel = new ProdukModel(); // Tambahkan model produk

        $user_id = $this->request->getPost('user_id');
        $id_produk = $this->request->getPost('id_produk');
        

        // Ambil data user
        $user = $userModel->find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Ambil data produk
        $produk = $produkModel->find($id_produk);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Cek apakah sudah pernah beli dan statusnya 'paid'
        $sudahBeli = $model->where([
            'user_id' => $user_id,
            'id_produk' => $id_produk,
            'status' => 'paid'
        ])->first();

        
        if ($sudahBeli) {
            $session->setFlashdata('pesan',
                '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Anda sudah membeli kursus ini.</h5></div>'
            );
            return redirect()->to(site_url('historipembelian'));
        }

        $masihPending = $model->where([
        'user_id' => $user_id,
        'id_produk' => $id_produk,
        'status' => 'pending'
        ])->first();

        if ($masihPending) {
        $session->setFlashdata('pesan',
            '<div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Kamu sudah memesan Kursus tersebut, harap selesaikan pembayaran.</h5></div>'
        );
        return redirect()->to(site_url('historipembelian'));
    }


        // Siapkan data pembayaran
        $data = [
            'user_id' => $user_id,
            'id_produk' => $id_produk,
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'harga' => $produk['harga'],
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'status' => 'pending',
        ];

        // Simpan ke database
        $model->save($data);
        $id = $model->insertID();

        return redirect()->to('/pembayaran/instruksi/' . $id);
    }


    public function proses($id_produk)
    {
        $session = session();
        $user_id = $session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $produkModel = new ProdukModel();

        $user = $userModel->find($user_id);
        $produk = $produkModel->find($id_produk);

        if (!$user || !$produk) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        return view('MainPage/pembayaran', [
            'user' => $user,
            'produk' => $produk,
        ]);
    }


    public function instruksi($id)
    {
        

        $session = session();
        $userId = $session->get('user_id'); // asumsikan ini ID user login
        $userRole = $session->get('role');

        $pembayaranModel = new PembayaranModel();
        $produkModel = new ProdukModel();

        $pembayaran = $pembayaranModel->find($id);

        if (!$pembayaran) {
            return redirect()->to('/courses')->with('error', 'Data pembayaran tidak ditemukan.');
        }

        // Jika bukan admin dan bukan pemilik pembayaran, tolak akses
        if (!$this->isAuthorizedUser($pembayaran['user_id'])) {
            return redirect()->to(base_url())->with('error', 'Anda tidak berhak mengakses halaman ini.');
        }


        $produk = $produkModel->find($pembayaran['id_produk']);

        return view('MainPage/instruksipembayaran', [
            'pembayaran' => $pembayaran,
            'produk' => $produk
        ]);
    }

    
    public function updateStatus($id)
    {
        $session = session();
        if ($session->get('role') !== 'Admin') {
            return redirect()->to(site_url('historipembelian'))->with('error', 'Unauthorized');
        }

        $status = $this->request->getPost('status');
        $pembayaranModel = new PembayaranModel();

        $pembayaranModel->update($id, ['status' => $status]);

        return redirect()->to(site_url('historipembelian'))->with('success', 'Status diperbarui');
    }


    public function deletepembelian($id_pembayaran) {
        $session = session();
        if($session->get('username') != '' && $session->get('login')==true){
            $pembayaranModel = new PembayaranModel();

            $data = $pembayaranModel->find($id_pembayaran);
            if ($data) {
                    if (!$this->isAuthorizedUser($data['user_id'])) {
                    return redirect()->to('/')->with('error', 'Anda tidak berhak menghapus data ini.');
                    }


                $pembayaranModel->where('id_pembayaran', $id_pembayaran)->delete();
                $session->setFlashdata('pesan',
                    '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Data Berhasil Dihapus</h5></div>');
            } else {
                $session->setFlashdata('pesan',
                    '<div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Data tidak ditemukan</h5></div>');
            }
        return redirect()->to(site_url('historipembelian'));
        }else{
            return redirect()->to(base_url());
        }                    
    }

    public function laporanPenjualan()
    {
        $session = session();
        if ($session->get('role') !== 'Admin') {
            // Langsung tampilkan halaman error
            return view('errors/403');
        }

        $pembayaranModel = new PembayaranModel();
        $laporan = $pembayaranModel->getLaporanPenjualan();

        $kursus_terlaris = '';
        $max_paid = 0;

        foreach ($laporan as $item) {
            if ($item['jumlah_paid'] > $max_paid) {
                $max_paid = $item['jumlah_paid'];
                $kursus_terlaris = $item['produk_nama'];
            }
        }

        return view('MainPage/laporanpenjualan', [
            'laporan' => $laporan,
            'kursus_terlaris' => $kursus_terlaris
        ]);
    }

    public function laporanKeuntungan()
    {
        $session = session();
        if ($session->get('role') !== 'Admin') {
            return view('errors/403');
        }

        $pembayaranModel = new PembayaranModel();
        $laporan = $pembayaranModel->getLaporanPembayaranBerhasil();

        // Hitung total keuntungan, pastikan cast ke numerik
        $totalKeuntungan = 0;
        foreach ($laporan as $item) {
            $angka = preg_replace('/[^0-9]/', '', $item['harga']); // ambil hanya digit
            $totalKeuntungan += (int) $angka;
        }

        return view('MainPage/laporankeuntungan', [
            'laporan' => $laporan,
            'totalKeuntungan' => $totalKeuntungan
        ]);
    }


}
