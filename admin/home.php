<?php
// ambil data admin dari session
if (isset($_SESSION['admin'])) {
	$user = $_SESSION['admin']['full_name'];
}

// jumlah semua barang
$barang1 = $koneksi->query("SELECT * FROM barang");
$jumlah_barang = mysqli_num_rows($barang1);

// jumlah stok barang yang habis
$barang2 = $koneksi->query("SELECT * FROM barang WHERE jumlah_brg < 1 ");
$barang_habis = mysqli_num_rows($barang2);

// pembelian pending
$pending = $koneksi->query("SELECT * FROM pembelian WHERE status_pembelian='pending'");
$pengiriman_pending = mysqli_num_rows($pending);

// pembelian sukses
$sukses = $koneksi->query("SELECT * FROM pembelian WHERE status_pembelian='selesai'");
$pengiriman_sukses = mysqli_num_rows($sukses);
?>
<!DOCTYPE html>
<html>

<head>
	<title>agentdrink</title>
	<link rel="stylesheet" type="text/css" href="dist/css/home_admin.css">
</head>

<body>
	<div class="container-fluid main-page">
		<div class="row">


			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2>Admin AgentDrink</h2>
				<p>Selemat Datang, <?php echo $_SESSION['admin']['full_name']; ?> </p>
				<hr class="soft">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="panel panel-back box-info">
							<i class="fa fa-cubes fa-4x"></i>
							<h3><?php echo $jumlah_barang; ?></h3>
							<label for="">jumlah barang</label>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="panel panel-back box-info">
							<i class="fa fa-dropbox fa-4x"></i>
							<h3><?php echo $barang_habis; ?></h3>
							<label for="">Stok Barang Habis</label>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="panel panel-back box-info">
							<i class="fa fa-rocket fa-4x"></i>
							<h3><?php echo $pengiriman_pending; ?></h3>
							<label for="">Pending</label>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="panel panel-back box-info">
							<i class="fa fa-truck fa-4x"></i>
							<h3><?php echo $pengiriman_sukses; ?></h3>
							<label for="">Terkirim</label>
						</div>
					</div>
				</div>
				<hr class="soft">
			</div>

			<!-- table pembelian pending -->
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="title">
					<h4>Pembelian sudah di bayar</h4>
				</div>
				<table class="table table-striped">
					<thead>
						<tr class="success">
							<th>Nama</th>
							<th>Tanggal</th>
							<th>Status</th>
							<th>Detail</th>
						</tr>
					</thead>
					<tbody>
						<?php $sql = $koneksi->query("SELECT * FROM view_pembelian WHERE status_pembelian='Sudah Bayar'"); ?>
						<?php while ($user = $sql->fetch_assoc()) : ?>
							<tr>
								<td><?php echo $user["username"]; ?></td>
								<td><?php echo $user["tgl_pembelian"]; ?></td>
								<td><?php echo $user["status_pembelian"]; ?></td>
								<td>
									<a href="index.php?halaman=pembayaran&id=<?php echo $user["id_pembelian"] ?>" class="btn-info btn">
										proses
									</a>
								</td>
							</tr>
							<!-- mengakhiri perulangan while serta memberikan increment atau penambahan pada variable $nomor -->
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

			<!-- table stok barang habis -->
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="title">
					<h4>Stok Barang Habis</h4>
				</div>
				<table class="table table-striped">
					<thead>
						<tr class="success">
							<th>No </th>
							<th>Nama </th>
							<th>Jenis </th>
							<th>Jumlah</th>
							<th>Aksi </th>
						</tr>
					</thead>

					<tbody>
						<?php $nomor = 1; ?>
						<?php $brg_kosong = $koneksi->query("SELECT * FROM barang WHERE jumlah_brg < 1 ");?>
						<?php while ($brg = $brg_kosong->fetch_assoc()) : ?>
							<tr>
								<td><?php echo $nomor; ?></td>
								<td><?php echo $brg["nama_brg"];  ?></td>
								<td><?php echo $brg["jenis_brg"]; ?></td>
								<td><?php echo $brg["jumlah_brg"]; ?></td>
								<td>
									<a href="index.php?halaman=ubah_data_barang&id=<?php echo $brg["id_brg"]; ?>" class="btn btn-warning">
										<i class="fa fa-refresh"></i>
									</a>
									<a href="index.php?halaman=hapus_data_barang&id=<?php echo $brg["id_brg"]; ?>" class="btn btn-danger">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							<!-- mengakhiri perulangan while serta memberikan increment atau penambahan pada variable $nomor -->
							<?php
							$nomor++;
						endwhile;
						?>
					</tbody>
				</table>
			</div>


		</div>
	</div>
</body>

</html>