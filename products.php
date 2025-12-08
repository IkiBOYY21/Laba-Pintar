<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

// Handle Add Product
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action']) && $_POST['action']=='add'){
    $nama = $_POST['nama_produk'];
    $harga = (float)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $kategori = (int)$_POST['id_kategori'];
    $des = $_POST['deskripsi'];
    $stmt = $conn->prepare("INSERT INTO produk (nama_produk,harga,stok,id_kategori,id_user,deskripsi,created_at) VALUES (?,?,?,?,?,?,NOW())");
    $stmt->bind_param('sdiiss',$nama,$harga,$stok,$kategori,$uid,$des);
    $stmt->execute();
    flash('success','Produk berhasil ditambahkan.');
    header('Location: '.BASE_URL.'/products.php'); exit;
}

// Handle Delete
if(isset($_GET['del'])){
    $id = (int)$_GET['del'];
    $stmt = $conn->prepare("DELETE FROM produk WHERE id_produk = ? AND id_user = ?");
    $stmt->bind_param('ii',$id,$uid);
    $stmt->execute();
    flash('success','Produk dihapus.');
    header('Location: '.BASE_URL.'/products.php'); exit;
}

include 'includes/header.php';
$cats = $conn->query("SELECT * FROM kategori_produk ORDER BY nama_kategori ASC");
$products = $conn->query("SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori_produk k ON p.id_kategori = k.id_kategori WHERE p.id_user = $uid ORDER BY p.nama_produk ASC");
?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="sticky-top" style="top: 90px; z-index: 10;">
            <h2 class="page-title mb-4">Manajemen Produk</h2>
            
            <div class="card-3d-glass p-4">
                <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-plus-square-fill me-2"></i>Tambah Produk</h5>
                
                <form method="post">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-floating-3d mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Produk</label>
                        <input class="form-control" name="nama_produk" placeholder="Contoh: Kopi Susu" required>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="form-floating-3d mb-3">
                                <label class="form-label small fw-bold text-muted">Harga (Rp)</label>
                                <input class="form-control" name="harga" type="number" step="100" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating-3d mb-3">
                                <label class="form-label small fw-bold text-muted">Stok Awal</label>
                                <input class="form-control" name="stok" type="number" value="0" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-floating-3d mb-3">
                        <label class="form-label small fw-bold text-muted">Kategori</label>
                        <select class="form-select" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php 
                            $cats->data_seek(0); // Reset pointer
                            while($c = $cats->fetch_assoc()): 
                            ?>
                                <option value="<?= $c['id_kategori'] ?>"><?= esc($c['nama_kategori']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-floating-3d mb-4">
                        <label class="form-label small fw-bold text-muted">Deskripsi (Opsional)</label>
                        <textarea class="form-control" name="deskripsi" placeholder="Keterangan singkat..." style="height: 100px"></textarea>
                    </div>

                    <button class="btn btn-gradient-3d w-100 py-2 fw-bold shadow-sm">
                        <i class="bi bi-save me-2"></i> SIMPAN PRODUK
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-3d-glass p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-muted mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Produk</h5>
                <span class="badge bg-primary rounded-pill"><?= $products->num_rows ?> Items</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = $products->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold text-dark"><?= esc($p['nama_produk']) ?></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary border"><?= esc($p['nama_kategori']) ?></span></td>
                            <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
                            <td class="text-center">
                                <?php if($p['stok'] <= 5): ?>
                                    <span class="badge bg-danger">Low: <?= $p['stok'] ?></span>
                                <?php else: ?>
                                    <span class="fw-bold text-muted"><?= $p['stok'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-danger border-0 rounded-circle" href="<?= BASE_URL ?>/products.php?del=<?= $p['id_produk'] ?>" onclick="return confirm('Hapus produk ini?')">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>