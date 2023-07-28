<?php
$message = "";
include("config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
    $is_error = 0;
    $result = mysqli_query($db, "SELECT * FROM sup_account_users WHERE user_name='" . $_POST["user"] . "' and u_password = '" . (md5($_POST["pass"])) . "'");
    $row = mysqli_fetch_array($result);
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
        mysqli_query($db, "INSERT INTO `sup_session_log`(`u_id`,`created_at`) VALUES ('$logid','$chicagotime')");
    } else {
        $result = mysqli_query($db, "SELECT * FROM sup_account_users WHERE u_status = '0' AND user_name='" . $_POST["user"] . "' and u_password = '" . (md5($_POST["pass"])) . "'");
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
<html lang="en">
<title></title>
<header>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/index_js/jquery.min.js"></script>
    <script src="assets/js/index_js/popper.js"></script>
    <script src="assets/js/index_js/bootstrap.min.js"></script>
    <script src="assets/js/index_js/main.js"></script>
    <style>
        body {margin: 0; height: 100%; overflow: hidden}
    </style>
</header>
<body data-new-gr-c-s-check-loaded="14.1116.0" data-gr-ext-installed="">
<section class="ftco-section">
    <?php
    if (!empty($import_status_message)) {
        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
    }
    ?>
    <form action="" class="form-validate" method="post">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section"></h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap py-5">
                    <div class="img d-flex align-items-center justify-content-center">
                        <img src="assets/images/site_logo.png" alt="" style="width:100px;"/>
                    </div>
                    <h3 class="text-center">Login to your account</h3>
                    <form action="#" class="login-form">
                        <div class="form-group">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
                            <input type="text" class="form-control" name="user" id="user" placeholder="Username / Email" required="required" style="color:white;">
                        </div>
                        <div class="form-group">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock"></span></div>
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required="">
                            <span toggle="#password-field" onclick="myFunction()" class="fa fa-fw fa-eye field-icon toggle-password" style="margin-left: 381px;margin-top: -29px;"></span>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-100 text-left">
                                <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                    <input type="checkbox" checked="" wfd-id="id2">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-100 text-md-right">
                                <a href="forgotpass.php">Forgot Password</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn form-control btn-primary rounded submit px-3" style="background-color:#1e73be;">Sign In</button>
                        </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</section>
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