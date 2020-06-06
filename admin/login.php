<?php
session_start();
require_once('./includes/header.php');
require_once('../includes/config.php');
require_once('../includes/functions.php');
if (isset($_POST['login-adm']) && !empty($_POST['login-adm'])) {
    $admn_email = htmlspecialchars($_POST['login-adm']);
    $admn_pwd = md5(htmlspecialchars($_POST['login-pwd']));
    $results = fetchData("SELECT * FROM admin WHERE email='$admn_email'");
    $login = false;
    $vldt_msg = null;
    $db_error = false;
    foreach ($results as $result) {
        if ($result['email'] == $admn_email && $result['passwrd'] == $admn_pwd) {
            $log_data = array("adm_id" => $result['id'], "adm_name" => $result['name'], "adm_email" => $result['email']);
            $login = true;
            break;
        } else {
            $login = false;
            break;
        }
    }
    if ($login) {
        $_SESSION['admin'] = $log_data;
        header('Location:index.php');
    } else {
        $vldt_msg = "Invalid Credentials";
    }
}
?>
<div class="cloud-login-ottr-wrp-admin">
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
                                <input type="email" class="form-control" name="login-adm" required>
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