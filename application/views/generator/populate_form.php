<?php  
echo form_open( 'crudgen/process_form');
?>

<label for="nama controller">Nama controller : </label>
<input type="text" name="nama_controller"/>

<hr>

<label for="Nama model">nama model</label>
<input type="text" name="nama_model"/>
<hr>

<?php
echo $tabel;
echo '<hr/>';
echo form_submit('submit', 'submit');
echo form_close();
?>			