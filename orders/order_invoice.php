<?php include("../config.php");
if (!isset($_SESSION['user'])) {
    header('location: ../logout.php');
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
    <title>Order Invoice</title>
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
                                                            <th> Invoice Amount </th>
                                                            <th> Ordered On </th>
                                                            <th> Order Status </th>
                                                            </thead>
                                                            <tbody id="tbody">
                                                            <tr>
                                                                <?php
                                                                $index_left = 1;
                                                                $index_right = 2;
                                                                $c_query = "SELECT count(*) as tot_count FROM sup_invoice";
                                                                $c_qur = mysqli_query($sup_db, $c_query);
                                                                $c_rowc = mysqli_fetch_array($c_qur);
                                                                $tot_invoices = $c_rowc['tot_count'];
                                                                $query = sprintf("SELECT * FROM sup_invoice where  created_by = '$user_id' group by sup_order_id LIMIT " . $start_index . ',' . $tab_num_rec);
                                                                $qur = mysqli_query($sup_db, $query);
                                                                while ($rowc = mysqli_fetch_array($qur)) {
                                                                $invoice_status = $rowc['invoice_status'];
                                                                $q13 = sprintf("SELECT * FROM sup_invoice_status where invoice_status_id = '$invoice_status'");
                                                                $qurr13 = mysqli_query($sup_db, $q13);
                                                                $row213 = mysqli_fetch_array($qurr13);
                                                                $invoice_status_name = $row213['invoice_status_name'];
                                                                $created_by = $rowc['created_by'];
                                                                $q = sprintf("SELECT * FROM sup_account_users where sup_id = '$created_by'");
                                                                $qurr = mysqli_query($sup_db, $q);
                                                                $row2 = mysqli_fetch_array($qurr);
                                                                $fullname = $row2['u_firstname'] . ' ' . $row2['u_lastname'];
                                                                $sup_order_id = $rowc['sup_order_id'];
                                                                $q1 = sprintf("SELECT sum(invoice_amount) as invoice_amount FROM sup_invoice where sup_order_id = '$sup_order_id'");
                                                                $qurr1 = mysqli_query($sup_db, $q1);
                                                                $row21 = mysqli_fetch_array($qurr1);
                                                                $invoice_amount = $row21['invoice_amount'];
                                                                $q12 = sprintf("SELECT * FROM sup_order where sup_order_id = '$sup_order_id'");
                                                                $qurr12 = mysqli_query($sup_db, $q12);
                                                                $row212 = mysqli_fetch_array($qurr12);
                                                                $order_name = $row212['order_name'];
                                                                ?>
                                                                <td><?php echo ++$counter; ?></td>
                                                                <td>
                                                                    <a class="btn btn-success btn-sm br-5 me-2 legitRipple" href="view_invoice_data.php?id=<?php echo $rowc['sup_order_id'] ?>"><i class="fa fa-eye"></i></a>
                                                                </td>
                                                                <td><?php echo $rowc['sup_order_id']; ?></td>
                                                                <td><?php echo $order_name; ?> </td>
                                                                <td><?php echo $invoice_amount; ?></td>
                                                                <td><?php echo dateReadFormat($rowc['created_on']); ?></td>
                                                                <td><?php echo $invoice_status_name; ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="row">
                                                            <?php
                                                            $remainder = $tot_invoices % $tab_num_rec;
                                                            $quotient = ($tot_invoices - $remainder) / $tab_num_rec;
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
<script>
    $("#num_tab_rec").change(function (e) {
        e.preventDefault();
        $(':input[type="button"]').prop('disabled', true);
        var data = "tab_rec_num="+ this.value;
        $.ajax({
            type: 'POST',
            data: data,
            url:'order_invoice.php',
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
            url:'order_invoice.php',
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
            url:'order_invoice.php',
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
            url:'order_invoice.php',
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
            url:'order_invoice.php',
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

