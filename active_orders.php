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
$heading = 'Active Orders';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PN</title>
   <style>
       .fa.fa-eye {
           color: #ffffff!important;
           width: 25px;
       }
       .fa-solid.fa-pen{
           width: 25px;
       }
       .btn.btn-success{
           background: #1F5D96!important;
           border-color: #1F5D96!important;
       }
       .alert-success {
           color: #0f5132!important;
           background-color: #d1e7dd!important;
           border-color: #badbcc!important;
           font-size: 17px!important;
       }
       .alert-danger {
           color: #721c24!important;
           background-color: #f8d7da!important;
           border-color: #f5c6cb!important;
           font-size: 17px;
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
                <?php
                if (!empty($import_status_message)) {
                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
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
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Status</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th> S.No </th>
                                            <th> Order No </th>
                                            <th> Order Name </th>
                                            <th> Order Desc </th>
                                            <th> Ordered On </th>
                                            <th> Order Status </th>
                                            <th> Actions </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  sup_order  where order_active = 1 and c_id = '$user_id' and is_deleted != 1 order by created_on DESC");
                                        $qur = mysqli_query($sup_db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?>
                                            <tr>

                                                <td>
                                                    <span class="pl-2"><?php echo ++$counter; ?></span>
                                                </td>
                                                <td>
                                                    <span class="pl-2"><?php echo $rowc['sup_order_id']; ?></span>
                                                </td>
                                                <?php $order_id = $rowc['order_id'];
                                                $order_status_id = $rowc['order_status_id'];
                                                $ship_det = $rowc['shipment_details']; ?>
                                                <input hidden id="edit_order_id" name="edit_order_id"
                                                       value="<?php echo $order_id; ?>">
                                                <input hidden id="e_order_status" name="e_order_status"
                                                       value="<?php echo $order_status_id; ?>">
                                                <td> <?php echo $rowc['order_name']; ?> </td>
                                                <td> <?php echo $rowc['order_desc']; ?> </td>
                                                <?php
                                                $qurtemp = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id' ");
                                                while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                                    $order_status = $rowctemp["sup_order_status"];
                                                }
                                                ?>
                                                <td> <?php echo dateReadFormat($rowc['created_on']); ?> </td>
                                                <td>  <div class="badge badge-outline-success">  <?php echo $order_status; ?></div></td>
                                                <?php if($order_status_id < 4){ ?>
                                                    <td>
                                                            <a class="btn btn-success" href="order_edit.php?id=<?php echo $order_id ?>">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </a>
                                                    <td>
                                                <?php }elseif($order_status_id == 4){ ?>
                                                    <td>
                                                        <a class="btn btn-success" href="edit_shipped_file.php?id=<?php echo $order_id ?>">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                    </td>
                                                <?php }else{ ?>
                                                    <td>
                                                        <a class="btn btn-success" href="view_order_data.php?id=<?php echo $rowc['sup_order_id'] ?>"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                <?php } ?>
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
