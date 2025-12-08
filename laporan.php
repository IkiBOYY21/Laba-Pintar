<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

$stmt = $conn->prepare("SELECT IFNULL(SUM(total),0) as income FROM transaksi_penjualan WHERE id_user = ? AND tanggal BETWEEN ? AND ?");
$stmt->bind_param('iss',$uid,$from,$to); $stmt->execute();
$income = $stmt->get_result()->fetch_assoc()['income'];

$stmt2 = $conn->prepare("SELECT IFNULL(SUM(jumlah),0) as expense FROM pengeluaran WHERE id_user = ? AND tanggal BETWEEN ? AND ?");
$stmt2->bind_param('iss',$uid,$from,$to); $stmt2->execute();
$expense = $stmt2->get_result()->fetch_assoc()['expense'];

$profit = $income - $expense;

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_report'])){
    $periode = $_POST['periode'] ?: ($from.' to '.$to);
    $stmt3 = $conn->prepare("INSERT INTO laporan_keuangan (periode,total_pemasukan,total_pengeluaran,laba_rugi,id_user,created_at) VALUES (?,?,?,?,?,NOW())");
    $stmt3->bind_param('sddsi',$periode,$income,$expense,$profit,$uid);
    $stmt3->execute();
    flash('success','Laporan disimpan.');
    header('Location: '.BASE_URL.'/laporan.php'); exit;
}

include 'includes/header.php';
?>
<h3>Laporan Keuangan</h3>
<form method="get" class="mb-3 row">
  <div class="col-md-3"><input class="form-control" type="date" name="from" value="<?= esc($from) ?>"></div>
  <div class="col-md-3"><input class="form-control" type="date" name="to" value="<?= esc($to) ?>"></div>
  <div class="col-md-2"><button class="btn btn-primary">Tampilkan</button></div>
</form>

<div class="card p-3 mb-3">
  <p>Periode: <strong><?= esc($from) ?> — <?= esc($to) ?></strong></p>
  <p>Pendapatan: Rp <?= number_format($income,0,',','.') ?></p>
  <p>Pengeluaran: Rp <?= number_format($expense,0,',','.') ?></p>
  <p><strong>Laba/Rugi: Rp <?= number_format($profit,0,',','.') ?></strong></p>

  <form method="post" class="mt-2">
    <input type="hidden" name="periode" value="<?= esc($from).' to '.esc($to) ?>">
    <button class="btn btn-success" name="save_report">Simpan Laporan</button>
  </form>
</div>

<h5>Laporan Tersimpan</h5>
<table class="table table-sm">
<thead><tr><th>ID</th><th>Periode</th><th>Pendapatan</th><th>Pengeluaran</th><th>Laba/Rugi</th><th>Tgl</th></tr></thead>
<tbody>
<?php
$rs = $conn->query("SELECT * FROM laporan_keuangan WHERE id_user = $uid ORDER BY created_at DESC");
while($r = $rs->fetch_assoc()):
?>
<tr>
  <td><?= $r['id_laporan'] ?></td>
  <td><?= esc($r['periode']) ?></td>
  <td>Rp <?= number_format($r['total_pemasukan'],0,',','.') ?></td>
  <td>Rp <?= number_format($r['total_pengeluaran'],0,',','.') ?></td>
  <td>Rp <?= number_format($r['laba_rugi'],0,',','.') ?></td>
  <td><?= esc($r['created_at']) ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php include 'includes/footer.php'; ?>
