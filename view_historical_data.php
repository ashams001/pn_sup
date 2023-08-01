<?php include("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PN</title>
    <!-- plugins:css -->

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
                    <h3 class="page-title"> View Order </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Order</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Order</li>
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
                                    <form class="forms-sample">
                                        <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $id; ?>">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Order Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_name" id="edit_order_name" placeholder="Order Name" value="<?php echo $order_name; ?>" style="pointer-events: none">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Order Id</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="edit_order_id" id="edit_order_id" placeholder="Order Id" value="<?php echo $ordr_id; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Order Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="edit_order_desc" id="edit_order_desc" placeholder="Order Description" value="<?php echo $rowcmain['order_desc']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Order Current Status</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="<?php echo $order_status; ?>" placeholder="Password">
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
                                                                 class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Attach Invoice</label>
                                                <div class="col-sm-9">
                                                    <input type="file" name="invoice" id="invoice" class="form-control">
                                                    <?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='invoice' and order_id = '$order_id'");
                                                    while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                                        $filename = $rowcimage['file_name'];
                                                        ?>
                                                        <div class="input-group col-xs-12">
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

                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <button class="btn btn-dark">Cancel</button>
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

