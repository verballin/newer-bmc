<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="google-translate-customization" content="9f841e7780177523-3214ceb76f765f38-gc38c6fe6f9d06436-c" />
    <title>BMC : Input Kursus</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="<?= base_url('brem/img/icon bmc.png') ?>" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet" />

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
        .tabs ul li {
            list-style-type: none;
        }

        .tabs ul li a {
            font-size: 25px;
            color: #4e4e4e !important;
            font-weight: 500;
        }

        .tabs ul li a.active {
            color: #f69050 !important;
        }

        .tabs ul li a:hover {
            color: #f69050 !important;
        }

        #more {
            display: none;
        }

        button {
            border: none;
            color: #f69050;
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <p class="m-0 fw-bold" style="font-size: 25px;"><img src="brem/img/icon bmc.png" alt="" height="50px"><span
                    style="color: #fb873f;"></span></p>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
            <?php
            $session=session();
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
                        <?php endif; ?>
                        <a href="<?= site_url('historipembelian') ?>" class="dropdown-item">Histori Pembelian</a>
                        <form action="<?= site_url('/logout') ?>" method="post" style="display: inline;">
                        <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </div>
                <?php } else { ?>
                    <a href="<?= site_url('login') ?>" class="nav-item nav-link"><i class="fa fa-user"></i></a>
                <?php } ?>
            </div>

                <a href="<?= base_url()?>" class="nav-item nav-link">Beranda</a>
                <a href="<?= site_url('about') ?>" class="nav-item nav-link">Tentang</a>
                <a href="<?= site_url('courses') ?>" class="nav-item nav-link">Kursus</a>
                <div class="nav-item dropdown">
                <?php if($isLoggedIn) { ?>
                    <a href="#" class="nav-item nav-link" data-bs-toggle="dropdown">Simulasi</a>
                        <div class="dropdown-menu fade-down m-0">
                            <?php if (session()->get('role') === 'Admin') : ?>
                            <a href="<?= site_url('infopengaturanujian') ?>" class="dropdown-item">Pengaturan Ujian</a>
                            <a href="<?= site_url('tambahsoal') ?>" class="dropdown-item">Tambah Soal Ujian</a>
                            <a href="<?= site_url('daftarsoal') ?>" class="dropdown-item">Lihat Daftar Soal Ujian</a>
                            <?php endif; ?>
                            <a href="<?= site_url('ujian') ?>" class="dropdown-item">Pilih Ujian</a>   
                        </div>
                    <?php } ?>
                </div>
                <a href="<?= site_url('contact') ?>" class="nav-item nav-link">Kontak</a>
     
                </div>
                

                <div id="google_translate_element">
                </div>


                </a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Input Kursus</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="<?= site_url('courses') ?>">Input Kursus</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

        <div class="container mt-5">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

                    <?php if (session()->getFlashdata('pesan')): ?> <?= session()->getFlashdata('pesan') ?><?php endif; ?>
            <h2>Input Data Produk Kursus</h2>
            <form method="post" action="<?= site_url('simpanPembelianProduk') ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="benefit" class="form-label">Benefit</label>
                    <input type="text" class="form-control" id="benefit" name="benefit" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga" required>
                </div>
                <div class="mb-3">
                    <label for="durasi" class="form-label">Durasi Kursus</label>
                    <input type="text" class="form-control" id="durasi" name="durasi" required>
                </div>

                <div class="mb-3">
                    <label for="about" class="form-label">About</label>
                    <textarea class="form-control" id="about" name="about" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="col-sm-3 col-form-label">Gambar</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control form-control-sm" name="gambar">
                        <small class="text-muted">Type file: JPG | JPEG | PNG </small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
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
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i> Jalan Farrel Pasaribu, Simpang GG. Rambutan Daerah, Jl. Lapangan Sepak Bola, Kec. Siantar Marihat, Kota Pematang Siantar, Sumatera Utara 21121</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>0821-6329-9216</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>kursuonline.moracollege@gmail.com</p>
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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('brem/lib/wow/wow.min.js') ?>"></script>
    <script src="<?= base_url('brem/lib/easing/easing.min.js') ?>"></script>
    <script src="<?= base_url('brem/lib/waypoints/waypoints.min.js') ?>"></script>
    <script src="<?= base_url('brem/lib/owlcarousel/owl.carousel.min.js') ?>"></script>

    <!-- Template Javascript -->
    <script src="<?= base_url('brem/js/main.js') ?>"></script>
</body>

</html>