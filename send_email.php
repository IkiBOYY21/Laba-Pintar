<?php
// send_email.php
require_once 'helpers.php'; 

// Cek apakah file library benar-benar ada
if (!file_exists('PHPMailer/PHPMailer.php')) {
    die("ERROR: File PHPMailer tidak ditemukan. Pastikan folder 'PHPMailer' berisi file PHPMailer.php, SMTP.php, dan Exception.php (keluarkan dari folder src).");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama_pengirim = htmlspecialchars($_POST['nama']);
    $email_pengirim = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);

    $mail = new PHPMailer(true);

    try {
        // --- DEBUGGING ON (HAPUS NANTI JIKA SUDAH BERHASIL) ---
        $mail->SMTPDebug = 2; // Menampilkan log error koneksi lengkap
        $mail->Debugoutput = 'html';

        // --- KONFIGURASI SERVER ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        // --- MASUKKAN KREDENSIAL DISINI ---
        $mail->Username   = 'email.anda@gmail.com'; // GANTI INI
        $mail->Password   = 'xxxx xxxx xxxx xxxx';  // GANTI DENGAN APP PASSWORD
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // --- PENGIRIM ---
        $mail->setFrom('email.anda@gmail.com', 'Laba Pintar System');
        $mail->addAddress('email.tujuan@gmail.com'); // Email penerima
        $mail->addReplyTo($email_pengirim, $nama_pengirim);

        // --- KONTEN ---
        $mail->isHTML(true);
        $mail->Subject = 'Pesan dari: ' . $nama_pengirim;
        $mail->Body    = "Pesan: $pesan <br> Dari: $email_pengirim";

        $mail->send();
        
        // Matikan debug sebelum redirect jika sukses
        $mail->SMTPDebug = 0; 
        flash('success', 'Email Terkirim!');
        header("Location: " . BASE_URL . "/contact.php");
        exit;

    } catch (Exception $e) {
        // Tampilkan error di layar
        echo "<h1>Gagal Mengirim Email</h1>";
        echo "Pesan Error Mailer: " . $mail->ErrorInfo;
        die(); // Stop script agar error terbaca
    }
}
?>