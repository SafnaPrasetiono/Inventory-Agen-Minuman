<?php
// pemanggilan koneksi wajib
require 'Connection/koneksi.php';
// pemanggilan akun yang akan di simpan di session
session_start();

// jika ada proses prubahan password  dan langsung masuk kesini maka dinyatakan batal
if (isset($_SESSION['RePassword'])) {
	unset($_SESSION['RePassword']);
	echo "<script>alert('Proses Ubah Password di Batalkan!');</script>";
}

// jika ada proses verifikasi email dan langsung masuk kesini maka dinyatakan batal
if (isset($_SESSION['v_email'])) {
	$ambil_email = $_SESSION['v_email'];
	$excute = $koneksi->query("DELETE FROM user where email='$ambil_email'");
	unset($_SESSION['v_email']);
}

// mengamankan admin agar tidak bisa masuk apabila tidak login
if (!isset($_SESSION['admin']) or empty($_SESSION['admin'])) {
	header('Location: ../index.php');
	exit();
} else {
	$frist_name = $_SESSION['admin']['first_name'];
	$last_name = $_SESSION['admin']['last_name'];
	$foto = $_SESSION['admin']['foto'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="Image/logo_title.png">
	<title>AgentDrink</title>
	<link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="Font-Awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="dist/css/admin.css">
</head>

<body>

	<div class="wrapper" id="layer">

		<!-- membuat navigasi pada layar utama admin -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#open-menu-up" aria-expanded="false">
					<i class="fa fa-bars box-ico"></i>
				</button>
				<a href="#" class="box-logo">
					<img src="Image/logo_768px.png" class="img-responsive">
				</a>
			</div>
			<div class="container-fluid">
				<div class="collapse navbar-collapse navbar-tanggal">
					<h4 class="pull-left">
						Jakarta, <?php echo date("d M Y"); ?>
					</h4>
					<ul class="nav pull-left">
						<li class="">
							<a href="index.php?halaman=logout" class="btn">
								LogOut <span class="fa fa-sign-out fa-lg"></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<!-- membuat tampilan menu pada layar utama -->
		<div class="sidebar" id="open-menu-up">

			<!-- foto dan nama profile -->
			<div class="box-profile">
				<div class="box-foto">
					<img src="Image/foto_admin/<?php echo $foto; ?>" class="img-responsive img-circle">
				</div>
				<div class="box-username">
					<h4 class="text-center">
						<?php echo $frist_name; ?>
						<br>
						<?php echo $last_name; ?>
					</h4>
				</div>
			</div>
			<!-- navihasi sidebar dan navbar -->
			<div class="box-navbar">
				<ul class="nav">
					<li><a href="index.php?halaman=home"><i class="fa fa-home fa-2x"></i> HOME </a></li>
					<li><a href="index.php?halaman=profile"><i class="fa fa-user fa-2x"></i> PROFILE </a></li>
					<li>
						<a data-toggle="collapse" data-target="#box-show" href="#box-show">
							<i class="fa fa-cube fa-2x"></i> BARANG <span class="caret"></span>
						</a>
						<div class="collapse" id="box-show">
							<ul class="nav">
								<li>
									<a href="index.php?halaman=tambah_data_barang">
										<span class="fa fa-caret-right"></span> INPUT BARANG
									</a>
								</li>
								<li>
									<a href="index.php?halaman=data_barang">
										<span class="fa fa-caret-right"></span> DATA BARANG
									</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<a href="index.php?halaman=user_pelanggan">
							<i class="fa fa-users fa-2x"></i> PELANGGAN
						</a>
					</li>
					<li>
						<a href="index.php?halaman=pembelian">
							<i class="fa fa-shopping-cart fa-2x"></i> PEMESANAN
						</a>
					</li>
					<li class="LogOut-hiden">
						<a href="index.php?halaman=logout">
							<i class="fa fa-sign-out fa-2x"></i> LogOut
						</a>
					</li>
				</ul>
			</div>

		</div>
		<!-- akhir sidebar -->

		<!-- membuat isi konten yang akan ditampilkan di bawah sini -->
		<section class="content">
			<div class="page-inner">
				<?php
				if (isset($_GET['halaman'])) {
					if ($_GET['halaman'] == "home") {
						include 'home.php';
					} elseif ($_GET['halaman'] == "profile") {
						include 'profile.php';
					} elseif ($_GET['halaman'] == "user_pelanggan") {
						include 'user_pelanggan.php';
					} elseif ($_GET['halaman'] == "pembelian") {
						include 'pembelian.php';
					} elseif ($_GET['halaman'] == "data_barang") {
						include 'data_barang.php';
					} elseif ($_GET['halaman'] == "detail") {
						include 'detail_pembelian.php';
					} elseif ($_GET['halaman'] == "tambah_data_barang") {
						include 'tambah_data_barang.php';
					} elseif ($_GET['halaman'] == "hapus_data_barang") {
						include 'hapus_data_barang.php';
					} elseif ($_GET['halaman'] == "ubah_data_barang") {
						include 'ubah_data_barang.php';
					} elseif ($_GET['halaman'] == "tambah_admin") {
						include 'tambah_admin.php';
					} elseif ($_GET['halaman'] == "pembayaran") {
						include 'pembayaran.php';
					} elseif ($_GET['halaman'] == "lihat_pembayaran") {
						include 'lihat_pembayaran.php';
					} elseif ($_GET['halaman'] == "logout") {
						include 'logout.php';
					}
				} else {
					include 'home.php';
				}
				?>
			</div>
		</section>

	</div>
	<!-- akhir div wrapper -->

	<script src="dist/js/jquery.js"></script>
	<script src="Bootstrap/js/bootstrap.min.js"></script>
	<script src="dist/js/admin.js"></script>
</body>

</html>