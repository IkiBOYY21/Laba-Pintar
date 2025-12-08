<?php
require_once 'helpers.php';
require_login();
$user = current_user();
$uid = (int)$_SESSION['user_id'];

// Data Statistik
$tot_produk = $conn->query("SELECT COUNT(*) as c FROM produk WHERE id_user = $uid")->fetch_assoc()['c'];
$tot_transaksi = $conn->query("SELECT COUNT(*) as c FROM transaksi_penjualan WHERE id_user = $uid")->fetch_assoc()['c'];
$pendapatan = $conn->query("SELECT IFNULL(SUM(total),0) as s FROM transaksi_penjualan WHERE id_user = $uid")->fetch_assoc()['s'];
$pengeluaran = $conn->query("SELECT IFNULL(SUM(jumlah),0) as s FROM pengeluaran WHERE id_user = $uid")->fetch_assoc()['s'];

include 'includes/header.php';
?>

<div class="mb-4">
    <h2 class="page-title">Dashboard Overview</h2>
    <p class="text-muted">Ringkasan performa bisnis Anda hari ini.</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="card-3d-glass p-4 h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                    <i class="bi bi-box-seam fs-2 text-success"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 text-uppercase fw-bold ls-1">Total Produk</p>
                    <h3 class="fw-bold mb-0"><?= $tot_produk ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-3d-glass p-4 h-100 position-relative overflow-hidden">
             <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                    <i class="bi bi-cart3 fs-2 text-primary"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 text-uppercase fw-bold ls-1">Total Transaksi</p>
                    <h3 class="fw-bold mb-0"><?= $tot_transaksi ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-3d-glass p-4 h-100 position-relative overflow-hidden">
             <div class="d-flex align-items-center">
                <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                    <i class="bi bi-wallet2 fs-2 text-info"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 text-uppercase fw-bold ls-1">Pendapatan</p>
                    <h4 class="fw-bold mb-0 text-truncate">Rp <?= number_format($pendapatan,0,',','.') ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-3d-glass p-4 h-100 position-relative overflow-hidden">
             <div class="d-flex align-items-center">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                    <i class="bi bi-arrow-down-circle fs-2 text-danger"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 text-uppercase fw-bold ls-1">Pengeluaran</p>
                    <h4 class="fw-bold mb-0 text-truncate">Rp <?= number_format($pengeluaran,0,',','.') ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-3d-glass p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-primary"><i class="bi bi-clock-history me-2"></i>Transaksi Terakhir</h5>
        <a href="<?= BASE_URL ?>/transaksi.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light text-uppercase small text-muted">
                <tr><th>Tanggal</th><th>Total</th><th>Catatan</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php
                $rs = $conn->query("SELECT * FROM transaksi_penjualan WHERE id_user = $uid ORDER BY created_at DESC LIMIT 5");
                if($rs->num_rows > 0):
                    while($r = $rs->fetch_assoc()):
                ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar2-week text-muted me-2"></i>
                            <span class="fw-bold"><?= date('d M Y', strtotime($r['tanggal'])) ?></span>
                        </div>
                    </td>
                    <td><span class="fw-bold text-success">Rp <?= number_format($r['total'],0,',','.') ?></span></td>
                    <td class="text-muted small fst-italic"><?= $r['catatan'] ? esc($r['catatan']) : '-' ?></td>
                    <td>
                        <a class="btn btn-sm btn-light border text-primary rounded-pill px-3 shadow-sm" href="<?= BASE_URL ?>/detail_transaksi.php?id=<?= $r['id_transaksi'] ?>">
                            <i class="bi bi-eye-fill me-1"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada transaksi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>