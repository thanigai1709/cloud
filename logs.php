<?php
require_once('./includes/header.php');
require_once('./includes/nav.php');
require_once('./includes/functions.php');

$usr_id = $_SESSION['user']['user_id'];
$results = fetchData("SELECT * FROM trace_log WHERE user_id='$usr_id' ORDER BY created_at DESC");

foreach ($results as $result) {
    $result['log'] = logDecode($result['log'], $_SESSION['user']['crypt_key']);
}
?>
<div class="bread-crumbs-wrp">
    <div class="container-fluid">
        <div class="bread-crumbs">
            <a href="http://localhost/zcloud">Dashboard</a>&gt;
            <a class="active" href="logs.php">Logs</a>
        </div>
    </div>
</div>
<div class="logs-ottr-wrp g-grey-bgclr">
    <div class="logs-innr-wrp">
        <div class="container-fluid">
            <div class="logs-ttle">
                Showing logs of <span><?php echo $_SESSION['user']['user_name']  ?></span>
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
                                <td><?php echo logDecode($result['log'], $_SESSION['user']['crypt_key']) ?></td>
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
require_once('includes/footer.php');
?>