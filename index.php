<?php
require_once('./includes/header.php');
require_once('./includes/nav.php');
require_once('./includes/functions.php');

$usr_id = $_SESSION['user']['user_id'];
$results = fetchData("SELECT * FROM trace_log WHERE user_id='$usr_id' ORDER BY created_at DESC LIMIT 10");
?>

<div class="zcld-dshbrd-cnt-wrp g-grey-bgclr">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="dashbrd-item match-height">
                    <div class="dashbrd-item-wrp">
                        <div class="dashbrd-item-img">
                            <img src="images/dropbox-1-logo-png-transparent.png" alt="icon">
                        </div>
                        <div id="dropbx-count" class="dashbrd-item-ttle">
                            Fetching..
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashbrd-item match-height">
                    <div class="dashbrd-item-wrp">
                        <div class="dashbrd-item-img">
                            <img src="images/pcloud.png" alt="icon">
                        </div>
                        <div id="pcld-count" class="dashbrd-item-ttle">
                            Fetching..
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
<script>
    const chart_val = {
        dropbx: null,
        pcld: null
    }
    var dbx = new Dropbox.Dropbox({
        accessToken: "<?php echo $_SESSION['user']['api_key'] ?>"
    });
    dbx
        .filesListFolder({
            path: ""
        })
        .then(function(response) {
            $('#dropbx-count').text(response.entries.length + ' files in Dropbox')
            response.entries.map(function(entry) {
                chart_val.dropbx += entry.size;
            });
            pCloudSdk.oauth.initOauthPollToken({
                client_id: "<?php echo $_SESSION['user']['api_key2'] ?>",
                receiveToken: function(access_token) {
                    client = pCloudSdk.createClient(access_token)
                    client.listfolder(0).then((response) => {
                        $('#pcld-count').text(response.contents.length + ' files in pCloud')
                        chart_val.pcld = response.contents.length;
                        response.contents.map(function(content) {
                            chart_val.pcld += content.size;
                        })
                        var score_chrt_obj = $('#chart_stat');
                        Chart.defaults.global.defaultFontFamily = 'Roboto';
                        Chart.defaults.global.defaultFontSize = 14;
                        Chart.defaults.global.defaultFontColor = '#333';
                        Chart.defaults.global.defaultFontStyle = 'normal'
                        var score_paststat = new Chart(score_chrt_obj, {
                            type: 'bar',
                            data: {
                                labels: ['Dropbox(' + bytesToSize(chart_val.dropbx) + ')', 'pCloud(' + bytesToSize(chart_val.pcld) + ')'],
                                datasets: [{
                                    label: 'Space Occupied',
                                    data: [bytesToSizewithoutUnit(chart_val.dropbx), bytesToSizewithoutUnit(chart_val.pcld)],
                                    backgroundColor: [
                                        'rgb(0, 98, 255)',
                                        'rgb(28, 203, 212)'
                                    ]
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: 'Cloud Memory Stats',
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
                    });
                    setTimeout(function() {
                        $('.match-height').matchHeight();
                    }, 800);

                },
                onError: function(err) {}
            });
        })
        .catch(function(error) {
            console.error(error);
        });


    function bytesToSize(bytes) {
        var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
        if (bytes == 0) return "0 Byte";
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return parseFloat(bytes / Math.pow(1024, i), 2).toFixed(2) + " " + sizes[i];
    }

    function bytesToSizewithoutUnit(bytes) {
        var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
        if (bytes == 0) return "0 Byte";
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return parseFloat(bytes / Math.pow(1024, i), 2).toFixed(2);
    }
</script>

<?php
require_once('includes/footer.php');
?>