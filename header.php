<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/vendor.bundle.base.css">
<!-- endinject -->
<!-- Plugin css for this page -->
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/materialdesignicons.min.css">
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/jquery-jvectormap.css">
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/flag-icon.min.css">
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/owl.theme.default.min.css">
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/select2.min.css">
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/select2-bootstrap.min.css">
<link href="<?php echo $siteURL; ?>assets/css/Roboto.css" rel="stylesheet"
      type="text/css">
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/all.min.css"/>
<!-- End plugin css for this page -->
<!-- inject:css -->
<!-- endinject -->
<!-- Layout styles -->
<link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/style.css">
<!-- End layout styles -->
<link rel="shortcut icon" href="https://themewagon.github.io/corona-free-dark-bootstrap-admin-template/assets/images/favicon.png" />
<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="<?php echo $siteURL; ?>orders/supplier_dashboard.php"><img src="./../assets/images/site_logo.png" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <i class="fa-sharp fa-solid fa-caret-right"></i>
        </button>
        <ul class="navbar-nav w-100">
            <li class="nav-item w-100">
              <h2><?php echo $heading; ?></h2>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                    <div class="navbar-profile">
                        <?php if(!empty($_SESSION["uu_img"])) {?>
                            <img class="img-xs rounded-circle" src="<?php echo site_img_url; ?>/assets/images/sup_user_img/<?php echo $_SESSION["uu_img"]; ?>" alt="">
                        <?php }else{?>
                            <img class="img-xs rounded-circle" src="<?php echo $siteURL; ?>user_images/user.png" alt="">
                        <?php }?>
                        <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $_SESSION['fullname']; ?></p>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="<?php echo $siteURL; ?>profile.php">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">My profile</p>
                        </div>

                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="<?php echo $siteURL; ?>change_pass.php">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Change Password</p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item" href="<?php echo $siteURL; ?>logout.php">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle">
                            <i class="fa fa-right-from-bracket"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Log out</p>
                        </div>

                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

<!-- plugins:js -->
<script src="<?php echo $siteURL; ?>assets/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="<?php echo $siteURL; ?>assets/js/progressbar.min.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/jquery-jvectormap.min.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/owl.carousel.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?php echo $siteURL; ?>assets/js/off-canvas.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/hoverable-collapse.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/misc.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/settings.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="<?php echo $siteURL; ?>assets/js/dashboard.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/select2.min.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/typeahead.bundle.min.js"></script>
<!-- End plugin js for this page -->

<!-- Custom js for this page -->
<script src="<?php echo $siteURL; ?>assets/js/file-upload.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/typeahead.js"></script>
<script src="<?php echo $siteURL; ?>assets/js/select2.js"></script>