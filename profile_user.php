<?php
// pemanggilan koneksi wajib
require 'koneksiDB/koneksi.php';

// jika tidak ada session user maka akan dilarikan ke index
if (!isset($_SESSION['user'])) {
	echo "<script>location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>AgentDrinl</title>
	<link rel="stylesheet" type="text/css" href="dist/css/profile_user.css">
</head>

<body>
	<br clear="clr">
	<div class="container">
		<div class="row">
			<!-- judul -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2><b>My Profile</b></h2>
				<hr class="soft">
			</div>

			<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
				<div class="row">
					<!-- detail profile dan ubah -->
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h3>Detail Profile</h3>
						<br clear="clr">
					</div>
					<form action="" method="POST" enctype="multipart/form-data">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="file-input" class="form-upload form-control">
									<?php if ($_SESSION['user']['foto'] == "") : ?>
										<img src="image/user.png" id="displayGambar" class="img-rounded img-responsive">
									<?php else : ?>
										<img src="image/pelanggan/<?php echo $_SESSION['user']['foto']; ?>" id="displayGambar" class="img-rounded img-responsive">
									<?php endif; ?>
								</label>
								<input type="file" name="foto" onchange="displayImage(this)" id="file-input">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label>username</label>
								<input type="text" name="username" class="form-control" placeholder="Full Name" value="<?php echo $_SESSION['user']['username']; ?>">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" placeholder="Email" readonly value="<?php echo $_SESSION['user']['email']; ?>">
							</div>
							<div class="form-group">
								<label>Telepon</label>
								<input type="text" name="notelepon" class="form-control" placeholder="No.Telepon" value="<?php echo $_SESSION['user']['no_tlp_user']; ?>">
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?php echo $_SESSION['user']['alamat']; ?>">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button class="btn btn-success form-control" name="ubah_profile">Ubah Profile</button>
						</div>
					</form>
					<!-- akhir row ubah profile -->
				</div>
				<br clear="clr"><br clear="clr">
			</div>


			<!-- riwayat belanja -->
			<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8" id="riwayat-belanja">
				<h3>Riwayat Belanja</h3>
				<br clear="clr">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr class="success">
								<th>No</th>
								<th>tanggal</th>
								<th>status</th>
								<th>total</th>
								<th>opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$nomor = 1;
							$id_user = $_SESSION['user']['id_user'];
							$sql = $koneksi->query("SELECT * FROM pembelian WHERE id_user='$id_user'");
							?>
							<?php while ($data_user = $sql->fetch_assoc()) : ?>
								<tr>
									<td><?php echo $nomor++; ?></td>
									<td><?php echo $data_user['tgl_pembelian']; ?></td>
									<td>
										<?php echo $data_user['status_pembelian']; ?>
										<br>
										<?php if (!empty($data_user['resi_pengiriman'])) : ?>
											Resi : <?php echo $data_user['resi_pengiriman'] ?>
										<?php endif; ?>
									</td>
									<td>Rp. <?php echo number_format($data_user['total_pembelian']); ?></td>
									<td>
										<a href="index.php?set=nota&id=<?php echo $data_user['id_pembelian'] ?>" class="btn btn-info">Nota</a>
										<?php if ($data_user['status_pembelian'] == "pending" and $data_user['metode_pembelian'] == "BANK") : ?>
											<a href="index.php?set=pembayaran&id=<?php echo $data_user['id_pembelian'] ?>" class="btn btn-primary">BAYAR</a>
										<?php elseif ($data_user['status_pembelian'] == "barang dikirim" OR $data_user['status_pembelian'] == "sudah bayar"  and $data_user['metode_pembelian'] == "BANK") : ?>
											<a href="index.php?set=lihat_pembayaran&id=<?php echo $data_user['id_pembelian'] ?>" class="btn btn-success">Lihat Pembayaran</a>
										<?php elseif ($data_user['status_pembelian'] == "selesai") : ?>
											<a href="index.php?set=lihat_pembayaran&id=<?php echo $data_user['id_pembelian'] ?>" class="btn btn-success">Lihat Pembayaran</a>
										<?php endif; ?>
									</td>
								</tr> <?php endwhile; ?> </tbody>
					</table> <br clear="clr">
				</div>
			</div>

			<!-- akhir div row dan container -->
		</div>
	</div>
	<br clear="clr">
	<br clear="clr">

	<!-- java skrip form-upload -->
	<script type="text/javascript" src="dist/js/form_upload.js"></script>
</body>

</html>
<?php

if (isset($_POST['ubah_profile'])) {

	// ambil data dari post
	$ambil_id_user = $_SESSION['user']['id_user'];
	$username = $_POST['username'];
	$no_tlp_user = $_POST['notelepon'];
	$alamat = $_POST['alamat'];
	$foto = $_FILES['foto']['name'];

	if ($foto != "") {
		// upload foto
		$ekstensi_diperbolehkan	= array('jpg', 'png', 'gif', 'jpeg');
		$foto_baru = $_FILES['foto']['name'];
		$x = explode('.', $foto_baru);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['foto']['size'];
		$file_tmp = $_FILES['foto']['tmp_name'];
		if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
			if ($ukuran < 4044070) {
				move_uploaded_file($file_tmp, "image/pelanggan/$foto_baru");
				$update = $koneksi->query("UPDATE user SET username='$username',
				no_tlp_user='$no_tlp_user',
				foto='$foto_baru',
				alamat='$alamat' WHERE id_user='$ambil_id_user'");
				if ($update) {
					// update pada session
					$_SESSION['user']['username'] = $username;
					$_SESSION['user']['no_tlp_user'] = $no_tlp_user;
					$_SESSION['user']['alamat'] = $alamat;
					$_SESSION['user']['foto'] = $foto_baru;
					echo "<script>alert('DATA BERHASIL DI UBAH');</script>";
					echo "<script>location = 'index.php?set=profile_user';</script>";
				} else {
					echo "<script>alert('PERUBAHAN GAGAL ULANGI NANTI');</script>";
					echo "<script>location = 'index.php?set=profile_user';</script>";
				}
			} else {
				echo "<script>alert('UKURAN FILE TERLALU BESAR');</script>";
				echo "<script>location = 'index.php?set=profile_user';</script>";
			}
		} else {
			echo "<script>alert('FILE BUKAN FOTO PILIH PNG ATAU JPG');</script>";
			echo "<script>location = 'index.php?set=profile_user';</script>";
		}
	} else {
		$koneksi->query("UPDATE user SET username='$username',
		no_tlp_user='$no_tlp_user',
		alamat='$alamat' WHERE id_user='$ambil_id_user'");

		// update pada session
		$_SESSION['user']['username'] = $username;
		$_SESSION['user']['no_tlp_user'] = $no_tlp_user;
		$_SESSION['user']['alamat'] = $alamat;

		echo "<script>alert('Ubah Data Berhasil');</script>";
		echo "<script>location = 'index.php?set=profile_user';</script>";
	}
}

?>