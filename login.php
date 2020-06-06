<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location:index.php');
}
require_once('includes/header.php');
require_once('includes/config.php');
require_once('includes/functions.php');

if (isset($_POST['login-usr']) && !empty($_POST['login-usr'])) {
    $usr_email = htmlspecialchars($_POST['login-usr']);
    $usr_pwd = md5(htmlspecialchars($_POST['login-pwd']));
    $results = fetchData("SELECT * FROM user WHERE email='$usr_email'");
    $login = false;
    $vldt_msg = null;
    $log_data = [];
    $db_error = false;
    foreach ($results as $result) {
        if ($result['email'] == $usr_email && $result['password'] == $usr_pwd) {
            $log_data = array("user_id" => $result['id'], "user_name" => $result['name'], "user_email" => $result['email'], "crypt_key" => $result['salt_key'], "api_key" => $result['api_key'], "api_key2" => $result['api_key2'], "msg" => $result['name'] . " has logged in successfully");
            if (pushLogs($log_data)) {
                $login = true;
                break;
            } else {
                $login = false;
                $db_error = true;
                break;
            }
        }
    }
    if ($login) {
        $_SESSION['user'] = $log_data;
        header('Location:index.php');
    } else {
        if ($db_error) {
            $vldt_msg = "Something went wrong, Please tryagain later";
        } else {
            $vldt_msg = "Invalid Credentials";
        }
    }
}
?>
<div class="cloud-login-ottr-wrp">
    <div class="cloud-login-wrp">
        <div class="container">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="colud-form-wrp">
                        <div class="logo">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" name="login-usr" required>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" name="login-pwd" required>
                            </div>
                            <button type="submit" class="btn g-blu-btn"><i class="fas fa-sign-in-alt"></i>Login</button>
                        </form>
                        <div class="g-error-msg"><?php if (isset($vldt_msg)) echo $vldt_msg; ?></div>
                        <div class="t-admin-login-cnt">
                            <a href=""></a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
</div>