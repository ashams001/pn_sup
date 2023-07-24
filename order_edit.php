<?php include("sup_config.php");
include("config.php");
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $sitename; ?> |Edit Form</title>
    <!-- Global stylesheets -->
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
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
            margin-top: -628px;
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
        .row.row-xs.align-items-center.mg-b-20{
            margin-top: 10px!important;
            margin-bottom: 10px!important;
        }
    </style>
</head>

<body class="ltr main-body app sidebar-mini">
<?php
$cam_page_header = "Active Orders";
include('s_header.php');
include('s_sidemenu.php');
?>
<!-- main-content -->
<div class="main-content app-content">
    <!-- row -->
    <?php
    if (!empty($import_status_message)) {
        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
    }
    displaySFMessage();
    ?>
    <?php
    $id = $_GET['id'];

    //   $id = base64_decode( urldecode( $form_id));

    $querymain = sprintf("SELECT * FROM `sup_order` where order_id = '$id' ");
    $qurmain = mysqli_query($db, $querymain);
    while ($rowcmain = mysqli_fetch_array($qurmain)) {
        $order_name = $rowcmain['order_name'];
        $ordr_id = $rowcmain['sup_order_id'];
        ?>
        <form action="" id="form_settings" enctype="multipart/form-data" class="form-horizontal" method="post">

            <div class="row row-sm">
                <div class="col-lg-10 col-xl-10 col-md-12 col-sm-12">
                    <div class="card  box-shadow-0">
                        <div class="card-header" style="background: #1F5D96;">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color: #FFFFFF;">EDIT ORDER - <?php echo $ordr_id; ?></span>
                        </div>
                        <div class="card-body pt-0" style="margin-top: 33px;">
                            <div class="pd-30 pd-sm-20">
                                <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $id; ?>">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Order Name</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="text" name="edit_order_name" id="edit_order_name" class="form-control"
                                               value="<?php echo $order_name; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Order Id</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="text" name="edit_order_id" id="edit_order_id" class="form-control"
                                               value="<?php echo $ordr_id; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Order Description</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="text" name="edit_order_desc" id="edit_order_desc" class="form-control"
                                               value="<?php echo $rowcmain['order_desc']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0">Order Status</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <select name="edit_order_status" id="edit_order_status" class="form-control form-select select2" data-bs-placeholder="Select Order Status">
                                            <option value="" selected disabled> Select Order Status </option>
                                           <!-- --><?php
/*                                            $form_type = $rowcmain['form_type'];
                                            $sql1 = "SELECT * FROM `form_type` ";
                                            $result1 = $mysqli->query($sql1);
                                            //                                            $entry = 'selected';
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if ($form_type == $row1['form_type_id']) {
                                                    $entry = 'selected';
                                                } else {
                                                    $entry = '';

                                                }
                                                echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
                                            }
                                            */?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php } ?>
</div>
<?php include('footer1.php') ?>
</body>