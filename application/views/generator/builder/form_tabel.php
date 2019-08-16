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
			<?php echo form_open('crudgen/form_fields', array('class' => '')); ?>
				<!-- form table -->
				<div class="form-group">
					<label for="nama">Daftar tabel <span class="field-required">*</span></label>
					<div class="form-input">
						<?php
						echo form_dropdown('list_tables', $list_table, $table, 'class="form-control"');
						?>
					</div>
				</div>
				<div class="well well-sm form-actions">
					<button type="submit" class="btn btn-success">Submit</button> 
				</div>

			<?php echo form_close(); ?>

		</div><!-- end col-md-12 -->
	</div><!-- end row-->

</div><!-- end container -->