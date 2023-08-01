<?php
@ob_start();
ini_set('display_errors', FALSE);
$message = "";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

include("config.php");
if (count($_POST) > 0) {
    $email = $_POST['email'];
    $result = mysqli_query($sup_db, "SELECT * FROM sup_account_users WHERE u_email='" . $_POST["email"] . "'");
    $row = mysqli_fetch_array($result);
    if (is_array($row)) {
        $id = $row['u_id'];
        $name = $row['user_name'];
        $password = "PW" . rand(10000, 500000);
        $pp = md5($password);
        $link = $siteURL;
        $msg = "Note: This is one time password once you login system ask to change password.";
        $msg .= "<br>";
        $msg .= "Your new password is :-" . $password;
        $msg .= "<br>";
        $msg .= "Click to login the page :-" .$link;
        $sql = "update `sup_account_users` set `u_password` = '$pp' where `u_id`='$id'";
        mysqli_query($sup_db, $sql);
        $sql1 = "update `sup_account_users` set u_status = '1' where `u_id`='$id'";
        mysqli_query($sup_db, $sql1);
        $mail = new PHPMailer();
        $mail->isSMTP();
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASSWORD;
        $mail->setFrom('admin@plantnavigator.com', 'Admin Plantnavigator');
        $email = $row["u_email"];
        $lastname = $row["u_lastname"];
        $firstname = $row["u_firstname"];
        $mail->addAddress($email, $firstname);
        $signature = '- Plantnavigator Admin';
        $structure = '<html><body>';
        $structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello " . $firstname ." " . $lastname.",</span><br/><br/>";
        $structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $msg . "</span><br/> ";
        $structure .= "<br/><br/>";
        $structure .= $signature;
        $structure .= "</body></html>";
        $subject = "Password Recovery";
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $structure;
        if (!$mail->send()) {
        }
        $_SESSION['temp'] = "forgotpass_success";
        header("Location:change_pass.php");
    } else {
        $message_stauts_class = $_SESSION["alert_danger_class"];
        $import_status_message = $_SESSION["error_3"];
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |Forgot Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-gap {
            padding-top: 70px;
        }
        </style>
</head>

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                                <form id="form"  role="form"  class="form-validate" method="post">
                                    <?php
                                    if (!empty($import_status_message)) {
                                        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                    }
                                    ?>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <p>Note: If you don't have email kindly contact your admin to change password</p>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>forgotpass.php");
    }
    $(document).ready(function () {
        $("form").submit(function () {
            var aa = document.getElementById("email").value;
            if (aa == "") {
                alert("Email Cant be Empty");
                return false;
            }
        });
    });
</script>

</html>
