<?php
include("sup_config.php");
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
if(count($_POST) > 0) {
    $edit_order_name = $_POST['edit_order_name'];
    $edit_order_id = $_POST['edit_order_id'];
    $edit_order_desc = $_POST['edit_order_desc'];
    $edit_order_status = $_POST['edit_order_status'];
    if ($edit_order_status != 4) {
        $e_order_status = $_POST['edit_order_status'];
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
        }
    } else {
        $order_status_id = $_POST['edit_order_status_id'];
        $order_up_status_id = $_POST['edit_order_status'];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Active Orders</title>

    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <!--    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>-->
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <!--    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>-->
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
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
        $order_status_id = $rowcmain['order_status_id'];
        ?>
        <?php

        $qurtemp = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id'");
        while ($rowctemp = mysqli_fetch_array($qurtemp)) {
            $order_status = $rowctemp["sup_order_status"];
        }
        ?>
        <form action="" id="form_settings" class="form-horizontal" method="post">
            <div class="row row-sm">
                <div class="col-lg-10 col-xl-10 col-md-12 col-sm-12">
                    <div class="card  box-shadow-0">
                        <div class="card-header" style="background: #1F5D96;">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color: #FFFFFF;">EDIT ORDER - <?php echo $ordr_id; ?></span>
                        </div>
                        <div class="card-body pt-0" style="margin-top: 33px;">
                            <div class="pd-30 pd-sm-20">
                                <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $id; ?>">
                                <input hidden id="e_order_status" name="e_order_status"
                                       value="<?php echo $order_status_id; ?>">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Order Name</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="text" name="edit_order_name" id="edit_order_name" class="form-control"
                                               value="<?php echo $order_name; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Order Id</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="text" name="edit_order_id" id="edit_order_id" class="form-control"
                                               value="<?php echo $ordr_id; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Order Description</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="text" name="edit_order_desc" id="edit_order_desc" class="form-control"
                                               value="<?php echo $rowcmain['order_desc']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Order Current Status</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="text" class="form-control" value="<?php echo $order_status; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Order Status</label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <select name="edit_order_status" id="edit_order_status" class="form-control form-select select2" data-bs-placeholder="Select Order Status" onchange = "ShowHideDiv()">
                                            <option value="" selected disabled> Select Order Status </option>
                                            <?php
                                            $os_access = 0;
                                            $os_sa_access = 0;
                                            if ($role == 3) {
                                                $os_access = 1;
                                                $sql1 = mysqli_query($sup_db, "SELECT * FROM `sup_order_status`  ORDER BY `sup_order_status_id` ASC ");
//												$result1 = mysqli_fetch_array($sql1);
                                                $selected = "";
                                                while ($row1 = mysqli_fetch_array($sql1)) {
                                                    if ($row1['sup_order_status_id'] == $order_status_id) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    if ($row1['sup_sa_os_access'] == 1) {
                                                        //echo "<option " . $selected . " disabled=\"disabled\" value='" . $row1['sup_order_status_id'] . "' >" . $row1['sup_order_status'] . "</option>";
                                                    } else {
                                                        echo "<option " . $selected . " value='" . $row1['sup_order_status_id'] . "'  >" . $row1['sup_order_status'] . "</option>";
                                                    }
                                                }
                                            } else if ($role == 2) {
                                                $os_sa_access = 1;
                                                $sql1 = mysqli_query($sup_db, "SELECT * FROM `sup_order_status`  ORDER BY `sup_order_status_id` ASC ");
                                                while ($row1 = mysqli_fetch_array($sql1)) {
                                                    if ($row1['sup_order_status_id'] == $order_status_id) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    if ($row1['sup_os_access'] == 1) {
                                                        // echo "<option " . $selected . " disabled=\"disabled\" value='" . $row1['sup_order_status_id'] . "'  >" . $row1['sup_order_status'] . "</option>";
                                                    } else {
                                                        echo "<option " . $selected . " value='" . $row1['sup_order_status_id'] . "'  >" . $row1['sup_order_status'] . "</option>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="dvPassport" style="display: none">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Shipment Details * : </label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                         <textarea required id="edit_ship_details" name="edit_ship_details" rows="3"
                                                   placeholder="Enter Shipment Details..."
                                                   class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Attach Invoice : </label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="file" name="invoice" id="invoice" class="form-control">
                                        <!-- `display Invoice-->
                                        <?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='invoice' and order_id = '$order_id'");
                                        while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                            $filename = $rowcimage['file_name'];
                                            ?>
                                            <div class="col-md-8">
                                                <a target="_blank" href='./order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
                                                <button id="file_del" onClick="file_del('$order_id','$filename')">
                                                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
                                                    <input type="hidden" name="file_name" id="file_name" value="<?php echo $filename; ?>">
                                                    <input type="hidden" name="file_type" id="file_type" value="invoice">
                                                    <span id="close_bt">&times;</span></button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-3">
                                        <label class="form-label mg-b-0">Other Attachments: </label>
                                    </div>
                                    <div class="col-md-6 mg-t-5 mg-md-t-0">
                                        <input type="file" name="attachments[]" id="attachments"
                                               class="form-control" multiple>
                                        <!-- `display Invoice-->
                                        <?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='attachment' and order_id = '$order_id'");
                                        while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                            $filename = $rowcimage['file_name'];
                                            ?>
                                            <div class="col-lg-12">
                                                <a target="_blank" href='./order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
                                                <button id="file_del" onClick="file_del('$order_id','$filename')">
                                                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
                                                    <input type="hidden" name="file_name" id="file_name" value="<?php echo $filename; ?>">
                                                    <input type="hidden" name="file_type" id="file_type" value="attachment">
                                                    <span id="close_bt">&times;</span></button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="pd-30 pd-sm-20">
                                <button type="submit" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5 ">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php } ?>
</div>

<script>
    function ShowHideDiv() {
        var ddlPassport = document.getElementById("edit_order_status");
        var dvPassport = document.getElementById("dvPassport");
        dvPassport.style.display = ddlPassport.value == "4" ? "block" : "none";
    }
</script>
<?php include('footer1.php') ?>
</body>
</html>