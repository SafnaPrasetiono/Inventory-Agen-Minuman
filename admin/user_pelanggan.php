<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<link rel="stylesheet" type="text/css" href="../dist/css/data_pelanggan_user.css">
</head>

<body>
	<div class="container-fluid main-page">
		<div class="row">

			<!-- judul -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2>Data Pelanggan</h2>
				<hr class="soft">
			</div>

			<!-- membuat form pencarian data pada data user atau pembeli -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form action="" method="post" class="navbar-form navbar-right">
					<div class="input-group">
						<input type="text" name="caripembeli" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit" name="caripelanggan">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</div>
				</form>
			</div>

			<!-- table pelanggan -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="over-table">
					<table class="table table-striped">
						<thead>
							<tr class="success">
								<th>NO</th>
								<th>NAMA</th>
								<th>EMAIL</th>
								<th>TELEPON</th>
								<th>ALAMAT</th>
							</tr>
						</thead>

						<tbody>
							<?php
							// pada kolom cari apa bila btn cari di klik maka akan di eksekusi pada cari uset
							// jik tidak maka akan menampilkan hanya data user yang tidak di cari
							if (isset($_POST["caripelanggan"])) {
								$hasilcari = $_POST["caripembeli"];
								$sql = $koneksi->query("SELECT * FROM user WHERE username LIKE '%$hasilcari%'");
							} else {
								$sql = $koneksi->query("SELECT * FROM user");
							}
							$nomor = 1;
							?>

							<?php while ($datauser = $sql->fetch_assoc()) : ?>
								<tr>
									<td><?php echo $nomor; ?></td>
									<td><?php echo $datauser["username"]; ?></td>
									<td><?php echo $datauser["email"]; ?></td>
									<td><?php echo $datauser["no_tlp_user"]; ?></td>
									<td><?php echo $datauser["alamat"]; ?></td>
								</tr>
								<?php
								$nomor++;
							endwhile;
							?>
						</tbody>
					</table>
				</div>
			</div>


		</div>
	</div>
	<!-- penutup container dan row -->

</body>

</html>