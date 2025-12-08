<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

// add transaksi (single transaksi + multiple detail)
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_transaksi'])){
    $tanggal = $_POST['tanggal'] ?: date('Y-m-d');
    $catatan = $_POST['catatan'];
    $products = $_POST['produk']; // array of id_produk
    $qtys = $_POST['qty']; // array matching

    // hitung total
    $total = 0;
    $items = [];
    for($i=0;$i<count($products);$i++){
        $pid = (int)$products[$i];
        $q = (int)$qtys[$i];
        if($q <= 0) continue;
        $row = $conn->query("SELECT harga, stok FROM produk WHERE id_produk = $pid AND id_user = $uid")->fetch_assoc();
        if(!$row) continue; // skip item bukan milik user
        $harga = (float)$row['harga'];
        $subtotal = $harga * $q;
        $items[] = ['id'=>$pid,'qty'=>$q,'harga'=>$harga,'subtotal'=>$subtotal,'stok'=>$row['stok']];
        $total += $subtotal;
    }

    if(count($items) == 0){
        flash('error','Tidak ada item valid untuk transaksi.');
    } else {
        // insert transaksi
        $stmt = $conn->prepare("INSERT INTO transaksi_penjualan (tanggal,total,id_user,catatan,created_at) VALUES (?,?,?,?,NOW())");
        $stmt->bind_param('sdss',$tanggal,$total,$uid,$catatan);
        // note: bind param types must match: 's d i s' but here we used 'sdss' and $uid is int; convert $uid to string/ cast
        // workaround: use separate query with escaping to avoid binding complexity
        $stmt->close();
        $tanggalEsc = $conn->real_escape_string($tanggal);
        $catEsc = $conn->real_escape_string($catatan);
        // Menggunakan prepared statement untuk menghindari potensi masalah binding
        $stmt_trans = $conn->prepare("INSERT INTO transaksi_penjualan (tanggal,total,id_user,catatan,created_at) VALUES (?,?,?,?,NOW())");
        $stmt_trans->bind_param('sdss',$tanggal,$total,$uid,$catatan);
        $stmt_trans->execute();
        $trans_id = $stmt_trans->insert_id;
        $stmt_trans->close();

        // insert detail and update stok
        $stmtDetail = $conn->prepare("INSERT INTO detail_transaksi (id_transaksi,id_produk,jumlah,harga_satuan,subtotal,created_at) VALUES (?,?,?,?,?,NOW())");
        foreach($items as $it){
            // check stok
            if($it['stok'] < $it['qty']){
                // skip or set error — we'll skip and inform
                continue;
            }
            $stmtDetail->bind_param('iiidd',$trans_id, $it['id'], $it['qty'], $it['harga'], $it['subtotal']);
            $stmtDetail->execute();
            // update stok
            $stmtUp = $conn->prepare("UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND id_user = ?");
            $stmtUp->bind_param('iii', $it['qty'], $it['id'], $uid);
            $stmtUp->execute();
            $stmtUp->close();
        }
        $stmtDetail->close();
        flash('success','Transaksi tercatat. ID: '.$trans_id);
        header('Location: '.BASE_URL.'/transaksi.php'); exit;
    }
}

// tampilkan form dan list
include 'includes/header.php';
$products_rs = $conn->query("SELECT id_produk, nama_produk, harga, stok FROM produk WHERE id_user = $uid AND stok > 0 ORDER BY nama_produk");
$products_data = $products_rs->fetch_all(MYSQLI_ASSOC);
$trans = $conn->query("SELECT * FROM transaksi_penjualan WHERE id_user = $uid ORDER BY created_at DESC");
?>
<h3>Transaksi Penjualan</h3>
<div class="content-section mb-4">
  <form method="post" id="frmTrans">
    <input type="hidden" name="create_transaksi" value="1">
    <div class="row g-3">
        <div class="col-md-4">
            <label>Tanggal</label>
            <input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="col-md-8">
            <label>Catatan</label>
            <input class="form-control" name="catatan">
        </div>
    </div>

    <h5 class="mt-4">Item Transaksi</h5>
    <div id="items" data-products='<?= htmlspecialchars(json_encode($products_data), ENT_QUOTES, 'UTF-8') ?>'>
      <div class="row mb-2 g-2 item-row">
        <div class="col-md-5">
          <select class="form-control product-select" name="produk[]">
            <option value="" data-harga="0" data-stok="0">Pilih Produk</option>
            <?php foreach($products_data as $p): ?>
              <option value="<?= $p['id_produk'] ?>" data-harga="<?= $p['harga'] ?>" data-stok="<?= $p['stok'] ?>"><?= esc($p['nama_produk']) ?> (stok: <?= $p['stok'] ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <input class="form-control qty-input" name="qty[]" type="number" value="1" min="1" required>
        </div>
        <div class="col-md-4">
          <input class="form-control subtotal-output" type="text" readonly value="Rp 0">
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-danger remove-item w-100"><i class="bi bi-x"></i></button>
        </div>
      </div>
    </div>
    <button type="button" id="addItem" class="btn btn-secondary mb-3"><i class="bi bi-plus-circle me-1"></i> Tambah Item</button>
    
    <div class="d-flex justify-content-end align-items-center border-top pt-3 mt-3">
        <h4 class="me-3 mb-0 text-muted">Total Transaksi:</h4>
        <h4 id="grandTotal" class="text-primary mb-0 fw-bold">Rp 0</h4>
    </div>
    <div class="mt-4">
        <button class="btn btn-primary btn-lg fw-bold"><i class="bi bi-save me-2"></i> Simpan Transaksi</button>
    </div>
  </form>
</div>

<h5 class="mt-4">Riwayat Transaksi</h5>
<div class="content-section">
  <table class="table table-sm">
  <thead><tr><th>ID</th><th>Tanggal</th><th>Total</th><th>Detail</th></tr></thead>
  <tbody>
  <?php while($t = $trans->fetch_assoc()): ?>
  <tr>
    <td><?= $t['id_transaksi'] ?></td>
    <td><?= esc($t['tanggal']) ?></td>
    <td>Rp <?= number_format($t['total'],0,',','.') ?></td>
    <td><a class="btn btn-sm btn-info text-white" href="<?= BASE_URL ?>/detail_transaksi.php?id=<?= $t['id_transaksi'] ?>">Lihat</a></td>
  </tr>
  <?php endwhile; ?>
  </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>