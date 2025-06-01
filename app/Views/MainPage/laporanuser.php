<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>BMC : Laporan User</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Favicon -->
    <link href="<?= base_url('brem/img/icon bmc.png') ?>" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url('brem/lib/animate/animate.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('brem/lib/owlcarousel/assets/owl.carousel.min.css') ?>" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url('brem/css/bootstrap.min.css') ?>" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="<?= base_url('brem/css/style.css') ?>" rel="stylesheet" />

    <style>
    @media print {
        button, .footer, .btn, nav, header, .page-header {
            display: none !important;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 30px;
        }

        .print-header h1 {
            margin: 0;
            font-size: 24px;
            color: #000;
        }

        .print-header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .summary-stats {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            border: 1px solid #000;
            padding: 15px;
        }

        .summary-stats div {
            text-align: center;
        }

        .print-date {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }
    }

    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .stat-item {
        text-align: center;
        padding: 15px;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        margin: 0 10px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .print-header {
        display: none;
    }

    .badge-admin {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .badge-siswa {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .table-responsive {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-top: none;
    }

    .table td {
        vertical-align: middle;
    }

    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    </style>
</head>

<body>
    <!-- Print Header (Only visible when printing) -->
    <div class="print-header">
        <h1>LAPORAN DATA USER</h1>
        <p>Bimbel Mora College (BMC)</p>
        <p>Jalan Farrel Pasaribu, Pematang Siantar, Sumatera Utara</p>
        <div class="print-date">
            Tanggal Cetak: <?= date('d F Y, H:i') ?> WIB
        </div>
    </div>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="<?= base_url() ?>" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <p class="m-0 fw-bold" style="font-size: 25px;">
                <img src="<?= base_url('brem/img/icon bmc.png') ?>" alt="" height="50px">
            </p>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <?php
                $session = session();
                $isLoggedIn = $session->get('login') === true;
                ?>
                <div class="nav-item dropdown">
                    <?php if ($isLoggedIn) { ?>
                        <a href="#" class="nav-item nav-link" data-bs-toggle="dropdown"><i class="fa fa-user"></i></a>
                        <div class="dropdown-menu fade-down m-0">
                            <?php if (session()->get('role') === 'Admin') : ?>
                                <a href="<?= site_url('kelolauser') ?>" class="dropdown-item">Kelola User</a>
                                <a href="<?= site_url('inputproduk') ?>" class="dropdown-item">Input Produk</a>
                                <a href="<?= site_url('laporanpenjualan') ?>" class="dropdown-item">Laporan Penjualan</a>
                                <a href="<?= site_url('laporankeuntungan') ?>" class="dropdown-item">Laporan Keuntungan</a>
                                <a href="<?= site_url('laporanuser') ?>" class="dropdown-item">Laporan User</a>
                            <?php endif; ?>
                            <a href="<?= site_url('historipembelian') ?>" class="dropdown-item">Histori Pembelian</a>
                            <form action="<?= site_url('/logout') ?>" method="post">
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    <?php } else { ?>
                        <a href="<?= site_url('login') ?>" class="nav-item nav-link"><i class="fa fa-user"></i></a>
                    <?php } ?>
                </div>

                <a href="<?= base_url() ?>" class="nav-item nav-link">Beranda</a>
                <a href="<?= site_url('about') ?>" class="nav-item nav-link">Tentang</a>
                <a href="<?= site_url('courses') ?>" class="nav-item nav-link">Kursus</a>

                <?php if($isLoggedIn): ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link" data-bs-toggle="dropdown">Simulasi</a>
                        <div class="dropdown-menu fade-down m-0">
                            <?php if (session()->get('role') === 'Admin') : ?>
                                <a href="<?= site_url('infopengaturanujian') ?>" class="dropdown-item">Pengaturan Ujian</a>
                                <a href="<?= site_url('tambahsoal') ?>" class="dropdown-item">Tambah Soal Ujian</a>
                                <a href="<?= site_url('daftarsoal') ?>" class="dropdown-item">Lihat Daftar Soal Ujian</a>
                            <?php endif; ?>
                            <a href="<?= site_url('ujian') ?>" class="dropdown-item">Pilih Ujian</a>
                        </div>
                    </div>
                <?php endif; ?>

                <a href="<?= site_url('contact') ?>" class="nav-item nav-link">Kontak</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Laporan User</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Laporan User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container mt-5">
        <?php if (session()->get('role') === 'Admin'): ?>
            
            <!-- Summary Statistics -->
            <div class="summary-card">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number"><?= count($users ?? []) ?></span>
                            <span class="stat-label">Total User</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number"><?= count(array_filter($users ?? [], fn($u) => $u['role'] === 'Admin')) ?></span>
                            <span class="stat-label">Admin</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number"><?= count(array_filter($users ?? [], fn($u) => $u['role'] === 'Siswa')) ?></span>
                            <span class="stat-label">Siswa</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number"><?= count(array_filter($users ?? [], fn($u) => $u['boleh_ujian'] == 1)) ?></span>
                            <span class="stat-label">Boleh Ujian</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">Data User Terdaftar</h3>
                        <small class="text-muted">Total: <?= count($users ?? []) ?> user</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <button id="cetakBtn" class="btn btn-primary" onclick="window.print()">
                            <i class="fa fa-print"></i> Cetak PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- User Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Status Ujian</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)) : ?>
                            <?php $no = 1; foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($user['username']) ?></td>
                                    <td><?= esc($user['full_name']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td>
                                        <span class="badge-<?= strtolower($user['role']) ?>">
                                            <?= esc($user['role']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($user['date_birth'])) ?></td>
                                    <td><?= esc($user['gender']) ?></td>
                                    <td><?= esc($user['phone']) ?></td>
                                    <td><?= esc($user['address']) ?></td>
                                    <td>
                                        <?php if ($user['boleh_ujian'] == 1): ?>
                                            <span class="badge bg-success">Diizinkan</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Belum Diizinkan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d-m-Y H:i', strtotime($user['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada data user.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary Statistics for Print -->
            <div class="summary-stats" style="display: none;">
                <div>
                    <strong>Total User:</strong><br>
                    <?= count($users ?? []) ?>
                </div>
                <div>
                    <strong>Admin:</strong><br>
                    <?= count(array_filter($users ?? [], fn($u) => $u['role'] === 'Admin')) ?>
                </div>
                <div>
                    <strong>Siswa:</strong><br>
                    <?= count(array_filter($users ?? [], fn($u) => $u['role'] === 'Siswa')) ?>
                </div>
                <div>
                    <strong>Boleh Ujian:</strong><br>
                    <?= count(array_filter($users ?? [], fn($u) => $u['boleh_ujian'] == 1)) ?>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Akses Ditolak!</h4>
                <p>Maaf, halaman ini hanya dapat diakses oleh Administrator.</p>
                <hr>
                <p class="mb-0"><a href="<?= base_url() ?>" class="btn btn-primary">Kembali ke Beranda</a></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-3">Tautan Cepat</h4>
                    <p><a class="text-light" href="<?= site_url('about') ?>">Tentang Kami</a></p>
                    <p><a class="text-light" href="<?= site_url('contact') ?>">Hubungi Kami</a></p>
                    <p><a class="text-light" href="<?= site_url('courses') ?>">Kursus</a></p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-3">Kontak</h4>
                    <p><i class="fa fa-map-marker-alt me-3"></i> Jalan Farrel Pasaribu, Pematang Siantar, Sumatera Utara</p>
                    <p><i class="fa fa-phone-alt me-3"></i> 0821-6329-9216</p>
                    <p><i class="fa fa-envelope me-3"></i> kursuonline.moracollege@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href="https://x.com/CollegeMora"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/moracollege/"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="<?= base_url('brem/lib/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('brem/lib/wow/wow.min.js') ?>"></script>
    <script src="<?= base_url('brem/lib/easing/easing.min.js') ?>"></script>
    <script src="<?= base_url('brem/lib/waypoints/waypoints.min.js') ?>"></script>
    <script src="<?= base_url('brem/lib/owlcarousel/owl.carousel.min.js') ?>"></script>
    <script src="<?= base_url('brem/js/main.js') ?>"></script>

    <script>
        // Auto-hide alerts
        window.setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 1500);

        // Print function
        function printReport() {
            window.print();
        }

        // Add print event listener for better formatting
        window.addEventListener('beforeprint', function() {
            document.querySelector('.summary-stats').style.display = 'flex';
        });

        window.addEventListener('afterprint', function() {
            document.querySelector('.summary-stats').style.display = 'none';
        });
    </script>
</body>
</html>