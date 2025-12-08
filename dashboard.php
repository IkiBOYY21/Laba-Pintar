<?php
require_once 'helpers.php';
require_login();
$user = current_user();

// statistik untuk user saat ini (opsi C: data user terisolasi)
$uid = (int)$_SESSION['user_id'];

$tot_produk = $conn->query("SELECT COUNT(*) as c FROM produk WHERE id_user = $uid")->fetch_assoc()['c'];
$tot_transaksi = $conn->query("SELECT COUNT(*) as c FROM transaksi_penjualan WHERE id_user = $uid")->fetch_assoc()['c'];
$pendapatan = $conn->query("SELECT IFNULL(SUM(total),0) as s FROM transaksi_penjualan WHERE id_user = $uid")->fetch_assoc()['s'];
$pengeluaran = $conn->query("SELECT IFNULL(SUM(jumlah),0) as s FROM pengeluaran WHERE id_user = $uid")->fetch_assoc()['s'];

include 'includes/header.php';
?>
<h1 class="page-title">Dashboard Utama</h1>

<div class="content-section mb-4 p-4">
  <h4 class="mb-4">Ringkasan Keuangan</h4>
  <div class="row g-4">
    <div class="col-lg-3 col-md-6">
      <div class="app-card stat-card interactive-card p-3 d-flex align-items-center">
        <i class="bi bi-box-seam fs-2 text-success me-3"></i>
        <div class="value-box">
          <div class="title text-muted small">Total Produk</div>
          <div class="value fw-bold fs-4"><?= $tot_produk ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="app-card stat-card interactive-card p-3 d-flex align-items-center">
        <i class="bi bi-cart3 fs-2 text-primary me-3"></i>
        <div class="value-box">
          <div class="title text-muted small">Total Transaksi</div>
          <div class="value fw-bold fs-4"><?= $tot_transaksi ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="app-card stat-card interactive-card p-3 d-flex align-items-center">
        <i class="bi bi-graph-up-arrow fs-2 text-warning me-3"></i>
        <div class="value-box">
          <div class="title text-muted small">Pendapatan Bersih</div>
          <div class="value fw-bold fs-4">Rp <?= number_format($pendapatan,0,',','.') ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="app-card stat-card interactive-card p-3 d-flex align-items-center">
        <i class="bi bi-graph-down-arrow fs-2 text-danger me-3"></i>
        <div class="value-box">
          <div class="title text-muted small">Total Pengeluaran</div>
          <div class="value fw-bold fs-4">Rp <?= number_format($pengeluaran,0,',','.') ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="content-section">
  <h4 class="mb-3">Transaksi Terakhir (5 Data)</h4>
  <div class="table-responsive">
    <table class="table data-table table-borderless">
      <thead><tr><th>Tanggal</th><th>Total</th><th>Catatan</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php
        $rs = $conn->query("SELECT * FROM transaksi_penjualan WHERE id_user = $uid ORDER BY created_at DESC LIMIT 5");
        while($r = $rs->fetch_assoc()):
        ?>
        <tr>
          <td><?= esc($r['tanggal']) ?></td>
          <td>Rp <?= number_format($r['total'],0,',','.') ?></td>
          <td><?= esc($r['catatan']) ?></td>
          <td><a class="btn btn-sm btn-info text-white" href="<?= BASE_URL ?>/detail_transaksi.php?id=<?= $r['id_transaksi'] ?>"><i class="bi bi-eye"></i> Lihat</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>