<?php include("config.php");
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

    $order_status_id = $_POST['edit_order_status'];
    $e_order_status = $_POST['e_order_status'];
    $order_id = $_POST['edit_order_id'];
    if (!is_null($order_status_id) && !empty($order_status_id)) {
        $sql = "update sup_order set order_status_id='$order_status_id', modified_on='$chicagotime', modified_by='$user_id' where  order_id = '$order_id'";
        $result1 = mysqli_query($sup_db, $sql);
        if ($result1) {

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
                $sql = "update sup_order set order_status_id='$order_up_status_id',shipment_details = '$ship_det' ,  modified_on='$chicagotime', modified_by='$user_id' where  order_id = '$order_id'";
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
        }
        $message_stauts_class = 'alert-success';
        $import_status_message = 'Order status Updated successfully.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |Historical Orders</title>
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
$cam_page_header = "Historical Orders";
include('s_header.php');
include('s_sidemenu.php');
?>
<form action="" id="form_settings" method="post" class="form-horizontal">
    <?php
    if (!empty($import_status_message)) {
        echo '<div class="alert-dismissible fade show alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
    }
    displaySFMessage();
    ?>
    <div class="row-body">
        <div class="col-12 col-sm-12">
            <div class="card" style="z-index: -1;">
                <div class="card-header" style="background: #1F5D96;">
                    <h4 class="card-title">
                        <button type="button" class="btn btn-danger btn-sm br-5" onclick="submitForm('delete_form_option.php')" style="color: #FFFFFF;">
                            <i>
                                <svg class="table-delete" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="16"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4h-3.5z"></path></svg>
                            </i>
                        </button>
                    </h4>
                </div>
                <div class="card-body pt-0" style="margin-top: 33px;">
                    <div class="table-responsive">
                        <table class="table datatable-basic table-bordered text-nowrap mb-0" id="example2">
                            <thead>
                            <tr>
                                <th><label class="ckbox"><input type="checkbox" id="checkAll" ><span></span></label></th>
                                <th>S.No</th>
                                <th>Order Desc</th>
                                <th>Ordered On</th>
                                <th>Order Status</th>
                                <th>Actions</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = sprintf("SELECT * FROM  sup_order  where order_active = 0 order by created_on DESC");
                            $qur = mysqli_query($sup_db, $query);
                            while ($rowc     = mysqli_fetch_array($qur)) {
                                ?>
                                <tr>
                                    <td><label class="ckbox"><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["form_create_id"]; ?>"><span></span></label></td>
                                    <td><?php echo ++$counter; ?></td>
                                    <?php $order_id = $rowc['order_id'];
                                    $order_status_id = $rowc['order_status_id'];
                                    $ship_det = $rowc['shipment_details']; ?>
                                    <td><?php echo $rowc['order_desc']; ?></td>
                                    <?php

                                    $qurtemp = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id'");
                                    while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                        $order_status = $rowctemp["sup_order_status"];
                                    }
                                    ?>
                                    <td><?php echo dateReadFormat($rowc['created_on']); ?></td>
                                    <td>
                                        <?php
                                        $query34 = sprintf("SELECT sup_order_status FROM  sup_order_status where sup_order_status_id = '$order_status_id'");
                                        $qur34 = mysqli_query($sup_db, $query34);
                                        $rowc34 = mysqli_fetch_array($qur34);
                                        echo $rowc34["sup_order_status"]; ?>
                                    </td>
                                    <td>
                                        <a href="view_historical_data.php?id=<?php echo $order_id; ?>" class="btn btn-info btn-xs" style="background-color:#1e73be;" target="_blank"><i class="fa fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-xs" style="background-color:#1e73be;">
                                            <div id="section1" onclick="assortiment(this)">
                                                <i class="fa fa-file"></i>
                                            </div>
                                        </button>
                                    </td>
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