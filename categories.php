<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']=='add'){
    $nama = $_POST['nama_kategori'];
    $des = $_POST['deskripsi'];
    $stmt = $conn->prepare("INSERT INTO kategori_produk (nama_kategori, deskripsi, created_at) VALUES (?,?,NOW())");
    $stmt->bind_param('ss',$nama,$des); $stmt->execute();
    flash('success','Kategori ditambahkan.');
    header('Location: '.BASE_URL.'/categories.php'); exit;
}

if(isset($_GET['del'])){
    $id = (int)$_GET['del'];
    $stmt = $conn->prepare("DELETE FROM kategori_produk WHERE id_kategori = ?");
    $stmt->bind_param('i',$id); $stmt->execute();
    flash('success','Kategori dihapus.');
    header('Location: '.BASE_URL.'/categories.php'); exit;
}

include 'includes/header.php';
$cats = $conn->query("SELECT * FROM kategori_produk ORDER BY created_at DESC");
?>
<h3>Kategori Produk</h3>
<form method="post" class="mb-3">
  <input type="hidden" name="action" value="add">
  <div class="row">
    <div class="col-md-4"><input class="form-control" name="nama_kategori" placeholder="Nama kategori" required></div>
    <div class="col-md-6"><input class="form-control" name="deskripsi" placeholder="Deskripsi (opsional)"></div>
    <div class="col-md-2"><button class="btn btn-success">Tambah</button></div>
  </div>
</form>

<table class="table table-sm">
<thead><tr><th>ID</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
<tbody>
<?php while($c = $cats->fetch_assoc()): ?>
<tr>
  <td><?= $c['id_kategori'] ?></td>
  <td><?= esc($c['nama_kategori']) ?></td>
  <td><?= esc($c['deskripsi']) ?></td>
  <td><a class="btn btn-sm btn-danger" href="<?= BASE_URL ?>/categories.php?del=<?= $c['id_kategori'] ?>" onclick="return confirm('Hapus?')">Hapus</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php include 'includes/footer.php'; ?>
