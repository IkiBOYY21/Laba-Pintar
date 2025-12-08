<?php
require_once __DIR__ . '/../helpers.php';
if(is_logged_in()) header('Location: '.BASE_URL.'/dashboard.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    if(empty($nama) || empty($email) || empty($password)){
        flash('error','Isi semua field wajib.');
    } else {

        $stmt = $conn->prepare("SELECT id_user FROM `user` WHERE email = ?");
        $stmt->bind_param('s',$email); 
        $stmt->execute();

        if($stmt->get_result()->num_rows > 0){
            flash('error','Email sudah terdaftar.');
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO `user` (nama,email,password,no_hp,alamat,created_at) VALUES (?,?,?,?,?,NOW())");
            $stmt->bind_param('sssss',$nama,$email,$hash,$no_hp,$alamat);

            if($stmt->execute()){
                flash('success','Registrasi berhasil, silakan login.');
                header('Location: '.BASE_URL.'/auth/login.php');
                exit;
            } else {
                flash('error','Gagal menyimpan user.');
            }
        }
    }

    header('Location: '.BASE_URL.'/auth/register.php');
    exit;
}
include __DIR__ . '/../includes/header.php';
?>
<div class="landing-wrapper" style="min-height: calc(100vh - 140px);">
    <div class="auth-card">
        <h4 class="fw-bold mb-3">Daftar Akun Baru</h4>
        <p class="text-muted mb-4">Isi data di bawah untuk memulai.</p>

        <form method="post" action="<?= BASE_URL ?>/auth/register.php">
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input name="nama" class="form-control" id="regNama" placeholder="Nama" required>
                        <label for="regNama">Nama Lengkap</label>
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-floating">
                        <input name="email" type="email" class="form-control" id="regEmail" placeholder="Email" required>
                        <label for="regEmail">Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input name="password" type="password" class="form-control" id="regPassword" placeholder="Password" required>
                        <label for="regPassword">Password</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input name="no_hp" class="form-control" id="regHP" placeholder="No HP">
                        <label for="regHP">No HP (Opsional)</label>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-floating">
                        <textarea name="alamat" class="form-control" id="regAlamat" placeholder="Alamat" style="height: 55px;"></textarea>
                        <label for="regAlamat">Alamat (Opsional)</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary w-100 py-2 fw-bold"><i class="bi bi-person-plus-fill me-2"></i> DAFTAR</button>
                <a href="<?= BASE_URL ?>auth/login.php" class="btn btn-secondary w-100 mt-2 py-2">
                    Sudah punya akun? Login
                </a>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>