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

$heading = 'Historical Orders';
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
                                            <th>Order Desc</th>
                                            <th>Ordered On</th>
                                            <th>Order Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  sup_order  where order_active = 0 order by created_on DESC");
                                        $qur = mysqli_query($sup_db, $query);
                                        while ($rowc     = mysqli_fetch_array($qur)) {
                                            ?>
                                            <tr>

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
                                                    <a class="link-opacity-10-hover" href="view_historical_data.php?id=<?php echo $order_id ?>">View</a>
                                                </td>
                                             <!--   <td>
                                                    <a href="view_historical_data.php?id=<?php /*echo $order_id; */?>" class="btn btn-info btn-xs" style="background-color:#1e73be;" target="_blank"><i class="fa fa-eye"></i></a>
                                                </td>-->
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

