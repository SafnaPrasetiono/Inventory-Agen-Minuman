<?php
if (empty($_SESSION['keranjang']) or !isset($_SESSION['keranjang'])) {
	echo "
			<script>
				location= 'index.php';
			</script>
		";
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<link rel="stylesheet" type="text/css" href="dist/css/keranjang.css">
</head>

<body>

	<div class="container set-page">
		<div class="row">

			<!-- judul -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2 class="pull-left animated bounceInRight">Keranjang Belanja</h2>
				<hr class="soft btn-block">
			</div>

			<!-- keranjang -->

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated fadeInUp">
				<form method="POST" class="pull-right">
					<button type="submit" name="batal_beli" class="btn btn-danger">
						<i class="fa fa-trash-o"></i> Batal Belanja
					</button>
				</form>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated fadeInUp">
				<br clear="clr">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr class="success">
								<th>No</th>
								<th>Barang</th>
								<th>Nama Barang</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Total</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$nomor = 1;
							$subtotal = 0;
							// mengambil isi array pada keranjang ke id_produk
							foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) :

								// menampilkan barang dengan id produk yang ada pada array
								$sql = $koneksi->query("SELECT*FROM barang WHERE id_brg='$id_produk'");
								$brg = $sql->fetch_assoc();
								// pada total julmah baran dibeli akan dikalikan pada harga barang tsb
								$total_harga = $brg['harga_brg'] * $jumlah;

								$subtotal += $total_harga;
								?>
								<tr>
									<!-- menampilkan barang yand dipilih untuk dibeli -->
									<td><?php echo $nomor; ?></td>
									<td class="foto-brg-keranjang">
										<img class="img-responsive" src="image/produk/<?php echo $brg['foto_brg']; ?>">
									</td>
									<td><?php echo $brg['nama_brg']; ?></td>
									<td>Rp. <?php echo number_format($brg['harga_brg']); ?></td>
									<td><?php echo $jumlah; ?></td>
									<td>Rp. <?php echo number_format($total_harga); ?></td>
									<th>
										<a href="hapuskeranjang.php?id=<?php echo $id_produk ?>" class="btn btn-danger">
											<i class="fa fa-trash"></i>
										</a>
									</th>
								</tr>
								<?php
								$nomor++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- grand total belanja -->
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 pull-right animated fadeInUp">
				<br clear="clr">
				<div class="alert alert-success box-info-keranjang-1">
					<h3 class="text-center"><strong>Total Harga</strong></h3>
					<h4 class="text-center">Rp. <?php echo number_format($subtotal); ?></h4>
				</div>
			</div>

			<!-- alert keterangan belanja -->
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 pull-left animated fadeInUp">
				<br clear="clr">
				<div class="alert alert-warning box-info-keranjang-2" role="alert">
					<label>Keterangan Belanja</label>
					<p>Total belanja belum termasuk ongkos kirim yang akan dihitung setelah proses belanja selesai</p>
					<p>pastikan kembali barang belanjaan yang akan dibeli dan baca peraturan beli sebelum membeli</p>
				</div>
			</div>

			<!-- button lanjut checkout -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 animated fadeInUp">
				<br clear="clr">
				<div class="pull-right">
					<a href="index.php" class="btn btn-default btn-lg">Lanjutkan Belanja</a>
					<?php if (empty($_SESSION['user']) or !isset($_SESSION['keranjang'])) : ?>
						<a href="login.php" class="btn btn-primary btn-lg">Checkout</a>
					<?php else : ?>
						<a href="index.php?set=checkout" class="btn btn-primary btn-lg">Checkout</a>
					<?php endif; ?>
				</div>
			</div>


		</div>
	</div>
	<br clear="clr">
	<br clear="clr">

</body>

</html>

<?php
if (isset($_POST['batal_beli'])) {
	// hapus semua keranjang
	unset($_SESSION['keranjang']);
	echo "
	<script>
		alert('keranjang telah dikosongkan')
		location='index.php?set=keranjang';
	</script>
	";
}
?>