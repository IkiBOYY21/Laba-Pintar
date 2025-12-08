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
    /* INLINE CRITICAL CSS FOR SIDEBAR LAYOUT */
    body.app-layout {
        padding-top: 0; /* Menghilangkan padding navbar default */
    }
    .app-layout #main-layout-wrapper {
        display: flex;
        flex-grow: 1;
        padding-top: 70px; /* Jarak untuk top-header */
    }
    .app-layout #main-content-area {
        flex-grow: 1;
        padding: var(--gap-desktop);
        width: 100%;
        margin-left: var(--sidebar-width, 260px); /* PENTING: Mendorong konten */
        transition: margin-left 0.3s;
    }

    .top-header-app {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 70px;
        z-index: 1030;
        padding: 0 20px 0 calc(var(--sidebar-width, 260px) + 20px);
        /* Sisanya diurus oleh style.css */
    }

    .app-sidebar {
        width: var(--sidebar-width, 260px);
        height: 100vh;
        position: fixed; /* KUNCI: Membuatnya tetap di tempat */
        top: 0;
        left: 0;
        z-index: 1030;
        padding-top: 70px;
        /* Sisanya diurus oleh style.css */
    }

    /* Toggle and other small CSS rules */
    .toggle-dark {
        width: 50px; height: 26px; border-radius: 20px; background: var(--border-color); position: relative; cursor: pointer; transition: .3s;
    }
    .toggle-dot {
        width: 22px; height: 22px; border-radius: 50%; background: #fff; position: absolute; top: 2px; left: 2px; transition: .3s; box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    body.dark-mode .toggle-dot {
        transform: translateX(24px); background: var(--primary-color);
    }
    body.dark-mode .toggle-dark {
        background: var(--border-color);
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
    
    <header class="top-header-app d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
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
    
    <?php include __DIR__ . '/sidebar.php'; // WAJIB: Memanggil konten Sidebar ?>

    <div id="main-layout-wrapper">
        <div id="main-content-area" class="container-fluid">

<?php else: ?>

    <nav class="navbar navbar-expand-lg app-navbar py-3">
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