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
$heading = 'Orders Invoice';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PN</title>
   <style>
       .fa {
           color: #ffffff!important;
           width: 30px;
       }
       .btn.btn-success.btn-sm.br-5.me-2.legitRipple{
           background: #1F5D96!important;
           border-color: #1F5D96!important;
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
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Status</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Action</th>
                                            <th>Order Id</th>
                                            <th>Invoice Status</th>
                                            <th>User</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM sup_invoice group by sup_order_id");
                                        $qur = mysqli_query($sup_db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            $invoice_status = $rowc['invoice_status'];
                                            if($invoice_status == 1){
                                                $inv = 'Active';
                                            }else{
                                                $inv = 'In-Active';
                                            }
                                            $created_by = $rowc['created_by'];
                                            $q = sprintf("SELECT * FROM sup_account_users where u_id = '$created_by'");
                                            $qurr = mysqli_query($sup_db, $q);
                                            $row2 = mysqli_fetch_array($qurr);
                                            $fullname = $row2['u_firstname'] . ' ' . $row2['u_lastname'];

                                            ?>
                                            <tr>
                                                <td><?php echo ++$counter; ?></td>
                                                <td>
                                                    <a class="btn btn-success btn-sm br-5 me-2 legitRipple" href="view_invoice_data.php?id=<?php echo $rowc['sup_order_id'] ?>"><i class="fa fa-eye"></i></a>
                                                </td>
                                                <td><?php echo $rowc['sup_order_id']; ?></td>
                                                <td><?php echo $inv; ?></td>
                                                <td><?php echo $fullname; ?></td>
                                                <td><?php echo dateReadFormat($rowc['created_on']); ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <?php include("footer.php"); ?>
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
<!-- End custom js for this page -->
</body>
</html>

