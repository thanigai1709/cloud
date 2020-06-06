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
                <a class="active" href="dropbox.php">Dropbox</a>
            </div>
        </div>
    </div>

    <div class="container-fluid section-tp-pd ">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="logs-ttle">
                    <i class="fab fa-dropbox"></i> Dropbox Storage
                </div>
            </div>
            <div class="col-md-6 text-right">
                <!-- <form action="">
                <label for=""></label>
                <input type="file" name="" id="">
            </form> -->
                <input type="file" name="" id="fileUpload">
                <label for="fileUpload" class="btn g-blu-btn"><i class="fas fa-upload icon-space"></i>Upload Files</label>
            </div>
        </div>
        <hr>
        <div id="files-list" class="row">

        </div>
    </div>
</div>

<script>
    String.prototype.trunc =
        String.prototype.trunc ||
        function(n) {
            return this.length > n ? this.substr(0, n - 1) + "&hellip;" : this;
        };
    var dbx = new Dropbox.Dropbox({
        accessToken: "<?php echo $_SESSION['user']['api_key'] ?>"
    });
    dbx
        .filesListFolder({
            path: ""
        })
        .then(function(response) {
            response.entries.map(function(entry) {
                if (entry[".tag"] != "folder") {
                    fetchDownloadlinks({
                        path: entry.path_display,
                        rev: entry.rev
                    });
                } else {
                    console.log(entry);
                }
            });
        })
        .catch(function(error) {
            console.error(error);
        });

    function fetchDownloadlinks(obj) {
        dbx
            .filesDownload({
                path: obj.path,
                rev: obj.rev
            })
            .then(function(data) {
                renderFilelist(data);
                $(".file-item-wrp").matchHeight();
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function trashFile(path) {
        dbx
            .filesDelete({
                path: path
            })
            .then(function(response) {
                pushLogs('<?php echo $_SESSION['user']['user_name'] ?> has deleted ' +
                    response.name + ' from Dropbox');
                alert(response.name + ' sucessfully deleted');
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function uploadFile(file) {
        dbx.filesUpload({
                path: '/' + file.name,
                contents: file
            })
            .then(function(response) {
                pushLogs('<?php echo $_SESSION['user']['user_name'] ?> has uploaded ' +
                    response.name + ' into Dropbox');
                alert(response.name + ' sucessfully uploaded');

            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function renderFilelist(file) {
        $("#files-list").append(
            '<div class="col-md-2"> <div class="file-item-wrp"> <div class="item-img text-center"><img src="images/document.png" alt="icon"></div><div class="item-cnt"> ' +
            file.name.trunc(18) +
            '</div><div class="item-size">' + bytesToSize(file.size) + '</div> <div class="action-btns"><a href="' +
            URL.createObjectURL(file.fileBlob) +
            '" download="' +
            file.name +
            '" class="file-dwld"><i class="fas fa-download"></i></a ><button path="' +
            file.path_display +
            '" class="file-del"><i class="fas fa-trash-alt"></i></button></div></div></div>'
        );
    }

    function bytesToSize(bytes) {
        var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
        if (bytes == 0) return "0 Byte";
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
    }

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
                if (!resp) {
                    console.log('error in pushing logs')
                } else {
                    location.reload();
                }
            }
        })
    }

    $(document).on("click", ".file-del", function() {
        trashFile($(this).attr('path'));
    });

    $(document).on("change", "#fileUpload", function() {
        uploadFile($("#fileUpload")[0].files[0]);
    });

    $(document).on("click", ".file-dwld", function() {
        let log_msg = '<?php echo $_SESSION['user']['user_name'] ?> has downloaded ' +
            $(this).attr('download') + ' from Dropbox';
        $.ajax({
            type: 'POST',
            url: 'logs-api.php',
            data: {
                'user_id': "<?php echo $_SESSION['user']['user_id'] ?>",
                'crypt_key': "<?php echo $_SESSION['user']['crypt_key'] ?>",
                'log-msg': log_msg
            },
            success: function(resp) {
                if (!resp) {
                    console.log('error in pushing logs')
                }
            }
        })
    });
</script>
<?php
require_once('includes/footer.php');
?>