<?php
require_once __DIR__ . '/../helpers.php';
if(is_logged_in()) header('Location: '.BASE_URL.'/dashboard.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_user,password FROM `user` WHERE email = ? LIMIT 1");
    $stmt->bind_param('s',$email); 
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();

    if($r && password_verify($password, $r['password'])){
        $_SESSION['user_id'] = $r['id_user'];
        flash('success','Login berhasil.');
        header('Location: '.BASE_URL.'/dashboard.php');
        exit;
    } else {
        flash('error','Email atau password salah.');
        header('Location: '.BASE_URL.'/auth/login.php');
        exit;
    }
}
include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 140px);">
    <div class="auth-card text-center">
        <h4 class="fw-bold mb-3">Login ke Akun Anda</h4>
        <p class="text-muted mb-4">Akses dashboard Anda untuk mengelola data.</p>
        <form method="post" action="<?= BASE_URL ?>/auth/login.php">
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Email" required>
                <label for="loginEmail">Email</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Password" required>
                <label for="loginPassword">Password</label>
            </div>

            <button class="btn btn-primary w-100 mb-3 py-2 fw-bold">
                <i class="bi bi-box-arrow-in-right me-2"></i> MASUK
            </button>
        </form>
        <p class="mt-3 text-muted">
            Belum punya akun? <a href="<?= BASE_URL ?>auth/register.php" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a>
        </p>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>