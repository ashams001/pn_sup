<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <title>Top navabr Mouse Hover</title>
    <style>
        * {
            margin: 0;
            padding: 0
        }
        .navbar-conts {

            width: 60px;
            height: 60px;
            background-color: transparent;
            content-visibility: hidden;
        }
        .imgfluid{
            position: absolute;
            width: 50px;
            height: 50px;
            top: 1%;
        }
        header{
            position: fixed;
            top: 0;
        }

        ul li a{
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        ul li a:hover {
            border-bottom: #000000 2px solid;
            box-shadow: rgba(255, 255, 255, 0.1) 0px 1px 1px 0px inset, rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
        }
        .navbar-conts{
            padding-left: 40PX;
            padding-right: 40PX;
            animation-name: navbar-conts;
            animation-duration: 0.5s;
            animation-timing-function: ease-in-out;
            animation-iteration-count: 1;
            animation-fill-mode: both;
            content-visibility: visible;
        }

        @keyframes navbar-conts {
            0% {
                width: 25%;
                background: #f0f0f0;
                box-shadow: 0 0 0 #cccccc, 0 0 0 #ffffff, 10px 10px 10px #cccccc inset, -10px -10px 10px #ffffff inset
            }

            25% {
                width: 50%;
                background: #f8f8f8;
                box-shadow: 10px 10px 10px #cccccc, 10px 10px 10px #ffffff, 0 0 0 #cccccc inset, 0 0 0 #ffffff inset
            }

            50% {
                width: 75%;
                background: #f8f8f8;
                box-shadow: 10px 10px 10px #cccccc, 10px 10px 10px #ffffff, 0 0 0 #cccccc inset, 0 0 0 #ffffff inset
            }

            100% {

                width: 100%;
                background: #fafafa;
                box-shadow: 40px 40px 40px #cccccc, 0 0 0 #ffffff, 0 0 0 #cccccc inset, 2px 2px 2px #ffffff inset
            }

        }
    </style>
</head>

<div class="d-flex vw-100 vh-100 align-items-center justify-content-center">
    <img src="https://www.clipartmax.com/png/full/357-3572287_southwestern-connections-inc-ss-green-projects-logo.png" class="rounded-circle imgfluid"  alt=""/>

    <header
            class="d-flex navbar-conts flex-wrap align-items-center justify-content-center justify-content-md-between py-1 mb-4 border-bottom rounded-pill  ">
        <a href="~/HOME"
           class="navbarlogo d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none w-auto">
            <img src="https://www.clipartmax.com/png/full/357-3572287_southwestern-connections-inc-ss-green-projects-logo.png" class="rounded-circle" width="32" height="32"  alt=""/>
        </a>

        <!--<ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
        </ul>-->

       <!-- <div class="col-md-5 text-end">
            <button type="button" class="btn btn-outline-primary rounded-pill me-2">Login</button>
            <button type="button" class="btn btn-primary rounded-pill">Sign-up</button>

        </div>-->
        <div class="dropdown text-end">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1"
               data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/js/bootstrap.min.js"></script>

    <!-- More: https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
</div>