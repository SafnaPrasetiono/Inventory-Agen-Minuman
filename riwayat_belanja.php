<!DOCTYPE html>
<html>
<head>
	<title>AgentDrinl</title>
</head>
<body>
	<div class="container">
		<h2><b>My Profile</b></h2>
		<hr class="soft">
		<br clear="clr">
			
		<div>
			<div class="col-md-3">
				<div class="row">
					<div class="foto_user col-md-12">
						<img src="img/user.png" alt="..." class="img-rounded img-responsive">
					</div>
					<div class="nama_user col-md-12">
						<h3><?php echo $_SESSION['user']['username']; ?></h3>
					</div>
					<div class="">
						
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<h3>Riwayat Belanja</h3>
				<hr class="soft">
				<br clear="clr">
				<table class="table table-bordered">
					<thead>
						<tr class="success">
							<th>No</th>
							<th>tanggal</th>
							<th>status</th>
							<th>total</th>
							<th>opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$nomor = 1;
							$id_user = $_SESSION['user']['id_user'];
							$sql = $koneksi->query("SELECT * FROM pembelian WHERE id_user='$id_user'");
						?>
						<?php while($data_user = $sql->fetch_assoc()) : ?>
						<tr>
							<td><?php echo $nomor++; ?></td>
							<td><?php echo $data_user['tgl_pembelian']; ?></td>
							<td><?php echo $data_user['status_pembelian']; ?></td>
							<td>Rp. <?php echo number_format($data_user['total_pembelian']); ?></td>
							<td>
								<a href="index.php?set=nota&id=<?php echo $data_user['id_pembelian'] ?>" class="btn btn-info">Nota</a>
								<a href="#" class="btn btn-success">Pembayaran</a>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</body>
</html>