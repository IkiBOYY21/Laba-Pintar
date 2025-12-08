<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

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
    flash('success','Laporan disimpan.');
    header('Location: '.BASE_URL.'/laporan.php'); exit;
}

include 'includes/header.php';
?>
<h3>Laporan Keuangan</h3>
<form method="get" class="mb-3 row g-2">
  <div class="col-md-3"><input class="form-control" type="date" name="from" value="<?= esc($from) ?>"></div>
  <div class="col-md-3"><input class="form-control" type="date" name="to" value="<?= esc($to) ?>"></div>
  <div class="col-md-2"><button class="btn btn-primary">Tampilkan</button></div>
</form>

<div class="content-section p-4 mb-4">
    <h4 class="mb-3">Ringkasan Laba/Rugi Periode: <strong><?= esc($from) ?> — <?= esc($to) ?></strong></h4>
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div style="height: 300px;"><canvas id="LabaRugiSummaryChart"></canvas></div>
        </div>
        <div class="col-md-4">
            <div class="app-card p-3 h-100 shadow-sm border-0">
                <p class="small text-muted mb-1">Total Pendapatan</p>
                <h3 class="fw-bold text-success">Rp <?= number_format($income,0,',','.') ?></h3>
                
                <hr>
                
                <p class="small text-muted mb-1">Total Pengeluaran</p>
                <h3 class="fw-bold text-danger">Rp <?= number_format($expense,0,',','.') ?></h3>
                
                <hr>

                <p class="small text-muted mb-1">Laba Bersih / Rugi</p>
                <h3 class="fw-bold <?= $profit >= 0 ? 'text-primary' : 'text-danger' ?>">Rp <?= number_format($profit,0,',','.') ?></h3>
            </div>
        </div>
    </div>
    
    <form method="post" class="mt-4">
        <input type="hidden" name="periode" value="<?= esc($from).' to '.esc($to) ?>">
        <button class="btn btn-success" name="save_report"><i class="bi bi-save me-2"></i> Simpan Laporan Ini</button>
    </form>
</div>

<script>
    const summary_ctx = document.getElementById('LabaRugiSummaryChart');
    const incomeValue = <?= $income ?>;
    const expenseValue = <?= $expense ?>;

    new Chart(summary_ctx, {
        type: 'bar',
        data: {
            labels: ['Pendapatan', 'Pengeluaran'],
            datasets: [{
                label: 'Jumlah (Rp)',
                data: [incomeValue, expenseValue],
                backgroundColor: [
                    'rgba(99, 91, 255, 0.8)', // Primary Color for Income
                    'rgba(220, 53, 69, 0.8)'  // Danger Color for Expense
                ],
                borderColor: [
                    'rgba(99, 91, 255, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, ticks) {
                            // Format number to IDR
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Perbandingan Pemasukan vs Pengeluaran'
                }
            }
        }
    });
</script>

<h5>Laporan Tersimpan</h5>
<div class="content-section">
    <table class="table table-sm">
    <thead><tr><th>ID</th><th>Periode</th><th>Pendapatan</th><th>Pengeluaran</th><th>Laba/Rugi</th><th>Tgl</th></tr></thead>
    <tbody>
    <?php
    $rs = $conn->query("SELECT * FROM laporan_keuangan WHERE id_user = $uid ORDER BY created_at DESC");
    while($r = $rs->fetch_assoc()):
    ?>
    <tr>
      <td><?= $r['id_laporan'] ?></td>
      <td><?= esc($r['periode']) ?></td>
      <td>Rp <?= number_format($r['total_pemasukan'],0,',','.') ?></td>
      <td>Rp <?= number_format($r['total_pengeluaran'],0,',','.') ?></td>
      <td>Rp <?= number_format($r['laba_rugi'],0,',','.') ?></td>
      <td><?= esc($r['created_at']) ?></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>