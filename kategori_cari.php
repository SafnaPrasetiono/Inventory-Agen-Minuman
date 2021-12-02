<?php
// pemanggilan koneksi php
include 'koneksiDB/koneksi.php';
// mengambil nilai ctg
if (!isset($_GET['ctg_search'])) {
	echo "
			<script>
				location= 'index.php';
			</script>
			";
} else {
	$ctg_search = $_GET['ctg_search'];
}
// jika halaman kosong atau tdk ada makan data halaman yang ditampilkan 0
// jika terjadapat halaman makan akan di kurangi 1 dan dikali 5 untuk mengambil
// pada array yang seterusnya
// bayaknya data yang di tampilkan tergantung dari data yang ingin ditampilkan
$banyak_data_tampil = 12;

if (empty($_GET["halaman"])) {
	$dt_halaman = 1;
	$st = 0;
} else {
	// manipulasi jika didapat halaman 1 maka tetap seperti tampilan awal
	// karna (1 - 1) * 5 = 0 data ditampilkan dari data o pada halaman 1
	// jika halaman 2 maka (2-1)*5 = 5 data ditampilkan dari data 5
	$dt_halaman = $_GET["halaman"];
	$st = ($dt_halaman - 1) * $banyak_data_tampil;
}
// pada data ke 0 akan ditampilkan 5
// jika data ingin berlanjut harus dimulai > 5
// pada data dibelakang koma adalah data ditampilkan sebanyak 5
$sql_data1 = $koneksi->query("SELECT * FROM barang WHERE nama_brg LIKE '%$ctg_search%' LIMIT $st,$banyak_data_tampil ");

// pagging untuk halaman berikut dan halaman sebelum
$halaman_sebelum = $dt_halaman - 1;
if ($halaman_sebelum < 1) {
	$halaman_sebelum = 1;
}
$halaman_berikut = $dt_halaman + 1;
?>

<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<!-- pemanggilan css pada kategori -->
	<link rel="stylesheet" type="text/css" href="dist/css/kategori.css">
</head>

<body>
	<!-- Main Container -->
	<div class="container">


		<div class="row">
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
						<hr class="soft btn-block">
					</div>

					<div class="carousel-inner">
						<div class="item active">
							<div class="row">
								<?php $sql1 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg > 200 LIMIT 0,4 "); ?>
								<?php while ($produk1 = $sql1->fetch_assoc()) : ?>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<a href="index.php?set=detail_produk&id=<?php echo $produk1['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img-responsive" src="data:image/jpeg;base64,<?php echo base64_encode($produk1['foto_brg']); ?>">
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
								<?php $sql2 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg < 100 LIMIT 4,4 "); ?>
								<?php while ($produk2 = $sql2->fetch_assoc()) : ?>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<a href="index.php?set=detail_produk&id=<?php echo $produk2['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img-responsive" src="data:image/jpeg;base64,<?php echo base64_encode($produk2['foto_brg']); ?>">
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
								<?php $sql3 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg > 100 LIMIT 8,4 "); ?>
								<?php while ($produk3 = $sql3->fetch_assoc()) : ?>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<a href="index.php?set=detail_produk&id=<?php echo $produk3['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img-responsive" src="data:image/jpeg;base64,<?php echo base64_encode($produk3['foto_brg']); ?>">
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
		</div>
		<!-- penutup rekomenddasi -->


		<!-- tampilan kategori dan barang -->
		<div class="row">

			<!-- membuat isi dari macam macam produk -->
			<div class="col-md-9 col-sm-9 col-xs-12 pull-right">
				<div class="row">

					<!-- membuat label dengan sebagai judul produk yang dan info isi produk -->
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h3>Produk <?php echo $ctg_search; ?>
							<?php $jumlah = 1; ?>
							<?php $sql = $koneksi->query("SELECT * FROM barang WHERE jenis_brg='$ctg_search'"); ?>
							<?php while ($produk = $sql->fetch_assoc()) : ?>
								<?php $jml_brg = $jumlah++; ?>
							<?php endwhile; ?>
							<small class="pull-right"> <?php echo $jml_brg; ?> produk ditemukan</small>
						</h3>
						<hr class="soft">
					</div>

					<!-- menampilkan macam-macam produk -->
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<?php while ($produk = $sql_data1->fetch_array()) : ?>
								<!-- div menampilkan produk -->
								<div class="box-barang col-md-3 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<!-- foto barang -->
										<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>" class="foto_brg_ctg">
											<img class="img-responsive" src="data:image/jpeg;base64,<?php echo base64_encode($produk['foto_brg']); ?>">
											<br class="cls">
										</a>
										<!-- caption barang -->
										<div class="caption">
											<div class="nama-produk">
												<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>">
													<?php echo $produk['nama_brg']; ?>
												</a>
											</div>
											<div class="harga-produk">
												<h5>Rp. <?php echo number_format($produk['harga_brg']); ?></h5>
											</div>
											<div class="aksi-produk">
												<!-- apa bila produk habis maka tidak dapat di order -->
												<?php $jum_produk = $produk['jumlah_brg']; ?>
												<?php if ($jum_produk <= 0) : ?>
													<a href="#" class="beli-btn-habis btn btn-danger">
														<i class="fa fa-cart-plus"></i> Habis
													</a>
												<?php else : ?>
													<a href="beli.php?ctg=<?php echo $ctg_search ?>&id=<?php echo $produk['id_brg']; ?>" class="beli-btn btn btn-primary">
														<i class="fa fa-cart-plus"></i> beli
													</a>
												<?php endif; ?>
											</div> <!-- penutup aksi produk -->
										</div> <!-- penutup div caption -->
									</div>
								</div>
							<?php endwhile; ?>
							<!-- div akhir menampilkan produk -->
						</div>
					</div>
					<!-- penutup col-md-12 -->

					<!-- membatasi produk untuk perhalaman (Pagging) yang di tampilkan -->
					<?php
					$sql_data2 = $koneksi->query("SELECT * FROM barang WHERE jenis_brg='$ctg_search'");
					$num = mysqli_num_rows($sql_data2);
					$hal = ceil($num / $banyak_data_tampil);
					?>
					<?php if ($hal > 1) : ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<nav aria-label="page navigation">
								<ul class="pagination pull-right">
									<li>
										<!-- jika halaman kurang dari 2 maka hilang -->
										<?php if ($dt_halaman > 1) : ?>
											<a href="index.php?set=kategori&ctg=<?php echo $ctg_search ?>&halaman=<?php echo $halaman_sebelum ?>" aria-label="Previous">
												<span aria-hidden="true">&laquo;</span>
											</a>
										<?php endif; ?>
									</li>
									<li>
										<!-- perulangan pada pagging -->
										<?php for ($i = 1; $i <= $hal; $i++) : $page = $i; ?>
											<a href="index.php?set=kategori&ctg=<?php echo $ctg_search ?>&halaman=<?php echo $page ?>">
												<?php echo $i; ?>
											</a>
										<?php endfor; ?>
									</li>
									<li>
										<!-- jika halaman berikutnya kurang dari = hal maka hilang -->
										<?php if ($halaman_berikut <= $hal) : ?>
											<a href="index.php?set=kategori&ctg=<?php echo $ctg_search ?>&halaman=<?php echo $halaman_berikut ?>" aria-label="Next">
												<span aria-hidden="true">&raquo;</span>
											</a>
										<?php endif; ?>
									</li>
								</ul>
							</nav>
						</div>
					<?php endif; ?>

				</div>
			</div>
			<!-- penutup row isi dari macam macam produk -->

			<div class="col-md-3 col-sm-3 col-xs-12 pull-left">
				<?php include 'kategori_panel.php'; ?>
			</div>

		</div>
		<!-- penutup row tampilan kategori dan barang -->

	</div>
	<!-- penutup container -->
	<br clear="clr">
	<br clear="clr">

</body>

</html>