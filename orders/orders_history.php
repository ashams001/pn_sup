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
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $sitename; ?> | Historical Orders</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
		  type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
	<!--<link href="<?php /*echo $siteURL . "/assets/css/icons/icomoon/styles.css" */?>" rel="stylesheet" type="text/css">
	<link href="<?php /*echo $siteURL . "/assets/css/bootstrap.css" */?>" rel="stylesheet" type="text/css">
	<link href="<?php /*echo $siteURL . "/assets/css/core.css" */?>" rel="stylesheet" type="text/css">
	<link href="<?php /*echo $siteURL . "/assets/css/components.css" */?>" rel="stylesheet" type="text/css">
	<link href="<?php /*echo $siteURL . "/assets/css/colors.css" */?>" rel="stylesheet" type="text/css">
	<link href="<?php /*echo $siteURL . "/assets/css/style_main.css" */?>" rel="stylesheet" type="text/css">-->
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<!--<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/plugins/loaders/pace.min.js" */?>"></script>
	<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/core/libraries/jquery.min.js" */?>"></script>
	<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/core/libraries/bootstrap.min.js" */?>"></script>
	<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/plugins/loaders/blockui.min.js" */?>"></script>-->
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<!--<script type="text/javascript"
			src="<?php /*echo $siteURL . "/assets/js/plugins/tables/datatables/datatables.min.js" */?>"></script>
	<script type="text/javascript"
			src="<?php /*echo $siteURL . "/assets/js/plugins/forms/selects/select2.min.js" */?>"></script>
	<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/core/app.js" */?>"></script>
	<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/pages/datatables_basic.js" */?>"></script>
	<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/plugins/ui/ripple.min.js" */?>"></script>
	<script type="text/javascript"
			src="<?php /*echo $siteURL . "/assets/js/plugins/notifications/sweet_alert.min.js" */?>"></script>
	<script type="text/javascript" src="<?php /*echo $siteURL . "/assets/js/pages/components_modals.js" */?>"></script>-->
	<!--chart -->
	<style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
            overflow: hidden;
        }
        .content {
            padding: 0px 15px !important;
            background-color: #060818;
        }
        .table>thead>tr>th {
            vertical-align: middle;
        }
		#order_details{
			margin-top: 20px;
		}
        #product_details{
            margin-top: 20px;
        }

		@media screen and (min-width: 2560px) {
			.dashboard_line_heading {
				font-size: 22px !important;
				padding-top: 5px;
			}
		}
		.thumb img:not(.media-preview) {
			height: 150px !important;
		}
	</style>
    <script>
        $(document).ready(function(){
            $("#flip").click(function(){
                $("#panel").slideToggle("slow");
            });
        });
    </script>
    <script>
        function assortiment(e){
            var assortimentid = e.id + "__js";
            if ($("#" + assortimentid).display = "block"){
                $(".assortiment").stop().slideUp();
                $("#" + assortimentid).stop().slideToggle();
            } else if ($("#" + assortimentid).display = "none"){
                $("#" + assortimentid).stop().slideToggle();
            }
        }
    </script>
    <style>
        #panel, #section1__js {
            padding: 5px;
            text-align: center;
            background-color: #e5eecc;
            border: solid 1px #c3c3c3;
        }

        #panel {
            padding: 50px;
        }
        * {margin: 0; box-sizing: border-box} /* addition; more "fluent" */

        .assortiment {
            display: none;
        }

        .btn {
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px;
            width: 100px;
            margin: 5px;
            background-color: lightblue;
        }

        .btn:hover {
            cursor: pointer
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<!-- /main navbar -->
<?php
$cam_page_header = "Historical Orders";
include("../sup_header.php");
include("../sup_admin_menu.php");
?>
<!-- Page container -->
<div class="page-container">
	<!-- Page content -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">
                <?php
                if (!empty($import_status_message)) {
                    echo '<div class="alert-dismissible fade show alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_stauts_class'] = '';
                    $_SESSION['import_status_message'] = '';
                }
                ?>
			<!-- Content area -->
			<div class="content" id="order_det_table">
				<div class="panel panel-flat">
					<table id="order_details" class="table">
						<thead>
						<tr>
							<th>S.No</th>
							<!--<th>Order ID</th>-->
							<th>Order Desc</th>
							<th>Ordered On</th>
							<th>Order Status</th>
							<th>Actions</th>
                            <th>Details</th>
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
                                <td>
                                    <button type="button" class="btn btn-info btn-xs" style="background-color:#1e73be;">
                                        <div id="section1" onclick="assortiment(this)">
                                            <i class="fa fa-file"></i>
                                        </div>
                                    </button>
                                </td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
                    <div class="assortiment" id="section1__js">
                    <div id="panel">
                                        <table id="product_details" class="table">
                                            <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Order Status</th>
                                                <th>User</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <?php
                                                $query12 = sprintf("SELECT * FROM  supplier_session_log  where order_id = '$order_id'");
                                                $qur12 = mysqli_query($sup_db, $query12);
                                                while ($rowc12     = mysqli_fetch_array($qur12)) {
                                                    $order_status_id = $rowc12['order_status_id'];
                                                    $created_by = $rowc12['created_by'];
                                                    $created_on = $rowc12['created_on'];
                                                    $qurtemp12 = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id'");
                                                    while ($rowctemp12 = mysqli_fetch_array($qurtemp12)) {
                                                        $order_status = $rowctemp12["sup_order_status"];
                                                    }
                                                    $qurtemp22 = mysqli_query($sup_db, "SELECT * FROM  cam_users where is_deleted != 1 and users_id = '$created_by'");
                                                    while ($rowctemp22 = mysqli_fetch_array($qurtemp22)) {
                                                        $firstname = $rowctemp22["firstname"];
                                                        $lastname = $rowctemp22["lastname"];
                                                        $full_name = $firstname . '' . $lastname;
                                                    }
                                                    ?>
                                                    <td><?php echo ++$cnt; ?></td>
                                                    <td><?php echo $order_status; ?></td>
                                                    <td><?php echo $full_name; ?></td>
                                                    <td><?php echo dateReadFormat($created_on); ?></td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                    </div>
                </div>
				</div>
			</div>
			<!-- edit modal -->
			<div id="edit_modal_theme_primary" class="modal fade" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-primary">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h6 class="modal-title">
								Update Shipment Data
							</h6>
						</div>
						<form action="" id="shipment_details_form" enctype="multipart/form-data" class="form-horizontal"
							  method="post">
							<div class="modal-body">
								<!--SHIPPING DETAILS-->
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="col-lg-4 control-label">Shipment Details * : </label>
											<div class="col-lg-8">
                                            <textarea required id="edit_ship_details" name="edit_ship_details" rows="3"
													  placeholder="Enter Shipment Details..."
													  class="form-control"></textarea>
											</div>
										</div>
									</div>
								</div>
								<!--Invoice-->
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="col-lg-4 control-label">Attach Invoice : </label>
											<div class="col-lg-8">
												<input type="file" name="invoice" id="invoice" class="form-control" disabled>
												<!-- `display Invoice-->
												<?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='invoice' and order_id = '$order_id'");
												while ($rowcimage = mysqli_fetch_array($qurimage)) {
													$filename = $rowcimage['file_name'];
													?>
													<div class="col-lg-12">
														<a target="_blank" href='./order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
													</div>
												<?php } ?>
												<div id=" error6" class="red">
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--ATTACHMENTS-->
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="col-lg-4 control-label">Other Attachments
												: </label>
											<div class="col-lg-8">
												<input type="file" name="attachments[]" id="attachments"
													   class="form-control" multiple disabled>
												<!-- `display Invoice-->
												<?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='attachment' and order_id = '$order_id'");
												while ($rowcimage = mysqli_fetch_array($qurimage)) {
													$filename = $rowcimage['file_name'];
													?>
													<div class="col-lg-12">
														<a target="_blank" href='./order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
													</div>
												<?php } ?>
												<div id="error6" class="red">
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
		<!-- /main content -->
	</div>
	<!-- /page content -->
</div>

<!-- new footer here -->
<?php
$i = $_SESSION["sqq1"];
if ($i == "") {
	?>

<?php }
?>
<script>
    jQuery(document).ready(function ($) {
        $(document).on('click', '#edit', function () {
            var element = $(this);
            var edit_id = $(this).data("id");
            var order_status_id = $(this).data("order_status_id");
            var ship_det = $(this).data("ship_det");
            var up_order_status_id = $("#edit_order_status").val();
            $("#edit_order_status_id").val(order_status_id);
            $("#edit_up_order_status_id").val(up_order_status_id);
            $("#edit_ship_details").val(ship_det);
            $("#edit_id").val(edit_id);
        });

    });
</script>
<script>
    $(document).on('click', '#file_del', function () {
        var order_id = $(this)[0].children.order_id.value;
        var file_name = $(this)[0].children.file_name.value;
        var file_type = $(this)[0].children.file_type.value;
        var data = "op_type=del_file&order_id=" + order_id +"&file_name="+file_name+"&file_type="+file_type;
        $.ajax({
            type: 'POST',
            data: data,
            async:false,
            success: function(data) {
                $('#edit_modal_theme_primary').modal({"backdrop": "static"},'show');
            }
        }).done(function( data ) {
            $('#edit_modal_theme_primary').modal({"backdrop": "static"},'show');
        });
    });

    setTimeout(function () {

        // Closing the alert
        $('.alert-success').delay(100).fadeOut(500);
    }, 2000);

    $(document).ready(function() {
        $('#order_details_wrapper').DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false
        } );
    } );
    // var alreadyDisplayed = localStorage.getItem('modalOpen');
    $(document).ready(function() {
        $('#product_details_wrapper').DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false
        } );
    } );

</script>
<?php include("footer.php"); ?> <!-- /page container -->
</body>
</html>