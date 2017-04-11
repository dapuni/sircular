<!DOCTYPE html>
<html lang="en">
  <head>
	  <base href="<?php echo base_url()?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sircular</title>

    <!-- Bootstrap -->
    <link href="assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="assets/gentelella/build/css/custom.min.css" rel="stylesheet">

    <!-- Custom Jquery UI -->
	<link rel="stylesheet" type="text/css" href="assets/jqueryui/jquery-ui.min.css">
	<script type="text/javascript" src="assets/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="assets/jqueryui/jquery-ui.min.js"></script>


  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><i class="fa fa-dashboard"></i> <span>Sircular</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo base_url()?>assets/gentelella/production/images/user.png"" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->userdata['username']?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url()?>">Dashboard</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Sirkulasi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      	<li><a href="sirkulasi/rencana_distribusi">Rencana Distribusi</a></li>
			            <li><a href="sirkulasi/realisasi_distribusi">Realisasi Distribusi</a></li>
			            <li><a href="sirkulasi/retur_penjualan">Retur Penjualan</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-money"></i> Tagihan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      	<li><a href="tagihan/invoice_jatah">Invoice Jatah</a></li>
			            <li><a href="tagihan/invoice_konsinyasi">Invoice Konsinyasi</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Master Data <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      	<li><a href="masterdata/penerbit">Penerbit</a></li>
			            <li><a href="masterdata/majalah">Majalah</a></li>
			            <li><a href="masterdata/edisi">Edisi</a></li>
			            <li><a href="masterdata/agent_cat">Kategori Agen</a></li>
			            <li><a href="masterdata/agent">Agen / Outlet</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="laporan/dashboard">Dashboard</a></li>
                    </ul>
                  </li>
                  <?php 
		          		if ($this->session->userdata['group'] == 2) 
		          		{ ?>
		          			<li><a><i class="fa fa-user"></i>User Management <span class="fa fa-chevron-down"></span></a>
			                    <ul class="nav child_menu">
                          <li><a href="login/add">Add User</a></li>
			                      <li><a href="login/user">User List</a></li>
			                    </ul>
			                </li>
		          		<?php }
		          	?>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url()?>assets/gentelella/production/images/user.png" alt=""><?php echo $this->session->userdata['username']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
                      <a href="login/password">
                        <span>Settings</span>
                      </a>
                    <li><a href=login/logout><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12" id="content_section">
                <?php $this->load->view($content)?>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">2016 MRA Media Group
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/gentelella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url() ?>assets/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url() ?>assets/gentelella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url() ?>assets/gentelella/vendors/nprogress/nprogress.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url() ?>assets/gentelella/build/js/custom.min.js"></script>
    <!-- Jquery UI -->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/jqueryui/jquery-ui.min.js"></script>
    <script type="text/javascript">
  		$( document ).ready(function() {
  	    	$('.date').datepicker({
  	    		dateFormat: 'yy-mm-dd'
  	    	});
  		});
	 </script>

  <style type="text/css">
    .table tbody tr td{
      vertical-align: middle;
    }
  </style>
  </body>
</html>
