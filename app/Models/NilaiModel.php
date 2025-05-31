<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'nilai_id';

    public function getLaporanNilai()
    {
        return $this->db->table('nilai')
            ->select('nilai.*, user.full_name, pengaturan.nama_ujian')
            ->join('user', 'user.user_id = nilai.user_id')
            ->join('pengaturan', 'pengaturan.id_pengaturan = nilai.id_pengaturan')
            ->orderBy('nilai.tanggal', 'DESC')
            ->get()
            ->getResult();
    }
}
