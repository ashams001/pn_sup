<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Vertical Form Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #supplier_settings {
            height: 600px;
            margin-top: -660px;
            margin-left: 250px;
            margin-right: 50px;
            background: #ffffff;
        }
        body {margin: 0; height: 100%; overflow: hidden}
    </style>
</head>
<body>
<?php
include('s_header.php');
include('s_sidemenu.php');
?>
<div class="container">
    <form action="" id="supplier_settings" method="post">
        <div class="row">
            <div class="col-lg-10 col-xl-10 col-md-12 col-sm-12">
                <div class="pd-30 pd-sm-20" style="margin-top: 20px;">
                    <div class="row row-xs align-items-center mg-b-40">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Form Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>