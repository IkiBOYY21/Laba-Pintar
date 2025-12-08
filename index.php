<?php
require_once 'helpers.php';
if(is_logged_in()){
    header('Location: '.BASE_URL.'dashboard.php');
} else {
    header('Location: '.BASE_URL.'auth/login.php');
}
exit;
