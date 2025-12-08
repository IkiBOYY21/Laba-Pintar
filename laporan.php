<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

// Logic Hitung (Tetap)
$stmt = $conn->prepare("SELECT IFNULL(SUM(total),0) as income FROM transaksi_penjualan WHERE id_user = ? AND tanggal BETWEEN ? AND ?");
$stmt->bind_param('iss',$uid,$from,$to); $stmt->execute();
$income = $stmt->get_result()->fetch_assoc()['income'];

$stmt2 = $conn->prepare("SELECT IFNULL(SUM(jumlah),0) as expense FROM pengeluaran WHERE id_user = ? AND tanggal BETWEEN ? AND ?");
$stmt2->bind_param('iss',$uid,$from,$to); $stmt2->execute();
$expense = $stmt2->get_result()->fetch_assoc()['expense'];

$profit = $income - $expense;

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_report'])){
    $periode = $_POST['periode'] ?: ($from.' to '.$to);
    $stmt3 = $conn->prepare("INSERT INTO laporan_keuangan (periode,total_pemasukan,total_pengeluaran,laba_rugi,id_user,created_at) VALUES (?,?,?,?,?,NOW())");
    $stmt3->bind_param('sddsi',$periode,$income,$expense,$profit,$uid);
    $stmt3->execute();
    flash('success','Laporan berhasil disimpan ke riwayat.');
    header('Location: '.BASE_URL.'/laporan.php'); exit;
}

include 'includes/header.php';
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <h2 class="page-title mb-3 mb-md-0">Laporan Keuangan</h2>
    
    <div class="card-3d-glass px-3 py-2 d-inline-block">
        <form method="get" class="d-flex align-items-center gap-2">
            <input class="form-control form-control-sm border-0 bg-transparent fw-bold" type="date" name="from" value="<?= esc($from) ?>">
            <span class="text-muted">-</span>
            <input class="form-control form-control-sm border-0 bg-transparent fw-bold" type="date" name="to" value="<?= esc($to) ?>">
            <button class="btn btn-sm btn-primary rounded-pill px-3 ms-2">Filter</button>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-3d-glass p-4 text-center h-100 border-bottom border-4 border-success">
            <p class="text-muted text-uppercase small fw-bold ls-1 mb-1">Pemasukan</p>
            <h3 class="fw-bold text-success mb-0">Rp <?= number_format($income,0,',','.') ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-3d-glass p-4 text-center h-100 border-bottom border-4 border-danger">
            <p class="text-muted text-uppercase small fw-bold ls-1 mb-1">Pengeluaran</p>
            <h3 class="fw-bold text-danger mb-0">Rp <?= number_format($expense,0,',','.') ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-3d-glass p-4 text-center h-100 border-bottom border-4 <?= $profit >= 0 ? 'border-primary' : 'border-warning' ?>">
            <p class="text-muted text-uppercase small fw-bold ls-1 mb-1">Laba Bersih</p>
            <h3 class="fw-bold <?= $profit >= 0 ? 'text-primary' : 'text-warning' ?> mb-0">Rp <?= number_format($profit,0,',','.') ?></h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-3d-glass p-4 h-100">
            <h5 class="fw-bold mb-3 text-muted">Visualisasi Laba Rugi</h5>
            <div style="height: 300px;">
                <canvas id="LabaRugiSummaryChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-3d-glass p-4 h-100 d-flex flex-column">
            <div class="mb-auto">
                <h5 class="fw-bold mb-3 text-muted">Aksi</h5>
                <p class="small text-muted">Simpan laporan periode ini untuk arsip masa depan.</p>
                <form method="post">
                    <input type="hidden" name="periode" value="<?= date('d M Y', strtotime($from)).' - '.date('d M Y', strtotime($to)) ?>">
                    <button class="btn btn-gradient-3d w-100 py-2" name="save_report">
                        <i class="bi bi-archive-fill me-2"></i> Simpan Laporan
                    </button>
                </form>
            </div>
            
            <div class="mt-4 pt-4 border-top">
                <h6 class="fw-bold text-muted mb-3">Arsip Laporan</h6>
                <div class="list-group list-group-flush small" style="max-height: 200px; overflow-y: auto;">
                    <?php
                    $rs = $conn->query("SELECT * FROM laporan_keuangan WHERE id_user = $uid ORDER BY created_at DESC LIMIT 10");
                    while($r = $rs->fetch_assoc()):
                    ?>
                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span><?= esc($r['periode']) ?></span>
                        <span class="<?= $r['laba_rugi'] >= 0 ? 'text-success' : 'text-danger' ?> fw-bold">
                            Rp <?= number_format($r['laba_rugi'],0,',','.') ?>
                        </span>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sama seperti sebelumnya, hanya pastikan ID canvas match
    const summary_ctx = document.getElementById('LabaRugiSummaryChart');
    if(summary_ctx){
        new Chart(summary_ctx, {
            type: 'doughnut', // Ubah ke doughnut agar lebih variatif
            data: {
                labels: ['Pendapatan', 'Pengeluaran', 'Sisa (Laba)'],
                datasets: [{
                    data: [<?= $income ?>, <?= $expense ?>, <?= max(0, $profit) ?>],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(220, 53, 69, 0.7)',
                        'rgba(13, 110, 253, 0.7)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>