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
$heading = 'Edit Active Orders';
if (count($_POST) > 0) {
    if (!empty($_POST['op_type']) && $_POST['op_type'] == "del_file") {
        $file_name = $_POST['file_name'];
        $order_id = $_POST['order_id'];
        $path = "order_invoices/" . $order_id . "/" . $_POST['file_name'];
        unlink($path);
        $sql22 = "DELETE FROM `sup_invoice` where sup_order_id = '$order_id' and invoice_file = '$file_name'";
        $result122 = mysqli_query($sup_db, $sql22);
        if(!empty($result122)){
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Invoice Deleted successfully.';
            header("Location:active_orders.php");
            exit();
        }else{
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Error: Invoice Not Deleted Please Try Again!...';
            header("Location:active_orders.php");
            exit();
        }
    } elseif (!empty($_POST['att_type']) && $_POST['att_type'] == "del_att") {
        $file_name1 = $_POST['file_name1'];
        $file_type1 = $_POST['file_type1'];
        $order_id1 = $_POST['order_id1'];
        $path = "order_invoices/" . $_POST['file_name1'];
        unlink($path);
        $sql123 = "DELETE FROM `order_files` where order_id = '$order_id1' and file_type ='$file_type1' and file_name= '$file_name1'";
        $result123 = mysqli_query($sup_db, $sql123);
        if(!empty($result123)){
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Attachments Deleted successfully.';
            header("Location:active_orders.php");
            exit();
        }else{
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Error: Attachments Not Deleted Please Try Again!..';
            header("Location:active_orders.php");
            exit();
        }
    } else {
        $edit_id = $_POST['edit_order_id'];
        $edit_bill_amount = $_POST['edit_bill_amount'];
        $e_ship_details = $_POST['e_ship_details'];
        //upload single invoice to database and directory
        $edit_invoice = $_FILES['edit_invoice']['name'];
        if(!empty($edit_invoice)){
            if (isset($_FILES['edit_invoice'])) {
                $errors = array();
                $file_name = $_FILES['edit_invoice']['name'];
                $file_size = $_FILES['edit_invoice']['size'];
                $file_tmp = $_FILES['edit_invoice']['tmp_name'];
                $file_type = $_FILES['edit_invoice']['type'];
                $file_ext = strtolower(end(explode('.', $file_name)));
                $extensions = array("jpeg", "jpg", "png", "pdf");
                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG/PNG/PDF file.";
                    $_SESSION['message_stauts_class'] = 'alert-danger';
                    $_SESSION['import_status_message'] = 'Error: Extension not allowed, please choose a JPEG/PNG/PDF file.';
                }
                if ($file_size > 2097152) {
                    $errors[] = 'Max allowed file size is 2 MB';
                    $_SESSION['message_stauts_class'] = 'alert-danger';
                    $_SESSION['import_status_message'] = 'Error: File size must not exceed 2 MB';
                }
                if (empty($errors) == true) {
                    $file_name = $edit_id . '__' . $file_name;
                    move_uploaded_file($file_tmp, "order_invoices/" . $edit_id . '/' . $file_name);
                    $sql2 = "INSERT INTO `sup_invoice`(`sup_order_id`, `invoice_file`, `invoice_amount`, `invoice_status`, `created_by`, `created_on`) VALUES ('$edit_id' ,'$file_name','$edit_bill_amount','1','$user_id','$chicagotime')";
                    $result2 = mysqli_query($sup_db, $sql2);
                }
            }
        }
        //upload multiple invoice to database and directory
        $file_name2 = $_FILES['edit_invoice_extra']['name'];
        if(!empty($file_name2)){
            if (isset($_FILES['edit_invoice_extra'])) {
                $errors = array();
                $edit_invoice_extra = $file_name2;
                if (!empty($edit_invoice_extra)) {
                    $edit_amount = $_POST['edit_amount_extra'];
                    $inv_extra = '[';
                    foreach ($edit_invoice_extra as $count => $result) {
                        $edit_invoice_file = $edit_id . '__' . $edit_invoice_extra[$count];
                        $edit_invoice_amount = $edit_amount[$count];
                        $sql2 = "INSERT INTO `sup_invoice`(`sup_order_id`, `invoice_file`, `invoice_amount`, `invoice_status`, `created_by`, `created_on`) VALUES ('$edit_id' ,'$edit_invoice_file','$edit_invoice_amount','1','$user_id','$chicagotime')";
                        $result2 = mysqli_query($sup_db, $sql2);
                    }
                    $inv_extra .= ']';
                }
            }
            //upload multiple invoice to directory
            $total_count = count($_FILES['edit_invoice_extra']['name']);
            for ($i = 0; $i < $total_count; $i++) {
                $tmpFilePath = $_FILES['edit_invoice_extra']['tmp_name'][$i];
                $file_name1 = $_FILES['edit_invoice_extra']['name'][$i];
                $file_size1 = $_FILES['edit_invoice_extra']['size'][$i];
                $file_tmp1 = $_FILES['edit_invoice_extra']['tmp_name'][$i];
                $file_type1 = $_FILES['edit_invoice_extra']['type'][$i];
                $file_ext1 = strtolower(end(explode('.', $file_name1)));
                $extensions1 = array("jpeg", "jpg", "png", "pdf");
                if (in_array($file_ext1, $extensions1) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG/PNG/PDF file.";
                    $_SESSION['message_stauts_class'] = 'alert-danger';
                    $_SESSION['import_status_message'] = 'Error: Extension not allowed, please choose a JPEG/PNG/PDF file.';
                }
                if ($file_size > 2097152) {
                    $errors[] = 'Max allowed file size is 2 MB';
                    $_SESSION['message_stauts_class'] = 'alert-danger';
                    $_SESSION['import_status_message'] = 'Error: File size must not exceed 2 MB';
                }
                if (empty($errors) == true) {
                    if ($tmpFilePath != "") {
                        $newFilePath = "order_invoices/" . $edit_id . '/' . $edit_id . '__' . $_FILES['edit_invoice_extra']['name'][$i];
                        //File is uploaded to temp dir
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        }
                    }
                }
            }
        }

        //upload attachments to database and directory
        $edit_attachments = $_FILES['edit_attachments']['name'];
        if(!empty($edit_attachments) && $edit_attachments != " "){
            if (isset($_FILES['edit_attachments'])) {
                foreach ($_FILES['edit_attachments']['name'] as $key => $val) {
                    $errors = array();
                    $file_name = $_FILES['edit_attachments']['name'][$key];
                    $file_size = $_FILES['edit_attachments']['size'][$key];
                    $file_tmp = $_FILES['edit_attachments']['tmp_name'][$key];
                    $file_type = $_FILES['edit_attachments']['type'][$key];
                    $file_ext = strtolower(end(explode('.', $file_name)));
                    $extensions = array("jpeg", "jpg", "png", "pdf");
                    if (in_array($file_ext, $extensions) === false) {
                        $errors[] = "extension not allowed, please choose a JPEG/PNG/PDF file.";
                        $_SESSION['message_stauts_class'] = 'alert-danger';
                        $_SESSION['import_status_message'] = 'Error: Extension not allowed, please choose a JPEG/PNG/PDF file.';
                    }
                    if ($file_size > 2097152) {
                        $errors[] = 'Max allowed file size is 2 MB';
                        $_SESSION['message_stauts_class'] = 'alert-danger';
                        $_SESSION['import_status_message'] = 'Error: File size must not exceed 2 MB';
                    }
                    if (empty($errors) == true) {
                        $file_name = $edit_id . '__' . $file_name;
                        move_uploaded_file($file_tmp, "order_invoices/" . $file_name);
                        $sql = "INSERT INTO `order_files`(`order_id`, `file_type`, `file_name`, `created_at`) VALUES ('$edit_id' ,'attachment','$file_name','$chicagotime' )";
                        $result111 = mysqli_query($sup_db, $sql);
                    }
                }
            }
        }

        //update the shipment details if edit
        if (!empty($e_ship_details)) {
            $sql = "update sup_order set shipment_details = '$e_ship_details' , sup_modified_on = '$message', sup_modified_by='$user_id' where  sup_order_id = '$edit_id'";
            $result1 = mysqli_query($sup_db, $sql);
            if (!empty(($result1))) {
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Shipment Details Updated successfully.';
                header("Location:active_orders.php");
                exit();
            } else {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Error: Error updating  order. Try after sometime.';
                header("Location:active_orders.php");
                exit();
            }
        }
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Shipment Details Updated successfully.';
        header("Location:active_orders.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Active Order</title>
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
                    <!--                    <h3 class="page-title"> View Order </h3>-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="active_orders.php">Active Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Active Orders</li>
                        </ol>
                    </nav>
                    <div  style="text-align: end;" class="col-sm-2">
                        <a href="active_orders.php" class="btn btn-primary text-white">Back</a>
                    </div>
                </div>
                <?php
                if (!empty($import_status_message)) {
                    echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_stauts_class'] = '';
                    $_SESSION['import_status_message'] = '';
                }
                ?>
                <div class="row">
                    <div class="col-md-10 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Details</h4>
                                <?php
                                $id = $_GET['id'];
                                $querymain = sprintf("SELECT * FROM `sup_order` where order_id = '$id' and is_deleted != 1");
                                $qurmain = mysqli_query($sup_db, $querymain);
                                while ($rowcmain = mysqli_fetch_array($qurmain)) {
                                    $order_name = $rowcmain['order_name'];
                                    $sup_order_id = $rowcmain['sup_order_id'];
                                    $order_status_id = $rowcmain['order_status_id'];

                                    $qurtemp = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id'");
                                    while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                        $order_status = $rowctemp["sup_order_status"];
                                    }
                                    ?>
                                    <form action="" method="post" id="order_edit" enctype="multipart/form-data">
                                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $sup_order_id; ?>">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Order Name : </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_name" id="edit_order_name" placeholder="Order Name" value="<?php echo $order_name; ?>" style="pointer-events: none;background: #d8dbe1;">
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Order Id : </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_id" id="edit_order_id" placeholder="Order Id" value="<?php echo $sup_order_id; ?>" style="pointer-events: none;background: #d8dbe1;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Order Description : </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_desc" id="edit_order_desc" placeholder="Order Description" value="<?php echo $rowcmain['order_desc']; ?>" style="pointer-events: none;background: #d8dbe1;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Order Current Status : </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="<?php echo $order_status; ?>" placeholder="Password" style="pointer-events: none;background: #d8dbe1;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Shipment Details : </label>
                                            <div class="col-sm-9">
                                                       <textarea required id="e_ship_details" name="e_ship_details" rows="3"
                                                                 placeholder="Enter Shipment Details..."
                                                                 class="form-control"><?php echo $rowcmain['shipment_details']; ?>
                                                       </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Attach Invoice : </label>
                                                <div class="col-sm-4">
                                                   <input type="file" name="edit_invoice" id="edit_invoice" class="form-control">
                                                </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="edit_bill_amount" id="edit_bill_amount" placeholder="Enter Bill Amount">
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn btn-primary btn-rounded btn-icon" name="add_more" id="add_more"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="edit_collapse_id" value="1">
                                        <div class="query_rows">
                                        </div>
                                        <div class="form-group row">
                                            <?php
                                            $sql3 = sprintf("SELECT * FROM sup_invoice where sup_order_id = '$sup_order_id'");
                                            $qur3 = mysqli_query($sup_db, $sql3);
                                            while($row3 = mysqli_fetch_array($qur3)){
                                                $file_name = $row3['invoice_file'];
                                                $invoice_amount = $row3['invoice_amount'];
                                                ?>
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Previous Attached Invoice : </label>
                                            </div>
                                            <div class="col-sm-5">
                                                <a href="order_invoices/<?php echo $sup_order_id; ?>/<?php echo $file_name; ?>" target="_blank">
                                                    <input type="text" name="att_doc" class="form-control pn_none" id="att_doc"
                                                           value="<?php echo $file_name; ?><?php /*echo $invoice_amount; */?>">
                                                </a>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" name="att_doc" class="form-control pn_none" id="att_doc"
                                                       value="<?php echo $invoice_amount; ?>">
                                            </div>
                                            <div class="col-sm-2">
                                                <button id="file_del" onClick="file_del('$sup_order_id','$file_name')" style="font-size: 14px!important;color: red;display: flex!important;">
                                                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $sup_order_id; ?>">
                                                    <input type="hidden" name="file_name" id="file_name" value="<?php echo $file_name; ?>">
                                                    <span id="close_bt" style="color: #ff0000!important;">&times;</span>
                                                </button>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Other Attachments : </label>
                                            <div class="col-sm-6">
                                                <input type="file" name="edit_attachments[]" id="edit_attachments"
                                                       class="form-control" multiple>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <?php
                                            $sql4 = sprintf("SELECT * FROM order_files where order_id = '$sup_order_id' and file_type = 'attachment'");
                                            $qur4 = mysqli_query($sup_db, $sql4);
                                            while($row4 = mysqli_fetch_array($qur4)){
                                                $file_name4 = $row4['file_name'];
                                                ?>
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">Previous Attachments : </label>
                                                </div>
                                                <div class="col-sm-7">
                                                    <a href="order_invoices/<?php echo $file_name4; ?>" target="_blank">
                                                        <input type="text" name="att_doc" class="form-control pn_none" id="att_doc"
                                                               value="<?php echo $file_name4; ?>">
                                                    </a>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button id="att_del" onClick="att_del('$sup_order_id','$file_name4')" style="font-size: 14px!important;display: flex!important;">
                                                        <input type="hidden" name="order_id" id="order_id" value="<?php echo $sup_order_id; ?>">
                                                        <input type="hidden" name="file_name" id="file_name" value="<?php echo $file_name4; ?>">
                                                        <input type="hidden" name="file_type" id="file_type" value="attachment">
                                                        <span id="close_bt" style="color: #ff0000!important;">&times;</span>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-primary mr-2">Submit</button>
                                        <a class="btn btn-dark" href="active_orders.php">Cancel</a>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
</div>
<!-- container-scroller -->
<script>
    $(document).on('click', '#att_del', function () {
        var order_id1 = $(this)[0].children.order_id.value;
        var file_name1 = $(this)[0].children.file_name.value;
        var file_type1 = $(this)[0].children.file_type.value;
        var data = "att_type=del_att&order_id1=" + order_id1 +"&file_name1="+file_name1+"&file_type1="+file_type1;
        $.ajax({
            type: 'POST',
            data: data,
            async:false,
            success: function(data) {
            }
        });
    });
</script>
<script>
    $(document).on('click', '#file_del', function () {
        var order_id = $(this)[0].children.order_id.value;
        var file_name = $(this)[0].children.file_name.value;
        var data = "op_type=del_file&order_id=" + order_id +"&file_name="+file_name;
        $.ajax({
            type: 'POST',
            data: data,
            async:false,
            success: function(data) {

            }
        });
    });
</script>
<script>
    $(document).on("click","#add_more",function() {
        var i = $('#edit_collapse_id').val();
        var inv = $('#edit_invoice').val();

        var edit_collapse_id = "collapse"+i;
        var count = i;

        $("#click_id").val(count);
        var html_content = '<div id="'+edit_collapse_id+'" class="collapse in"><div class="form-group row part_rem_' + count + '" id="section_' + count + '"><label for="exampleInputPassword2" class="col-sm-3 col-form-label">Attach Invoice</label><div class="col-sm-4"> <input type="file" name="edit_invoice_extra[]" id="edit_invoice_extra' + count + '" class="form-control"></div><div class="col-sm-4"><input type="text" class="form-control" name="edit_amount_extra[]" id="edit_amount_extra_' + count + '" placeholder="Enter Bill Amount"></div><button type="button" name="remove_btn" class="btn btn-danger btn-rounded btn-icon remove_btn" id="btn_id_' + count + '" data-id="' + count + '" fdprocessedid="7w26pm"><i class="fa fa-trash"></i></button></a></div></div></div></div>';
        $( ".query_rows" ).append( html_content );
        var invc_count = count - 1;
        var inv_ex = $('#edit_invoice_extra' + invc_count).val();
        $.ajax({
            url: "retrive_invoice.php?edit_invoice=" + inv + "&edit_invoice_extra=" + inv_ex,
            dataType: 'Json',
            data: {},
            success: function (data) {
                // $('select[name="item_name[]"]').empty();
                // $('#'+select_id).append('<option value="" selected disabled>Select Your Item</option>');
                $.each(data, function (key, value) {
                    $('#edit_invoice_extra' + count).append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
        document.getElementById("edit_collapse_id").value = parseInt(i) + 1;
    });

    $(document).on("click",".remove_btn",function() {
        var row_id = $(this).attr("data-id");
        $(".part_rem_"+row_id).remove();
    });
</script>
<script>
    $('.select2').select2();
    $(".js-example-placeholder-single").select2({
        placeholder: "Select Stations",
        allowClear: true
    });
</script>
<!-- End custom js for this page -->
</body>
</html>

