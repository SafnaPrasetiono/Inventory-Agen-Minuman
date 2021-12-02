<?php
	// pemanggilan koneksi wajib ada
require 'koneksiDB/koneksi.php';

	// untu penyimpanan akun user yang ingin masuk ke agentmart
session_start();

// jika tidak ada register email maka akan di larikan ke verifikasi
if (!isset($_SESSION['v_email'])) {
	header('Location: signup.php');
}else{
	$ambil_email = $_SESSION['v_email'];
}
	// menekan tombol verifikasi password maka email akan di proses 
	if (isset($_POST['v_password'])) {

		$sql = $koneksi->query("SELECT * FROM user WHERE email='$ambil_email'");
		$ambil = $sql->fetch_assoc();

		$v_key = $ambil['vkey'];
		$vp1 = $_POST['v1'];
		$vp2 = $_POST['v2'];
		$vp3 = $_POST['v3'];
		$vp4 = $_POST['v4'];
		$vp5 = $_POST['v5'];
		$vp6 = $_POST['v6'];

		$verifikasi_password = $vp1.$vp2.$vp3.$vp4.$vp5.$vp6;

		// jika inputan pada kotak registrasi email sama dengan kode vkey maka aktifasi email di proses  
		if ($verifikasi_password == $v_key) {
			$excute = $koneksi->query("UPDATE user SET active='1' WHERE vkey='$verifikasi_password'");
			if ($excute) {
				echo "<script>
				alert('EMAIL BERHASIL DIVERIFIKASI SILAHKAN LOGIN');
				location= 'login.php';
				</script>";
				unset($_SESSION['v_email']);
			}else{
				echo "<script>alert('VERIFIKASI EMAIL GAGAL!');</script>";	
			}
		}else{
			echo "<script>
			alert('KODE VERIFIKASI TIDAK SAMA!');
			location= 'verifikasi.php';
			</script>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="img/logo_title.png">
	<title>AgentDrink</title>

	<!-- koneksi ke css bootstrap dan ke css fontawesome -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/verifikasi.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<br clear="clr">
				<br clear="clr">
				<br clear="clr">
				<h1 class="text-center">Verifikasi Email</h1>
				<div class="row">
					<div class="col-md-offset-4 col-md-4">
						<hr class="soft">
					</div>
				</div>
			</div>
			<form class="col-md-12 col-sm-12 col-xs-12" method="POST" action="">
				<div class="row">
					<div class="col-md-offset-3 col-md-1 col-sm-2 col-xs-2">
						<div class="from-group">
							<input type="text" name="v1" class="control-box" min="1" max="1">
						</div>
					</div>
					<div class="col-md-1 col-sm-2 col-xs-2">
						<div class="from-group">
							<input type="text" name="v2" class="control-box" min="1" max="1">
						</div>
					</div>
					<div class="col-md-1 col-sm-2 col-xs-2">
						<div class="from-group">
							<input type="text" name="v3" class="control-box" min="1" max="1">
						</div>
					</div>
					<div class="col-md-1 col-sm-2 col-xs-2">
						<div class="from-group">
							<input type="text" name="v4" class="control-box" min="1" max="1">
						</div>
					</div>
					<div class="col-md-1 col-sm-2 col-xs-2">
						<div class="from-group">
							<input type="text" name="v5" class="control-box" min="1" max="1">
						</div>
					</div>
					<div class="col-md-1 col-sm-2 col-xs-2">
						<div class="from-group">
							<input type="text" name="v6" class="control-box" min="1" max="1">
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<br clear="clr">
						<br clear="clr">
						<p class="text-center">Kode Verifikasi Telah Dikirim Melalui Email!</p>
					</div>
					<div class="col-md-offset-4 col-sm-offset-3 col-xs-offset-3 col-md-4 col-sm-6 col-xs-6">
						<div class="from-group">
							<button type="submit" name="v_password" class="btn btn-primary btn-lg btn-block cntrl-btn">Verifikasi</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript" src="dist/js/jquery.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>