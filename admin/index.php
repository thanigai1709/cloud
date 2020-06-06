<?php
require_once('./includes/nav.php');
require_once('../includes/functions.php');
$user_count = fetchData("SELECT COUNT(id) as total from user")->fetch_assoc();
$users_id = fetchData("SELECT * FROM user");
$user_names = array();
$logs_count = array();
$recent_logs = fetchData("SELECT * FROM trace_log ORDER BY created_at DESC LIMIT 10");
foreach ($users_id as $id) {
    array_push($user_names, $id['name']);
    $temp_id = $id['id'];
    $temp_logcount = fetchData("SELECT COUNT(id) as total from trace_log  WHERE user_id=$temp_id")->fetch_assoc();
    array_push($logs_count, $temp_logcount['total']);
}

// $chart_user_names =  rtrim(implode(',', $user_names), ',');
// $chart_logs_count = rtrim(implode(',', $logs_count), ',');
?>
<div class="zcld-dshbrd-cnt-wrp g-grey-bgclr">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="dashbrd-item match-height">
                    <div class="dashbrd-item-wrp">
                        <div class="dashbrd-item-img">
                            <img src="../images/users.png" alt="icon">
                        </div>
                        <div class="dashbrd-item-ttle">
                            <?php echo $user_count['total']; ?> users found
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashbrd-chrt-wrp match-height">
                    <canvas id="chart_stat"></canvas>
                </div>
            </div>
        </div>

        <hr>
        <div class="logs-ttle">
            Recent Logs
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
                    foreach ($recent_logs as $result) : ?>
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
<script>
    var chart_colors = new Array();
    var chart_labels = new Array();
    <?php foreach ($user_names as $key => $val) { ?>
        chart_labels.push('<?php echo $val; ?>');
        chart_colors.push('rgb(0, 98, 255)')
    <?php } ?>
    var chart_data = new Array();
    <?php foreach ($logs_count as $key => $val) { ?>
        chart_data.push(<?php echo $val; ?>);
    <?php } ?>
    var score_chrt_obj = $('#chart_stat');
    Chart.defaults.global.defaultFontFamily = 'Roboto';
    Chart.defaults.global.defaultFontSize = 14;
    Chart.defaults.global.defaultFontColor = '#333';
    Chart.defaults.global.defaultFontStyle = 'normal'
    var score_paststat = new Chart(score_chrt_obj, {
        type: 'bar',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Actions Done',
                data: chart_data,
                backgroundColor: chart_colors
            }]
        },
        options: {
            title: {
                display: true,
                text: 'User usage stats',
                fontSize: 18,
                padding: 16,
                fontStyle: 'normal'
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            // when the floored value is the same as the value we have a whole number
                            if (Math.floor(label) === label) {
                                return label;
                            }

                        },
                    }
                }],
            },
        }
    });
    $('.match-height').matchHeight();
</script>
<?php require_once('../includes/footer.php'); ?>