<?php
require_once 'helpers.php';
require_once 'includes/header.php';
?>

<div class="content-section" id="service-section">
    
    <div class="text-center mb-5 animate-on-scroll">
        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill mb-3 fw-bold ls-1">OUR FEATURES</span>
        <h1 class="page-title display-4 fw-bold mb-3">Layanan Unggulan</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Kami menyediakan berbagai fitur canggih untuk mempermudah operasional dan pelaporan keuangan bisnis Anda.
        </p>
    </div>

    <div class="row g-4 justify-content-center">
        
        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.1s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-primary opacity-25 blur-3xl" style="width: 120px; height: 120px; filter: blur(45px); z-index: 0;"></div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="icon-wrapper mb-3 text-primary">
                        <i class="bi bi-receipt fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Pencatatan Transaksi</h5>
                    <p class="text-muted small">Mencatat setiap transaksi penjualan beserta detail produk, kuantitas, harga satuan, dan subtotal secara akurat.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.2s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-success opacity-25 blur-3xl" style="width: 120px; height: 120px; filter: blur(45px); z-index: 0;"></div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="icon-wrapper mb-3 text-success">
                        <i class="bi bi-cash-stack fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Manajemen Pengeluaran</h5>
                    <p class="text-muted small">Mencatat semua pengeluaran operasional bisnis Anda untuk perhitungan laba rugi yang komprehensif.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.3s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-warning opacity-25 blur-3xl" style="width: 120px; height: 120px; filter: blur(45px); z-index: 0;"></div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="icon-wrapper mb-3 text-warning">
                        <i class="bi bi-box-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Manajemen Stok</h5>
                    <p class="text-muted small">Kelola daftar produk, harga, kategori, dan otomatisasi pembaruan stok saat penjualan terjadi.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.4s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-info opacity-25 blur-3xl" style="width: 120px; height: 120px; filter: blur(45px); z-index: 0;"></div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="icon-wrapper mb-3 text-info">
                        <i class="bi bi-file-earmark-bar-graph fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Laporan Otomatis</h5>
                    <p class="text-muted small">Menghasilkan laporan laba rugi, total pendapatan, dan pengeluaran berdasarkan periode yang dipilih.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.5s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-danger opacity-25 blur-3xl" style="width: 120px; height: 120px; filter: blur(45px); z-index: 0;"></div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="icon-wrapper mb-3 text-danger">
                        <i class="bi bi-people-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Privasi Terjamin</h5>
                    <p class="text-muted small">Data bisnis Anda terisolasi secara aman, memastikan privasi data antar pengguna aplikasi.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card-3d-glass p-4 h-100 text-center position-relative animate-on-scroll" style="transition-delay: 0.6s;">
                <div class="position-absolute top-0 start-50 translate-middle-x bg-secondary opacity-25 blur-3xl" style="width: 120px; height: 120px; filter: blur(45px); z-index: 0;"></div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="icon-wrapper mb-3 text-secondary">
                        <i class="bi bi-moon-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Mode Gelap</h5>
                    <p class="text-muted small">Tampilan yang nyaman di mata, dapat diaktifkan kapan saja untuk sesi kerja malam hari.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* CSS Inline untuk efek hover ikon melayang */
    .icon-wrapper i {
        display: inline-block;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .card-3d-glass:hover .icon-wrapper i {
        transform: scale(1.3) translateY(-10px);
        text-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
</style>

<?php include 'includes/footer.php'; ?>