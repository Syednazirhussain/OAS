<?php
ob_start();
    require_once('autoload.php');
    $user = new user();
echo print_r($_SESSION);exit;
    $user->logout();
    header("location:login.php");
ob_flush();
?>