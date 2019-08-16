<div class="container white-container">

	<!-- Head title -->
	<div class="row">
		<div class="col-md-6">
			<h3 class="head-title"><span class="glyphicon glyphicon-play"></span> {php_open} echo $title; {php_close}</h3>
		</div>

		<div class="col-md-6">
			<a href="{php_open} echo site_url().'/{controller_name}'; {php_close}" class="pull-right"><i class="glyphicon glyphicon-arrow-left"></i> Kembali ke daftar {title_name}</a>				
		</div>
	</div>

	<hr class="hr-head-title">	

	{php_open}
	echo $this->session->flashdata('action_status');
	echo validation_errors(); 
	{php_close}

	{php_open} echo form_open('{controller_name}/edit/'.$row->{primary_key}.'',array( "class" => "form-horizontal form-validasi" ) ); {php_close}
	
	{update_form}
	<div class="form-group">
		<label for="{label}" class="col-md-4 control-label {label_required}">{label}</label>
		<div class="col-md-4">
			{update_input}
		</div>
	</div>
	{/update_form}

	<!-- Submit button -->
	<div class="row">
		<div class="col-md-12">
			<div class="save-cancel well text-right">
				<input type="submit" value="Update" class="btn btn-success submit-btn btn-md"/>
				&nbsp;
				<a href="{php_open} echo site_url(); {php_close}/{controller_name}/lists" class="btn">Batal</a>
			</div>				
		</div>
	</div>

	{php_open}
	echo form_close(); 
	{php_close}
</div>