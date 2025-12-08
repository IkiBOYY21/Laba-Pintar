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
echo "<script>var loginModal = new bootstrap.Modal(document.getElementById('loginModal')); loginModal.show();</script>";
include __DIR__ . '/../includes/footer.php';
