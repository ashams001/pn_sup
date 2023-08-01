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
if (count($_POST) > 0) {
    $message_stauts_class = '';
    $import_status_message = '';

    $order_status_id = $_POST['edit_order_status'];
    $e_order_status = $_POST['e_order_status'];
    $order_id = $_POST['edit_order_id'];
    if (!is_null($order_status_id) && !empty($order_status_id)) {
        $sql = "update sup_order set order_status_id='$order_status_id', modified_on='$chicagotime', modified_by='$user_id' where  order_id = '$order_id'";
        $result1 = mysqli_query($sup_db, $sql);
        if ($result1) {

            $message_stauts_class = 'alert-success';
            $import_status_message = 'Order status Updated successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    } else {
        $order_status_id = $_POST['edit_order_status_id'];
        $order_up_status_id = $_POST['edit_up_order_status_id'];
        $e_order_status = $_POST['e_order_status'];
        $order_id = $_POST['edit_id'];
        $is_updated = true;
        if (null != $order_id) {
            $ship_det = $_POST['edit_ship_details'];
            if (null != $ship_det) {
                $sql = "update sup_order set order_status_id='$order_up_status_id',shipment_details = '$ship_det' ,  modified_on='$chicagotime', modified_by='$user_id' where  order_id = '$order_id'";
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
        }
        $message_stauts_class = 'alert-success';
        $import_status_message = 'Order status Updated successfully.';
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
                                                    <a href="view_historical_data.php?id=<?php echo $order_id; ?>" class="btn btn-info btn-xs" style="background-color:#1e73be;" target="_blank"><i class="fa fa-eye"></i></a>
                                                </td>

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

