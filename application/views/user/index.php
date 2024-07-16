<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admin | Dashboard</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?= base_url('assets'); ?>./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets'); ?>./vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets'); ?>./vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?= base_url('assets'); ?>/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="#">
                    <span class="brand">Mangli Djaya Raya
                        <!--<span class="brand-tip">(Admin)</span>-->
                    </span>
                    <span class="brand-mini"></span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <!-- <li>
                        <form class="navbar-search" action="javascript:;">
                            <div class="rel">
                                <span class="search-icon"><i class="ti-search"></i></span>
                                <input class="form-control" placeholder="Search here...">
                            </div>
                        </form>
                    </li> -->
                </ul>
                <ul class="nav navbar-toolbar">
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="<?= base_url('assets/img/users/') . $user['image']; ?>" />
                            <span><?= $user['name']; ?><i class="fa fa-angle-down m-l-5"></i></a></span>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?= base_url('profile'); ?>"><i class="fa fa-user"></i>Profile</a>
                            <!-- <a class="dropdown-item" href="<?= base_url('assets'); ?>profile.html"><i class="fa fa-cog"></i>Settings</a> -->
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href=<?= base_url('auth/logout'); ?>><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="<?= base_url('assets/img/users/') . $user['image']; ?>" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong"><?= $user['name']; ?></div><small>Administrator</small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href=<?= base_url('user/index'); ?>><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="heading">FEATURES</li>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Transaksi</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="<?= base_url('request'); ?>">Request</a>
                            </li>
                            <li>
                                <a href="<?= base_url('replace'); ?>">Replace</a>
                            </li>
                            <li>
                                <a href="<?= base_url('pinjam'); ?>">Pinjam</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" ><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">Barang</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href=<?= base_url('satuan'); ?>>Satuan Barang</a>
                            </li>
                            <li>
                                <a href=<?= base_url('jenis'); ?>>Jenis Barang</a>
                            </li>
                            <li>
                                <a href=<?= base_url('barang'); ?>>Data Barang</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?= $pinjam ?></h2>
                                <div class="m-b-5">PINJAM</div><i class="ti-bar-chart widget-stat-icon"></i>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-info color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?= $request ?></h2>
                                <div class="m-b-5">REQUEST</div><i class="ti-bar-chart widget-stat-icon"></i>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?= $replace ?></h2>
                                <div class="m-b-5">REPLACE</div><i class="ti-bar-chart widget-stat-icon"></i>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?= $barang ?></h2>
                                <div class="m-b-5">BARANG</div><i class="ti-bar-chart widget-stat-icon"></i>
                                
                            </div>
                        </div>
                    </div>
                </div>
                    
                <style>
                    .visitors-table tbody tr td:last-child {
                        display: flex;
                        align-items: center;
                    }

                    .visitors-table .progress {
                        flex: 1;
                    }

                    .visitors-table .progress-parcent {
                        text-align: right;
                        margin-left: 10px;
                    }
                </style>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13">2024 © <b>PT Mangli Djaya Raya</b> </div>
                <a class="px-4" href="<?= base_url('assets'); ?>http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank"></a>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
    </div>
    
    <!-- END THEME CONFIG PANEL -->
    <!-- BEGIN PAGA BACKDROPS-->
    <!--<div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="<?= base_url('assets'); ?>./vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?= base_url('assets'); ?>./vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?= base_url('assets'); ?>/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="<?= base_url('assets'); ?>./js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
</body>

</html>
