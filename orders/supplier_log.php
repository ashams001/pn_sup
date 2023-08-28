<?php include("../config.php");
$curdate = date('Y-m-d');
$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: ../logout.php');
}
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
$chicagotime = date("d-m-Y");
$role = $_SESSION['role_id'];
$user_id = $_SESSION["id"];
$heading = 'Supplier Logs';
$_SESSION['supplier'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
if (count($_POST) > 0) {
    $_SESSION['supplier'] = $_POST['supplier'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['timezone'] = $_POST['timezone'];
    $supplier = $_POST['supplier'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $timezone = $_POST['timezone'];
}
if(empty($dateto)){
    $curdate = date('Y-m-d');
    $dateto = $curdate;
}

if(empty($datefrom)){
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
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
    <link rel="stylesheet" href="<?php echo $siteURL; ?>assets/pages/css/pag_table.css"/>
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
    <?php include ('../admin_menu.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper margin-244">
        <!-- partial:partials/_navbar.html -->
        <?php include ('../header.php'); ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../orders/supplier_log.php">Supplier</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Supplier Log</li>
                        </ol>
                    </nav>
                </div>
                <?php
                if (!empty($import_status_message)) {
                    echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_stauts_class'] = '';
                    $_SESSION['import_status_message'] = '';
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
                                                <select name="supplier" id="supplier" class="form-control" data-bs-placeholder="Select Supplier" style="border: 1px solid black;">
                                                    <option value="" selected> Select Supplier </option>
                                                    <?php
                                                    $st_dashboard = $_POST['supplier'];
                                                    $sql1 = "SELECT * FROM `sup_account` order by c_id asc";
                                                    $result1 = mysqli_query($sup_db,$sql1);
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
                                                    <input type="date" name="date_from" id="date_from" class="form-control" value="<?php echo $datefrom; ?>" style="float: left;width: initial;" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <label for="exampleInputUsername2" class="col-sm-1 col-form-label">Date To</label>
                                            <div class="col-sm-4">
                                                <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo $dateto; ?>" style="float: left;width: initial;" required>
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
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" id="up-supplier-module" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" class="ptab_search" id="ptab_search" placeholder="Type to search">
                                                <span class="form-horizontal pull-right">
                                                <div class="form-group">
                                                    <label>Show : </label>
                                                    <?php
                                                    $tab_num_rec = (empty($_POST['tab_rec_num'])?10:$_POST['tab_rec_num']);
                                                    $pg = (empty($_POST['pg_num'])?0:($_POST['pg_num'] - 1));
                                                    $start_index = $pg * $tab_num_rec;
                                                    ?>
                                                    <input type="hidden" id='tab_rec_num' value="<?php echo $tab_num_rec?>">
                                                    <input type="hidden" id='curr_pg' value="<?php echo $pg?>">
                                                    <select id="num_tab_rec" class="ptab_search">
                                                        <option value="10" <?php echo ($tab_num_rec ==10)? 'selected' : ''?>>10</option>
                                                        <option value="25" <?php echo ($tab_num_rec ==25)? 'selected' : ''?>>25</option>
                                                        <option value="50" <?php echo ($tab_num_rec ==50)? 'selected' : ''?>>50</option>
                                                    </select>
                                                </div>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th>S.No</th>
                                            <th>Action</th>
                                            <th> Order No </th>
                                            <th> Order Name </th>
                                            <th> Order Desc </th>
                                            <th> Invoice Amount </th>
                                            <th> Ordered On </th>
                                            <th> Order Status </th>
                                            </thead>
                                            <tbody id="tbody">
                                            <tr>
                                                <?php
                                                $index_left = 1;
                                                $index_right = 2;
                                                $c_query = "SELECT count(*) as tot_count FROM sup_order where is_deleted != 1";
                                                $c_qur = mysqli_query($sup_db, $c_query);
                                                $c_rowc = mysqli_fetch_array($c_qur);
                                                $tot_suppliers = $c_rowc['tot_count'];
                                                $supplier = $_POST['supplier'];
                                                $datefrom = $_POST['date_from'];
                                                $dateto = $_POST['date_to'];
                                                if ($supplier != "" && $datefrom != "" && $dateto != "") {
                                                    $date_from = convertDMYToYMD($datefrom);
                                                    $date_to = convertDMYToYMD($dateto);
                                                    $result = "SELECT `order_id`,`sup_order_id`,`c_id`,`order_name`,`order_desc`,`order_status_id`,`order_active`,`created_on`,`pn_modified_on`,sup_modified_on FROM `sup_order` WHERE DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and c_id = '$supplier' and is_deleted != 1 LIMIT " . $start_index . ',' . $tab_num_rec;
                                                    $qur = mysqli_query($sup_db,$result);
                                                } else if ($supplier != "" && $datefrom == "" && $dateto == "") {
                                                    $qur = mysqli_query($sup_db, "SELECT `order_id`,`sup_order_id`,`c_id`,`order_name`,`order_desc`,`order_status_id`,`order_active`,`created_on`,`pn_modified_on`,sup_modified_on FROM `sup_order` WHERE  c_id = '$supplier'");
                                                } else if ($supplier == "" && $datefrom != "" && $dateto != "") {
                                                    $date_from = convertDMYToYMD($datefrom);
                                                    $date_to = convertDMYToYMD($dateto);
                                                    $qur = mysqli_query($sup_db, "SELECT `order_id`,`sup_order_id`,`c_id`,`order_name`,`order_desc`,`order_status_id`,`order_active`,`created_on`,`pn_modified_on`,sup_modified_on FROM `sup_order` WHERE DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and is_deleted != 1 LIMIT " . $start_index . ',' . $tab_num_rec);
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
                                    <div class="panel-footer">
                                        <div class="row">
                                            <?php
                                            $remainder = $tot_suppliers % $tab_num_rec;
                                            $quotient = ($tot_suppliers - $remainder) / $tab_num_rec;
                                            $tot_pg  = (($remainder == 0)?$quotient: ($quotient+1));
                                            $curr_page = ($pg + 1);
                                            ?>
                                            <div class="col-sm-4 col-xs-6">Page <b><?php echo $curr_page ?></b> of <b><?php echo $tot_pg ?></b></div>
                                            <div class="col-sm-4 col-xs-6" style="text-align: center">Go To Page -
                                                <input id="num_tab_pg" class="ptab_goto_num" type="number" min="1" value=<?php echo $curr_page ?> />
                                            </div>
                                            <div class="col-sm-4 col-xs-6">
                                                <ul class="pagination hidden-xs pull-right">
                                                    <?php

                                                    $xx = (($curr_page -2) > 0)?($curr_page -2):1;
                                                    $zz = (($curr_page +2) < $tot_pg)?($curr_page +2):$tot_pg;
                                                    if($curr_page > 1){
                                                        $pPg = $xx -1;
                                                        echo "<li><a <a id='prev_pg' val='$pPg'>«</a></li>";
                                                    }
                                                    for ($x = $xx; $x <= $zz; $x++) {
                                                        if($x == $curr_page){
                                                            echo "<li" . " class='active'" . "><a class='tab_pg' id='tab_pg_$x' val='$x' >$x</a></li>";
                                                        }else{
                                                            echo "<li><a class='tab_pg'  id='tab_pg_$x' val='$x' >$x</a></li>";
                                                        }
                                                    }
                                                    if($curr_page < $tot_pg){
                                                        $nPg= $zz+1;
                                                        echo "<li><a id='next_pg' val='$nPg'>»</a></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
</div>
<script>
    $(function () {
        $('input:radio').change(function () {
            var abc = $(this).val()
            //alert(abc)
            if (abc == "button1")
            {
                $('#date_from').prop('disabled', false);
                $('#date_to').prop('disabled', false);
                $('#timezone').prop('disabled', true);
            }
        });
    });
</script>
<script>
    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;

        $('#date_to').attr('max', maxDate);
        $('#date_from').attr('max', maxDate);
    });
</script>

<script>
    $("#num_tab_rec").change(function (e) {
        e.preventDefault();
        $(':input[type="button"]').prop('disabled', true);
        var data = "tab_rec_num="+ this.value;
        $.ajax({
            type: 'POST',
            data: data,
            url:'supplier_log.php',
            success: function (data) {
                $("body").html(data);
            }
        });
    });
    $( "[id^='tab_pg']" ).click(function (e){
        e.preventDefault();
        var tab_num = document.getElementById('tab_rec_num').value;
        var data = "tab_rec_num="+ tab_num +"&pg_num="+ this.text;
        $.ajax({
            type: 'POST',
            data: data,
            url:'supplier_log.php',
            success: function (data) {
                $("body").html(data);
            }
        });
    });

    $( "#next_pg" ).click(function (e){
        e.preventDefault();
        var tab_num = document.getElementById('tab_rec_num').value;
        var pg_num = document.getElementById('curr_pg').value;
        var nPage = 1;
        if(pg_num != null){
            nPage = (parseInt(pg_num) + 2);
        }
        var data = "tab_rec_num="+ tab_num +"&pg_num="+ nPage;
        $.ajax({
            type: 'POST',
            data: data,
            url:'supplier_log.php',
            success: function (data) {
                $("body").html(data);
            }
        });
    });


    $( "#prev_pg" ).click(function (e){
        e.preventDefault();
        var tab_num = document.getElementById('tab_rec_num').value;
        var pg_num = document.getElementById('curr_pg').value;
        // var nPage = 1;
        // if(pg_num != null){
        //     nPage = (parseInt(pg_num) - 1);
        // }
        var data = "tab_rec_num="+ tab_num +"&pg_num="+ pg_num;
        // var data = "tab_rec_num="+ tab_num +"&pg_num="+ this.text;
        $.ajax({
            type: 'POST',
            data: data,
            url:'supplier_log.php',
            success: function (data) {
                $("body").html(data);
            }
        });
    });

    $( "#num_tab_pg" ).change(function() {
        // e.preventDefault();
        var tab_num = document.getElementById('tab_rec_num').value;
        var pg_num =  this.value;
        var data = "tab_rec_num="+ tab_num +"&pg_num="+ pg_num;
        $.ajax({
            type: 'POST',
            data: data,
            url:'supplier_log.php',
            success: function (data) {
                $("body").html(data);
            }
        });
    });
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    var $rows = $('#tbody tr');
    $('#ptab_search').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>
<?php include("../footer.php"); ?>
</body>
</html>

