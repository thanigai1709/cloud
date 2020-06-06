<?php
require_once('./includes/functions.php');
require_once('./includes/config.php');



if (isset($_POST['log-msg'])) {
    $log_data = array(
        "user_id" => $_POST['user_id'],
        "crypt_key" => $_POST['crypt_key'],
        "msg" => $_POST['log-msg']
    );
    if (pushLogs($log_data)) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
}
