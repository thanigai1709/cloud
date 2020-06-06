<?php
require_once('./includes/nav.php');
require_once('../includes/functions.php');
$results = fetchData("SELECT * FROM trace_log ORDER BY created_at DESC");
$users = fetchData("SELECT * FROM user");
if (isset($_GET['filter-usr'])) {
    $id = $_GET['filter-usr'];
    $results = fetchData("SELECT * FROM trace_log  WHERE user_id='$id' ORDER BY created_at DESC");
    $filter_name = fetchData("SELECT * FROM user  WHERE id='$id'")->fetch_assoc();
}
?>
<div class="bread-crumbs-wrp">
    <div class="container-fluid">
        <div class="bread-crumbs">
            <a href="<?php echo ROOT_URL . "/admin/index.php";  ?>">Dashboard</a>&gt;
            <a class="active" href="logs.php">Logs</a>
        </div>
    </div>
</div>
<div class="logs-ottr-wrp g-grey-bgclr">
    <div class="logs-innr-wrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="logs-ttle">
                        <?php if (isset($filter_name) && !empty($filter_name)) : ?>
                            Showing logs for <?php echo $filter_name['name']; ?>
                        <?php else : ?>
                            Showing logs for all
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                        <select class="form-control filter" name="filter-usr" id="">
                            <option selected="selected" disabled>Select..</option>                            
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user['id'] ?>"><?php echo $user['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn g-blu-btn">Filter</button></form>
                </div>
            </div>
            <div class="logs-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S no</th>
                            <th>TimeStamp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1;
                        foreach ($results as $result) : ?>
                            <tr>
                                <td><?php echo $index ?></td>
                                <td><?php echo $result['created_at'] ?></td>
                                <td><?php echo adminDecode($result['log'], $result['user_id']) ?></td>
                            </tr>
                        <?php $index++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
require_once('../includes/footer.php');
?>