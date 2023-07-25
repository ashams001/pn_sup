<?php
include("config.php");
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
$temp = "";
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
$chicagotime = date("Y-m-d H:i:s");
$role = $_SESSION['role_id'];
$user_id = $_SESSION["id"];
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |Active Orders</title>
    <!-- Global stylesheets -->

    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <!--    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>

    <!--Internal  Datetimepicker-slider css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/amazeui.datetimepicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/jquery.simple-dtpicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/picker.min.css" rel="stylesheet">
    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/form_css/bootstrap-datepicker.css">
    <!-- Internal Select2 css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/select2.min.css" rel="stylesheet">
    <!-- STYLES CSS -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style-dark.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style-transparent.css" rel="stylesheet">
    <!---Internal Fancy uploader css-->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/fancy_fileupload.css" rel="stylesheet" />
    <!--Internal  Datepicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/datepicker.js"></script>
    <!-- Internal Select2.min js -->
    <!--Internal  jquery.maskedinput js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/jquery.maskedinput.js"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/spectrum.js"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/datetimepicker.min.js"></script>
    <!-- Ionicons js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/jquery.simple-dtpicker.js"></script>
    <!--Internal  pickerjs js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/picker.min.js"></script>
    <!--internal color picker js-->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/pickr.es5.min.js"></script>
    <script src="<?php echo $siteURL; ?>assets/js/form_js/colorpicker.js"></script>
    <!--Bootstrap-datepicker js-->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/bootstrap-datepicker.js"></script>
    <!-- Internal form-elements js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/form-elements.js"></script>
    <link href="<?php echo $siteURL; ?>assets/css/form_css/demo.css" rel="stylesheet"/>
    <link href="<?php echo $siteURL; ?>assets/css/select/select2.min.css" rel="stylesheet" />
    <script src="<?php echo $siteURL; ?>assets/js/select/select2.min.js"></script>

    <style>
        body {margin: 0; height: 100%; overflow: hidden}
        #form_settings {
            margin-left: 414px;
            margin-right: -70px;
            margin-top: -578px;
        }
        .navbar {

            padding-top: 0px!important;
        }
        .dropdown .arrow {

            margin-top: -25px!important;
            width: 1.5rem!important;
        }
        #ic .arrow {
            margin-top: -22px!important;
            width: 1.5rem!important;
        }
        .fs-6 {
            font-size: 1rem!important;
        }

        .content_img {
            width: 113px;
            float: left;
            margin-right: 5px;
            border: 1px solid gray;
            border-radius: 3px;
            padding: 5px;
            margin-top: 10px;
        }

        /* Delete */
        .content_img span {
            border: 2px solid red;
            display: inline-block;
            width: 99%;
            text-align: center;
            color: red;
        }
        .remove_btn{
            float: right;
        }
        .contextMenu{ position:absolute;  width:min-content; left: 204px; background:#e5e5e5; z-index:999;}
        .collapse.in {
            display: block!important;
        }
        .mt-4 {
            margin-top: 0rem!important;
        }
        .row-body {
            display: flex;
            flex-wrap: wrap;
            margin-left: -8.75rem;
            margin-right: 6.25rem;
        }



        table.dataTable thead .sorting:after {
            content: ""!important;
            top: 49%;
        }
        .card-title:before{
            width: 0;

        }
        .main-content .container, .main-content .container-fluid {
            padding-left: 20px;
            padding-right: 238px;
        }
        .main-footer {
            margin-left: -127px;
            margin-right: 112px;
            display: block;
        }
    </style>
</head>
<body class="ltr main-body app horizontal">
<?php
$cam_page_header = "Active Orders";
include('s_header.php');
include('s_sidemenu.php');
?>
<form action="" id="form_settings" method="post" class="form-horizontal">
<div class="row-body">
    <div class="col-12 col-sm-12">
        <div class="card" style="z-index: -1;">
            <div class="card-header" style="background: #1F5D96;">
                <h4 class="card-title">
                </h4>
            </div>
            <div class="card-body pt-0" style="margin-top: 33px;">
                <div class="table-responsive">
                    <table class="table datatable-basic table-bordered text-nowrap mb-0" id="example2">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Order Desc</th>
                            <th>Ordered On</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = sprintf("SELECT * FROM  sup_order  where order_active = 1 order by created_on DESC ;  ");
                        $qur = mysqli_query($sup_db, $query);
                        while ($rowc = mysqli_fetch_array($qur)) {
                            ?>
                            <tr>
                                <td><?php echo ++$counter; ?></td>
                                <?php $order_id = $rowc['order_id'];
                                $order_status_id = $rowc['order_status_id'];
                                $ship_det = $rowc['shipment_details']; ?>
                                <input hidden id="edit_order_id" name="edit_order_id"
                                       value="<?php echo $order_id; ?>">
                                <input hidden id="e_order_status" name="e_order_status"
                                       value="<?php echo $order_status_id; ?>">
                                <td><?php echo $rowc['order_desc']; ?></td>
                                <?php

                                $qurtemp = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id' ");
                                while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                    $order_status = $rowctemp["sup_order_status"];
                                }
                                ?>
                                <td><?php echo dateReadFormat($rowc['created_on']); ?></td>
                                <td><?php echo $order_status; ?></td>
                                <a href="order_edit.php">  <td>
                                        <a class="link-opacity-10-hover" href="order_edit.php?id=<?php echo $order_id ?>">Edit</a>
                                        <!-- <a class="btn btn-success btn-sm br-5 me-2" href="order_edit.php?id=<?php /*echo $order_id */?>">
                                        <i>
                                            <svg class="table-edit" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="16"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19zM20.71 5.63l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41z"></path></svg>
                                        </i>
                                    </a>-->
                                    </td></a>

                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
    <script>

        $('.select2').select2();

        $(".js-example-placeholder-single").select2({
            placeholder: "Select Stations",
            allowClear: true
        });
    </script>
</form>
</body>
</html>