<?php
require_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in(){
    return isset($_SESSION['user_id']);
}

function require_login(){
    if(!is_logged_in()){
        header('Location: '.BASE_URL.'/auth/login.php');
        exit;
    }
}

function current_user(){
    global $conn;
    if(!is_logged_in()) return null;
    $id = (int)$_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT id_user, nama, email FROM `user` WHERE id_user = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

function flash($key='', $msg = null){
    if($msg === null){
        if(isset($_SESSION['flash'][$key])){
            $m = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $m;
        }
        return null;
    } else {
        $_SESSION['flash'][$key] = $msg;
    }
}

function esc($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
