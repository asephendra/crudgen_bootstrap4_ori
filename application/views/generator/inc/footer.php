	<script>

	function confirm_delete()
	{
		
		var get_confirm = confirm('Apakah Anda yakin akan menghapus data ini ?');
	
		if(get_confirm == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	$(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy'
		});
	});
	</script>

	<div class="footer">	
		<hr>
		<p class="pull-left"><small>CRUD Codeigniter</small></p>
		<p class="pull-right"><small>Craft with love, Kinta Mahadji</small></p>
	</div>

	</div><!-- end container -->


	</body>
</html>