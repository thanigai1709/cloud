
<?php
session_start();
require_once('./includes/config.php');
require_once('includes/functions.php');


if (isset($_POST['profile-api'])) {
    $usr_id = $_SESSION['user']['user_id'];
    $usr_email = $_SESSION['user']['user_email'];
    $api_key = $_POST['profile-api'];
    $api_key2 = $_POST['profile-api2'];
    $updated_at = date('Y-m-d H:i:s');
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "UPDATE user SET updated_at ='$updated_at', api_key = '$api_key',api_key2 = '$api_key2' WHERE id ='$usr_id' ";
    if (mysqli_query($con, $query)) {
        $log_data = array(
            "user_id" => $usr_id,
            "user_email" => $usr_email,
            "crypt_key" => $_SESSION['user']['crypt_key'],
            "msg" => $_SESSION['user']['user_name'] . " has changed the API key"
        );
        if (pushLogs($log_data)) {
            header('Location:profile.php');
        }
    }
}

if (isset($_POST['profile-name'])) {
    $usr_id = $_SESSION['user']['user_id'];
    $usr_name = $_POST['profile-name'];
    $updated_at = date('Y-m-d H:i:s');
    if (empty($_POST['profile-pwd'])) {
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $query = "UPDATE user SET updated_at ='$updated_at', name='$usr_name' WHERE id ='$usr_id' ";
        if (mysqli_query($con, $query)) {
            $log_data = array(
                "user_id" => $usr_id,
                "user_email" => $_SESSION['user']['user_email'],
                "crypt_key" => $_SESSION['user']['crypt_key'],
                "msg" => $_SESSION['user']['user_name'] . " has updated profile"
            );
            if (pushLogs($log_data)) {
                header('Location:profile.php');
            }
        }
    } else {
        $pwd = md5($_POST['profile-pwd']);
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $query = "UPDATE user SET updated_at ='$updated_at', name='$usr_name', password='$pwd' WHERE id ='$usr_id' ";
        if (mysqli_query($con, $query)) {
            $log_data = array(
                "user_id" => $usr_id,
                "user_email" => $_SESSION['user']['user_email'],
                "crypt_key" => $_SESSION['user']['crypt_key'],
                "msg" => $_SESSION['user']['user_name'] . " has updated profile"
            );
            if (pushLogs($log_data)) {
                header('Location:profile.php');
            }
        }
    }
}

?>