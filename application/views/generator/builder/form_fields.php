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
			
			<!-- Daftar tabel -->
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
			<?php echo form_close(); ?><!-- end daftar tabel -->


			<!-- MVC builder -->
			<?php echo form_open('crudgen/build', array('class' => '')); ?>
			
			<!-- form nama page -->
			<div class="form-group">
				<label for="nama">Nama page <span class="field-required">*</span></label>
				<div class="form-input">
					<input type="text" name="title_name" class="form-control" id="title_name" value="<?php echo $title_name ?>" required="required"/>
				</div>
			</div>
			
			<!-- form mvc -->
			<div class="row">

				<div class="col-md-4">
					<div class="form-group">
						<label for="nama">Nama model <span class="field-required">*</span></label>
						<div class="form-input">
							<input type="text" name="model_name" class="form-control" id="model_name" value="<?php echo $model_name ?>" required="required"/>
						</div>
					</div>						
				</div>		

				<div class="col-md-4">
					<div class="form-group">
						<label for="nama">Nama folder view <span class="field-required">*</span></label>
						<div class="form-input">
							<input type="text" name="view_name" class="form-control" id="view_name" value="<?php echo $view_name ?>" required="required"/>
						</div>
					</div>	
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label for="nama">Nama controller <span class="field-required">*</span></label>
						<div class="form-input">
							<input type="text" name="controller_name" class="form-control" id="controller_name" value="<?php echo $controller_name ?>" required="required"/>
						</div>
					</div>
				</div>					
			</div>				

			<?php echo form_hidden('table_name', $table_name) ?>

			<?php echo $list_fields; ?>

			<div class="well well-sm form-actions">
				<button type="submit" class="btn btn-primary">Generate !</button> 
			</div>

		<?php echo form_close(); ?>

		</div><!-- end col-md-12 -->
	</div><!-- end row-->

</div><!-- end container -->