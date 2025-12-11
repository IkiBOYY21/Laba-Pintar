<?php
require_once 'helpers.php';
require_login();
$uid = (int)$_SESSION['user_id'];

// 1. Filter Periode
$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

// --- LOGIKA DATA ---

// A. Siapkan array tanggal (untuk Grafik Garis)
$period = new DatePeriod(
     new DateTime($from),
     new DateInterval('P1D'),
     (new DateTime($to))->modify('+1 day')
);

$dates = [];
$data_pemasukan = [];
$data_pengeluaran = [];

// Isi default 0
foreach ($period as $key => $value) {
    $tgl_str = $value->format('Y-m-d');
    $dates[] = $value->format('d M'); // Label X (Tgl)
    $data_pemasukan[$tgl_str] = 0;
    $data_pengeluaran[$tgl_str] = 0;
}

// B. Query Pemasukan
$sql_in = "SELECT DATE(tanggal) as tgl, SUM(total) as total 
           FROM transaksi_penjualan 
           WHERE id_user = $uid AND tanggal BETWEEN '$from' AND '$to' 
           GROUP BY DATE(tanggal)";
$res_in = $conn->query($sql_in);
while($row = $res_in->fetch_assoc()){
    $data_pemasukan[$row['tgl']] = (float)$row['total'];
}

// C. Query Pengeluaran
$sql_out = "SELECT DATE(tanggal) as tgl, SUM(jumlah) as total 
            FROM pengeluaran 
            WHERE id_user = $uid AND tanggal BETWEEN '$from' AND '$to' 
            GROUP BY DATE(tanggal)";
$res_out = $conn->query($sql_out);
while($row = $res_out->fetch_assoc()){
    $data_pengeluaran[$row['tgl']] = (float)$row['total'];
}

// D. Hitung Total & Data Chart
$total_income = 0;
$total_expense = 0;

$chart_income = [];
$chart_expense = [];
$chart_profit = [];

foreach ($data_pemasukan as $tgl => $in) {
    $out = $data_pengeluaran[$tgl];
    $chart_income[] = $in;
    $chart_expense[] = $out;
    $chart_profit[] = $in - $out;

    $total_income += $in;
    $total_expense += $out;
}

$total_profit = $total_income - $total_expense;

// E. Simpan Laporan
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_report'])){
    $periode_lbl = $_POST['periode'] ?: ($from.' to '.$to);
    $stmt3 = $conn->prepare("INSERT INTO laporan_keuangan (periode,total_pemasukan,total_pengeluaran,laba_rugi,id_user,created_at) VALUES (?,?,?,?,?,NOW())");
    $stmt3->bind_param('sddsi',$periode_lbl,$total_income,$total_expense,$total_profit,$uid);
    $stmt3->execute();
    flash('success','Laporan berhasil disimpan ke riwayat.');
    header('Location: '.BASE_URL.'/laporan.php?from='.$from.'&to='.$to); exit;
}

include 'includes/header.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

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
            <p class="text-muted text-uppercase small fw-bold ls-1 mb-1">Total Pemasukan</p>
            <h3 class="fw-bold text-success mb-0">Rp <?= number_format($total_income,0,',','.') ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-3d-glass p-4 text-center h-100 border-bottom border-4 border-danger">
            <p class="text-muted text-uppercase small fw-bold ls-1 mb-1">Total Pengeluaran</p>
            <h3 class="fw-bold text-danger mb-0">Rp <?= number_format($total_expense,0,',','.') ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-3d-glass p-4 text-center h-100 border-bottom border-4 <?= $total_profit >= 0 ? 'border-primary' : 'border-warning' ?>">
            <p class="text-muted text-uppercase small fw-bold ls-1 mb-1">Laba Bersih</p>
            <h3 class="fw-bold <?= $total_profit >= 0 ? 'text-primary' : 'text-warning' ?> mb-0">Rp <?= number_format($total_profit,0,',','.') ?></h3>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    
    <div class="col-lg-8">
        <div class="card-3d-glass p-4 h-100">
            <h5 class="fw-bold mb-4 text-muted"><i class="bi bi-graph-up me-2"></i>Tren Harian</h5>
            <div style="height: 350px; width: 100%;">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-3d-glass p-4 h-100">
            <h5 class="fw-bold mb-4 text-muted"><i class="bi bi-pie-chart me-2"></i>Perbandingan</h5>
            <div style="height: 300px; position: relative;">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="mt-3 text-center small text-muted">
                Pemasukan vs Pengeluaran
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-3d-glass p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-muted mb-0">Arsip Laporan</h5>
                <form method="post" class="d-inline">
                    <input type="hidden" name="periode" value="<?= date('d M Y', strtotime($from)).' - '.date('d M Y', strtotime($to)) ?>">
                    <button class="btn btn-sm btn-gradient-3d px-4" name="save_report">
                        <i class="bi bi-save me-2"></i> Simpan
                    </button>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light"><tr><th>Tanggal</th><th>Periode</th><th>Pemasukan</th><th>Pengeluaran</th><th>Laba</th></tr></thead>
                    <tbody>
                    <?php
                    $rs = $conn->query("SELECT * FROM laporan_keuangan WHERE id_user = $uid ORDER BY created_at DESC LIMIT 5");
                    while($r = $rs->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-muted small"><?= date('d/m/y H:i', strtotime($r['created_at'])) ?></td>
                        <td class="fw-bold"><?= esc($r['periode']) ?></td>
                        <td class="text-success">Rp <?= number_format($r['total_pemasukan'],0,',','.') ?></td>
                        <td class="text-danger">Rp <?= number_format($r['total_pengeluaran'],0,',','.') ?></td>
                        <td class="<?= $r['laba_rugi'] >= 0 ? 'text-primary' : 'text-warning' ?> fw-bold">
                            Rp <?= number_format($r['laba_rugi'],0,',','.') ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Register Plugin DataLabels agar bisa menampilkan teks di dalam chart
    Chart.register(ChartDataLabels);

    const labels = <?= json_encode($dates) ?>;
    const dataIncome = <?= json_encode($chart_income) ?>;
    const dataExpense = <?= json_encode($chart_expense) ?>;
    const dataProfit = <?= json_encode($chart_profit) ?>;

    // 1. CONFIG LINE CHART
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: dataIncome,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.3, fill: true,
                    datalabels: { display: false } // Matikan label angka di garis agar tidak penuh
                },
                {
                    label: 'Pengeluaran',
                    data: dataExpense,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.3, fill: true,
                    datalabels: { display: false }
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // 2. CONFIG PIE CHART (DENGAN PERSENTASE)
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Pemasukan', 'Pengeluaran'],
            datasets: [{
                data: [<?= $total_income ?>, <?= $total_expense ?>],
                backgroundColor: ['#198754', '#dc3545'], // Hijau & Merah
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                // KONFIGURASI PERSENTASE
                datalabels: {
                    color: '#fff', // Warna teks putih
                    font: { weight: 'bold', size: 14 },
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => { sum += data; }); // Hitung total
                        if(sum === 0) return '0%';
                        let percentage = (value * 100 / sum).toFixed(1) + "%"; // Hitung %
                        return percentage;
                    }
                }
            }
        }
    });
</script>

<?php include 'includes/footer.php'; ?>