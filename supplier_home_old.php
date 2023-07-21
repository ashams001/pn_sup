<?php include("sup_config.php");
include("config.php");
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
$temp = "";
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
$chicagotime = date("Y-m-d H:i:s");
$role = $_SESSION['role_id'];
$user_id = $_SESSION["id"];
	$message_stauts_class = '';
	$import_status_message = '';
    if(null != $_POST['op_type'] && $_POST['op_type'] == "del_file"){
		$file_name = $_POST['file_name'];
		$file_type = $_POST['file_type'];
		$order_id = $_POST['order_id'];
        $path = "./order_invoices/" . $_POST['file_name'];
		unlink($path);
		$sql = "DELETE FROM `order_files` where order_id = '$order_id' and file_type ='$file_type' and file_name= '$file_name'";
		$result1 = mysqli_query($sup_db, $sql);
		exit();
    }else{
		$order_status_id = $_POST['edit_order_status'];
		$e_order_status = $_POST['e_order_status'];
		$order_id = $_POST['edit_order_id'];
		if (!is_null($order_status_id) && !empty($order_status_id)) {
			$sql = "update sup_order set order_status_id='$order_status_id', modified_on='$chicagotime', modified_by='$user_id' where  order_id = '$order_id'";
			$result1 = mysqli_query($sup_db, $sql);
			if ($result1) {
                $sql_ses_log = "INSERT INTO `supplier_session_log`(`order_id`, `c_id`, `order_status_id`, `created_by`, `created_on`) VALUES ('$order_id','','$order_status_id','$user_id','$chicagotime')";
                $result_log = mysqli_query($sup_db, $sql_ses_log);
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
					$sql = "update sup_order set order_status_id='$order_up_status_id',shipment_details = '$ship_det' , modified_on = '$message', modified_by='$user_id' where  order_id = '$order_id'";
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
                $sql_ses_log = "INSERT INTO `supplier_session_log`(`order_id`, `c_id`, `order_status_id`, `created_by`, `created_on`) VALUES ('$order_id','','$order_status_id','$user_id','$chicagotime')";
                $result_log = mysqli_query($sup_db, $sql_ses_log);
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
    <title><?php echo $sitename; ?> | Active Orders</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style_main.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="assets/js/core/app.js"></script>
    <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/components_modals.js"></script>
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style.css" rel="stylesheet">
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
        #close_bt{
            color: #cc0000;
        }

        #file_del{
            background-color: #fff;
            border: navajowhite;
        }

        #order_details{
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
         .navbar {

             padding-top: 0px!important;
         }
        .dropdown .arrow {

            margin-top: -25px!important;
            width: 1.5rem!important;
        }
        #ic .arrow {
            margin-top: -22px!important;
            width: 1.5rem!important;
        }
        .fs-6 {
            font-size: 1rem!important;
        }

        .content_img {
            width: 113px;
            float: left;
            margin-right: 5px;
            border: 1px solid gray;
            border-radius: 3px;
            padding: 5px;
            margin-top: 10px;
        }

        /* Delete */
        .content_img span {
            border: 2px solid red;
            display: inline-block;
            width: 99%;
            text-align: center;
            color: red;
        }
        .remove_btn{
            float: right;
        }
        .contextMenu{ position:absolute;  width:min-content; left: 204px; background:#e5e5e5; z-index:999;}
        .collapse.in {
            display: block!important;
        }
        .mt-4 {
            margin-top: 0rem!important;
        }

        table.dataTable thead .sorting:after {
            content: ""!important;
            top: 49%;
        }
        .card-title:before{
            width: 0;

        }
        .main-content .container, .main-content .container-fluid {
            padding-left: 20px;
            padding-right: 238px;
        }
        .main-footer {
            margin-left: -127px;
            margin-right: 112px;
            display: block;
        }
        .badge {
            padding: 0.5em 0.5em!important;
            width: 100px;
            height: 23px;
        }
        @media (min-width: 481px) and (max-width: 768px){
            .col-md-1.media{
                display: none!important;
            }
            .col-md-2 {
                width: 24%;
            }
        }
        a.btn.btn-success.btn-sm.br-5.me-2.legitRipple {
            height: 32px;
            width: 32px;
        }
        .sidebar.sidebar-main.sidebar-default{
            background-color: #191e3a;
            width: 210px;
            margin-top: 60px!important;
            margin-left: -4px!important;
        }
        .navbar-header {
            margin-right: 1300px!important;
        }
        body {
            line-height: 1.5384616!important;
            font-size: 14px!important;
        }

    </style>
    </style>
</head>

<?php
$cam_page_header = "Active Orders";
include("./sup_header.php");
include("./sup_admin_menu.php");
?>
<body>
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <div class="content-wrapper">
            <!-- Content area -->
            <div>
                <?php if ($temp == "one") { ?>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                        <span class="text-semibold">Form Type</span> Created Successfully.
                    </div>
                <?php } ?>
                <?php if ($temp == "two") { ?>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                        <span class="text-semibold">Form Type</span> Updated Successfully.
                    </div>
                <?php } ?>
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
            </div>
            <div class="content" id="order_det_table">
                <form action="" id="update-form" method="post" class="form-horizontal">
                    <br/>
                    <!-- Main charts -->
                    <!-- Basic datatable -->
                    <div class="panel panel-flat">
                        <table id="order_details" class="table">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order Desc</th>
                                <th>Ordered On</th>
                                <th>Current Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  sup_order  where order_active = 1 order by created_on DESC");
							$qur = mysqli_query($sup_db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><?php echo ++$counter; ?></td>
									<?php $order_id = $rowc['order_id'];
                                    $sup_order_id = $rowc['sup_order_id'];
                                    $order_name = $rowc['order_name'];
									$order_status_id = $rowc['order_status_id'];
									$ship_det = $rowc['shipment_details']; ?>
                                    <input hidden id="edit_order_id" name="edit_order_id"
                                           value="<?php echo $order_id; ?>">
                                    <input hidden id="e_order_status" name="e_order_status"
                                           value="<?php echo $order_status_id; ?>">
                                    <td><?php echo $rowc['order_desc']; ?></td>
									<?php
									$qurtemp = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$order_status = $rowctemp["sup_order_status"];
									}
									?>
                                    <td><?php echo dateReadFormat($rowc['created_on']); ?></td>
                                    <td><?php echo $order_status; ?></td>
                                    <td>
                                       <button type="button" id="edit" class="btn btn-primary btn-xs submit_btn"
                                                data-id="<?php echo $order_id ?>"
                                                data-order_idd="<?php echo $sup_order_id; ?>"
                                                data-order_name="<?php echo $order_name; ?>"
                                                data-order_status_id="<?php echo $order_status_id ?>"
                                                data-ship_det="<?php echo $ship_det ?>"
                                               data-toggle="modal"
                                               style="color:background-color:legitReppile"
                                               data-target="#edit_modal_theme_primary">  <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal col-lg-12 col-md-12">
                <div class="modal-dialog" style="width:100%">
                    <div class="modal-content">
                        <div class="card-header" style="background: #1F5D96;">
                            <button type="button" style="color: white;font-size: 1.9125rem;" class="close" data-dismiss="modal">&times;</button>
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Update Supplier Order Status</span>
                        </div>
                        <form action="" id="shipment_details_form" enctype="multipart/form-data" class="form-horizontal"
                              method="post">
                            <div class="card-body" style="">
                                <div class="col-lg-12 col-md-12">
                                    <div class="pd-30 pd-sm-20">
                                        <div class="row row-xs">
                                            <div class="col-md-4">
                                                <label class="form-label mg-b-0">Order Id:</label>
                                            </div>
                                            <div class="col-md-8 mg-t-10 mg-md-t-0">
                                                <input type="text" name="edit_order_idd" id="edit_order_idd" class="form-control" disabled>
                                                <input type="hidden" name="edit_id" id="edit_id">
                                                <input type="hidden" name="edit_order_status_id" id="edit_order_status_id">
                                                <input type="hidden" name="edit_up_order_status_id"
                                                       id="edit_up_order_status_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pd-30 pd-sm-20">
                                        <div class="row row-xs">
                                            <div class="col-md-4">
                                                <label class="form-label mg-b-0">Order Name:</label>
                                            </div>
                                            <div class="col-md-8 mg-t-10 mg-md-t-0">
                                                <input type="text" name="edit_order_name" id="edit_order_name" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pd-30 pd-sm-20">
                                        <div class="row row-xs">
                                            <div class="col-md-4">
                                                <label class="form-label mg-b-0">Order Status:</label>
                                            </div>
                                            <div class="col-md-8 mg-t-10 mg-md-t-0">
                                                <select name="edit_order_status" id="edit_order_status" class="form-control" data-placeholder="Select Order Status"
                                                        onchange = "ShowHideDiv()">
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
                                    </div>
                                    <div id="dvPassport" style="display: none">
                                    <div class="pd-30 pd-sm-20">
                                        <div class="row row-xs">
                                            <div class="col-md-4">
                                                <label class="form-label mg-b-0">Shipment Details * : </label>
                                            </div>
                                            <div class="col-md-8 mg-t-10 mg-md-t-0">
                                                 <textarea required id="edit_ship_details" name="edit_ship_details" rows="3"
                                                           placeholder="Enter Shipment Details..."
                                                           class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pd-30 pd-sm-20">
                                        <div class="row row-xs">
                                            <div class="col-md-4">
                                                <label class="form-label mg-b-0">Attach Invoice : </label>
                                            </div>
                                            <div class="col-md-8 mg-t-10 mg-md-t-0">
                                                <input type="file" name="invoice" id="invoice" class="form-control">
                                                <!-- `display Invoice-->
                                                <?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='invoice' and order_id = '$order_id'");
                                                while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                                    $filename = $rowcimage['file_name'];
                                                    ?>
                                                    <div class="col-md-8">
                                                        <a target="_blank" href='./order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
                                                        <button id="file_del" onClick="file_del('$order_id','$filename')">
                                                            <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
                                                            <input type="hidden" name="file_name" id="file_name" value="<?php echo $filename; ?>">
                                                            <input type="hidden" name="file_type" id="file_type" value="invoice">
                                                            <span id="close_bt">&times;</span></button>
                                                    </div>
                                                <?php } ?>
                                                <div id=" error6" class="red">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pd-30 pd-sm-20">
                                        <div class="row row-xs">
                                            <div class="col-md-4">
                                                <label class="form-label mg-b-0">Other Attachments: </label>
                                            </div>
                                            <div class="col-md-8 mg-t-10 mg-md-t-0">
                                                <input type="file" name="attachments[]" id="attachments"
                                                       class="form-control" multiple>
                                                <!-- `display Invoice-->
                                                <?php $qurimage = mysqli_query($sup_db, "SELECT * FROM  order_files where file_type='attachment' and order_id = '$order_id'");
                                                while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                                    $filename = $rowcimage['file_name'];
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <a target="_blank" href='./order_invoices/<?php echo $filename; ?>'><?php echo $filename; ?></a>
                                                        <button id="file_del" onClick="file_del('$order_id','$filename')">
                                                            <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
                                                            <input type="hidden" name="file_name" id="file_name" value="<?php echo $filename; ?>">
                                                            <input type="hidden" name="file_type" id="file_type" value="attachment">
                                                            <span id="close_bt">&times;</span></button>
                                                    </div>
                                                <?php } ?>
                                                <div id="error6" class="red">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
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
<?php
$i = $_SESSION["sqq1"];
if ($i == "") {}
?>
<script>
    $(document).on('click', '#edit', function () {
        var element = $(this);
        var edit_id = $(this).data("id");
        var order_idd = $(this).data("order_idd");
        var order_name = $(this).data("order_name");
        var order_status_id = $(this).data("order_status_id");
        var ship_det = $(this).data("ship_det");
        var up_order_status_id = $("#edit_order_status").val();
        $("#edit_order_status_id").val(order_status_id);
        $("#edit_up_order_status_id").val(up_order_status_id);
        $("#edit_ship_details").val(ship_det);
        $("#edit_order_name").val(order_name);
        $("#edit_order_idd").val(order_idd);
        $("#edit_id").val(edit_id);
        /*var updatedVal = $("#edit_order_status").val();
        $("input#e_order_status").val($("#edit_order_status").val());
        if (updatedVal == 4) {
            $("button#edit")[0].setAttribute('type', 'button');
        } else {
            $("button#edit")[0].setAttribute('type', 'submit');
        }*/
        });
</script>
<script>
    function ShowHideDiv() {
        var ddlPassport = document.getElementById("edit_order_status");
        var dvPassport = document.getElementById("dvPassport");
        dvPassport.style.display = ddlPassport.value == "4" ? "block" : "none";
    }
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
                $('#dvPassport').modal('show');
            }
        }).done(function( data ) {
            $('#dvPassport').modal('show');
        });
    });
    $(document).ready(function() {
        $('#order_details_wrapper').DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false
        } );
    } );
</script>
<?php include("footer.php"); ?>
</body>
</html>