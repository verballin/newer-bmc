<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Penjualan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Favicon -->
    <!-- <link href="<?= base_url('brem/img/icon bmc.png') ?>" rel="icon" /> -->

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

            button,
            .footer,
            .btn,
            nav,
            header {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px;
                font-size: 14px;
            }
        }
    </style>



</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="<?= base_url() ?>" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <p class="m-0 fw-bold" style="font-size: 25px;">
                <!-- <img src="<?= base_url('brem/img/icon bmc.png') ?>" alt="" height="50px"> -->
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
                                <a href="<?= site_url('laporan/user') ?>" class="dropdown-item">Laporan User</a>
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

                <?php if ($isLoggedIn): ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link" data-bs-toggle="dropdown">Simulasi</a>
                        <div class="dropdown-menu fade-down m-0">
                            <?php if (session()->get('role') === 'Admin') : ?>
                                <a href="<?= site_url('infopengaturanujian') ?>" class="dropdown-item">Pengaturan Ujian</a>
                                <a href="<?= site_url('tambahsoal') ?>" class="dropdown-item">Tambah Soal Ujian</a>
                                <a href="<?= site_url('daftarsoal') ?>" class="dropdown-item">Lihat Daftar Soal Ujian</a>
                                <a href="<?= site_url('laporan') ?>" class="dropdown-item">Lihat Laporan Nilai Ujian</a>
                            <?php endif; ?>
                            <?php if (session()->get('role') === 'Siswa') : ?>
                                <a href="<?= site_url('ujian') ?>" class="dropdown-item">Pilih Ujian</a>
                            <?php endif; ?>
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
                    <h1 class="display-3 text-white animated slideInDown">Laporan Keuntungan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Laporan Keuntungan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container mt-5">
        <h3 class="mb-4">Laporan Keuntungan</h3>
        <?php if (session()->get('role') === 'Admin'): ?>
            <button id="cetakBtn" class="btn btn-primary" onclick="window.print()">
                <i class="fa fa-print"></i> Cetak PDF
            </button>
        <?php endif; ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Nama Kursus</th>
                    <th>Harga</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan)) : ?>
                    <?php foreach ($laporan as $item) : ?>
                        <tr>
                            <td><?= esc($item['nama_user']) ?></td>
                            <td><?= esc($item['nama_kursus']) ?></td>
                            <td>Rp <?= number_format((int) preg_replace('/[^0-9]/', '', $item['harga']), 0, ',', '.') ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($item['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data pembayaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total Keuntungan</th>
                    <th colspan="2">Rp <?= number_format((float)$totalKeuntungan, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Footer Start -->
    <!-- <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
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
    </div> -->
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
</body>

</html>