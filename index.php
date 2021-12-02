<?php
// pemanggilan database
require 'koneksiDB/koneksi.php';

// membukan session
session_start();

// jika sedang dalam verifikasi tetapi kembali atau pinda halaman maka dinyatakan batal
if (isset($_SESSION['v_email'])) {
	$ambil_email = $_SESSION['v_email'];
	$excute = $koneksi->query("DELETE FROM user where email='$ambil_email'");
	unset($_SESSION['v_email']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<link rel="icon" type="image/png" href="image/logo_title.png" />
	<title>AgentDrink</title>
	<!-- digunakan untuk menghubungkan bootstrap, font-awsome -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
	<!-- pemanggilan css pada index atau menu utama -->
	<link rel="stylesheet" type="text/css" href="dist/css/main_form.css" />
	<!-- pemanggilan css pada header -->
	<link rel="stylesheet" type="text/css" href="dist/css/header.css" />
	<!-- pemanggilan css pada navigasi  -->
	<link rel="stylesheet" type="text/css" href="dist/css/navbar.css" />
	<!-- pemanggilan css pada animate -->
	<link rel="stylesheet" type="text/css" href="dist/css/animate.css" />
</head>
<body>
	<!-- menyisipkan headerphp pada index -->
	<header class="box-header hidden-xs">
		<?php include 'header.php'; ?>
	</header>

	<!-- menyisipkan navigasi pada form utama -->
	<nav class="box-navbar">
		<?php include 'navbar.php'; ?>
	</nav>

	<!-- menyisipkan main dari jalur yang ada di home -->
	<content class="content">
		<div class="inner">
			<?php
			if (isset($_GET['set'])) {
				if ($_GET['set'] == "home") {
					include 'home.php';
				} elseif ($_GET['set'] == "kategori") {
					include 'kategori.php';
				} elseif ($_GET['set'] == "pencarian") {
					include 'pencarian.php';
				} elseif ($_GET['set'] == "keranjang") {
					include 'keranjang.php';
				} elseif ($_GET['set'] == "detail_produk") {
					include 'detail_produk.php';
				} elseif ($_GET['set'] == "checkout") {
					include 'checkout.php';
				} elseif ($_GET['set'] == "nota") {
					include 'nota.php';
				} elseif ($_GET['set'] == "profile_user") {
					include 'profile_user.php';
				} elseif ($_GET['set'] == "riwayat_belanja") {
					include 'riwayat_belanja.php';
				} elseif ($_GET['set'] == "cara_belanja") {
					include 'cara_belanja.php';
				} elseif ($_GET['set'] == "tentang_kami") {
					include 'tentang_kami.php';
				} elseif ($_GET['set'] == "pembayaran") {
					include 'pembayaran.php';
				} elseif ($_GET['set'] == "lihat_pembayaran") {
					include 'lihat_pembayaran.php';
				} elseif ($_GET['set'] == "syarat_ketentuan") {
					include 'syarat_ketentuan.php';
				}
			} else {
				include 'home.php';
			}
			?>
		</div>
	</content>

	<!-- menyisipkan footer pada box-footer -->
	<footer class="box-footer">
		<?php include 'footer.php'; ?>
	</footer>

	<div class="box-copy-right">
		<p>COPYRIGHT © 2019 AgentDrink</p>
	</div>


	<!-- script wajib untuk membuka bootstrap dan jquery -->
	<script type="text/javascript" src="dist/js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<!-- penambahan java script pada header -->
	<script type="text/javascript" src="dist/js/header.js"></script>
</body>
</html>