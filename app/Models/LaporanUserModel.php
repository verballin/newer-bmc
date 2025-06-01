<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanUserModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    public function getLaporanPembayaranUser()
    {
        return $this->db->table('pembayaran')
            ->select('user.username, produk.title AS kursus, pembayaran.status, pembayaran.created_at')
            ->join('user', 'user.user_id = pembayaran.user_id')
            ->join('produk', 'produk.id_produk = pembayaran.id_produk')
            ->orderBy('pembayaran.created_at', 'DESC')
            ->get()
            ->getResult();
    }
}
