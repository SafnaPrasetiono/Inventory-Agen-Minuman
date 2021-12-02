<?php
// pemanggilan koneksi php
include 'koneksiDB/koneksi.php';
// mengambil nilai ctg
if (isset($_GET['ctg'])) {
	$ctg = $_GET['ctg'];
} else {
	echo "<script>location= 'index.php';</script>";
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
$sql_data1 = $koneksi->query("SELECT * FROM barang WHERE jenis_brg='$ctg' LIMIT $st,$banyak_data_tampil ");

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
	<br class="clr"><br class="clr">
	<div class="container">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2>
					Kategori <?php echo $ctg; ?>
					<?php $sql_jum = $koneksi->query("SELECT * FROM barang WHERE jenis_brg='$ctg'"); ?>
					<small class="pull-right"> <?php echo $sql_jum->num_rows; ?> produk</small>
				</h2>
				<hr class="soft btn-block">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">


					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pull-right">
						<div class="row">

							<!-- menampilkan macam-macam produk -->
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">
									<?php while ($produk = $sql_data1->fetch_array()) : ?>
										<!-- div menampilkan produk -->
										<div class="box-barang col-md-3 col-sm-4 col-xs-6">
											<div class="thumbnail">
												<!-- foto barang -->
												<a href="index.php?set=detail_produk&id=<?php echo $produk['id_brg']; ?>" class="foto_brg_ctg">
													<img class="img-responsive" src="image/produk/<?php echo $produk['foto_brg']; ?>">
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
															<a href="beli.php?ctg=<?php echo $ctg ?>&id=<?php echo $produk['id_brg']; ?>" class="beli-btn btn btn-primary">
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
							<!-- engambil banyak data pada sql data2 hasil dibagi dua dan dibulatkan dengan ceil -->
							<?php $sql_data2 = $koneksi->query("SELECT * FROM barang WHERE jenis_brg='$ctg'"); ?>
							<?php $num = $sql_data2->num_rows;
							$hal = ceil($num / $banyak_data_tampil); ?>
							<!-- membuat produk perhalaman -->
							<?php if ($hal > 1) : ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<nav aria-label="page navigation">
										<ul class="pagination pull-right">
											<li>
												<!-- jika halaman kurang dari 2 maka hilang -->
												<?php if ($dt_halaman > 1) : ?>
													<a href="index.php?set=kategori&ctg=<?php echo $ctg ?>&halaman=<?php echo $halaman_sebelum ?>" aria-label="Previous">
														<span aria-hidden="true">&laquo;</span>
													</a>
												<?php endif; ?>
											</li>
											<li>
												<!-- perulangan pada pagging -->
												<?php for ($i = 1; $i <= $hal; $i++) : $page = $i; ?>
													<a href="index.php?set=kategori&ctg=<?php echo $ctg ?>&halaman=<?php echo $page ?>">
														<?php echo $i; ?>
													</a>
												<?php endfor; ?>
											</li>
											<li>
												<!-- jika halaman berikutnya kurang dari = hal maka hilang -->
												<?php if ($halaman_berikut <= $hal) : ?>
													<a href="index.php?set=kategori&ctg=<?php echo $ctg ?>&halaman=<?php echo $halaman_berikut ?>" aria-label="Next">
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
					
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 hidden-xs">
					<?php include 'kategori_panel.php'; ?>
					</div>

					<!-- col-12 and row -->
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<br class="clr">
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
						<!-- minimal tampilan produk sebanyak 3 di active  -->
						<div class="item active">
							<div class="row">
								<?php $sql1 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg > 200 LIMIT 0,4 "); ?>
								<?php while ($produk1 = $sql1->fetch_assoc()) : ?>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<a href="index.php?set=detail_produk&id=<?php echo $produk1['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img-responsive" src="image/produk/<?php echo $produk1['foto_brg']; ?>">
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
						<!-- tampilan produk yang ada akan di slide ke 2 -->
						<div class="item">
							<div class="row">
								<?php $sql2 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg < 100 LIMIT 4,4 "); ?>
								<?php while ($produk2 = $sql2->fetch_assoc()) : ?>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<a href="index.php?set=detail_produk&id=<?php echo $produk2['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img-responsive" src="image/produk/<?php echo $produk2['foto_brg']; ?>">
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
						<!-- tampilan produk yang akan di slid ke 3 -->
						<div class="item">
							<div class="row">
								<?php $sql3 = $koneksi->query("SELECT*FROM barang WHERE jumlah_brg > 100 LIMIT 8,4 "); ?>
								<?php while ($produk3 = $sql3->fetch_assoc()) : ?>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<a href="index.php?set=detail_produk&id=<?php echo $produk3['id_brg']; ?>" class="thumbnail">
											<div class="foto_brg">
												<img class="img-responsive" src="image/produk/<?php echo $produk3['foto_brg']; ?>">
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
						<!-- carausel inner -->
					</div>
					<!-- carauser slide -->
				</div>
				<!-- penutup rekomendasi produk dan row -->
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<br class="clr"><br class="clr">
			</div>
			


			<!-- container and row -->
		</div>
	</div>

</body>

</html>