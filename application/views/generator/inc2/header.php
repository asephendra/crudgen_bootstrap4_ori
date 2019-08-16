<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title; ?></title>
		
		<!--
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.css">
		-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets_crudgen/css/bootstrap-cerulean.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets_crudgen/css/custom.css">

		<!-- jquery js -->
		<script src="<?php echo base_url(); ?>assets_crudgen/js-library/jquery/jquery.js"></script>
	
		<!-- bootstrap js -->
		<script src="<?php echo base_url(); ?>assets_crudgen/js/bootstrap.js"></script>

		<!-- bootstrap datepicker js -->
		<script src="<?php echo base_url(); ?>assets_crudgen/js-library/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets_crudgen/js-library/bootstrap-datepicker/css/bootstrap-datepicker.css">

	</head>
	<body class="crud">
	
	<?php// if( $this->ion_auth->logged_in() === TRUE ): ?>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container">

			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo site_url(); ?>/builder/crudgen" target="_blank">KMS</a>
			</div>

			<div class="collapse navbar-collapse navbar-ex1-collapse">
				
				<!-- Menu kiri -->
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Page <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo site_url(); ?>/backend/page/hanya_admin">Page hanya admin</a></li>
							<li><a href="<?php echo site_url(); ?>/backend/page/semua_user">Page semua user</a></li>
						</ul>
					</li>
				</ul>

				<!-- Menu kanan -->
				<ul class="nav navbar-nav navbar-right">
					
					<?php// if($this->ion_auth->is_admin()): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo site_url(); ?>/backend/pengguna">Pengguna</a></li>
							<li><a href="<?php echo site_url(); ?>/backend/groups">Groups</a></li>
						</ul>
					</li>
					<?php //endif; ?>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hai, <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="">Edit profil</a></li>
						</ul>
					</li>
					<li><a href="<?php echo site_url().'/auth/logout'; ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>					
				</ul>
			</div>
		</div>
	</nav>

	<?php// endif; ?>

	<div style="background:#fff">