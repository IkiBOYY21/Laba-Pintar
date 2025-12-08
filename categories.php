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

<div class="row g-4 justify-content-center">
    <div class="col-md-4">
        <h2 class="page-title mb-4">Kategori</h2>
        <div class="card-3d-glass p-4 sticky-top" style="top: 90px;">
            <h5 class="fw-bold mb-3 text-primary">Buat Kategori Baru</h5>
            <form method="post">
                <input type="hidden" name="action" value="add">
                
                <div class="form-floating-3d mb-3">
                    <label class="form-label small fw-bold">Nama Kategori</label>
                    <input class="form-control" name="nama_kategori" placeholder="Nama" required>
                </div>
                
                <div class="form-floating-3d mb-4">
                    <label class="form-label small fw-bold">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" placeholder="Deskripsi..." style="height: 80px;"></textarea>
                </div>
                
                <button class="btn btn-gradient-3d w-100 fw-bold">
                    <i class="bi bi-plus-circle me-2"></i> Tambah
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-3d-glass p-4 mt-5 mt-md-0"> <h5 class="fw-bold mb-3 text-muted">Daftar Kategori</h5>
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>Nama</th><th>Deskripsi</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                <?php while($c = $cats->fetch_assoc()): ?>
                <tr>
                    <td class="fw-bold"><?= esc($c['nama_kategori']) ?></td>
                    <td class="text-muted small"><?= esc($c['deskripsi']) ?></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-danger rounded-circle" href="<?= BASE_URL ?>/categories.php?del=<?= $c['id_kategori'] ?>" onclick="return confirm('Hapus kategori ini? (Produk terkait mungkin akan kehilangan kategori)')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>