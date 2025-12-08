<?php
require_once 'helpers.php';
if(is_logged_in()){
    header('Location: '.BASE_URL.'dashboard.php');
} else {
    // Arahkan ke Halaman Home/Landing baru
    header('Location: '.BASE_URL.'home.php'); 
}
exit;