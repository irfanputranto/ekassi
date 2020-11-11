<body class="nav-md loadpage">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>E-Kas</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?= base_url() ?>assets/frontend/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Irfan Putranto Pratama</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section menuload">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li <?php if ($this->uri->segment(1) == 'dashboard') {
                                        # code...
                                        echo 'class="active"';
                                    } ?>>
                                    <a href="<?= base_url('dashboard'); ?>"><i class="fa fa-home"></i> Dashboard</a>
                                </li>
                                <li><a><i class="fa fa-desktop"></i> Keuangan <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?= base_url('kk') ?>">Kas Keluar</a></li>
                                        <li><a href="<?= base_url('km') ?>">Kas Masuk</a></li>
                                        <li><a href="typography.html">Jurnal</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-edit"></i> Master <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?= base_url('anggota'); ?>">Anggota</a></li>
                                        <li><a href="<?= base_url('jabatan'); ?>">Jabatan</a></li>
                                        <li><a href="<?= base_url('kodeakun'); ?>">Akun Akutansi</a></li>
                                        <li><a href="<?= base_url('akun') ?>">Akun</a></li>
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-table"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="tables_dynamic.html">Table Dynamic</a></li>
                                    </ul>
                                </li>

                                <!-- <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="chartjs.html">Chart JS</a></li>
                                        <li><a href="chartjs2.html">Chart JS2</a></li>
                                        <li><a href="morisjs.html">Moris JS</a></li>
                                        <li><a href="echarts.html">ECharts</a></li>
                                        <li><a href="other_charts.html">Other Charts</a></li>
                                    </ul>
                                </li> -->
                                <!-- <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
                                        <li><a href="fixed_footer.html">Fixed Footer</a></li>
                                    </ul>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small mx-auto">
                        <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a> -->
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>