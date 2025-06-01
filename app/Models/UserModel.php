<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email', 
        'password',
        'full_name',
        'role',
        'date_birth',
        'gender',
        'phone',
        'address',
        'boleh_ujian',
        'reset_password_token',
        'reset_password_token_expiry'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'username'  => 'required|min_length[3]|max_length[50]|is_unique[user.username]',
        'email'     => 'required|valid_email|is_unique[user.email]',
        'password'  => 'required|min_length[6]',
        'full_name' => 'required|min_length[3]|max_length[100]',
        'role'      => 'required|in_list[Admin,Siswa]',
        'date_birth'=> 'required|valid_date',
        'gender'    => 'required|in_list[Perempuan,Laki-Laki]',
        'phone'     => 'required|min_length[10]|max_length[20]',
        'address'   => 'required|min_length[10]'
    ];

    protected $validationMessages   = [
        'username' => [
            'is_unique' => 'Username sudah digunakan, silakan pilih username lain.'
        ],
        'email' => [
            'is_unique' => 'Email sudah terdaftar, gunakan email lain.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    // Custom methods
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getUserByEmail($email) 
    {
        return $this->where('email', $email)->first();
    }

    public function updateBolehUjian($userId, $status)
    {
        return $this->update($userId, ['boleh_ujian' => $status]);
    }
    
}