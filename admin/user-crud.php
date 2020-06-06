<?php
session_start();
require_once('../includes/config.php');
require_once('../includes/functions.php');

if (isset($_POST['usr-name'])) {
    $name = $_POST['usr-name'];
    $email = $_POST['usr-email'];
    $password = md5($_POST['usr-pswd']);
    $salt_key = $_POST['usr-salt'];
    $api1 = $_POST['usr-api1'];
    $api2 = $_POST['usr-api2'];
    $created_at = date('Y-m-d H:i:s');
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "INSERT INTO user (name,email,password,salt_key,api_key,api_key2,created_at) VALUES ('$name','$email','$password','$salt_key','$api1','$api2','$created_at')";
    if (mysqli_query($con, $query)) {
        header('Location:users.php');
    }
}

if (isset($_POST['del-id'])) {
    $del_id = $_POST['del-id'];
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "DELETE FROM user WHERE id='$del_id'";
    if (mysqli_query($con, $query)) {
        header('Location:users.php');
    }
}


if (isset($_POST['updt-id'])) {
    $id = $_POST['updt-id'];
    $name = $_POST['updt-name'];
    $salt_key = $_POST['updt-salt'];
    $api1 = $_POST['updt-api1'];
    $api2 = $_POST['updt-api2'];
    $updated_at = date('Y-m-d H:i:s');
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "UPDATE user SET updated_at ='$updated_at', api_key = '$api1',api_key2 = '$api2',name='$name',salt_key='$salt_key'  WHERE id ='$id' ";
    if (mysqli_query($con, $query)) {
        header('Location:users.php');
    }
}
