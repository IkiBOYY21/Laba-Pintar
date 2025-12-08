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
<h3>Dashboard</h3>
<div class="row">
  <div class="col-md-3"><div class="card p-3">Produk<br><strong><?= $tot_produk ?></strong></div></div>
  <div class="col-md-3"><div class="card p-3">Transaksi<br><strong><?= $tot_transaksi ?></strong></div></div>
  <div class="col-md-3"><div class="card p-3">Pendapatan<br><strong>Rp <?= number_format($pendapatan,0,',','.') ?></strong></div></div>
  <div class="col-md-3"><div class="card p-3">Pengeluaran<br><strong>Rp <?= number_format($pengeluaran,0,',','.') ?></strong></div></div>
</div>

<h4 class="mt-4">Transaksi Terakhir</h4>
<table class="table table-sm">
  <thead><tr><th>Tanggal</th><th>Total</th><th>Catatan</th></tr></thead>
  <tbody>
    <?php
    $rs = $conn->query("SELECT * FROM transaksi_penjualan WHERE id_user = $uid ORDER BY created_at DESC LIMIT 5");
    while($r = $rs->fetch_assoc()):
    ?>
    <tr>
      <td><?= esc($r['tanggal']) ?></td>
      <td>Rp <?= number_format($r['total'],0,',','.') ?></td>
      <td><?= esc($r['catatan']) ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'includes/footer.php'; ?>
