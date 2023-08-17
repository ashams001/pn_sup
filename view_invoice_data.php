<?php include("config.php");
$heading = 'View Invoice';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Invoice Order</title>
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
                   <!-- <h3 class="page-title"> View Invoice </h3>-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="order_invoice.php">Invoice</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Invoice</li>
                        </ol>
                    </nav>
                    <div  style="text-align: end;" class="col-sm-2">
                        <a href="order_invoice.php" class="btn btn-primary text-white">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Id - <?php echo $_GET['id']; ?></h4>
                                <form class="forms-sample">
                                    <div class="form-group row">
                                        <div class="col-sm-4">Invoice Files</div>
                                        <div class="col-sm-4"> Total Invoice Amount</div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-2">Date</div>
                                    </div>
                                <?php
                                    $id = $_GET['id'];
                                    $sql = sprintf("SELECT * FROM sup_invoice where sup_order_id = '$id' ");
                                    $qur = mysqli_query($sup_db, $sql);
                                    while($row = mysqli_fetch_array($qur)){
                                    //$sup_order_id = $row['sup_order_id'];
                                    $invoice_file = $row['invoice_file'];
                                    $invoice_amount = $row['invoice_amount'];
                                    $created_by = $row['created_by'];
                                    $q = sprintf("SELECT * FROM sup_account_users where u_id = '$created_by'");
                                    $qurr = mysqli_query($sup_db, $q);
                                    $row2 = mysqli_fetch_array($qurr);
                                    $fullname = $row2['u_firstname'] . ' ' . $row2['u_lastname'];

                                ?>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <a href="order_invoices/<?php echo $row['sup_order_id']; ?>/<?php echo $invoice_file; ?>" target="_blank">
                                                <input type="text" name="att_doc" class="form-control pn_none" id="att_doc"
                                                       value="<?php echo $invoice_file; ?>" style="pointer-events: none;">
                                            </a>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" name="o_name" id="o_name" class="form-control" value="<?php echo $invoice_amount; ?>" style="pointer-events: none;">
                                        </div>
                                        <div class="col-sm-1" style="font-size: 20px!important;text-align: center!important;margin-left: -42px!important;">
                                            <?php echo payment_currency; ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="o_name" id="o_name" class="form-control" value="<?php echo dateReadFormat($row['created_on']); ?>" style="pointer-events: none;">
                                        </div>
                                    </div>
                                <?php } ?>
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

