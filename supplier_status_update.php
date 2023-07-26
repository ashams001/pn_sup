<?php include("config.php");
if (!isset($_SESSION['user'])) {
    header('location: ./../logout.php');
}
$temp = "";
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
$chicagotime = date("Y-m-d H:i:s");

if($_SESSION['role_id'] === 'super'){
    $role = 1;
}else{
    $role = $_SESSION['role_id'];
}
/*$user_id = $_SESSION["id"];
if (count($_POST) > 0) {
    $message_stauts_class = '';
    $import_status_message = '';
    if(null != $_POST['op_type'] && $_POST['op_type'] == "del_file"){
        $file_name = $_POST['file_name'];
        $file_type = $_POST['file_type'];
        $order_id = $_POST['order_id'];
        $path = "./order_invoices/" . $_POST['file_name'];
        unlink($path);
        $sql = "DELETE FROM `order_files` where order_id = '$order_id' and file_type ='$file_type' and file_name= '$file_name'";
        $result1 = mysqli_query($sup_db, $sql);
        exit();
    }else{
        $order_status_id = $_POST['edit_order_status'];
        $e_order_status = $_POST['e_order_status'];
        $order_id = $_POST['edit_order_id'];
        if (!is_null($order_status_id) && !empty($order_status_id)) {
            $sql = "update sup_order set order_status_id='$order_status_id', modified_on='$chicagotime', modified_by='$user_id' where  order_id = '$order_id'";
            $result1 = mysqli_query($sup_db, $sql);
            if ($result1) {
                $sql_ses_log = "INSERT INTO `supplier_session_log`(`order_id`, `c_id`, `order_status_id`, `created_by`, `created_on`) VALUES ('$order_id','','$order_status_id','$user_id','$chicagotime')";
                $result_log = mysqli_query($sup_db, $sql_ses_log);
                $message_stauts_class = 'alert-success';
                $import_status_message = 'Order status Updated successfully.';
            } else {
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: Please Insert valid data';
            }
        } else {
            $order_status_id = $_POST['edit_order_status_id'];
            $order_up_status_id = $_POST['edit_up_order_status_id'];
            $e_order_status = $_POST['e_order_status'];
            $order_id = $_POST['edit_id'];
            $is_updated = true;
            if (null != $order_id) {
                $ship_det = $_POST['edit_ship_details'];
                if (null != $ship_det) {
                    $sql = "update sup_order set order_status_id='$order_up_status_id',shipment_details = '$ship_det' , modified_on = '$message', modified_by='$user_id' where  order_id = '$order_id'";
                    $result1 = mysqli_query($sup_db, $sql);
                    if (!$result1) {
                        $is_updated = false;
                    }
                }
                if (!$is_updated) {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Error updating  order. Try after sometime.';
                }
                //invoice
                if (isset($_FILES['invoice'])) {
                    $errors = array();
                    $file_name = $_FILES['invoice']['name'];
                    $file_size = $_FILES['invoice']['size'];
                    $file_tmp = $_FILES['invoice']['tmp_name'];
                    $file_type = $_FILES['invoice']['type'];
                    $file_ext = strtolower(end(explode('.', $file_name)));
                    $extensions = array("jpeg", "jpg", "png", "pdf");
                    if (in_array($file_ext, $extensions) === false) {
                        $errors[] = "extension not allowed, please choose a JPEG/PNG/PDF file.";
                        $message_stauts_class = 'alert-danger';
                        $import_status_message = 'Error: Extension not allowed, please choose a JPEG/PNG/PDF file.';
                    }
                    if ($file_size > 2097152) {
                        $errors[] = 'Max allowed file size is 2 MB';
                        $message_stauts_class = 'alert-danger';
                        $import_status_message = 'Error: File size must not exceed 2 MB';
                    }
                    if (empty($errors) == true) {
                        $file_name = $order_id . '__' . $file_name;
                        move_uploaded_file($file_tmp, "./order_invoices/" . $file_name);
                        $sql = "INSERT INTO `order_files`(`order_id`, `file_type`, `file_name`, `created_at`) VALUES ('$order_id' ,'invoice','$file_name','$chicagotime' )";
                        $result1 = mysqli_query($sup_db, $sql);
                    }

                }
                //attachments
                if (isset($_FILES['attachments'])) {
                    foreach ($_FILES['attachments']['name'] as $key => $val) {

                        $errors = array();
                        $file_name = $_FILES['attachments']['name'][$key];
                        $file_size = $_FILES['attachments']['size'][$key];
                        $file_tmp = $_FILES['attachments']['tmp_name'][$key];
                        $file_type = $_FILES['attachments']['type'][$key];
                        $file_ext = strtolower(end(explode('.', $file_name)));
                        $extensions = array("jpeg", "jpg", "png", "pdf");
                        if (in_array($file_ext, $extensions) === false) {
                            $errors[] = "extension not allowed, please choose a JPEG/PNG/PDF file.";
                            $message_stauts_class = 'alert-danger';
                            $import_status_message = 'Error: Extension not allowed, please choose a JPEG/PNG/PDF file.';
                        }
                        if ($file_size > 2097152) {
                            $errors[] = 'Max allowed file size is 2 MB';
                            $message_stauts_class = 'alert-danger';
                            $import_status_message = 'Error: File size must not exceed 2 MB';
                        }
                        if (empty($errors) == true) {
                            $file_name = $order_id . '__' . $file_name;
                            move_uploaded_file($file_tmp, "./order_invoices/" . $file_name);
                            $sql = "INSERT INTO `order_files`(`order_id`, `file_type`, `file_name`, `created_at`) VALUES ('$order_id' ,'attachment','$file_name','$chicagotime' )";
                            $result1 = mysqli_query($sup_db, $sql);

                        }
                    }
                }
                $sql_ses_log = "INSERT INTO `supplier_session_log`(`order_id`, `c_id`, `order_status_id`, `created_by`, `created_on`) VALUES ('$order_id','','$order_status_id','$user_id','$chicagotime')";
                $result_log = mysqli_query($sup_db, $sql_ses_log);
            }
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Order status Updated successfully.';
        }
    }
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Active Orders</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo $siteURL . "/assets/css/icons/icomoon/styles.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL . "/assets/css/bootstrap.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL . "/assets/css/core.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL . "/assets/css/components.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL . "/assets/css/colors.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL . "/assets/css/style_main.css" ?>" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/plugins/loaders/pace.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/core/libraries/jquery.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/core/libraries/bootstrap.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/plugins/loaders/blockui.min.js" ?>"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/plugins/tables/datatables/datatables.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/plugins/forms/selects/select2.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/core/app.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/pages/datatables_basic.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/plugins/ui/ripple.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/plugins/notifications/sweet_alert.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo $siteURL . "/assets/js/pages/components_modals.js" ?>"></script>
    <!--chart -->
    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
            overflow: hidden;
        }
        .content {
            padding: 0px 15px !important;
            background-color: #060818;
        }
        @media screen and (min-width: 2560px) {
            .dashboard_line_heading {
                font-size: 22px !important;
                padding-top: 5px;
            }
        }

        .thumb img:not(.media-preview) {
            height: 150px !important;
        }
    </style>

</head>

<?php
$cam_page_header = "Active Orders";
include("./sup_header.php");
include("./sup_admin_menu.php");
?>
<body>
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <div class="content-wrapper">
            <!-- Content area -->
            <div>
                <?php if ($temp == "one") { ?>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                class="sr-only">Close</span></button>
                        <span class="text-semibold">Form Type</span> Created Successfully.
                    </div>
                <?php } ?>
                <?php if ($temp == "two") { ?>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                class="sr-only">Close</span></button>
                        <span class="text-semibold">Form Type</span> Updated Successfully.
                    </div>
                <?php } ?>
                <?php
                if (!empty($import_status_message)) {
                    echo '<div class="alert-dismissible fade show alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_stauts_class'] = '';
                    $_SESSION['import_status_message'] = '';
                }
                ?>
            </div>
        </div>
        <div class="content">
            <form action="" id="update-form" method="post" class="form-horizontal">
                <div class="panel panel-flat">
                    <?php
                      $id = $_GET['id'];
                      $sql = "select * from sup_order where order_id = '$id'";
                      $result = mysqli_query($db, $sql);
                      $row = mysqli_fetch_array($result);
                      $order_desc = $row['order_desc'];
                      $order_status_id = $row['order_status_id'];
                      $created_on = $row['created_on'];
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="">
                                    <div class="card-header">
                                        <span class="main-content-title mg-b-0 mg-b-lg-1">Create Iot Device</span>
                                    </div>
                                    <form action="" id="sup_update" enctype="multipart/form-data" method="post">
                                        <!--<div class="pd-30 pd-sm-20">
                                            <div class="row row-xs">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0">Customer : </label>
                                                </div>
                                                <div class="col-md-6 mg-t-10 mg-md-t-0">
                                                    <select name="customer" id="customer" class="form-control form-select select2" data-placeholder="Select Customer">
                                                        <option value="" selected> Select Customer </option>
                                                        <?php
/*
                                                        $st_dashboard = $_POST['customer'];

                                                        $sql1 = "SELECT * FROM `cus_account` where is_deleted != 1";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if($st_dashboard == $row1['c_id'])
                                                            {
                                                                $entry = 'selected';
                                                            }
                                                            else
                                                            {
                                                                $entry = '';

                                                            }
                                                            echo "<option value='" . $row1['c_id'] . "' $entry>" . $row1['c_name'];"</option>";
                                                        }
                                                        */?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="pd-30 pd-sm-20">
                                            <div class="row row-xs">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0">Device Id : </label>
                                                </div>
                                                <div class="col-md-6 mg-t-10 mg-md-t-0">
                                                    <input type="text" name="dev_id" id="dev_id" class="form-control" placeholder="Enter Device Id" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pd-30 pd-sm-20">
                                            <div class="row row-xs">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0">Device Name : </label>
                                                </div>
                                                <div class="col-md-6 mg-t-10 mg-md-t-0">
                                                    <input type="text" name="dev_name" id="dev_name" class="form-control" placeholder="Enter Device Name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pd-30 pd-sm-20">
                                            <div class="row row-xs">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0">Device Description : </label>
                                                </div>
                                                <div class="col-md-6 mg-t-10 mg-md-t-0">
                                                    <input type="text" name="dev_desc" id="dev_desc" class="form-control" placeholder="Enter Device Description" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pd-30 pd-sm-20">
                                            <div class="row row-xs">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0">Device Location : </label>
                                                </div>
                                                <div class="col-md-6 mg-t-10 mg-md-t-0">
                                                    <input type="text" name="dev_loc" id="dev_loc" class="form-control" placeholder="Enter Device Location" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pd-30 pd-sm-20">
                                            <div class="card">
                                                <div>
                                                    <button type="submit" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5" id="part_submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include("footer1.php"); ?>
</body>
</html>