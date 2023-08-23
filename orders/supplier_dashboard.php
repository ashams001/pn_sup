<?php include("../config.php");
	if (!isset($_SESSION['user'])) {
		header('location: logout.php');
	}
	$temp = "";
	$timestamp = date('H:i:s');
	$message = date("Y-m-d H:i:s");
	$chicagotime = date("Y-m-d H:i:s");
	$role = $_SESSION['role_id'];
	$user_id = $_SESSION["id"];
	$heading = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard</title>
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
	<?php include ('../admin_menu.php'); ?>
	<!-- partial -->
	<div class="container-fluid page-body-wrapper margin-244">
		<!-- partial:partials/_navbar.html -->
		<?php include ('../header.php'); ?>
		<!-- partial -->
		<div class="main-panel">
			<div class="content-wrapper">
			</div>
			<!-- content-wrapper ends -->
			<?php include("../footer.php"); ?>
		</div>
		<!-- main-panel ends -->
	</div>
	<!-- page-body-wrapper ends -->
</div>

<!-- End custom js for this page -->
</body>
</html>
