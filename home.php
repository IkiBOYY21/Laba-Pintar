<?php
require_once 'helpers.php';
include 'includes/header.php';

$is_logged = is_logged_in();
?>

<div class="landing-wrapper">
    <header class="landing-hero text-center" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('Assets/img/bg_home.png');">
        <div class="app-container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="landing-title-home">
                        Laba Pintar: Solusi Cerdas untuk Bisnis UKM Anda
                    </h1>
                    <p class="landing-header-subtitle">
                        Otomatisasi pencatatan, pelaporan laba rugi real-time, dan manajemen stok terintegrasi dalam satu platform yang elegan.
                    </p>
                    <div class="d-flex justify-content-center gap-3 mb-5">
                        <a href="<?= BASE_URL ?>auth/register.php" class="btn btn-lg btn-primary fw-bold px-4 py-3 interactive-button">
                            Mulai Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="<?= BASE_URL ?>service.php" class="btn btn-lg btn-outline-light px-4 py-3 interactive-button">
                            Lihat Fitur
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                                    </div>
            </div>
            </div>
    </header>

    <div class="container-fluid app-container py-5">
        <h2 class="text-center page-title mb-5">Layanan Unggulan Kami</h2>
        <div class="row g-5"> 
            <div class="col-md-4">
                <div class="app-card interactive-card p-4 h-100 feature-hover"> 
                    <i class="bi bi-cart-check-fill text-primary fs-1 mb-3"></i> 
                    <h5 class="fw-bold text-color">Manajemen Penjualan</h5>
                    <p class="text-muted small">Catat dan lacak setiap transaksi penjualan dengan mudah dan cepat.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="app-card interactive-card p-4 h-100 feature-hover">
                    <i class="bi bi-bar-chart-line-fill text-success fs-1 mb-3"></i>
                    <h5 class="fw-bold text-color">Laporan Real-time</h5>
                    <p class="text-muted small">Dapatkan laporan laba rugi dan keuangan secara instan tanpa perlu perhitungan manual.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="app-card interactive-card p-4 h-100 feature-hover">
                    <i class="bi bi-box-seam-fill text-warning fs-1 mb-3"></i>
                    <h5 class="fw-bold text-color">Kontrol Stok Produk</h5>
                    <p class="text-muted small">Otomatisasi pembaruan stok setiap kali terjadi transaksi penjualan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>