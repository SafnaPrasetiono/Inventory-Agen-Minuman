<?php
//pemanggilan koneksi agar terhubung database
require '../koneksiDB/koneksi.php';

$nomor = 1;

// mengambil id untuk detail nota
$ambil_id = $_GET["id"];

// membuat query dengan join antara pembelian dan user
$sql = $koneksi->query("SELECT * FROM pembelian JOIN user ON 
			pembelian.id_user = user.id_user WHERE 
			pembelian.id_pembelian ='$ambil_id'");

// data di pecan dalam bentuk array
$detail = $sql->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<link rel="stylesheet" type="text/css" href="dist/css/detail_pembelian.css">
</head>

<body>
	<div class="container-fluid main-page">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2>Nota Pembelian</h2>
				<hr class="soft">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 class="text-left">
							<b>Pembelian</b>
							<hr class="soft">
						</h3>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
								<p><b>No Pembelian</b><br><?php echo $detail["id_pembelian"]; ?></p>
								<p><b>Tanggal Pembelian</b><br><?php echo $detail["tgl_pembelian"]; ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
								<p><b>Total Pembelian</b><br>Rp. <?php echo number_format($detail["total_pembelian"]); ?></p>
								<p><b>Status Pembelian</b><br><?php echo $detail["status_pembelian"]; ?></p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 class="text-left">
							<b>Pelanggan</b>
							<hr class="soft">
						</h3>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Nama Pelanggan</b><br><?php echo $detail["username"]; ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>No Telepon</b><br><?php echo $detail["no_tlp_user"]; ?></p>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p><b>Email</b><br> <?php echo $detail["email"]; ?> </p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 class="text-leftr">
							<b>Pengiriman</b>
							<hr class="soft">
						</h3>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Kota</b><br><?php echo $detail["kota_pembelian"]; ?></p>
								<p><b>Kode Pos </b><br><?php echo $detail["kode_pos"]; ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Harga Ongkos Kirim</b><br>Rp. <?php echo number_format($detail["harga_ongkir"]); ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Alamat Pengiriman</b><br><?php echo $detail["alamat_pembelian"]; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<hr class="soft">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>NO</th>
								<th>NAMA BARANG</th>
								<th>HARGA</th>
								<th>JUMLAH</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php $ambil_barang = $koneksi->query("SELECT * FROM pembelian_barang WHERE id_pembelian='$ambil_id'"); ?>
							<?php while ($detail_brg = $ambil_barang->fetch_assoc()) : ?>
								<tr>
									<td><?php echo $nomor ?></td>
									<td><?php echo $detail_brg["nama_barang"]; ?></td>
									<td>Rp. <?php echo number_format($detail_brg["harga_barang"]); ?></td>
									<td><?php echo $detail_brg["jumlah"]; ?></td>
									<td>Rp. <?php echo number_format($detail_brg["total_harga"]); ?></td>
								</tr>
								<?php
								$nomor++;
							endwhile;
							?>
						</tbody>
					</table>
				</div>
			</div>

			<?php if ($detail['metode_pembelian'] == "COD" AND $detail['status_pembelian'] !== "selesai") : ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a href="cetak_pembelian.php?id=<?php echo $ambil_id; ?>" class="btn btn-success" target="_BLANK">
						<i class="fa fa-print"></i> Proses Pengiriman & Cetak Halaman ini
					</a>
				</div>
			<?php endif; ?>

		</div>
	</div>

</body>

</html>