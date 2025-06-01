<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tentang Kami</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <!-- <link href="<?= base_url('brem/img/icon bmc.png') ?>" rel="icon"> -->

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url('brem/lib/animate/animate.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('brem/lib/owlcarousel/assets/owl.carousel.min.css') ?>" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url('brem/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= base_url('brem/css/style.css') ?>" rel="stylesheet">
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
            <!-- <p class="m-0 fw-bold" style="font-size: 25px;"><img src="brem/img/icon bmc.png" alt="" height="50px"><span
                    style="color: #fb873f;"></span></p> -->
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
                            <form action="<?= site_url('/logout') ?>" method="post" style="display: inline;">
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
                <div class="nav-item dropdown">
                    <?php if ($isLoggedIn) { ?>
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
                    <h1 class="display-3 text-white animated slideInDown">Tentang Kami</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Tentang</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start pe-3">Tentang Kami</h6>
                    <h1 class="mb-4" style="color: #fb873f;">Visi dan Misi Bimbel</h1>
                    <p class="mb-4">
                        Menjadi lembaga bimbingan belajar terdepan yang mencetak generasi unggul, berprestasi, dan berkarakter
                        melalui pembelajaran yang inovatif, inspiratif, dan berdaya saing global.
                    </p>

                    <h3 class="mb-3">Misi</h3>
                    <ul class="mb-4">
                        <li class="mb-2">Menyediakan layanan pendidikan berkualitas dengan pendekatan personal dan metode belajar yang efektif, menyenangkan, serta adaptif terhadap kebutuhan siswa.</li>
                        <li class="mb-2">Mengembangkan potensi akademik dan karakter siswa melalui program pembelajaran terpadu yang mencakup aspek kognitif, afektif, dan psikomotorik.</li>
                        <li class="mb-2">Mengintegrasikan teknologi dan inovasi pembelajaran dalam setiap kegiatan bimbingan untuk meningkatkan daya serap dan minat belajar siswa.</li>
                        <li class="mb-2">Menciptakan lingkungan belajar yang suportif, profesional, dan inspiratif guna membangun kepercayaan diri dan semangat berprestasi.</li>
                        <li class="mb-2">Menyiapkan siswa untuk menghadapi tantangan pendidikan masa kini dan masa depan, termasuk ujian masuk sekolah/kampus unggulan serta pengembangan keterampilan abad 21.</li>
                    </ul>

                </div>

            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Footer Start
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
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i></p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i></p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i></p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
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