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
        $conn->query("INSERT INTO transaksi_penjualan (tanggal,total,id_user,catatan,created_at) VALUES ('$tanggalEsc',$total,$uid,'$catEsc',NOW())");
        $trans_id = $conn->insert_id;

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
$products = $conn->query("SELECT * FROM produk WHERE id_user = $uid AND stok > 0");
$trans = $conn->query("SELECT * FROM transaksi_penjualan WHERE id_user = $uid ORDER BY created_at DESC");
?>
<h3>Transaksi Penjualan</h3>
<form method="post" id="frmTrans">
  <input type="hidden" name="create_transaksi" value="1">
  <div class="mb-2"><label>Tanggal</label><input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>"></div>
  <div class="mb-2"><label>Catatan</label><input class="form-control" name="catatan"></div>

  <h5>Item</h5>
  <div id="items">
    <div class="row mb-2 item-row">
      <div class="col-md-6">
        <select class="form-control" name="produk[]">
          <?php $products->data_seek(0); while($p = $products->fetch_assoc()): ?>
            <option value="<?= $p['id_produk'] ?>"><?= esc($p['nama_produk']) ?> (stok: <?= $p['stok'] ?>)</option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-3"><input class="form-control" name="qty[]" type="number" value="1"></div>
      <div class="col-md-3"><button type="button" class="btn btn-danger remove-item">Hapus</button></div>
    </div>
  </div>
  <button type="button" id="addItem" class="btn btn-secondary mb-2">Tambah Item</button>
  <div><button class="btn btn-primary">Simpan Transaksi</button></div>
</form>

<h5 class="mt-4">Riwayat Transaksi</h5>
<table class="table table-sm">
<thead><tr><th>ID</th><th>Tanggal</th><th>Total</th><th>Detail</th></tr></thead>
<tbody>
<?php while($t = $trans->fetch_assoc()): ?>
<tr>
  <td><?= $t['id_transaksi'] ?></td>
  <td><?= esc($t['tanggal']) ?></td>
  <td>Rp <?= number_format($t['total'],0,',','.') ?></td>
  <td><a class="btn btn-sm btn-info" href="<?= BASE_URL ?>/detail_transaksi.php?id=<?= $t['id_transaksi'] ?>">Lihat</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php include 'includes/footer.php'; ?>
