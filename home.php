<?php
// pemanggilan koneksi databaase
require 'koneksiDB/koneksi.php';

?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="dist/css/home.css">
</head>

<body>
	<!-- slide show tentang minuman terbaik atau terjual -->
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="image/Toko/Gambar_toko_6.png" alt="" class="img-responsive">
				<div class="carousel-caption hidden-xs">
					<h3>AgentDrink indonesia</h3>
				</div>
			</div>
			<div class="item">
				<img src="image/Toko/Gambar_toko_3.png" alt="" class="img-responsive">
				<div class="carousel-caption hidden-xs">
					<h3>AgentDrink indonesia</h3>
				</div>
			</div>
			<div class="item">
				<img src="image/Toko/Gambar_toko_4.png" alt="" class="img-responsive">
				<div class="carousel-caption hidden-xs">
					<h3>AgentDrink indonesia</h3>
				</div>
			</div>
		</div>
		<!-- Controls atau button slide-->
		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<!-- akhir div slide barang -->

	<div class="box-rekomen">
		<div class="container">
			<h4 class="text-center"><b>REKOMENDASI <br> PRODUK BERDASARKAN KATEGORI</b></h4>
		</div>
	</div>


	<br clear="clr">
	<!-- membuat kontent barang dengan jenis barang mineral -->
	<section class="konten-barang">
		<div class="container">
			<h3 class="">
				Produk Mineral
				<a href="index.php?set=kategori&ctg=Mineral" class="btn pull-right">Lihat semua</a>
			</h3>
			<hr class="soft">
			<div class="row">
				<?php $sql = $koneksi->query("SELECT*FROM barang WHERE jenis_brg='Mineral' AND jumlah_brg > 10 LIMIT 0,4 "); ?>
				<?php while ($produk = $sql->fetch_assoc()) : ?>
					<div class="produk_kontent col-md-3 col-sm-4 col-xs-6">
						<div class="thumbnail">
							<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>" class="foto-brg-kontent">
								<img src="image/produk/<?php echo $produk['foto_brg']; ?>" class="img-responsive">
							</a>
							<div class="caption caption-produk">
								<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>"><?php echo $produk['nama_brg']; ?></a>
								<h5>Rp. <?php echo number_format($produk['harga_brg']); ?></h5>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>

	<br clear="clr">
	<!-- membuat kontent barang dengan jenis barang mineral -->
	<section class="konten-barang">
		<div class="container">
			<h3>
				Produk Susu
				<a href="index.php?set=kategori&ctg=Susu" class="btn pull-right">Lihat semua</a>
			</h3>
			<hr class="soft">
			<div class="row">
				<?php $sql = $koneksi->query("SELECT*FROM barang WHERE jenis_brg='susu' AND jumlah_brg > 10 LIMIT 0,4 "); ?>
				<?php while ($produk = $sql->fetch_assoc()) : ?>
					<div class="produk_kontent col-md-3 col-sm-4 col-xs-6">
						<div class="thumbnail">
							<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>" class="foto-brg-kontent">
								<img src="image/produk/<?php echo $produk['foto_brg']; ?>" class="img-responsive">
							</a>
							<div class="caption caption-produk">
								<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>"><?php echo $produk['nama_brg']; ?></a>
								<h5>Rp. <?php echo number_format($produk['harga_brg']); ?></h5>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>

	<br clear="clr">
	<!-- membuat kontent barang dengan jenis barang mineral -->
	<section class="konten-barang">
		<div class="container">
			<h3>
				Produk Kopi
				<a href="index.php?set=kategori&ctg=kopi" class="btn pull-right">Lihat semua</a>
			</h3>
			<hr class="soft">
			<div class="row">
				<?php $sql = $koneksi->query("SELECT*FROM barang WHERE jenis_brg='kopi' AND jumlah_brg > 10 LIMIT 0,4 "); ?>
				<?php while ($produk = $sql->fetch_assoc()) : ?>
					<div class="produk_kontent col-md-3 col-sm-4 col-xs-6">
						<div class="thumbnail">
							<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>" class="foto-brg-kontent">
								<img src="image/produk/<?php echo $produk['foto_brg']; ?>" class="img-responsive">
							</a>
							<div class="caption caption-produk">
								<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>"><?php echo $produk['nama_brg']; ?></a>
								<h5>Rp. <?php echo number_format($produk['harga_brg']); ?></h5>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>

	<!-- kategori lainnya -->
	<br clear="clr">
	<section class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>Kategori Lainnya</h3>
				<hr class="soft">
			</div>
			<div class="col-md-4 col-sm-4">
				<div class="box-panel-kategori panel panel-success">
					<div class="panel-heading"><label>Produk Mineral</label></div>
					<div class="list-group">
						<a href="index.php?set=pencarian&ctg_search=aqua  " class="list-group-item">Aqua </a>
						<a href="index.php?set=pencarian&ctg_search=ron88 " class="list-group-item">Ron 88 </a>
						<a href="index.php?set=pencarian&ctg_search=stream" class="list-group-item">Stream </a>
						<a href="index.php?set=pencarian&ctg_search=aqso  " class="list-group-item">Aqso </a>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4">
				<div class="box-panel-kategori panel panel-success">
					<div class="panel-heading"><label>Produk Susu</label></div>
					<div class="list-group">
						<a href="index.php?set=pencarian&ctg_search=good day" class="list-group-item">Good Day </a>
						<a href="index.php?set=pencarian&ctg_search=expresso" class="list-group-item">Exspreso </a>
						<a href="index.php?set=pencarian&ctg_search=late    " class="list-group-item">Late </a>
						<a href="index.php?set=pencarian&ctg_search=kopiko  " class="list-group-item">Kopiko </a>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4">
				<div class="box-panel-kategori panel panel-success">
					<div class="panel-heading"><label>Produk Susu</label></div>
					<div class="list-group">
						<a href="index.php?set=pencarian&ctg_search=ultra milk" class="list-group-item">Ultra Milk </a>
						<a href="index.php?set=pencarian&ctg_search=fisianflag" class="list-group-item">Fisianflag </a>
						<a href="index.php?set=pencarian&ctg_search=cimory    " class="list-group-item">Cimory </a>
						<a href="index.php?set=pencarian&ctg_search=milo      " class="list-group-item">Milo </a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<br clear="clr">


	<!-- penjelasan singkat tentang web ini -->
	<section class="box-info-web">
		<div class="inner">
			<div class="container">
				<label>AgentDrink - Toko Penjualan Minuman Terbaik di Indonesia</label>
				<p class="text-justify">
					Dengan berkembanya teknologi secara global, dapat memberikan kemudahan bagi masyarakat sehingga banyak
					hal yang bisa dilakukan secara praktis. Kini anda tidak perlu repot - repot untuk datang ke-toko dalam
					mencari produk minuman, anda tidak perlu untuk menghabiskan banyak biaya dan tenaga dalam
					berbelanja produk minuman. <a href="index.php?set=tentang_kami" class="text-danger">Semua...</a>
				</p>
			</div>
		</div>
	</section>

</body>

</html>