<?php

namespace App\Controllers;
use App\Models\ProdukModel;
use App\Models\PembayaranModel;
use App\Models\UserModel; //menyertakan usermodel.php pada controller
use CodeIgniter\I18n\Time;

class Home extends BaseController
{
    public function index(): string
    {
        $session= session();
        $data['isLoggedIn'] = $session->get('login') === true;

        if ($data['isLoggedIn']) {
            $user = $session->get('full_name'); // Assuming you have stored the user's full name in the session
            $session->setFlashdata('pesan', 
                '<div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-check"></i> Selamat Datang, ' . $user . ' </h5>
                </div>'
            );
        }
        return view('/MainPage/index');
    }

    public function logout() {
            $session = session();
            $session->destroy(); // Correctly destroy the session
            return redirect()->to(site_url('login')); // Redirect to the login page after logout
        }

    public function ceklogin()
    {
        //tangkap varabel yang dikirim dari form login username dan password
        $session = session();
        $username = $this->request->getVar('username'); // ambil data username di database
        $password = $this->request->getVar('password'); // Get password from input
        
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && $this->verifyPassword($password, $user['password'])) {

            // Login successful
            $session->set('user_id', $user['user_id']);
            $session->set('role', $user['role']);
            $session->set('username', $user['username']);
            $session->set('full_name', $user['full_name']);
            $session->set('boleh_ujian', $user['boleh_ujian']);
            $session->set('login', true);
            return redirect()->to(base_url());

        } else {
            $session->setFlashdata('pesan', 
                                '<div class="alert alert-danger alert-dismissible">
                                 <h5><i class="icon fas fa-times"></i> Username/Password Salah</h5></div>');
         return redirect()->to(site_url('login'));
        }
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
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

    public function infocourses()
    {
        $produkModel = new ProdukModel();
        $data = [
            'title' => 'Kategori Kursus Mora College',
            'produk' => $produkModel->findAll()
        ];
        return view('/MainPage/courses', $data); // assuming view is at app/Views/courses.php
    }



    public function inputProduk()
    {
        $session = session();
        if($session->get('username') != '' && $session->get('login')==true){
        return view('MainPage/inputproduk'); // Load the input form view
        }else{
            return redirect()->to(base_url());
        }
    }
    // New method to handle the form submission
    public function simpanPembelianProduk()
    {
        $session = session();
        $produkModel = new ProdukModel();

        if (!$this->validate([
            'title' => 'required',
            'benefit' => 'required',
            'about' => 'required',
            'harga' => 'required',
            'durasi' => 'required',
            'gambar' => [
            'uploaded[gambar]',
            'mime_in[gambar,image/jpg,image/jpeg,image/png,image]',
            'max_size[gambar,2048]',
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

            // Proses upload gambar
        $gambar = $this->request->getFile('gambar');
        $gambarName = $gambar->getRandomName();
        $gambar->move('uploads/gambar_produk/', $gambarName);

        $insert = [
            'title' => $this->request->getVar('title'),
            'benefit' => $this->request->getVar('benefit'),
            'about' => $this->request->getVar('about'),
            'harga' => $this->request->getVar('harga'),
            'durasi' => $this->request->getVar('durasi'),
            'gambar' => $gambarName
        ];

        if ($produkModel->insert($insert)) {
            $session->setFlashdata('pesan', 
                                    '<div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> Data Produk Berhasil Disimpan</h5></div>');
        } else {
            $session->setFlashdata('pesan', 
                                    '<div class="alert alert-danger alert-dismissible">
                                    <h5><i class="icon fas fa-times"></i> Gagal Menyimpan Data</h5></div>');
            return redirect()->back()->withInput();
        }

        if ($session->get('username') != '' && $session->get('login') === true) {
            return redirect()->to(site_url('courses'));
        } else {
            return redirect()->to(base_url());
        }
    }

    public function historipembelian()
    {
        $session = session();
        $user_id = $session->get('user_id'); // ambil ID user dari session login
        $role = $session->get('role');

        if (!$user_id) {
            return redirect()->to(site_url('login'));
        }

        $pembayaranModel = new PembayaranModel();

        // Jika admin, ambil semua data pembelian
        if ($role === 'Admin') {
            $data['pembayaran'] = $pembayaranModel
                ->select('pembayaran.*, produk.title as produk_nama, user.full_name as user_nama')
                ->join('produk', 'produk.id_produk = pembayaran.id_produk')
                ->join('user', 'user.user_id = pembayaran.user_id') // join untuk ambil nama user
                ->orderBy('pembayaran.created_at', 'DESC')
                ->findAll();

        }else {
        // Query join pembayaran + produk
            $data['pembayaran'] = $pembayaranModel
                ->select('pembayaran.*, produk.title as produk_nama')
                ->join('produk', 'produk.id_produk = pembayaran.id_produk')
                ->where('pembayaran.user_id', $user_id)
                ->orderBy('pembayaran.created_at', 'DESC')
                ->findAll();
        }
        return view('MainPage/historipembelian', $data);
    }
    

}
