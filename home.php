<?php
require_once 'helpers.php';
include 'includes/header.php';

$is_logged = is_logged_in();
?>

<div class="landing-wrapper">
    <header class="landing-header text-center">
        <div class="app-container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="landing-title-home text-white">
                        Laba Pintar: Solusi Cerdas untuk Bisnis UKM Anda
                    </h1>
                    <p class="landing-header-subtitle text-white-50">
                        Otomatisasi pencatatan, pelaporan laba rugi real-time, dan manajemen stok terintegrasi dalam satu platform yang elegan.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= BASE_URL ?>auth/register.php" class="btn btn-lg btn-light fw-bold">
                            Mulai Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="<?= BASE_URL ?>service.php" class="btn btn-lg btn-outline-light">
                            Lihat Fitur
                        </a>
                    </div>
                </div>
            </div>
            <div class="header-illustration"></div>
        </div>
    </header>

    <div class="container-fluid app-container">
        <h2 class="text-center page-title mb-5">Layanan Unggulan Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="app-card interactive-card text-center">
                    <i class="bi bi-cart-check-fill text-primary fs-2 mb-3"></i>
                    <h5 class="fw-bold">Manajemen Penjualan</h5>
                    <p class="text-muted">Catat dan lacak setiap transaksi penjualan dengan mudah dan cepat.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="app-card interactive-card text-center">
                    <i class="bi bi-bar-chart-line-fill text-success fs-2 mb-3"></i>
                    <h5 class="fw-bold">Laporan Real-time</h5>
                    <p class="text-muted">Dapatkan laporan laba rugi dan keuangan secara instan tanpa perlu perhitungan manual.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="app-card interactive-card text-center">
                    <i class="bi bi-box-seam-fill text-warning fs-2 mb-3"></i>
                    <h5 class="fw-bold">Kontrol Stok Produk</h5>
                    <p class="text-muted">Otomatisasi pembaruan stok setiap kali terjadi transaksi penjualan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>