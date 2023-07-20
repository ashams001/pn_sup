<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
        @font-face { font-family: Arial !important; font-display: swap !important; }
    </style>
    <link href="#" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <script type="text/javascript" src="#"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/components_dropdowns.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
    <style>
        .rounded-pill {
            border-radius: 0rem!important;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        } @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root{

            --body-color: #E4E9F7;
            --sidebar-color: #FFF;
            --primary-color: #1707c4;
            --primary-color-light: #F6F5FF;
            --toggle-color: #DDD;
            --text-color: #383838;
            --tran-03: all 0.2s ease;
            --tran-03: all 0.3s ease;
            --tran-04: all 0.3s ease;
            --tran-05: all 0.3s ease;
        }

        body{
            min-height: 100vh;
            background-color: var(--body-color);
            transition: var(--tran-05);
        }

        ::selection{
            background-color: var(--primary-color);
            color: #fff;
        }

        body.dark{
            --body-color: #18191a;
            --sidebar-color: #242526;
            --primary-color: #3a3b3c;
            --primary-color-light: #3a3b3c;
            --toggle-color: #fff;
            --text-color: #ccc;
        }

        /* ===== Sidebar ===== */
        .sidebar{
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            padding: 10px 14px;
            background: var(--sidebar-color);
            transition: var(--tran-05);
            z-index: 100;
        }
        .sidebar.close{
            width: 88px;
        }

        /* ===== Reusable code - Here ===== */
        .sidebar li{
            height: 50px;
            list-style: none;
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .sidebar header .image,
        .sidebar .icon{
            min-width: 60px;
            border-radius: 6px;
        }

        .sidebar .icon{
            min-width: 60px;
            border-radius: 6px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .sidebar .text,
        .sidebar .icon{
            color: var(--text-color);
            transition: var(--tran-03);
        }

        .sidebar .text{
            font-size: 17px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 1;
        }
        .sidebar.close .text{
            opacity: 0;
        }
        /* =========================== */

        .sidebar header{
            position: relative;
        }

        .sidebar header .image-text{
            display: flex;
            align-items: center;
        }
        .sidebar header .logo-text{
            display: flex;
            flex-direction: column;
        }
        header .image-text .name {
            margin-top: 2px;
            font-size: 18px;
            font-weight: 600;
        }

        header .image-text .profession{
            font-size: 16px;
            margin-top: -2px;
            display: block;
        }

        .sidebar header .image{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar header .image img{
            width: 40px;
            border-radius: 6px;
        }

        .sidebar header .toggle{
            position: absolute;
            top: 50%;
            right: -35px;
            transform: translateY(-50%) rotate(180deg);
            height: 40px;
            width: 40px;
            background-color: var(--primary-color);
            color: var(--sidebar-color);
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            cursor: pointer;
            transition: var(--tran-05);
        }

        body.dark .sidebar header .toggle{
            color: var(--text-color);
        }

        .sidebar.close .toggle{
            transform: translateY(-50%) rotate(0deg);
        }

        .sidebar .menu{
            margin-top: 40px;
        }

        .sidebar li.search-box{
            border-radius: 6px;
            background-color: var(--primary-color-light);
            cursor: pointer;
            transition: var(--tran-05);
        }

        .sidebar li.search-box input{
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            background-color: var(--primary-color-light);
            color: var(--text-color);
            border-radius: 6px;
            font-size: 17px;
            font-weight: 500;
            transition: var(--tran-05);
        }
        .sidebar li a{
            list-style: none;
            height: 100%;
            background-color: transparent;
            display: flex;
            align-items: center;
            height: 100%;
            width: 100%;
            border-radius: 6px;
            text-decoration: none;
            transition: var(--tran-03);
        }

        .sidebar li a:hover{
            background-color: var(--primary-color);
        }
        .sidebar li a:hover .icon,
        .sidebar li a:hover .text{
            color: var(--sidebar-color);
        }
        body.dark .sidebar li a:hover .icon,
        body.dark .sidebar li a:hover .text{
            color: var(--text-color);
        }

        .sidebar .menu-bar{
            height: calc(100% - 55px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: scroll;
        }
        .menu-bar::-webkit-scrollbar{
            display: none;
        }
        .sidebar .menu-bar .mode{
            border-radius: 6px;
            background-color: var(--primary-color-light);
            position: relative;
            transition: var(--tran-05);
        }

        .menu-bar .mode .sun-moon{
            height: 50px;
            width: 60px;
        }

        .mode .sun-moon i{
            position: absolute;
        }
        .mode .sun-moon i.sun{
            opacity: 0;
        }
        body.dark .mode .sun-moon i.sun{
            opacity: 1;
        }
        body.dark .mode .sun-moon i.moon{
            opacity: 0;
        }

        .menu-bar .bottom-content .toggle-switch{
            position: absolute;
            right: 0;
            height: 100%;
            min-width: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            cursor: pointer;
        }
        .toggle-switch .switch{
            position: relative;
            height: 22px;
            width: 40px;
            border-radius: 25px;
            background-color: var(--toggle-color);
            transition: var(--tran-05);
        }

        .switch::before{
            content: '';
            position: absolute;
            height: 15px;
            width: 15px;
            border-radius: 50%;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            background-color: var(--sidebar-color);
            transition: var(--tran-04);
        }

        body.dark .switch::before{
            left: 20px;
        }

        .home{
            position: absolute;
            top: 0;
            left: 250px;
            height: 100vh;
            width: calc(100% - 250px);
            background-color: var(--body-color);
            transition: var(--tran-05);
        }
        .home .text{
            font-size: 30px;
            font-weight: 500;
            color: var(--text-color);
            padding: 12px 60px;
        }

        .sidebar.close ~ .home{
            left: 78px;
            height: 100vh;
            width: calc(100% - 78px);
        }
        body.dark .home .text{
            color: var(--text-color);
        }
        code {
            background: #fff;
            padding: 0.2rem;
            border-radius: 0.2rem;
            margin: 0 0.3rem;
        }
    </style>
</head>
<body classname="snippet-body" data-new-gr-c-s-check-loaded="14.1115.0" data-gr-ext-installed="">
<div class="d-flex vw-100 vh-100 align-items-center justify-content-center">
    <img src="https://www.clipartmax.com/png/full/357-3572287_southwestern-connections-inc-ss-green-projects-logo.png" class="rounded-circle imgfluid"  alt=""/>

    <header
            class="d-flex navbar-conts flex-wrap align-items-center justify-content-center justify-content-md-between py-1 mb-4 border-bottom rounded-pill  ">
        <a href="~/HOME" class="navbarlogo d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none w-auto">
            <img src="assets/images/site_logo.png" alt="" style="width: 150px!important;margin-left: 72px!important;"/>
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
                <li><a href="<?php echo $siteURL; ?>profile.php" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a></li>
                <li><a href="<?php echo $siteURL; ?>change_pass.php" class="dropdown-item"><i class="icon-cog5"></i> Change Password</a></li>
                <li><a href="logout.php" class="dropdown-item"><i class="icon-switch2"></i> Logout</a></li>
                <!--<li><a class="dropdown-item" href="#"><i class="icon-user-plus"></i>My Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="icon-cog5"></i>Change Password</a></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>-->
            </ul>
        </div>
    </header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/js/bootstrap.min.js"></script>

    <!-- More: https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
</div>
<nav class="sidebar">
    <header>
        <div class="image-text">
                <span class="image">
                    <!--<img src="logo.png" alt="">-->
                </span>

            <div class="text logo-text">
                <img src="assets/images/site_logo.png" alt="" style="width:150px;margin-left: -36px;height: 50px;"/></div>
            </div>
        </div>

        <i class="bx bx-chevron-right toggle"></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

           <!-- <li class="search-box">
                <i class="bx bx-search icon"></i>
                <input type="text" placeholder="Search...">
            </li>-->

            <ul class="menu-links">
                <li class="nav-link">
                    <a href="#">
                        <i class="bx bx-home-alt icon" style="margin-left: -57px;"></i>
                        <span class="text nav-text">Active Orders</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class="bx bx-bar-chart-alt-2 icon" style="margin-left: -57px;"></i>
                        <span class="text nav-text">Historical Orders</span>
                    </a>
                </li>

   <!--             <li class="nav-link">
                    <a href="#">
                        <i class="bx bx-bell icon"></i>
                        <span class="text nav-text">Notifications</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class="bx bx-pie-chart-alt icon"></i>
                        <span class="text nav-text">Stats</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class="bx bx-heart icon"></i>
                        <span class="text nav-text">Favourites</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class="bx bx-wallet icon"></i>
                        <span class="text nav-text">Money</span>
                    </a>
                </li>

            </ul>-->
        </div>

        <!--<div class="bottom-content">
            <li class="">
                <a href="#">
                    <i class="bx bx-log-out icon"></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

            <li class="mode">
                <div class="sun-moon">
                    <i class="bx bx-moon icon moon"></i>
                    <i class="bx bx-sun icon sun"></i>
                </div>
                <span class="mode-text text">Dark mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>

        </div>-->
    </div>

</nav>
<script type="text/javascript" src="#"></script>
<script type="text/javascript" src="#"></script>
<script type="text/javascript" src="#"></script>
<script type="text/javascript" src="#"></script>
<script type="text/javascript">const body = document.querySelector('body'),
        sidebar = body.querySelector('nav'),
        toggle = body.querySelector(".toggle"),
        searchBtn = body.querySelector(".search-box"),
        modeSwitch = body.querySelector(".toggle-switch"),
        modeText = body.querySelector(".mode-text");


    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    })

    searchBtn.addEventListener("click", () => {
        sidebar.classList.remove("close");
    })

    modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");

        if (body.classList.contains("dark")) {
            modeText.innerText = "Light mode";
        } else {
            modeText.innerText = "Dark mode";

        }
    });</script>
<script type="text/javascript">
    var myLink = document.querySelectorAll('a[href="#"]');
    myLink.forEach(function(link){
        link.addEventListener('click', function(e) {
            e.preventDefault();
        });
    });
</script>

</body><grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration></html>