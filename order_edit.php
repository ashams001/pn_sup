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
$heading = 'Order Edit';
if (count($_POST) > 0) {
    $edit_order_name = $_POST['edit_order_name'];
    $edit_order_id = $_POST['edit_order_id'];
    $edit_order_desc = $_POST['edit_order_desc'];
    $edit_order_status = $_POST['edit_order_status'];

    if ($edit_order_status != 4) {
        $e_order_status = $_POST['edit_order_status'];
        $order_status_id = $_POST['edit_order_status'];
        $e_order_status = $_POST['e_order_status'];
        $order_id = $_POST['edit_order_id'];
        $click_id = $_POST['click_id'];

        if (!is_null($order_status_id) && !empty($order_status_id)) {
            $sql = "update sup_order set order_status_id='$order_status_id', modified_on='$chicagotime', modified_by='$user_id' where  sup_order_id = '$order_id'";
            $result1 = mysqli_query($sup_db, $sql);
            if ($result1) {
                $sql_ses_log = "INSERT INTO `supplier_session_log`(`order_id`, `c_id`, `order_status_id`, `created_by`, `created_on`) VALUES ('$order_id','','$order_status_id','$user_id','$chicagotime')";
                $result_log = mysqli_query($sup_db, $sql_ses_log);
                $message_stauts_class = 'alert-success';
                $import_status_message = 'Order status Updated successfully.';
                header("Location:active_orders.php");
            } else {
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: Please Insert valid data';
            }
        }
    }else {
        $order_status_id = $_POST['edit_order_status_id'];
        $order_up_status_id = $_POST['edit_order_status'];
        $e_order_status = $_POST['e_order_status'];
        $order_id = $_POST['edit_id'];
        $bill_amount = $_POST['bill_amount'];
        $is_updated = true;
        if (null != $order_id) {
            $ship_det = $_POST['edit_ship_details'];
            if (null != $ship_det) {
                $sql = "update sup_order set order_status_id='$order_up_status_id',shipment_details = '$ship_det' , modified_on = '$message', modified_by='$user_id' where  sup_order_id = '$order_id'";
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
            if (isset($_FILES['invoice']))
            {
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
                        $folderPath = 'order_invoices/';
                        mkdir($folderPath.'/'.$order_id, 0777, true);
                        move_uploaded_file($file_tmp, "order_invoices/". $order_id . '/' . $file_name);
                        $sql2 = "INSERT INTO `sup_invoice`(`sup_order_id`, `invoice_file`, `invoice_amount`, `invoice_status`, `created_by`, `created_on`) VALUES ('$order_id' ,'$file_name','$bill_amount','1','$user_id','$chicagotime')";
                        $result2 = mysqli_query($sup_db, $sql2);
                    }

            }
            //invoice extra
            $file_name2 = $_FILES['invoice_extra']['name'];
            if (isset($_FILES['invoice_extra'])) {
                $errors = array();
                $invoice_extra = $file_name2;
                // move_uploaded_file($file_tmp1, "order_invoices/" . $file_name1);
                if(!empty($invoice_extra)) {
                    $amount = $_POST['amount_extra'];
                    $inv_extra = '[';
                    foreach ($invoice_extra as $count => $result) {
                        $invoice_file = $order_id . '__' . $invoice_extra[$count];
                        $invoice_amount = $amount[$count];
                        $sql2 = "INSERT INTO `sup_invoice`(`sup_order_id`, `invoice_file`, `invoice_amount`, `invoice_status`, `created_by`, `created_on`) VALUES ('$order_id' ,'$invoice_file','$invoice_amount','1','$user_id','$chicagotime')";
                        $result2 = mysqli_query($sup_db, $sql2);

                    }
                    $inv_extra .= ']';

                  /*  $sql = "INSERT INTO `order_files`(`order_id`, `file_type`,`file_name`, `extra_invoice`, `created_at`) VALUES ('$order_id' ,'invoice','$file_name','$inv_extra','$chicagotime' )";
                    $result1 = mysqli_query($sup_db, $sql);*/
                   /* $sql2 = "INSERT INTO `sup_invoice`(`sup_order_id`, `invoice_name`, `invoice_extra`, `invoice_status`, `created_by`, `created_on`) VALUES ('$order_id' ,'$file_name','$inv_extra','1','$user_id','$chicagotime')";
                    $result2 = mysqli_query($sup_db, $sql2);*/
                }
            }

                  //  move the file to server
                    $total_count = count($_FILES['invoice_extra']['name']);
                    for( $i=0 ; $i < $total_count; $i++ ) {
                        $tmpFilePath = $_FILES['invoice_extra']['tmp_name'][$i];
                        $file_name1 = $_FILES['invoice_extra']['name'][$i];
                        $file_size1 = $_FILES['invoice_extra']['size'][$i];
                        $file_tmp1 = $_FILES['invoice_extra']['tmp_name'][$i];
                        $file_type1 = $_FILES['invoice_extra']['type'][$i];
                        $file_ext1 = strtolower(end(explode('.', $file_name1)));
                        $extensions1 = array("jpeg", "jpg", "png", "pdf");
                        if (in_array($file_ext1, $extensions1) === false) {
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
                            if ($tmpFilePath != "") {
                                $newFilePath = "order_invoices/" . $order_id . '/' . $order_id . '__' . $_FILES['invoice_extra']['name'][$i];
                                //File is uploaded to temp dir
                                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                                }
                            }
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
                        move_uploaded_file($file_tmp, "order_invoices/" . $file_name);
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
        header("Location:active_orders.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PN</title>
    <!-- plugins:css -->
</head>
<style>
    .collapse.in {
        display: block!important;
    }
</style>
<body>
<div class="container-scroller">
    <?php include ('admin_menu.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <?php include ('header.php'); ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Edit Order </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Order</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Order</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-10 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Details</h4>
                                <?php
                                $id = $_GET['id'];

                                //   $id = base64_decode( urldecode( $form_id));

                                $querymain = sprintf("SELECT * FROM `sup_order` where order_id = '$id' ");
                                $qurmain = mysqli_query($sup_db, $querymain);
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
                                    <form action="" method="post" id="order_edit" enctype="multipart/form-data">
                                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $ordr_id; ?>">
                                        <input type="hidden" name="edit_order_status_id" id="edit_order_status_id" value="<?php echo $order_status_id; ?>">
                                        <input hidden id="e_order_status" name="e_order_status"
                                               value="<?php echo $order_status_id; ?>">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Order Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_name" id="edit_order_name" placeholder="Order Name" value="<?php echo $order_name; ?>" style="pointer-events: none;background: #d8dbe1;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Order Id</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_id" id="edit_order_id" placeholder="Order Id" value="<?php echo $ordr_id; ?>" style="pointer-events: none;background: #d8dbe1;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Order Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_desc" id="edit_order_desc" placeholder="Order Description" value="<?php echo $rowcmain['order_desc']; ?>" style="pointer-events: none;background: #d8dbe1;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Order Current Status</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="<?php echo $order_status; ?>" placeholder="Password" style="pointer-events: none;background: #d8dbe1;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Order Status</label>
                                            <div class="col-sm-9">
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
                                            <div class="form-group row">
                                                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Shipment Details</label>
                                                <div class="col-sm-9">
                                                       <textarea required id="edit_ship_details" name="edit_ship_details" rows="3"
                                                                 placeholder="Enter Shipment Details..."
                                                                 class="form-control">
                                                       </textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Attach Invoice</label>
                                                <div class="col-sm-4">
                                                    <input type="file" name="invoice" id="invoice" class="form-control">
                                                    <?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='invoice' and order_id = '$order_id'");
                                                    while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                                        $filename = $rowcimage['file_name'];
                                                        ?>
                                                        <div class="input-group col-xs-12">
                                                            <a target="_blank" href='order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
                                                            <button id="file_del" onClick="file_del('$order_id','$filename')">
                                                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
                                                                <input type="hidden" name="file_name" id="file_name" value="<?php echo $filename; ?>">
                                                                <input type="hidden" name="file_type" id="file_type" value="invoice">
                                                                <span id="close_bt">&times;</span></button>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="bill_amount" id="bill_amount" placeholder="Enter Bill Amount">
                                                </div>

                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-primary btn-rounded btn-icon" name="add_more" id="add_more"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="collapse_id" value="1">
                                            <div class="query_rows">

                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Other Attachments</label>
                                                <div class="col-sm-9">
                                                    <input type="file" name="attachments[]" id="attachments"
                                                           class="form-control" multiple>
                                                    <?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='attachment' and order_id = '$order_id'");
                                                    while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                                        $filename = $rowcimage['file_name'];
                                                        ?>
                                                        <div class="input-group col-xs-12">
                                                            <a target="_blank" href='order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
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
                                        <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-primary mr-2">Submit</button>
                                        <button class="btn btn-dark">Cancel</button>
                                        <input type="hidden" name="click_id" id="click_id" >
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
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
<script>
    function ShowHideDiv() {
        var ddlPassport = document.getElementById("edit_order_status");
        var dvPassport = document.getElementById("dvPassport");
        dvPassport.style.display = ddlPassport.value == "4" ? "block" : "none";
    }
</script>
<script>
    $(document).on("click","#add_more",function() {
        var i = $('#collapse_id').val();
        var inv = $('#invoice').val();

        var collapse_id = "collapse"+i;
        var count = i;

        $("#click_id").val(count);
        var html_content = '<div id="'+collapse_id+'" class="collapse in"><div class="form-group row part_rem_' + count + '" id="section_' + count + '"><label for="exampleInputPassword2" class="col-sm-3 col-form-label">Attach Invoice</label><div class="col-sm-4"> <input type="file" name="invoice_extra[]" id="invoice_extra' + count + '" class="form-control"></div><div class="col-sm-4"><input type="text" class="form-control" name="amount_extra[]" id="amount_extra_' + count + '" placeholder="Enter Bill Amount"></div><button type="button" name="remove_btn" class="btn btn-danger btn-rounded btn-icon remove_btn" id="btn_id_' + count + '" data-id="' + count + '" fdprocessedid="7w26pm"><i class="fa fa-trash"></i></button></a></div></div></div></div>';
        $( ".query_rows" ).append( html_content );
        var invc_count = count - 1;
        var inv_ex = $('#invoice_extra' + invc_count).val();
        $.ajax({
            url: "retrive_invoice.php?invoice=" + inv + "&invoice_extra=" + inv_ex,
            dataType: 'Json',
            data: {},
            success: function (data) {
                // $('select[name="item_name[]"]').empty();
                // $('#'+select_id).append('<option value="" selected disabled>Select Your Item</option>');
                $.each(data, function (key, value) {
                    $('#invoice_extra' + count).append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
        document.getElementById("collapse_id").value = parseInt(i) + 1;
    });

    $(document).on("click",".remove_btn",function() {

        var row_id = $(this).attr("data-id");
        $(".part_rem_"+row_id).remove();

    });

</script>
<!-- End custom js for this page -->
</body>
</html>

