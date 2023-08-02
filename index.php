<?php
$message = "";
include("config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
    $is_error = 0;
    $result = "SELECT * FROM sup_account_users WHERE user_name='" . $_POST["user"] . "' and u_password = '" . (md5($_POST["pass"])) . "'";
    $q = mysqli_query($sup_db,$result);
    $row = mysqli_fetch_array($q);
    if (is_array($row)) {
        $_SESSION["id"] = $row['u_id'];
        $_SESSION["user"] = $row['user_name'];
        $_SESSION["name"] = $row['user_name'];
        $_SESSION["email"] = $row['u_email'];
        $_SESSION["uu_img"] = $row['u_profile_pic'];
        $_SESSION["role_id"] = $row['role'];
        $logid = $row['u_id'];
        $_SESSION["fullname"] = $row['u_firstname'] . "&nbsp;" . $row['u_lastname'];
        $_SESSION["pin"] = $row['pin'];
        $_SESSION["pin_flag"] = $row['pin_flag'];
        $pin = $row['pin'];
        $pin_flag = $row['pin_flag'];
        mysqli_query($sup_db, "INSERT INTO `sup_session_log`(`u_id`,`created_at`) VALUES ('$logid','$chicagotime')");
    } else {
        $result = mysqli_query($sup_db, "SELECT * FROM sup_account_users WHERE u_status = '0' AND user_name='" . $_POST["user"] . "' and u_password = '" . (md5($_POST["pass"])) . "'");
        $row = mysqli_fetch_array($result);
        if (is_array($row)) {
            $message_stauts_class = $_SESSION["alert_danger_class"];
            $import_status_message = $_SESSION["error_6"];
            $is_error = 1;
        } else {
            $message_stauts_class = $_SESSION["alert_danger_class"];
            $import_status_message = $_SESSION["error_1"];
            $is_error = 1;
        }
    }
    if ($is_error == 0) {
        header("Location:active_orders.php");
    }
}
$tmp = $_SESSION['temp'];
$_SESSION['temp'] = "";
if ($tmp == "forgotpass_success") {
    $message_stauts_class = $_SESSION["alert_success_class"];
    $import_status_message = $_SESSION["error_2"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
    <script src="assets/js/vendor.bundle.base.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
</head>
<body>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <div class="card col-lg-4 mx-auto">
                    <div class="row" style="font-size: 26px;">
                        <?php
                        if (!empty($import_status_message)) {
                            echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                        }
                        ?>
                    </div>
                    <div class="card-body px-5 py-5">
                        <h3 class="card-title text-left mb-3">Login</h3>
                        <form action="" class="form-validate" method="post">
                            <div class="form-group">
                                <label  style="margin-left: -269px;"  >Username or email *</label>
                                <input type="text" name="user" id="user" class="form-control" placeholder="Username / Email" required="required">
                            </div>
                            <div class="form-group">
                                <label  style="margin-left: -340px;" >Password *</label>
                                <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required="">
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between" style="margin-left: 120px;">
                                <a href="forgotpass.php" class="forgot-pass">Forgot password</a>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script>
    function myFunction() {
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";

        } else {
            x.type = "password";
        }
    }
</script>
</body>
</html>