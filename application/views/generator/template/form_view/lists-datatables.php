<div class="container white-container">
	
	{php_open} echo $this->session->flashdata('action_status'); {php_close}

	<!-- Head title -->
	<div class="row">
		<div class="col-md-6">
			<h3 class="head-title"><span class="glyphicon glyphicon-play"></span> {php_open} echo $title; {php_close}</h3>
		</div>

		<div class="col-md-6">
			<ul class="list-inline pull-right">
				<li>
					<a href="{php_open} echo site_url().'/{controller_name}/add'; {php_close}" class="btn btn-primary btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah {title_name}" data-original-title="Tambah {title_name}"><i class="glyphicon glyphicon-plus"></i> Tambah {title_name}</a>
				</li>
			</ul>
		</div>
	</div>

	<hr class="hr-head-title">	
	
	<!-- Content -->
	<div class="row">
		<div class="col-md-12">

			{php_open} 			
			if($result === FALSE)
			{
				echo '<div class="no-content">Data belum tersedia</div>';
			}
			else
			{
			{php_close}

			<table class="table table-striped table-hover table-bordered table-condensed datatables">

				<thead>
				    <tr>
						<th class="text-center" width="50px">NO</th>{list_fields}
						<th>{label}</th>{/list_fields}
						<th class="text-center">Aksi</th>
				    </tr>
			    </thead>

			    <tbody>
				
				{php_open} 
				$i = 1;

				foreach ($result as $row):
				{php_close}
					<tr>
						<td class="text-center">{php_open} echo $i; {php_close}</td>
			            {list_fields}
			            <td>{php_open} echo $row->{name}; {php_close}</td>{/list_fields}
						<td class="text-center">
							<a href="{php_open} echo site_url().'/{controller_name}/detail/'.$row->{primary_key}; {php_close}"><i class="glyphicon glyphicon-zoom-in"></i></a>
							<a href="{php_open} echo site_url().'/{controller_name}/edit/'.$row->{primary_key}; {php_close}"><i class="glyphicon glyphicon-pencil"></i></a>
							<a href="{php_open} echo site_url().'/{controller_name}/delete/'.$row->{primary_key}; {php_close}" onclick="return confirm_delete();"><i class="glyphicon glyphicon-trash"></i></a>
				        </td>
					</tr>
				{php_open} 
				$i++;
				endforeach;
				{php_close}

				</tbody>

			</table>

			{php_open}
			echo $pagination;
			{php_close}			

			{php_open} 
			} // endif
			{php_close}

		</div><!-- end col-md-12 -->
	</div><!-- end row-->

</div><!-- end container -->

<!-- load datatables -->
<script src="{php_open} echo base_url(); {php_close}assets/bower_components/datatables/jquery.dataTables.js"></script>
<script src="{php_open} echo base_url(); {php_close}assets/bower_components/datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" href="{php_open} echo base_url(); {php_close}assets/bower_components/datatables/dataTables.bootstrap.css">

<script>
	$(document).ready(function(){
		$('.datatables').dataTable();
	});
</script>