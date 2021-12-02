<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<link rel="stylesheet" type="text/css" href="../dist/css/pembelian.css">
</head>

<body>
	<div class="container-fluid main-page">
		<div class="row">
			<!-- judul -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2>Data Pemesanan</h2>
				<hr class="soft">
			</div>

			<!-- membuat form pencarian data pada data user atau pembeli -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form action="" method="post" class="navbar-form navbar-right">
					<div class="input-group">
						<input type="text" name="caripembeli" class="form-control" placeholder="cari...">
						<div class="input-group-btn">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Status <span class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right">
								<li>
									<a href="index.php?halaman=pembelian&status=pending">pending</a>
								</li>
								<li>
									<a href="index.php?halaman=pembelian&status=sudah_bayar">sudah bayar</a>
								</li>
								<li>
									<a href="index.php?halaman=pembelian&status=barang_dikirim">barang dikirim</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="index.php?halaman=pembelian&status=COD">COD</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="index.php?halaman=pembelian">semua</a>
								</li>
							</ul>
						</div><!-- /btn-group -->
					</div><!-- /input-group -->
				</form>
			</div>

			<!-- table pembelian pelanggan -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr class="success">
								<th>NO PEMBELIAN</th>
								<th>NAMA</th>
								<th>TANGGAL</th>
								<th>STATUS</th>
								<th>PEMBAYARAN</th>
								<th>TOTAL</th>
								<th>AKSI</th>
							</tr>
						</thead>

						<tbody>
							<?php
							// pada kolom cari apa bila btn cari di klik maka aka di ksekusi pada cari brg
							// jik tidak maka akan menampilkan hanya data barang yang tidak di cari
							// v_pembelian merupakan table view dari pembelian atau view pembelian
							if (isset($_POST["caripembeli"])) {
								$hasilcari = $_POST["caripembeli"];
								if (isset($_GET['status'])) {
									if ($_GET['status'] == "pending") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE status_pembelian='pending' AND username LIKE '%$hasilcari%'");
									} elseif ($_GET['status'] == "sudah_bayar") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE status_pembelian='Sudah Bayar' AND username LIKE '%$hasilcari%'");
									} elseif ($_GET['status'] == "barang_dikirim") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE status_pembelian='Barang dikirim' AND username LIKE '%$hasilcari%'");
									}elseif ($_GET['status'] == "COD") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE metode_pembelian='COD' AND username LIKE '%$hasilcari%'");
									}
								} else {
									$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE username LIKE '%$hasilcari%'");
								}
							} else {
								if (isset($_GET['status'])) {
									if ($_GET['status'] == "pending") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE status_pembelian='pending'");
									} elseif ($_GET['status'] == "sudah_bayar") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE status_pembelian='Sudah Bayar'");
									} elseif ($_GET['status'] == "barang_dikirim") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE status_pembelian='Barang dikirim'");
									} elseif ($_GET['status'] == "COD") {
										$sql = $koneksi->query("SELECT * FROM view_pembelian WHERE metode_pembelian='COD'");
									}
								} else {
									$sql = $koneksi->query("SELECT * FROM view_pembelian");
								}
							}
							?>
							<!-- membuat perulangan pada barang selama barang masih ada akan ditampikan sampai proses -->
							<!-- dari prulangan while dihentikan -->
							<?php while ($detail = $sql->fetch_assoc()) : ?>
								<tr>
									<td><?php echo $detail["id_pembelian"];  ?></td>
									<td><?php echo $detail["username"]; ?></td>
									<td><?php echo $detail["tgl_pembelian"]; ?></td>
									<td><?php echo $detail["status_pembelian"]; ?></td>
									<td><?php echo $detail["metode_pembelian"]; ?></td>
									<td>Rp. <?php echo number_format($detail["total_pembelian"]); ?></td>
									<td>
										<a href="index.php?halaman=detail&id=<?php echo $detail["id_pembelian"] ?>" class="btn-info btn">
											Detail
										</a>
										<?php if ($detail['status_pembelian'] == "sudah bayar"  and $detail['metode_pembelian'] == "BANK") : ?>
											<a href="index.php?halaman=pembayaran&id=<?php echo $detail["id_pembelian"] ?>" class="btn btn-success">
												Proses Pengiriman
											</a>
										<?php elseif ($detail['status_pembelian'] == "barang dikirim" and $detail['metode_pembelian'] == "BANK") : ?>
											<a href="index.php?halaman=pembayaran&id=<?php echo $detail["id_pembelian"] ?>" class="btn btn-warning">
												Akhiri Pengiriman
											</a>
										<?php elseif ($detail['status_pembelian'] == "barang dikirim"  and $detail['metode_pembelian'] == "COD") : ?>
											<!-- pembelian COD -->
											<a href="index.php?halaman=pembayaran&id=<?php echo $detail["id_pembelian"] ?>" class="btn btn-danger">
												Akhiri Pembayaran
											</a>
										<?php elseif ($detail['status_pembelian'] == "selesai") : ?>
											<a href="index.php?halaman=lihat_pembayaran&id=<?php echo $detail["id_pembelian"] ?>" class="btn btn-info">
												Lihat Pembayaran
											</a>
										<?php endif; ?>
									</td>
								</tr>
								<!-- mengakhiri perulangan while serta memberikan increment atau penambahan pada variable $nomor -->
							<?php endwhile; ?>
						</tbody>
					</table>

				</div>
			</div>


		</div>
	</div>
	<!-- penutup container-fluid dan row -->

</body>

</html>