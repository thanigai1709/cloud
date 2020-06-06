<?php

function pushLogs($log_data)
{
    $user_id =  $log_data['user_id'];
    $crypt_key = $log_data['crypt_key'];
    $log = logEncode($log_data['msg'], $crypt_key);
    $created_at = date('Y-m-d H:i:s');
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "INSERT INTO trace_log (`user_id`,`log`,`created_at`) VALUES ('$user_id','$log','$created_at')";
    if (!mysqli_query($con, $query)) {
        return false;
    } else {
        return true;
    }
}

function logEncode($data, $salt)
{
    $method = 'aes-256-ecb';
    return openssl_encrypt($data, $method, $salt);
}

function logDecode($data, $salt)
{
    $method = 'aes-256-ecb';
    return openssl_decrypt($data, $method, $salt);
}

function fetchData($sql_query)
{
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $result_data = mysqli_query($con, $sql_query);
    return $result_data;
    mysqli_close($con);
}

function countRows($sql_query)
{
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $result_data = mysqli_query($con, $sql_query);
    return mysqli_num_rows($result_data);
    mysqli_close($con);
}

function adminDecode($log, $user_id)
{
    $salt_key =  fetchData("SELECT * FROM user WHERE id=$user_id")->fetch_assoc();
    return logDecode($log, $salt_key['salt_key']);
}
