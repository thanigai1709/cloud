<?php
require_once('includes/header.php');
require_once('./includes/nav.php');
require_once('includes/config.php');
?>
<div class="dropbx-page-wrp g-grey-bgclr">
    <div class="bread-crumbs-wrp">
        <div class="container-fluid">
            <div class="bread-crumbs">
                <a href="<?php echo ROOT_URL;  ?>">Dashboard</a>>
                <a class="active" href="pcloud.php">pCloud</a>
            </div>
        </div>
    </div>

    <div class="container-fluid section-tp-pd ">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="logs-ttle">
                    <i class="fab fa-cloudversify"></i> Pcloud Storage
                </div>
            </div>
            <div class="col-md-6 text-right">
                <input type="file" name="" id="fileUpload">
                <label for="fileUpload" class="btn g-blu-btn"><i class="fas fa-upload icon-space"></i>Upload Files</label>
            </div>
        </div>
        <hr>
        <div id="files-list" class="row">

        </div>
        <div>Download action temporarily suspended by pColud support team due to technical issues. Please refer <a href="https://github.com/pCloud/pcloud-sdk-js/issues/6">https://github.com/pCloud/pcloud-sdk-js/issues/6</a> </div>
    </div>
</div>
<script>
    String.prototype.trunc =
        String.prototype.trunc ||
        function(n) {
            return this.length > n ? this.substr(0, n - 1) + "&hellip;" : this;
        };
    var client = null;
    pCloudSdk.oauth.initOauthPollToken({
        client_id: "<?php echo $_SESSION['user']['api_key2'] ?>",
        receiveToken: function(access_token) {
            client = pCloudSdk.createClient(access_token)
            client.listfolder(0).then((response) => {
                console.log(response.contents)
                response.contents.map(function(content) {
                    renderFileList(content)
                })
            });
        },
        onError: function(err) {}
    });

    function renderFileList(file) {
        $("#files-list").append(
            '<div class="col-md-2"> <div class="file-item-wrp"> <div class="item-img text-center"><img src="images/document.png" alt="icon"></div><div class="item-cnt"> ' +
            file.name.trunc(18) +
            '</div><div class="item-size">' + bytesToSize(file.size) + '</div> <div class="action-btns"><button file-id="' + file.fileid + '" file-name="' + file.name + '"  class="file-del"><i class="fas fa-trash-alt"></i></button></div></div></div>'
        );

    }

    function trashFile(fileId, fileName) {
        client.deletefile(parseInt(fileId)).then(function(resp) {
            if (resp) {
                pushLogs('<?php echo $_SESSION['user']['user_name'] ?> has deleted ' +
                    fileName + ' from pCloud');
                alert(fileName + ' sucessfully deleted')
            }
        })
    }

    function uploadFile(file) {
        client.upload(file, 0, {
            onBegin: function() {
                console.log('Upload started.');
            },
            onProgress: function(progress) {
                console.log(progress.direction, progress.loaded, progress.total);
            },
            onFinish: function(uploadData) {
                pushLogs('<?php echo $_SESSION['user']['user_name'] ?> has uploaded ' +
                    uploadData.metadata.name + ' into pCloud');
                alert(uploadData.metadata.name + ' sucessfully uploaded');

            }
        });
    }

    function bytesToSize(bytes) {
        var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
        if (bytes == 0) return "0 Byte";
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];

    }

    $(document).on("click", ".file-del", function() {
        trashFile($(this).attr('file-id'), $(this).attr('file-name'));
    });

    $(document).on("change", "#fileUpload", function() {
        uploadFile($("#fileUpload")[0].files[0]);
    })

    function pushLogs(log_msg) {
        $.ajax({
            type: 'POST',
            url: 'logs-api.php',
            data: {
                'user_id': "<?php echo $_SESSION['user']['user_id'] ?>",
                'crypt_key': "<?php echo $_SESSION['user']['crypt_key'] ?>",
                'log-msg': log_msg
            },
            success: function(resp) {
                if (resp) {
                    location.reload();
                } else {
                    console.log('error in pushing logs')
                }
            }
        })
    }
</script>
<?php
require_once('includes/footer.php');
?>