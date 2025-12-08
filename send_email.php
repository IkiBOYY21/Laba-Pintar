<?php
// send_email.php
require_once 'helpers.php'; // Untuk flash message
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load library PHPMailer secara manual
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama_pengirim = htmlspecialchars($_POST['nama']);
    $email_pengirim = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);

    $mail = new PHPMailer(true);

    try {
        // --- KONFIGURASI SERVER GMAIL ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        // GANTI DENGAN EMAIL & APP PASSWORD ANDA
        $mail->Username   = 'email.anda@gmail.com'; // Email Gmail Anda
        $mail->Password   = 'xxxx xxxx xxxx xxxx';  // App Password (16 digit)
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // --- PENGIRIM & PENERIMA ---
        
        $mail->setFrom('email.anda@gmail.com', 'Sistem Laba Pintar');
        $mail->addAddress('email.tujuan@gmail.com'); // Email Admin/Support penerima laporan
        $mail->addReplyTo($email_pengirim, $nama_pengirim);

        // --- KONTEN EMAIL ---
        $mail->isHTML(true);
        $mail->Subject = 'Pesan Baru dari: ' . $nama_pengirim;
        $mail->Body    = "
            <h3>Pesan Baru dari Website Laba Pintar</h3>
            <p><strong>Nama:</strong> $nama_pengirim</p>
            <p><strong>Email:</strong> $email_pengirim</p>
            <hr>
            <p><strong>Pesan:</strong><br>$pesan</p>
        ";

        $mail->send();
        flash('success', 'Pesan berhasil dikirim via Gmail!');
    } catch (Exception $e) {
        flash('error', "Gagal mengirim pesan. Error: {$mail->ErrorInfo}");
    }

    // Kembali ke halaman contact
    header("Location: " . BASE_URL . "/contact.php");
    exit;
}
?>