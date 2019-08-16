<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- <link rel="stylesheet" href="bootstrap.css"> -->
	<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">

</head>
<body>
	<h1>CONTOH CETAK PDF DENGAN MUDAH</h1>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Kelompok</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($kategori as $key => $row): ?>
			<tr>
				<td><?= $row['id'] ?></td>
				<td><?= $row['name'] ?></td>
				<td><?= $row['active'] ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>