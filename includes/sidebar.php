<?php
// ikiboyy21/laba-pintar/Laba-Pintar-074ca69357fb28dc6f11b9e6d279be5dd0ec7c2c/includes/sidebar.php
// Pastikan variabel $current_page dan $master_active sudah tersedia dari header.php
if (!isset($current_page) || !isset($master_active)) {
    // Fallback jika dipanggil tanpa header, meski seharusnya tidak terjadi
    $current_page = '';
    $master_active = false;
}
?>

<nav class="app-sidebar offcanvas offcanvas-start d-lg-block" tabindex="-1" id="sidebarOffcanvas">
    <div class="offcanvas-header d-lg-none">
        <h5 class="offcanvas-title fw-bold" id="offcanvasLabel">Laba Pintar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0"> 
        <h5 class="fw-bold mb-4 text-primary px-3 pt-3">Navigasi Aplikasi</h5>
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/dashboard.php"><i class="bi bi-grid-fill me-2"></i> <span class="nav-label">Dashboard</span></a></li>
                <li class="nav-item">
                    <a class="nav-link <?= $master_active ? 'active' : '' ?>" data-bs-toggle="collapse" href="#masterData" role="button" aria-expanded="<?= $master_active ? 'true' : 'false' ?>">
                        <i class="bi bi-database-fill me-2"></i> <span class="nav-label">Data Master</span> <i class="bi bi-chevron-down ms-auto" style="font-size: 12px;"></i>
                    </a>
                    <div class="collapse <?= $master_active ? 'show' : '' ?> p-0" id="masterData">
                        <ul class="nav flex-column ms-3">
                            <li><a class="nav-link py-1 <?= $current_page == 'products.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/products.php"><i class="bi bi-box me-2"></i> <span class="nav-label">Produk</span></a></li>
                            <li><a class="nav-link py-1 <?= $current_page == 'categories.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/categories.php"><i class="bi bi-tags me-2"></i> <span class="nav-label">Kategori</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'transaksi.php' || $current_page == 'detail_transaksi.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/transaksi.php"><i class="bi bi-cart-fill me-2"></i> <span class="nav-label">Transaksi</span></a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'pengeluaran.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/pengeluaran.php"><i class="bi bi-currency-dollar me-2"></i> <span class="nav-label">Pengeluaran</span></a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'laporan.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/laporan.php"><i class="bi bi-bar-chart-fill me-2"></i> <span class="nav-label">Laporan</span></a></li>
                
                <hr class="mt-4">
                <h5 class="fw-bold mb-2 text-muted small px-3">Halaman Publik</h5>
                <li class="nav-item"><a class="nav-link py-1" href="<?= BASE_URL ?>/home.php"><i class="bi bi-house-fill me-2"></i> <span class="nav-label">Home</span></a></li>
                <li class="nav-item"><a class="nav-link py-1" href="<?= BASE_URL ?>/service.php"><i class="bi bi-box-fill me-2"></i> <span class="nav-label">Services</span></a></li>
                <li class="nav-item"><a class="nav-link py-1" href="<?= BASE_URL ?>/about.php"><i class="bi bi-info-circle-fill me-2"></i> <span class="nav-label">About Us</span></a></li>
                <li class="nav-item"><a class="nav-link py-1" href="<?= BASE_URL ?>/contact.php"><i class="bi bi-envelope-fill me-2"></i> <span class="nav-label">Contact</span></a></li>

            </ul>
        </div>
    </div>
</nav>