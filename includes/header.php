<?php
require_once __DIR__ . '/../helpers.php';
$user = is_logged_in() ? current_user() : null;
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Labapintar - Sistem Keuangan UKM</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

  <style>
    /* Background blur for modal */
    .modal-backdrop.show {
        opacity: .45 !important;
        backdrop-filter: blur(5px);
    }

    /* Navbar glass effect */
    .navbar-glass {
        backdrop-filter: blur(12px);
        background: rgba(25, 25, 35, 0.60) !important;
        transition: .3s ease;
    }

    body.dark-mode .navbar-glass {
        background: rgba(255, 255, 255, 0.08) !important;
    }

    /* Dark mode toggle switch */
    .toggle-dark {
        width: 50px;
        height: 26px;
        border-radius: 20px;
        background: var(--toggle-bg);
        position: relative;
        cursor: pointer;
        transition: .3s;
    }
    .toggle-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #fff;
        position: absolute;
        top: 2px;
        left: 2px;
        transition: .3s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    body.dark-mode .toggle-dot {
        transform: translateX(24px);
    }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-glass shadow-sm py-3">
  <div class="container">

    <a class="navbar-brand fw-bold fs-4" href="<?= BASE_URL ?>/dashboard.php">
      Labapintar
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-4">

        <?php if($user): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/products.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/categories.php">Kategori</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/transaksi.php">Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pengeluaran.php">Pengeluaran</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/laporan.php">Laporan</a></li>
          <li class="nav-item">
            <a class="nav-link text-warning fw-bold" href="<?= BASE_URL ?>/auth/logout.php">
              Logout
            </a>
          </li>

        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#loginModal">
              Login
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#registerModal">
              Register
            </a>
          </li>
        <?php endif; ?>

        <!-- Dark Mode Toggle -->
        <li class="nav-item">
          <div id="darkToggle" class="toggle-dark">
            <div class="toggle-dot"></div>
          </div>
        </li>

      </ul>
    </div>
  </div>
</nav>


<div class="container mt-4">
<?php if($m = flash('success')): ?>
  <div class="alert alert-success shadow-sm"><?= esc($m) ?></div>
<?php endif; ?>

<?php if($m = flash('error')): ?>
  <div class="alert alert-danger shadow-sm"><?= esc($m) ?></div>
<?php endif; ?>
</div>



<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content card-glass">

      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Login Akun</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" action="<?= BASE_URL ?>/auth/login.php">
        <div class="modal-body">

          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control input-modern" required>
          </div>

          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control input-modern" required>
          </div>

        </div>

        <div class="modal-footer border-0">
          <button class="btn btn-primary w-100 btn-animate">Login</button>
        </div>
      </form>

    </div>
  </div>
</div>



<!-- REGISTER MODAL -->
<div class="modal fade" id="registerModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content card-glass">

      <div class="modal-header border-0">
        <h4 class="modal-title fw-bold">Buat Akun</h4>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" action="<?= BASE_URL ?>/auth/register.php">
        <div class="modal-body">

          <div class="mb-3">
            <label>Nama</label>
            <input name="nama" class="form-control input-modern" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="form-control input-modern" required>
          </div>

          <div class="mb-3">
            <label>Password</label>
            <input name="password" type="password" class="form-control input-modern" required>
          </div>

          <div class="mb-3">
            <label>No HP</label>
            <input name="no_hp" class="form-control input-modern">
          </div>

          <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control input-modern"></textarea>
          </div>

        </div>

        <div class="modal-footer border-0">
          <button class="btn btn-success w-100 btn-animate">Register</button>
        </div>
      </form>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // DARK MODE SYSTEM
  const body = document.body;
  const toggle = document.getElementById("darkToggle");

  // Load saved theme
  if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark-mode");
  }

  toggle.addEventListener("click", () => {
      body.classList.toggle("dark-mode");

      // save mode
      if (body.classList.contains("dark-mode")) {
          localStorage.setItem("theme", "dark");
      } else {
          localStorage.setItem("theme", "light");
      }
  });
</script>
