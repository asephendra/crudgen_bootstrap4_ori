<div class="container white-container">
	
	<?php echo $this->session->flashdata('action_status'); ?>

	<!-- Head title -->
	<div class="row">
		<div class="col-md-6">
			<h3 class="head-title"><span class="glyphicon glyphicon-play"></span> <?php echo $title; ?></h3>
		</div>

		<div class="col-md-6">&nbsp;</div>
	</div>

	<hr class="hr-head-title">	
	
	<!-- Content -->
	<div class="row">
		<div class="col-md-12">

			<div class="jumbotron">
				<div class="container">
					<h1>CRUD Builder</h1>
					<p>body text</p>
					<p>
						<a href="<?php echo site_url() ?>/builder/crudgen" class="btn btn-primary btn-lg">tambah modul</a>
					</p>
				</div>
			</div>

		</div><!-- end col-md-12 -->
	</div><!-- end row-->

</div><!-- end container -->