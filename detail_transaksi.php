<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id) { header('Location: '.BASE_URL.'/transaksi.php'); exit; }

// pastikan transaksi milik user
$r = $conn->query("SELECT * FROM transaksi_penjualan WHERE id_transaksi = $id AND id_user = $uid")->fetch_assoc();
if(!$r){ flash('error','Transaksi tidak ditemukan.'); header('Location: '.BASE_URL.'/transaksi.php'); exit; }

$details = $conn->query("SELECT dt.*, p.nama_produk FROM detail_transaksi dt JOIN produk p ON dt.id_produk = p.id_produk WHERE dt.id_transaksi = $id");
include '/header.php';
?>
<h3>Detail Transaksi #<?= $id ?></h3>
<p>Tanggal: <?= esc($r['tanggal']) ?> | Total: Rp <?= number_format($r['total'],0,',','.') ?></p>
<table class="table table-sm">
<thead><tr><th>Produk</th><th>Harga Satuan</th><th>Qty</th><th>Subtotal</th></tr></thead>
<tbody>
<?php while($d = $details->fetch_assoc()): ?>
<tr>
  <td><?= esc($d['nama_produk']) ?></td>
  <td>Rp <?= number_format($d['harga_satuan'],0,',','.') ?></td>
  <td><?= $d['jumlah'] ?></td>
  <td>Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php include '/footer.php'; ?>
