<?php include("./../../sup_config.php");
include("./../../config.php");
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |View Historical Order</title>
    <!-- Global stylesheets -->
    <link href="../assets_old/css/core.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <!--    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>-->
    <script type="text/javascript" src="../assets_old/js/form_js/jquery-min.js"></script>
    <script type="text/javascript" src="../assets_old/js/libs/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/plugins/loaders/blockui.min.js"></script>
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets_old/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets_old/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets_old/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets_old/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets_old/js/plugins/ui/ripple.min.js"></script>

    <!--Internal  Datetimepicker-slider css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/amazeui.datetimepicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/jquery.simple-dtpicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/picker.min.css" rel="stylesheet">
    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/form_css/bootstrap-datepicker.css">
    <!-- Internal Select2 css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/select2.min.css" rel="stylesheet">
    <!-- STYLES CSS -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style.css" rel="stylesheet">
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
    <script src="<?php echo $siteURL; ?>assets/js/form_js/select2.min.js"></script>
    <!-- Internal form-elements js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/form-elements.js"></script>
    <link href="<?php echo $siteURL; ?>assets/css/form_css/demo.css" rel="stylesheet"/>

    <style>
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

        .mt-4 {
            margin-top: 0rem!important;
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

        .text-center {
            text-align: center!important;
            background-image: none!important;
            font-size: large;
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

        a.btn.btn-success.btn-sm.br-5.me-2.legitRipple {
            height: 32px;
            width: 32px;
        }
        .badge {
            padding: 0.5em 0.5em!important;
            width: 100px;
            height: 23px;
        }
    </style>
</head>
<!-----body-------->
<body class="ltr main-body app horizontal">
<!-- Main navbar -->
<?php
//$cust_cam_page_header = "Job Title";
include("../../header.php");
include("../../admin_menu.php");
?>
<!-----main content----->
<div class="main-content app-content">
    <!---container--->
    <div class="main-container container">
        <!---breadcrumb--->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Supplier</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Historical Data</li>
                </ol>
            </div>
        </div>
        <?php
        $sql = sprintf("SELECT * FROM sup_order where order_id = '$id' ");
        $qur = mysqli_query($sup_db, $sql);
        $row = mysqli_fetch_array($qur);
        $order_name = $row['order_name'];
        $order_desc = $row['order_desc'];
        $order_status_id = $row['order_status_id'];
        $created_on = $row['created_on'];
        $created_by = $row['created_by'];
        $shipment_details = $row['shipment_details'];
        $c_id = $row['c_id'];
        ?>
        <form action="" id="" enctype="multipart/form-data" class="form-horizontal" method="post">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="">
                            <div class="card-header">
                                <span class="main-content-title mg-b-0 mg-b-lg-1">ORDER DETAILS</span>
                            </div>
                            <div class="pd-30 pd-sm-20">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Supplier Name</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <?php
                                        $sql5 = sprintf("SELECT * FROM sup_account where c_id = '$c_id'");
                                        $qur5 = mysqli_query($sup_db, $sql5);
                                        $row5 = mysqli_fetch_array($qur5);
                                        $c_name = $row5['c_name'];
                                        ?>
                                        <input type="text" name="s_name" id="s_name" class="form-control" value="<?php echo $c_name; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Order Name</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <input type="text" name="o_name" id="o_name" class="form-control" value="<?php echo $order_name; ?>" disabled>
                                    </div>
                                </div>

                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Order Description</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <input type="text" name="o_desc" id="o_desc" class="form-control" value="<?php echo $order_desc; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Order Status</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <?php
                                        $sql1 = sprintf("SELECT * FROM sup_order_status where sup_order_status_id = '$order_status_id' ");
                                        $qur1 = mysqli_query($sup_db, $sql1);
                                        $row1 = mysqli_fetch_array($qur1);
                                        $sup_order_status = $row1['sup_order_status'];
                                        ?>
                                        <input type="text" name="o_status" id="o_status" class="form-control" value="<?php echo $sup_order_status; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Created By</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <?php
                                        $sql2 = sprintf("SELECT * FROM cam_users where users_id = '$created_by' and is_deleted != 1");
                                        $qur2 = mysqli_query($db, $sql2);
                                        $row2 = mysqli_fetch_array($qur2);
                                        $full_name = $row2['firstname'] . ' ' . $row2['lastname'];
                                        ?>
                                        <input type="text" name="c_by" id="c_by" class="form-control" value="<?php echo $full_name; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Created On</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <input type="text" name="c_date" id="c_date" class="form-control" value="<?php echo dateReadFormat($created_on); ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="">
                            <div class="card-header">
                                <span class="main-content-title mg-b-0 mg-b-lg-1">Shipment Details</span>
                            </div>

                            <div class="pd-30 pd-sm-20">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Shipment Name</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <input type="text" name="ship_name" id="ship_name" class="form-control" value="<?php echo $shipment_details; ?>" disabled>
                                    </div>
                                </div>

                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Attach Invoice</label>
                                    </div>
                                    <?php
                                    $sql3 = sprintf("SELECT * FROM order_files where order_id = '$id' and file_type = 'invoice'");
                                    $qur3 = mysqli_query($sup_db, $sql3);
                                    $row3 = mysqli_fetch_array($qur3);
                                    $file_name = $row3['file_name'];
                                    ?>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <a href="<?php echo $siteURL; ?>supplier/order_invoices/<?php echo $file_name; ?>" target="_blank">
                                            <input type="text" name="att_voice" class="form-control pn_none" id="att_voice"
                                                   value="<?php echo $file_name; ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Other Attachments</label>
                                    </div>
                                    <?php
                                    $sql4 = sprintf("SELECT * FROM order_files where order_id = '$id' and file_type = 'attachment'");
                                    $qur4 = mysqli_query($sup_db, $sql4);
                                    $row4 = mysqli_fetch_array($qur4);
                                    $file_name4 = $row4['file_name'];
                                    ?>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <a href="<?php echo $siteURL; ?>supplier/order_invoices/<?php echo $file_name4; ?>" target="_blank">
                                            <input type="text" name="att_doc" class="form-control pn_none" id="att_doc"
                                                   value="<?php echo $file_name4; ?>">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
        </form>
    </div>
</div>
<?php include('./../../footer1.php') ?>
</body>
