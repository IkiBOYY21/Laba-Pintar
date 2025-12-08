<?php
// ikiboyy21/laba-pintar/Laba-Pintar-074ca69357fb28dc6f11b9e6d279be5dd0ec7c2c/includes/header.php

require_once __DIR__ . '/../helpers.php';
$user = is_logged_in() ? current_user() : null;
$page_dir = explode('/', $_SERVER['PHP_SELF']);
$current_page = end($page_dir);

$master_active = ($current_page == 'products.php' || $current_page == 'categories.php');
// Halaman yang menggunakan layout Sidebar (Setelah Login)
$app_pages = ['dashboard.php', 'products.php', 'categories.php', 'transaksi.php', 'pengeluaran.php', 'laporan.php', 'detail_transaksi.php'];
$is_app_page = $user && in_array($current_page, $app_pages);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Labapintar - Sistem Keuangan UKM</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

  <style>
    /* ATURAN UNTUK DARK MODE TOGGLE (TETAP DI SINI KARENA CRITICAL) */
    .toggle-dark {
        width: 50px; height: 26px; border-radius: 20px; background: var(--border-color); position: relative; cursor: pointer; transition: .3s;
    }
    .toggle-dot {
        width: 22px; height: 22px; border-radius: 50%; background: #fff; position: absolute; top: 2px; left: 2px; transition: .3s; box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    body.dark-mode .toggle-dot {
        transform: translateX(24px); 
        background: var(--text-color); 
    }
    body.dark-mode .toggle-dark {
        background: var(--primary-light); 
    }
  </style>
</head>

<body class="<?= $is_app_page ? 'app-layout' : '' ?>">
<script>
  const body = document.body;
  if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark-mode");
  }
</script>

<?php if($is_app_page): ?>
    
    <?php include __DIR__ . '/sidebar.php'; // WAJIB: Memanggil konten Sidebar ?>
    
    <div id="app-content-wrapper"> 

        <header class="top-header-app d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                
                <button type="button" id="sidebarToggleDesktop" class="btn btn-sm btn-outline-primary d-none d-lg-block me-3">
                    <i class="bi bi-list"></i>
                </button>
                
                <button class="btn btn-sm btn-outline-primary d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-bold fs-5 text-primary d-none d-lg-block">Laba Pintar</span> </div>
            
            <div class="d-flex align-items-center gap-3">
                <span class="user-info d-none d-lg-inline text-muted small">Halo, <?= esc($user['nama']) ?></span>
                
                <div id="darkToggle" class="toggle-dark">
                    <div class="toggle-dot"></div>
                </div>

                <a class="btn btn-sm btn-danger" href="<?= BASE_URL ?>/auth/logout.php">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </header>

        <div id="main-layout-wrapper">
            <div id="main-content-area" class="container-fluid">

<?php else: ?>

    <nav class="navbar navbar-expand-lg app-navbar py-3">
        <div class="app-container">
            <a class="navbar-brand fw-bold text-primary" href="<?= BASE_URL ?>home.php">Laba Pintar</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link <?= $current_page == 'home.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current_page == 'service.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>service.php">Service</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current_page == 'about.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current_page == 'contact.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>contact.php">Contact</a></li>
                    
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <div class="d-flex">
                            <a href="<?= BASE_URL ?>auth/login.php" class="btn btn-outline-primary fw-bold me-2">Login</a>
                            <a href="<?= BASE_URL ?>auth/register.php" class="btn btn-primary fw-bold">Daftar</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid app-container mt-4">

<?php endif; ?>

<?php if(is_logged_in() || !$is_app_page): ?>
    <?php if($m = flash('success')): ?>
      <div class="alert alert-success shadow-sm mt-3"><i class="bi bi-check-circle-fill me-2"></i><?= esc($m) ?></div>
    <?php endif; ?>

    <?php if($m = flash('error')): ?>
      <div class="alert alert-danger shadow-sm mt-3"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc($m) ?></div>
    <?php endif; ?>
<?php endif; ?>