<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Home extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function inputUser()
    {
        $session = session();
        
        // Validasi input
        $validation = \Config\Services::validation();
        
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]|is_unique[user.full_name]',
            'username'  => 'required|min_length[3]|max_length[50]|is_unique[user.username]',
            'email'     => 'required|valid_email|is_unique[user.email]',
            'password'  => 'required|min_length[6]',
            'phone'     => 'required|min_length[10]|max_length[20]|is_unique[user.phone]',
            'address'   => 'required|min_length[20]|max_length[500]|is_unique[user.address]'
        ];

        $messages = [
            'full_name' => [
                'required' => 'Nama lengkap harus diisi.',
                'min_length' => 'Nama lengkap minimal 3 karakter.',
                'is_unique' => 'Nama lengkap sudah terdaftar. Silakan gunakan nama lain.'
            ],
            'username' => [
                'is_unique' => 'Username sudah terdaftar. Silakan gunakan username lain.'
            ],
            'email' => [
                'is_unique' => 'Email sudah terdaftar. Silakan gunakan email lain.'
            ],
            'password' => [
                'required' => 'Password harus diisi.',
                'min_length' => 'Password minimal 6 karakter.'
            ],
            'phone' => [
                'required' => 'Nomor telepon harus diisi.',
                'min_length' => 'Nomor telepon minimal 10 karakter.',
                'max_length' => 'Nomor telepon maksimal 20 karakter.',
                'is_unique' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.'
            ],
            'address' => [
                'required' => 'Alamat lengkap harus diisi.',
                'min_length' => 'Alamat harus diisi dengan lengkap minimal 20 karakter (nama jalan, RT/RW, kelurahan, kecamatan, kota).',
                'max_length' => 'Alamat maksimal 500 karakter.',
                'is_unique' => 'Alamat sudah terdaftar. Silakan periksa kembali alamat Anda.'
            ]
        ];

        $validation->setRules($rules, $messages);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali ke form dengan error
            $session->setFlashdata('errors', $validation->getErrors());
            $session->setFlashdata('input', $this->request->getPost());
            return redirect()->back();
        }

        // Cek manual apakah nama lengkap sudah ada
        $existingFullName = $this->userModel->where('full_name', $this->request->getPost('full_name'))->first();
        if ($existingFullName) {
            $session->setFlashdata('error', 'Nama lengkap "' . $this->request->getPost('full_name') . '" sudah terdaftar. Silakan gunakan nama lain.');
            $session->setFlashdata('input', $this->request->getPost());
            return redirect()->back();
        }

        // Cek manual apakah alamat sudah ada
        $existingAddress = $this->userModel->where('address', $this->request->getPost('address'))->first();
        if ($existingAddress) {
            $session->setFlashdata('error', 'Alamat "' . $this->request->getPost('address') . '" sudah terdaftar. Silakan periksa kembali alamat Anda.');
            $session->setFlashdata('input', $this->request->getPost());
            return redirect()->back();
        }

        // Cek manual apakah nomor telepon sudah ada
        $existingPhone = $this->userModel->where('phone', $this->request->getPost('phone'))->first();
        if ($existingPhone) {
            $session->setFlashdata('error', 'Nomor telepon "' . $this->request->getPost('phone') . '" sudah terdaftar. Silakan gunakan nomor lain.');
            $session->setFlashdata('input', $this->request->getPost());
            return redirect()->back();
        }

        // Cek manual apakah username atau email sudah ada
        $existingUser = $this->userModel->where('username', $this->request->getPost('username'))->first();
        if ($existingUser) {
            $session->setFlashdata('error', 'Username "' . $this->request->getPost('username') . '" sudah terdaftar. Silakan gunakan username lain.');
            $session->setFlashdata('input', $this->request->getPost());
            return redirect()->back();
        }

        $existingEmail = $this->userModel->where('email', $this->request->getPost('email'))->first();
        if ($existingEmail) {
            $session->setFlashdata('error', 'Email "' . $this->request->getPost('email') . '" sudah terdaftar. Silakan gunakan email lain.');
            $session->setFlashdata('input', $this->request->getPost());
            return redirect()->back();
        }

        // Jika validasi berhasil, simpan data
        $data = [
            'full_name'  => $this->request->getPost('full_name'),
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'), // Hash akan dilakukan di model
            'role'       => $this->request->getPost('role'),
            'date_birth' => $this->request->getPost('date_birth'),
            'gender'     => $this->request->getPost('gender'),
            'phone'      => $this->request->getPost('phone'),
            'address'    => $this->request->getPost('address'),
            'boleh_ujian'=> 0 // Default tidak boleh ujian untuk siswa baru
        ];

        if ($this->userModel->insert($data)) {
            $session->setFlashdata('success', 'Pendaftaran berhasil! Silakan login.');
            return redirect()->to(site_url('login'));
        } else {
            // Cek apakah error karena duplicate entry
            $error = $this->userModel->errors();
            if (!empty($error)) {
                // Jika ada error dari model validation
                $session->setFlashdata('errors', $error);
            } else {
                // Error umum database
                $session->setFlashdata('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            }
            $session->setFlashdata('input', $this->request->getPost());
            return redirect()->back();
        }
    }
}