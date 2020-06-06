<?php require_once('includes/config.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
}
?>
<div class="cloud-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    <a href="<?php echo ROOT_URL;  ?>"><i class="fas fa-cloud-upload-alt"></i></a>
                </div>
            </div>
            <div class="col-sm-6 text-right">
                <div class="nav-links">
                    <!-- <a href="dropbox.php"><i class="fab fa-dropbox"></i>Dropbox</a>
                    <a href="profile.php"><i class="fas fa-user-alt"></i>Profile</a>
                    <a href="logs.php"><i class="fas fa-address-book"></i>Logs</a>
                    <a href="logout.php"><i class="fas fa-power-off"></i>Logout</a> -->
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
            <img src="images/undraw_profile_pic_ic5t.svg" alt="icon">
        </div>
        <div class="menu-pannel-profile-name text-center">
            <?php echo $_SESSION['user']['user_name'] ?>
        </div>
        <div class="menu-pannel-profile-email text-center">
            <?php echo $_SESSION['user']['user_email'] ?>
        </div>
        <hr>
        <div class="nav-links-wrp">
            <div class="link-wrp">
                <a href="<?php echo ROOT_URL;  ?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
            </div>
            <div class="link-wrp">
                <a href="dropbox.php"><i class="fab fa-dropbox"></i>Dropbox</a>
            </div>
            <div class="link-wrp">
                <a href="pcloud.php"><i class="fab fa-cloudversify"></i>Pcloud</a>
            </div>
            <div class="link-wrp">
                <a href="logs.php"><i class="fas fa-address-book"></i>Logs</a>
            </div>
            <div class="link-wrp">
                <a href="profile.php"><i class="fas fa-user-alt"></i>Profile</a>
            </div>
            <div class="link-wrp">
                <a href="logout.php"><i class="fas fa-power-off"></i>Logout</a>
            </div>
        </div>
    </div>
</div>