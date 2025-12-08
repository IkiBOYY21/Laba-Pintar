<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action']) && $_POST['action']=='add'){
    $tanggal = $_POST['tanggal'] ?: date('Y-m-d');
    $des = $_POST['deskripsi'];
    $jumlah = (float)$_POST['jumlah'];

    $stmt = $conn->prepare("INSERT INTO pengeluaran (tanggal,deskripsi,jumlah,id_user,created_at) VALUES (?,?,?,?,NOW())");
    $stmt->bind_param('ssds',$tanggal,$des,$jumlah,$uid);
    $stmt->execute();
    flash('success','Pengeluaran dicatat.');
    header('Location: '.BASE_URL.'/pengeluaran.php'); exit;
}

if(isset($_GET['del'])){
    $id = (int)$_GET['del'];
    $stmt = $conn->prepare("DELETE FROM pengeluaran WHERE id_pengeluaran = ? AND id_user = ?");
    $stmt->bind_param('ii',$id,$uid); $stmt->execute();
    flash('success','Pengeluaran dihapus (jika milik Anda).');
    header('Location: '.BASE_URL.'/pengeluaran.php'); exit;
}

include 'includes/header.php';
$pengs = $conn->query("SELECT * FROM pengeluaran WHERE id_user = $uid ORDER BY created_at DESC");
?>
<h3>Pengeluaran</h3>
<form method="post" class="mb-3">
  <input type="hidden" name="action" value="add">
  <div class="row">
    <div class="col-md-3"><input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>"></div>
    <div class="col-md-5"><input class="form-control" name="deskripsi" placeholder="Deskripsi"></div>
    <div class="col-md-2"><input class="form-control" name="jumlah" type="number" step="0.01" placeholder="Jumlah" required></div>
    <div class="col-md-2"><button class="btn btn-success">Simpan</button></div>
  </div>
</form>

<table class="table table-sm">
<thead><tr><th>Tanggal</th><th>Deskripsi</th><th>Jumlah</th><th>Aksi</th></tr></thead>
<tbody>
<?php while($p = $pengs->fetch_assoc()): ?>
<tr>
  <td><?= esc($p['tanggal']) ?></td>
  <td><?= esc($p['deskripsi']) ?></td>
  <td>Rp <?= number_format($p['jumlah'],0,',','.') ?></td>
  <td><a class="btn btn-sm btn-danger" href="<?= BASE_URL ?>/pengeluaran.php?del=<?= $p['id_pengeluaran'] ?>" onclick="return confirm('Hapus?')">Hapus</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php include 'includes/footer.php'; ?>
