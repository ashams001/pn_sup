<?php include("config.php");
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
$temp = "";
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
$chicagotime = date("d-m-Y");
$role = $_SESSION['role_id'];
$user_id = $_SESSION["id"];
$heading = 'Supplier Logs';
$button_event = "button3";
$curdate = date($message);
$dfrom =   date($message,strtotime("-1 days"));
$dateto = $curdate;
$datefrom = $dfrom;
$temp = "";
if (count($_POST) > 0) {
    $supplier = $_POST['supplier'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $timezone = $_POST['timezone'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Supplier Log</title>
    <!-- Page level plugin JavaScript-->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteURL;?>assets/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="<?php echo $siteURL;?>assets/js/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL;?>assets/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-size: 1rem!important;
        }
        .fa.fa-eye {
            color: #ffffff!important;
            width: 30px;
        }
        .btn.btn-primary.mg-t-5{
            background: #1F5D96!important;
            border-color: #1F5D96!important;
        }
        .btn.btn-success{
            background: #1F5D96!important;
            border-color: #1F5D96!important;
        }
        .table-responsive {
            font-weight: normal!important;
        }
    </style>
</head>
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
                    <h3 class="page-title"> Supplier Log </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Supplier</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Supplier Log</li>
                        </ol>
                    </nav>
                </div>
                <?php
                if (!empty($import_status_message)) {
                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                }
                ?>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                    <form action="" method="post" id="sup_log" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label">Order Status</label>
                                            <div class="col-sm-4">
                                                <select name="supplier" id="supplier" class="form-control form-select select2" data-bs-placeholder="Select Supplier" style="border: 1px solid black;">
                                                    <option value="" selected> Select Supplier </option>
                                                    <?php
                                                    $st_dashboard = $_POST['supplier'];
                                                    $sql1 = "SELECT * FROM `sup_account` order by c_id asc";
                                                    $result1 = $mysqli->query($sql1);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        if($st_dashboard == $row1['c_id'])
                                                        {
                                                            $entry = 'selected';
                                                        }
                                                        else
                                                        {
                                                            $entry = '';

                                                        }
                                                        echo "<option value='" . $row1['c_id'] . "'  $entry>" . $row1['c_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Date From</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input class="form-control" name="date_from" id="date_from" value="<?php echo $datefrom; ?>" type="date">
                                                </div>
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <label for="exampleInputUsername2" class="col-sm-1 col-form-label">Date To</label>
                                            <div class="col-sm-4">
                                                    <input class="form-control datepicker" name="date_to" id="date_to" value="<?php echo $dateto; ?>"  type="date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-1">
                                                <button type="submit" class="btn btn-primary mg-t-5 submit_btn">Submit</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn btn-success mg-t-5" onclick="window.location.reload();">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                        </div>
                    </div>
                </div>
                </div>
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Action</th>
                                            <th> Order No </th>
                                            <th> Order Name </th>
                                            <th> Order Desc </th>
                                            <th> Invoice Amount </th>
                                            <th> Ordered On </th>
                                            <th> Order Status </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($supplier != "" && $datefrom != "" && $dateto != "") {
                                            $date_from = convertDMYToYMD($datefrom);
                                            $date_to = convertDMYToYMD($dateto);
                                            $result = "SELECT `order_id`,`sup_order_id`,`c_id`,`order_name`,`order_desc`,`order_status_id`,`order_active`,`created_on`,`pn_modified_on`,sup_modified_on FROM `sup_order` WHERE DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and c_id = '$supplier' " . $q_str . "order by order_id asc";
                                            $qur = mysqli_query($sup_db,$result);
                                        } else if ($supplier != "" && $datefrom == "" && $dateto == "") {
                                            $qur = mysqli_query($sup_db, "SELECT `order_id`,`sup_order_id`,`c_id`,`order_name`,`order_desc`,`order_status_id`,`order_active`,`created_on`,`pn_modified_on`,sup_modified_on FROM `sup_order` WHERE  c_id = '$supplier'");
                                        } else if ($supplier == "" && $datefrom != "" && $dateto != "") {
                                            $date_from = convertDMYToYMD($datefrom);
                                            $date_to = convertDMYToYMD($dateto);
                                            $qur = mysqli_query($sup_db, "SELECT `order_id`,`sup_order_id`,`c_id`,`order_name`,`order_desc`,`order_status_id`,`order_active`,`created_on`,`pn_modified_on`,sup_modified_on FROM `sup_order` WHERE DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto'" . $q_str . "order by order_id asc");
                                        }
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            $order_id = $rowc['order_id'];
                                            $sup_order_id = $rowc['sup_order_id'];
                                            $order_status_id = $rowc['order_status_id'];
                                            $ship_det = $rowc['shipment_details'];
                                            $qurtemp =  "SELECT * FROM sup_order_status where sup_order_status_id  = '$order_status_id' ";
                                            $restemp = mysqli_query($sup_db,$qurtemp);
                                            $rowctemp = mysqli_fetch_array($restemp);
                                            $order_status = $rowctemp["sup_order_status"];
                                            $qurtemp1 =  "SELECT sum(invoice_amount) as invoice_amount FROM sup_invoice where sup_order_id  = '$sup_order_id'";
                                            $restemp1 = mysqli_query($sup_db,$qurtemp1);
                                            $rowctemp1 = mysqli_fetch_array($restemp1);
                                            $invoice_amount = $rowctemp1["invoice_amount"];
                                            ?>
                                            <tr>
                                                <td><span class="pl-2"><?php echo ++$counter; ?></span></td>
                                                <td> <a class="btn btn-success" href="view_historical_data.php?id=<?php echo $rowc['order_id'] ?>"><i class="fa fa-eye"></i></a> </td>
                                                <td><span class="pl-2"><?php echo $rowc['sup_order_id']; ?></span></td>
                                                <td> <?php echo $rowc['order_name']; ?> </td>
                                                <td> <?php echo $rowc['order_desc']; ?> </td>
                                                <td> <?php echo $invoice_amount; ?> </td>
                                                <td> <?php echo dateReadFormat($rowc['created_on']); ?> </td>
                                                <td><?php echo $order_status; ?></td>
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
        </div>
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<script>
    new DataTable('#example', {
        pagingType: 'full_numbers'
    });
</script>
<script>
    $('#supplier').on('change', function (e) {
        $("#sup_log").submit();
    });
</script>
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
</div>
<?php include("footer.php"); ?>
</body>
</html>

