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

	<div class="container">	
		<hr>
		<p class="pull-left"><small>Copyright &copy; 2017</small></p>
		<p class="pull-right"><small><a href="http://kurmamedia.com">Kurma Media</a></small></p>
	</div>

	</div><!-- end container -->

	</body>
</html>