<?php
require_once('./includes/nav.php');
require_once('../includes/functions.php');
$results = fetchData("SELECT * FROM user ");
?>
<div class="bread-crumbs-wrp">
    <div class="container-fluid">
        <div class="bread-crumbs">
            <a href="<?php echo ROOT_URL . "/admin/index.php";  ?>">Dashboard</a>&gt;
            <a class="active" href="users.php">Users</a>
        </div>
    </div>
</div>
<div class="logs-ottr-wrp g-grey-bgclr">
    <div class="logs-innr-wrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="logs-ttle">
                        Showing all users</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <button class="btn g-blu-btn" data-toggle="modal" data-target="#insertModal"><i class="fas fa-user-plus"></i>&nbsp;Add New User</button>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <?php foreach ($results as $result) : ?>
                    <div class="col-sm-2">
                        <div class="t-usr-wrp text-center">
                            <div class="t-usr-avtr-img">
                                <img src="../images/undraw_profile_pic_ic5t.svg" alt="avatar">
                            </div>
                            <div class="t-usr-name ">
                                <?php echo $result['name'] ?>
                            </div>
                            <div class="t-usr-eml">
                                <?php echo $result['email'] ?>
                            </div>
                            <div class="t-usr-actn text-right">
                                <button data-toggle="modal" data-target="#updateModal" updt-id="<?php echo $result['id']  ?>" updt-name="<?php echo $result['name']  ?>" updt-api1="<?php echo $result['api_key']  ?>" updt-api2="<?php echo $result['api_key2']  ?>" updt-salt="<?php echo $result['salt_key']  ?>" class="usr-updt updt-mdl-map"><i class="fas fa-pen"></i></button>
                                <button data-toggle="modal" data-target="#deleteModal" del-id="<?php echo $result['id']  ?>" del-name="<?php echo $result['name']  ?>" class="usr-del del-mdl-map"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- Inser Modal -->
<div id="insertModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <form class="insert-form" action="user-crud.php" method="POST" name="insert-user">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usr">Name:</label>
                        <input name="usr-name" type="text" class="form-control" id="usr" required>
                    </div>
                    <div class="form-group">
                        <label for="usr">Email Account Registered with Cloud Platform:</label>
                        <input name="usr-email" type="Email" class="form-control" id="usr" required>
                    </div>
                    <div class="form-group">
                        <label for="usr">Password:</label>
                        <input name="usr-pswd" type="password" class="form-control" id="usr" required>
                    </div>
                    <div class="form-group">
                        <label for="usr">Salt Key(must be a number):</label>
                        <input name="usr-salt" type="text" class="form-control" id="usr" pattern="\d*" maxlength="2" required>
                    </div>
                    <div class="form-group">
                        <label for="usr">API Key1:</label>
                        <input name="usr-api1" type="text" class="form-control" id="usr" required>
                    </div>
                    <div class="form-group">
                        <label for="usr">API Key2:</label>
                        <input name="usr-api2" type="text" class="form-control" id="usr" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn g-blu-btn"><i class="fas fa-user-plus"></i>&nbsp;Add New User</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Update modal -->
<div id="updateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update User</h4>
            </div>
            <form class="update-form" action="user-crud.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="updt-id">
                    <div class="form-group">
                        <label>Name:</label>
                        <input name="updt-name" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Salt Key(must be a number):</label>
                        <input name="updt-salt" type="text" class="form-control" pattern="\d*" maxlength="2" required>
                    </div>
                    <div class="form-group">
                        <label>API Key1:</label>
                        <input name="updt-api1" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>API Key2:</label>
                        <input name="updt-api2" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn g-blu-btn">Update</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Delete modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete User</h4>
            </div>
            <form class="delete-form" action="user-crud.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="del-id">
                    Are you sure you want to delete <span id="del-usr-name"></span>?
                </div>
                <div class="modal-footer">
                    <button class="btn g-red-btn">Delete</button>
                </div>
            </form>
        </div>

    </div>
</div>



<?php
require_once('../includes/footer.php');
?>