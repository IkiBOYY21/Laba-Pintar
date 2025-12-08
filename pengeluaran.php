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
    flash('success','Pengeluaran berhasil dicatat.');
    header('Location: '.BASE_URL.'/pengeluaran.php'); exit;
}

if(isset($_GET['del'])){
    $id = (int)$_GET['del'];
    $stmt = $conn->prepare("DELETE FROM pengeluaran WHERE id_pengeluaran = ? AND id_user = ?");
    $stmt->bind_param('ii',$id,$uid); $stmt->execute();
    flash('success','Data pengeluaran dihapus.');
    header('Location: '.BASE_URL.'/pengeluaran.php'); exit;
}

include 'includes/header.php';
$pengs = $conn->query("SELECT * FROM pengeluaran WHERE id_user = $uid ORDER BY created_at DESC");
?>

<div class="row g-4">
    <div class="col-lg-4">
        <h2 class="page-title mb-4">Pengeluaran</h2>
        <div class="card-3d-glass p-4 sticky-top" style="top: 90px;">
            <h5 class="fw-bold mb-4 text-danger"><i class="bi bi-dash-circle-fill me-2"></i>Catat Pengeluaran</h5>
            <form method="post">
                <input type="hidden" name="action" value="add">
                
                <div class="form-floating-3d mb-3">
                    <label class="form-label small fw-bold">Tanggal</label>
                    <input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>">
                </div>
                
                <div class="form-floating-3d mb-3">
                    <label class="form-label small fw-bold">Jumlah (Rp)</label>
                    <input class="form-control" name="jumlah" type="number" step="0.01" placeholder="0" required>
                </div>

                <div class="form-floating-3d mb-4">
                    <label class="form-label small fw-bold">Keterangan</label>
                    <textarea class="form-control" name="deskripsi" placeholder="Untuk keperluan apa?" style="height: 100px"></textarea>
                </div>
                
                <button class="btn btn-danger w-100 py-2 fw-bold shadow-sm" style="border-radius: 12px;">
                    <i class="bi bi-save me-2"></i> SIMPAN
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-3d-glass p-4">
            <h5 class="fw-bold mb-3 text-muted">Riwayat Pengeluaran</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light"><tr><th>Tanggal</th><th>Deskripsi</th><th>Jumlah</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                    <?php while($p = $pengs->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <?= date('d M Y', strtotime($p['tanggal'])) ?>
                            </span>
                        </td>
                        <td><?= esc($p['deskripsi']) ?></td>
                        <td class="fw-bold text-danger">Rp <?= number_format($p['jumlah'],0,',','.') ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary border-0 rounded-circle" href="<?= BASE_URL ?>/pengeluaran.php?del=<?= $p['id_pengeluaran'] ?>" onclick="return confirm('Hapus data ini?')">
                                <i class="bi bi-x-lg"></i>
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