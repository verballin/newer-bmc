<?php

namespace App\Models;
use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = [
        'user_id', 'id_produk', 'full_name', 'email', 'harga', 'metode_pembayaran', 'status', 'created_at'
    ];

    public function getLaporanPenjualan()
    {
        return $this->select('produk.title AS produk_nama')
            ->selectCount("CASE WHEN pembayaran.status = 'paid' THEN 1 ELSE NULL END", 'jumlah_paid', false)
            ->selectCount("CASE WHEN pembayaran.status = 'pending' THEN 1 ELSE NULL END", 'jumlah_pending', false)
            ->join('produk', 'produk.id_produk = pembayaran.id_produk')
            ->groupBy('pembayaran.id_produk, produk.title')
            ->findAll();
    }

    public function getLaporanPembayaranBerhasil()
    {
        return $this->select('user.full_name AS nama_user, produk.title AS nama_kursus, pembayaran.harga, pembayaran.created_at')
            ->join('user', 'user.user_id = pembayaran.user_id')
            ->join('produk', 'produk.id_produk = pembayaran.id_produk')
            ->where('pembayaran.status', 'paid')
            ->orderBy('pembayaran.created_at', 'DESC')
            ->findAll();
    }
}

