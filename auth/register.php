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
echo "<script>var r = new bootstrap.Modal(document.getElementById('registerModal')); r.show();</script>";
include __DIR__ . '/../includes/footer.php';
