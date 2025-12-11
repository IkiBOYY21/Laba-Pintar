<?php
// FILE: detail_transaksi.php
// Pastikan path helpers benar (menggunakan __DIR__ agar lebih aman)
require_once __DIR__ . '/helpers.php';
require_login();

$uid = (int)$_SESSION['user_id'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validasi: Jika tidak ada ID, kembalikan ke halaman transaksi
if(!$id) { 
    header('Location: '.BASE_URL.'/transaksi.php'); 
    exit; 
}

// 1. Ambil Data Header Transaksi
$queryTrans = $conn->prepare("SELECT * FROM transaksi_penjualan WHERE id_transaksi = ? AND id_user = ?");
$queryTrans->bind_param('ii', $id, $uid);
$queryTrans->execute();
$transaksi = $queryTrans->get_result()->fetch_assoc();

// Jika transaksi tidak ditemukan
if(!$transaksi){ 
    flash('error','Transaksi tidak ditemukan.'); 
    header('Location: '.BASE_URL.'/transaksi.php'); 
    exit; 
}

// 2. Ambil Data Detail Item
$queryItems = $conn->prepare("
    SELECT dt.*, p.nama_produk 
    FROM detail_transaksi dt 
    JOIN produk p ON dt.id_produk = p.id_produk 
    WHERE dt.id_transaksi = ?
");
$queryItems->bind_param('i', $id);
$queryItems->execute();
$items = $queryItems->get_result();

// --- BARIS 13 YANG SAYA PERBAIKI ---
// Hapus tanda '/' di depan agar tidak mencari di C:/
include 'includes/header.php'; 
?>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="<?= BASE_URL ?>/transaksi.php" class="text-decoration-none text-muted small mb-2 d-inline-block">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
                <h2 class="page-title mb-0">Detail Transaksi</h2>
            </div>
            <button onclick="window.print()" class="btn btn-outline-primary rounded-pill px-4 d-print-none">
                <i class="bi bi-printer me-2"></i> Cetak Invoice
            </button>
        </div>

        <div class="card-3d-glass p-0 overflow-hidden">
            
            <div class="p-4 border-bottom bg-light bg-opacity-10">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill mb-3">
                            SUKSES
                        </span>
                        <h1 class="fw-bold text-primary mb-1">#<?= $transaksi['id_transaksi'] ?></h1>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-calendar-event me-1"></i> 
                            <?= date('d F Y, H:i', strtotime($transaksi['created_at'])) ?>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <p class="text-muted small mb-1 text-uppercase ls-1 fw-bold">Total Pembayaran</p>
                        <h2 class="fw-bold text-dark mb-0">Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></h2>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light text-uppercase small text-muted">
                            <tr>
                                <th style="width: 40%;">Produk</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($item = $items->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($item['nama_produk']) ?></div>
                                </td>
                                <td class="text-end text-muted">
                                    Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?>
                                </td>
                                <td class="text-center fw-bold">
                                    <?= $item['jumlah'] ?>
                                </td>
                                <td class="text-end fw-bold text-primary">
                                    Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <td colspan="3" class="text-end pt-4 pb-0 text-muted small text-uppercase fw-bold">Grand Total</td>
                                <td class="text-end pt-4 pb-0 fw-bold fs-5 text-dark">
                                    Rp <?= number_format($transaksi['total'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if(!empty($transaksi['catatan'])): ?>
                <div class="mt-4 p-3 bg-secondary bg-opacity-10 rounded-3 border border-secondary border-opacity-10">
                    <h6 class="fw-bold text-muted mb-2"><i class="bi bi-sticky me-2"></i>Catatan Transaksi</h6>
                    <p class="mb-0 small text-muted fst-italic">"<?= esc($transaksi['catatan']) ?>"</p>
                </div>
                <?php endif; ?>

            </div>

            <div class="bg-light bg-opacity-25 p-3 text-center border-top">
                <p class="mb-0 small text-muted">Terima kasih telah berbelanja di Laba Pintar.</p>
            </div>
        </div>

    </div>
</div>

<style>
@media print {
    .app-sidebar, .top-header-app, .d-print-none, .btn { display: none !important; }
    #app-content-wrapper { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
    .card-3d-glass { box-shadow: none !important; border: 1px solid #ddd !important; }
    body { background-color: white !important; }
}
</style>

<?php 
// Perbaikan Footer
include 'includes/footer.php'; 
?>