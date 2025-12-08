<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

// --- LOGIC PHP (TIDAK BERUBAH) ---
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_transaksi'])){
    $tanggal = $_POST['tanggal'] ?: date('Y-m-d');
    $catatan = $_POST['catatan'];
    $products = $_POST['produk']; 
    $qtys = $_POST['qty']; 

    $total = 0;
    $items = [];
    for($i=0;$i<count($products);$i++){
        $pid = (int)$products[$i];
        $q = (int)$qtys[$i];
        if($q <= 0) continue;
        $row = $conn->query("SELECT harga, stok FROM produk WHERE id_produk = $pid AND id_user = $uid")->fetch_assoc();
        if(!$row) continue;
        $harga = (float)$row['harga'];
        $subtotal = $harga * $q;
        $items[] = ['id'=>$pid,'qty'=>$q,'harga'=>$harga,'subtotal'=>$subtotal,'stok'=>$row['stok']];
        $total += $subtotal;
    }

    if(count($items) == 0){
        flash('error','Tidak ada item valid untuk transaksi.');
    } else {
        $stmt_trans = $conn->prepare("INSERT INTO transaksi_penjualan (tanggal,total,id_user,catatan,created_at) VALUES (?,?,?,?,NOW())");
        $stmt_trans->bind_param('sdss',$tanggal,$total,$uid,$catatan);
        $stmt_trans->execute();
        $trans_id = $stmt_trans->insert_id;
        $stmt_trans->close();

        $stmtDetail = $conn->prepare("INSERT INTO detail_transaksi (id_transaksi,id_produk,jumlah,harga_satuan,subtotal,created_at) VALUES (?,?,?,?,?,NOW())");
        foreach($items as $it){
            if($it['stok'] < $it['qty']) continue; 
            $stmtDetail->bind_param('iiidd',$trans_id, $it['id'], $it['qty'], $it['harga'], $it['subtotal']);
            $stmtDetail->execute();
            
            $stmtUp = $conn->prepare("UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND id_user = ?");
            $stmtUp->bind_param('iii', $it['qty'], $it['id'], $uid);
            $stmtUp->execute();
            $stmtUp->close();
        }
        $stmtDetail->close();
        flash('success','Transaksi berhasil disimpan! ID: #'.$trans_id);
        header('Location: '.BASE_URL.'/transaksi.php'); exit;
    }
}

include 'includes/header.php';
$products_rs = $conn->query("SELECT id_produk, nama_produk, harga, stok FROM produk WHERE id_user = $uid AND stok > 0 ORDER BY nama_produk");
$products_data = $products_rs->fetch_all(MYSQLI_ASSOC);
$trans = $conn->query("SELECT * FROM transaksi_penjualan WHERE id_user = $uid ORDER BY created_at DESC LIMIT 10"); // Limit 10 agar tidak terlalu panjang
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-0">Transaksi Baru</h2>
        <p class="text-muted small">Input penjualan dan kelola keranjang belanja.</p>
    </div>
    <div class="text-end d-none d-md-block">
        <span class="badge bg-primary fs-6 rounded-pill px-3 py-2 shadow-sm">
            <i class="bi bi-calendar-event me-2"></i> <?= date('d F Y') ?>
        </span>
    </div>
</div>

<form method="post" id="frmTrans">
    <input type="hidden" name="create_transaksi" value="1">
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-3d-glass p-4 mb-4">
                <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-cart-plus me-2"></i>Keranjang Belanja</h5>
                
                <div class="row mb-2 d-none d-md-flex text-muted small fw-bold text-uppercase ls-1">
                    <div class="col-md-5">Produk</div>
                    <div class="col-md-2">Qty</div>
                    <div class="col-md-4">Subtotal</div>
                    <div class="col-md-1"></div>
                </div>

                <div id="items" data-products='<?= htmlspecialchars(json_encode($products_data), ENT_QUOTES, 'UTF-8') ?>'>
                    <div class="row g-3 align-items-center item-row item-card-row mx-0">
                        <div class="col-md-5 form-floating-3d">
                            <select class="form-select product-select" name="produk[]" required style="cursor: pointer;">
                                <option value="" data-harga="0" data-stok="0">-- Pilih Produk --</option>
                                <?php foreach($products_data as $p): ?>
                                <option value="<?= $p['id_produk'] ?>" data-harga="<?= $p['harga'] ?>" data-stok="<?= $p['stok'] ?>">
                                    <?= esc($p['nama_produk']) ?> (Rp <?= number_format($p['harga'],0,',','.') ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 form-floating-3d">
                            <input class="form-control qty-input text-center fw-bold" name="qty[]" type="number" value="1" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control subtotal-output bg-transparent border-0 fw-bold text-primary fs-5" type="text" readonly value="Rp 0">
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-circle remove-item shadow-sm" style="width: 35px; height: 35px;">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" id="addItem" class="btn btn-outline-primary fw-bold rounded-pill px-4 border-2">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Baris
                    </button>
                </div>
            </div>

            <div class="card-3d-glass p-4">
                <h5 class="fw-bold mb-3 text-muted"><i class="bi bi-clock-history me-2"></i>Riwayat Terakhir</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light"><tr><th>ID</th><th>Tgl</th><th>Total</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php while($t = $trans->fetch_assoc()): ?>
                        <tr>
                            <td><span class="badge bg-secondary rounded-pill">#<?= $t['id_transaksi'] ?></span></td>
                            <td><?= date('d/m/y', strtotime($t['tanggal'])) ?></td>
                            <td class="fw-bold text-success">Rp <?= number_format($t['total'],0,',','.') ?></td>
                            <td><a class="btn btn-sm btn-light text-primary border rounded-pill px-3" href="<?= BASE_URL ?>/detail_transaksi.php?id=<?= $t['id_transaksi'] ?>">Detail</a></td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 90px; z-index: 1020;">
                
                <div class="total-price-display shadow-lg mb-4 text-center">
                    <p class="mb-0 text-white-50 small text-uppercase ls-2">Total Transaksi</p>
                    <h1 class="display-5 fw-bold mb-0" id="grandTotal">Rp 0</h1>
                </div>

                <div class="card-3d-glass p-4">
                    <div class="mb-3 form-floating-3d">
                        <label class="form-label text-muted small fw-bold">Tanggal Transaksi</label>
                        <input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>">
                    </div>
                    
                    <div class="mb-4 form-floating-3d">
                        <label class="form-label text-muted small fw-bold">Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan" rows="3" placeholder="Contoh: Pelanggan A..." style="height: 100px"></textarea>
                    </div>

                    <button class="btn btn-gradient-3d w-100 py-3 fw-bold fs-5 btn-lg">
                        <i class="bi bi-check-circle-fill me-2"></i> PROSES TRANSAKSI
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include 'includes/footer.php'; ?>