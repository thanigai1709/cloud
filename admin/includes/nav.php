<?php
require_once('./includes/header.php');
require_once('../includes/config.php');
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location:login.php');
}
?>
<div class="cloud-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    <a href="<?php echo ROOT_URL . "/admin/index.php";  ?>"><i class="fas fa-cloud-upload-alt"></i></a>
                </div>
            </div>
            <div class="col-sm-6 text-right">
                <div class="nav-links">
                    <span class="menu-header"><i class="fas fa-bars"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="menu-pannel-wrp">
    <div class="menu-pannel-innr-wrp">
        <div class="close-btn">
            <span><i class="fas fa-arrow-right"></i></span>
        </div>
        <div class="menu-pannel-profile-img text-center">
            <img src="../images/undraw_profile_pic_ic5t.svg" alt="icon">
        </div>
        <div class="menu-pannel-profile-name text-center">
            <?php echo $_SESSION['admin']['adm_name'] ?>
        </div>
        <div class="menu-pannel-profile-email text-center">
            <?php echo $_SESSION['admin']['adm_email'] ?>
        </div>
        <hr>
        <div class="nav-links-wrp">
            <div class="link-wrp">
                <a href="<?php echo ROOT_URL . "/admin/index.php";  ?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
            </div>
            <div class="link-wrp">
                <a href="logs.php"><i class="fas fa-address-book"></i>Logs</a>
            </div>
            <div class="link-wrp">
                <a href="users.php"><i class="fas fa-users"></i>Users</a>
            </div>
            <div class="link-wrp">
                <a href="logout.php"><i class="fas fa-power-off"></i>Logout</a>
            </div>
        </div>
    </div>
</div>