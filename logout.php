<?php

session_start();
require_once('includes/config.php');
require_once('includes/functions.php');
$log_data = array(
    "user_id" => $_SESSION['user']['user_id'],
    "user_email" => $_SESSION['user']['user_email'],
    "crypt_key" => $_SESSION['user']['crypt_key'],
    "msg" => $_SESSION['user']['user_name'] . " has logged out successfully"
);
pushLogs($log_data);
unset($_SESSION['user']);
header('Location:login.php');
