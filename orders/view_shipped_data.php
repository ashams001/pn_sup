<?php include("config.php");
$heading = 'View Shipped Order';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Order</title>
    <!-- plugins:css -->

<body>
<div class="container-scroller">
    <?php include ('admin_menu.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper margin-244">
        <!-- partial:partials/_navbar.html -->
        <?php include ('header.php'); ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <!--  <h3 class="page-title"> View Order </h3>-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="order_shipment.php">Shipment details</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Shipped Order</li>
                        </ol>
                    </nav>
                    <div  style="text-align: end;" class="col-sm-2">
                        <a href="order_shipment.php" class="btn btn-primary text-white">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $id = $_GET['id'];

                                $sql = sprintf("SELECT * FROM sup_order where sup_order_id = '$id' and is_deleted != 1");
                                $qur = mysqli_query($sup_db, $sql);
                                $row = mysqli_fetch_array($qur);
                                $sup_order_id = $row['sup_order_id'];
                                $order_name = $row['order_name'];
                                $order_desc = $row['order_desc'];
                                $order_status_id = $row['order_status_id'];
                                $created_on = $row['created_on'];
                                $created_by = $row['created_by'];
                                $shipment_details = $row['shipment_details'];
                                $c_id = $row['c_id'];
                                ?>
                                <h4 class="card-title">Order Id - <?php echo $sup_order_id; ?></h4>
                                <form class="forms-sample">
                                    <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $id; ?>">
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Supplier Name : </label>
                                        <div class="col-sm-9">
                                            <?php
                                            $sql5 = sprintf("SELECT * FROM sup_account where c_id = '$c_id'");
                                            $qur5 = mysqli_query($sup_db, $sql5);
                                            $row5 = mysqli_fetch_array($qur5);
                                            $c_name = $row5['c_name'];
                                            ?>
                                            <input type="text" name="s_name" id="s_name" class="form-control" value="<?php echo $c_name; ?>" style="pointer-events: none;background: #d8dbe1;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Order Name : </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="o_name" id="o_name" class="form-control" value="<?php echo $order_name; ?>" style="pointer-events: none;background: #d8dbe1;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Order Description : </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="o_desc" id="o_desc" class="form-control" value="<?php echo $order_desc; ?>" style="pointer-events: none;background: #d8dbe1;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Order Status : </label>
                                        <div class="col-sm-9">
                                            <?php
                                            $sql1 = sprintf("SELECT * FROM sup_order_status where sup_order_status_id = '$order_status_id' ");
                                            $qur1 = mysqli_query($sup_db, $sql1);
                                            $row1 = mysqli_fetch_array($qur1);
                                            $sup_order_status = $row1['sup_order_status'];
                                            ?>
                                            <input type="text" name="o_status" id="o_status" class="form-control" value="<?php echo $sup_order_status; ?>" style="pointer-events: none;background: #d8dbe1;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Created By : </label>
                                        <div class="col-sm-9">
                                            <?php
                                            $sql2 = sprintf("SELECT * FROM cam_users where users_id = '$created_by' and is_deleted != 1");
                                            $qur2 = mysqli_query($db, $sql2);
                                            $row2 = mysqli_fetch_array($qur2);
                                            $full_name = $row2['firstname'] . ' ' . $row2['lastname'];
                                            ?>
                                            <input type="text" name="c_by" id="c_by" class="form-control" value="<?php echo $full_name; ?>" style="pointer-events: none;background: #d8dbe1;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Created On : </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="c_date" id="c_date" class="form-control" value="<?php echo $created_on; ?>" style="pointer-events: none;background: #d8dbe1;">
                                        </div>
                                    </div>
                                    <h4 style="margin-top: 20px;margin-left: 10px;">Shipment Details : </h4>
                                    <hr>
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Shipment Name : </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="ship_name" id="ship_name" class="form-control" value="<?php echo $shipment_details; ?>" style="pointer-events: none;background: #d8dbe1;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <?php
                                        $sql3 = sprintf("SELECT * FROM sup_invoice where sup_order_id = '$sup_order_id'");
                                        $qur3 = mysqli_query($sup_db, $sql3);
                                        while($row3 = mysqli_fetch_array($qur3)){
                                            $file_name = $row3['invoice_file'];
                                            $invoice_amount = $row3['invoice_amount'];
                                            ?>
                                            <?php if(!empty($file_name)){ ?>
                                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Invoice : </label>
                                                <div class="col-sm-5">
                                                    <a href="order_invoices/<?php echo $sup_order_id; ?>/<?php echo $file_name; ?>" target="_blank">
                                                        <input type="text" name="att_voice" class="form-control pn_none" value="<?php echo $file_name; ?>" style="pointer-events: none!important;">
                                                    </a>
                                                </div>
                                                <label for="exampleInputMobile" class="col-sm-1 col-form-label">Amount  </label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="att_amount" class="form-control pn_none" value="<?php echo $invoice_amount; ?>" style="pointer-events: none!important;">
                                                </div>
                                                <div class="col-sm-1" style="font-size: 20px!important;text-align: center;margin-left: -39px;margin-top: 4px;">
                                                    <?php echo "(" . payment_currency . ")"; ?>
                                                </div>
                                            <?php } } ?>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Attachments : </label>
                                        <div class="col-sm-9">
                                            <?php
                                            $sql4 = sprintf("SELECT * FROM order_files where order_id = '$sup_order_id' and file_type = 'attachment'");
                                            $qur4 = mysqli_query($sup_db, $sql4);
                                            $row4 = mysqli_fetch_array($qur4);
                                            $file_name4 = $row4['file_name'];
                                            ?>
                                            <a href="order_invoices/<?php echo $file_name4; ?>" target="_blank">
                                                <input type="text" name="att_doc" class="form-control pn_none" id="att_doc"
                                                       value="<?php echo $file_name4; ?>" style="pointer-events: none!important;">
                                            </a>
                                        </div>
                                    </div>
                                </form>
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
<!-- End custom js for this page -->
</body>
</html>

