<?php

if (empty($_GET["id"])) {
	echo "
	<script>
	location= 'index.php';
	</script>
	";
} else {

	$id_produk = $_GET["id"];
	$sql = $koneksi->query("SELECT*FROM barang WHERE id_brg='$id_produk'");
	$brg = $sql->fetch_assoc();

	// informasi barang
	$nama_barang = $brg['nama_brg'];
	$harga_barang = $brg['harga_brg'];
	$foto_barang = $brg['foto_brg'];
	$jumlah_barang = $brg['jumlah_brg'];
	$terjual = $brg['terjual'];
}

if (isset($_POST['order_barang'])) {
	// jika tombol beli diklik maka akan masuk ke klom order sesuai jumlah barang yang diinputkan
	$id_brg_dibeli = $brg['id_brg'];
	// menjadapatkan jumlah produk yang diinputkan
	$jum_order = $_POST['jumlah_order'];

	// jika di keranjang sudah ada produk tsb maka di +1
	if (isset($_SESSION['keranjang'][$id_brg_dibeli])) {
		$_SESSION['keranjang'][$id_brg_dibeli] += $jum_order;
	}
	// jika tidak ttp diangap 1
	else {
		$_SESSION['keranjang'][$id_brg_dibeli] = $jum_order;
	}
	// 	// mengorder barang yang dipilih sesuai jumlah
	// $_SESSION['keranjang'][$id_brg_dibeli] += $jum_order;

	// memberikan informasi bahwa barang sudah masuk dalam orderan
	// dan dilarikan ke orderan
	echo "<script> alert('Produk Sudah Masuk, Lihat Keranjang'); </script>";
	echo "<script>location='index.php?set=detail_produk&id=$id_produk';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="dist/css/detail_produk.css">
	<link rel="stylesheet" type="text/css" href="dist/css/kategori.css">
</head>

<body>
	<div class="container main-page">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">

					<div class="box-img col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<img class="img-responsive" src="image/produk/<?php echo $foto_barang; ?>">
					</div>
					<div class="col-md-offset-1 col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="box-judul">
									<h2 class="text-uppercase"><?php echo $nama_barang; ?></h2>
									<h4>Rp. <?php echo number_format($harga_barang); ?></h4>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<hr class="soft">
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">
									<form method="POST" action="">
										<div class="col-xs-4 col-sm-4 col-md-4">
											<input name="jumlah_order" class="btn-block text-jumlah" type="number" min="1" max="<?php echo $jumlah_barang; ?>" value="1" required>
										</div>
										<div class="col-xs-8 col-sm-8 col-md-8">
											<?php if ($jumlah_barang <= 0) : ?>
												<button class="btn-aksi btn btn-danger btn-lg btn-block" name="stok_habis">
													<i class="fa fa-cart-plus"></i> Stok Habis
												</button>
											<?php else : ?>
												<button class="btn-aksi btn btn-success btn-lg btn-block" name="order_barang">
													<i class="fa fa-cart-plus"></i> Order Sekarang
												</button>
											<?php endif; ?>
										</div>
									</form>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<br class="clr">
								<div class="alert alert-info">
									<strong>Info AgentDrink</strong>
									<p>pastikan barang tersedia dan cek kembali harga. sewaktu - waktu harga berubah.</p>
								</div>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<hr class="soft">
								<div class="row">
									<div class="col-md-3 col-xs-3 col-sm-3">
										<div class="box-info">
											<div class="gambar-title">
												<i class="fa fa-truck fa-2x"></i>
											</div>
											<div class="text-title text-center">
												<p>Terkirim</p>
												<p><?php echo $terjual ?></p>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-xs-3 col-sm-3">
										<div class="box-info">
											<div class="gambar-title">
												<i class="fa fa-archive fa-2x"></i>
											</div>
											<div class="text-title text-center">
												<p>Tersedia</p>
												<p><?php echo $brg['jumlah_brg']; ?></p>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-xs-3 col-sm-3">
										<div class="box-info">
											<div class="gambar-title">
												<i class="fa fa-tag fa-2x"></i>
											</div>
											<div class="text-title text-center">
												<p>Min.Beli</p>
												<p>1</p>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-xs-3 col-sm-3">
										<div class="box-info">
											<div class="gambar-title">
												<i class="fa fa-cube fa-2x"></i>
											</div>
											<div class="text-title text-center">
												<p>Kondisi</p>
												<p>Baru</p>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div> <!-- end row -->
			</div> <!-- end detail col-md-12 -->

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<br class="clr"><br class="clr">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<!-- list pilihan detail produk -->
						<ul class="nav nav-tabs" id="productDetail">
							<li class="active">
								<a href="#home" data-toggle="tab"><i class="fa fa-file-text"></i> Detail Produk</a>
							</li>
						</ul>
						<!-- isi tentang informasi produk -->
						<div class="tab-content tabWrapper" id="myTabContent">
							<div class="tab-pane fade active in" id="home">
								<br clear="clr">
								<p class="text-justify"><?php echo $brg['article_brg']; ?></p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<!-- rekomendasi produk yang yang sama -->
						<?php $jenis_barang = $brg['jenis_brg']; ?>
						<?php $sql_barang_sama = $koneksi->query("SELECT*FROM barang WHERE jenis_brg='$jenis_barang' LIMIT 2,3 "); ?>
						<?php if ($sql_barang_sama->num_rows > 1) : ?>
							<div class="panel-barang panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Produk yang sama</h3>
								</div>
								<div class="list-group">
									<?php while ($barang_list = $sql_barang_sama->fetch_assoc()) : ?>
										<a href="index.php?set=detail_produk&id=<?php echo $barang_list['id_brg']; ?>" class="list-group-item">
											<div class="row">
												<div class="foto_brg col-md-5 col-xs-12 col-sm-12">
													<img class="img img-responsive" src="image/produk/<?php echo $barang_list['foto_brg']; ?>">
												</div>
												<div class="caption col-md-7 col-xs-12 col-sm-12">
													<h4><?php echo $barang_list['nama_brg']; ?></h4>
													<h6c class="text-danger">Rp. <?php echo number_format($barang_list['harga_brg']); ?></h6>
												</div>
											</div>
										</a>
									<?php endwhile; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<br class="clr"><br class="clr">
			</div>

			<div class="box-rekomendasi col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="carousel slide" id="recommended-item-carousel" data-ride="carousel">
					<div class="judul">
						<h3 class="pull-left">Rekomendasi Produk</h3>
						<div class="box-slide pull-right">
							<!-- membuat button next dan preview -->
							<a class="left" href="#recommended-item-carousel" data-slide="prev">
								<span class="fa fa-angle-left fa-2x"></span>
							</a>
							<a class="right" href="#recommended-item-carousel" data-slide="next">
								<span class="fa fa-angle-right fa-2x"></span>
							</a>
						</div>
						<hr class="sof btn-block">
					</div>
					<div class="carousel-inner">
						<div class="item active">
							<div class="row">
								<?php $sql1 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg > 100 LIMIT 0,4 "); ?>
								<?php while ($produk1 = $sql1->fetch_assoc()) : ?>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
										<a href="index.php?set=detail_produk&id=<?php echo $produk1['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img img-responsive" src="image/produk/<?php echo $produk1['foto_brg']; ?>">
											</div>
											<div class="caption title-rekomendasi">
												<h4><?php echo $produk1['nama_brg']; ?></h4>
												<h5>Rp. <?php echo number_format($produk1['harga_brg']); ?></h5>
											</div>
										</a>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
						<div class="item">
							<div class="row">
								<?php $sql2 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg > 50 LIMIT 4,4 "); ?>
								<?php while ($produk2 = $sql2->fetch_assoc()) : ?>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
										<a href="index.php?set=detail_produk&id=<?php echo $produk2['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img img-responsive" src="image/produk/<?php echo $produk2['foto_brg']; ?>">
											</div>
											<div class="caption title-rekomendasi">
												<h4><?php echo $produk2['nama_brg']; ?></h4>
												<h5>Rp. <?php echo number_format($produk2['harga_brg']); ?></h5>
											</div>
										</a>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
						<div class="item">
							<div class="row">
								<?php $sql3 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg > 10 LIMIT 8,4 "); ?>
								<?php while ($produk3 = $sql3->fetch_assoc()) : ?>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
										<a href="index.php?set=detail_produk&id=<?php echo $produk3['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img img-responsive" src="image/produk/<?php echo $produk3['foto_brg']; ?>">
											</div>
											<div class="caption title-rekomendasi">
												<h4><?php echo $produk3['nama_brg']; ?></h4>
												<h5>Rp. <?php echo number_format($produk3['harga_brg']); ?></h5>
											</div>
										</a>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
				</div>
			</div>


			<!-- container and row -->
		</div>
	</div>
	<br class="clr"><br class="clr">

</body>

</html>

