<?php
require_once('./includes/header.php');
require_once('./includes/nav.php');
require_once('./includes/functions.php');
$user = $_SESSION['user'];
$usr_id = $user['user_id'];
$result = fetchData("SELECT * FROM user WHERE id='$usr_id'")->fetch_assoc();
?>

<div class="zcld-profile-wrp">
    <div class="zcld-profile-innr">
        <div class="container">
            <div class="zcld-profile-dtls">
                <div class="row-flex">
                    <div class="col-5">
                        <div class="zcld-profile-logo">
                            <img src="images/undraw_profile_pic_ic5t.svg" alt="icon">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="profile-user-name">
                            <?php echo $result['name'] ?>
                        </div>
                        <div class="profile-user-dtls">
                            <?php echo $result['email'] ?>
                        </div>
                        <div class="profile-user-dtls">
                            Date Created: <?php echo $result['created_at'] ?>
                        </div>
                        <div class="profile-user-api">

                            <form action="cloud_crud.php" method="POST" name="api-key">
                                <div class="profile-user-api-key">
                                    <span>API key1</span>
                                    <input type="text" name="profile-api" id="" value="<?php echo $result['api_key'] ?>" required>
                                    <span>API key2</span>
                                    <input type="text" name="profile-api2" id="" value="<?php echo $result['api_key2'] ?>" required>
                                    <span><button class="btn g-blu-btn">Update</button></span>
                                </div>
                            </form>
                        </div>
                        <div class="profile-user-settings">
                            <span data-toggle="modal" data-target="#profile-settings"><i class="fas fa-user-cog"></i>Settings</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div id="profile-settings" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Profile Settings</h4>
                        </div>
                        <div class="modal-body">
                            <form action="cloud_crud.php" method="POST">
                                <div class="form-group">
                                    <label for="email">Profile Name:</label>
                                    <input type="text" class="form-control" name="profile-name" value="<?php echo $result['name'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" class="form-control" name="profile-pwd">
                                </div>
                                <hr>
                                <div class="profile-update-form text-right">
                                    <button class="btn g-blu-btn">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once('includes/footer.php');
?>