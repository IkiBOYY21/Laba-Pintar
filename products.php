<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

// add product
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action']) && $_POST['action']=='add'){
    $nama = $_POST['nama_produk'];
    $harga = (float)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $kategori = (int)$_POST['id_kategori'];
    $des = $_POST['deskripsi'];
    $stmt = $conn->prepare("INSERT INTO produk (nama_produk,harga,stok,id_kategori,id_user,deskripsi,created_at) VALUES (?,?,?,?,?,?,NOW())");
    $stmt->bind_param('sdiiss',$nama,$harga,$stok,$kategori,$uid,$des);
    $stmt->execute();
    flash('success','Produk ditambahkan.');
    header('Location: '.BASE_URL.'/products.php'); exit;
}

// delete
if(isset($_GET['del'])){
    $id = (int)$_GET['del'];
    // pastikan milik user
    $stmt = $conn->prepare("DELETE FROM produk WHERE id_produk = ? AND id_user = ?");
    $stmt->bind_param('ii',$id,$uid);
    $stmt->execute();
    flash('success','Produk dihapus (jika benar milik Anda).');
    header('Location: '.BASE_URL.'/products.php'); exit;
}

include 'includes/header.php';
$cats = $conn->query("SELECT * FROM kategori_produk");
$products = $conn->query("SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori_produk k ON p.id_kategori = k.id_kategori WHERE p.id_user = $uid");
?>
<h3>Produk</h3>

<button class="btn btn-primary mb-2" onclick="document.getElementById('form-add').classList.toggle('d-none')">Tambah Produk</button>
<div id="form-add" class="card p-3 mb-3 d-none">
  <form method="post">
    <input type="hidden" name="action" value="add">
    <div class="row">
      <div class="col-md-4"><input class="form-control" name="nama_produk" placeholder="Nama produk" required></div>
      <div class="col-md-2"><input class="form-control" name="harga" type="number" step="0.01" placeholder="Harga" required></div>
      <div class="col-md-2"><input class="form-control" name="stok" type="number" value="0" placeholder="Stok"></div>
      <div class="col-md-2">
        <select class="form-control" name="id_kategori" required>
          <option value="">Pilih kategori</option>
          <?php while($c = $cats->fetch_assoc()): ?>
            <option value="<?= $c['id_kategori'] ?>"><?= esc($c['nama_kategori']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-12 mt-2"><textarea class="form-control" name="deskripsi" placeholder="Deskripsi"></textarea></div>
      <div class="col-md-12 mt-2"><button class="btn btn-success">Simpan Produk</button></div>
    </div>
  </form>
</div>

<table class="table table-sm">
<thead><tr><th>ID</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
<tbody>
<?php while($p = $products->fetch_assoc()): ?>
<tr>
  <td><?= $p['id_produk'] ?></td>
  <td><?= esc($p['nama_produk']) ?></td>
  <td><?= esc($p['nama_kategori']) ?></td>
  <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
  <td><?= $p['stok'] ?></td>
  <td>
    <a class="btn btn-sm btn-danger" href="<?= BASE_URL ?>/products.php?del=<?= $p['id_produk'] ?>" onclick="return confirm('Hapus produk?')">Hapus</a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php include 'includes/footer.php'; ?>
