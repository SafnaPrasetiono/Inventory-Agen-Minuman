<?php

// jika tidak ada session user maka akan dilarikan ke index
if (empty($_SESSION['user']) or !isset($_SESSION['keranjang'])) {
	echo "
		<script>
			location= 'login.php';
		</script>
		";
	exit();
}

if (isset($_POST['checkout'])) {
	// mengambil informasi dengan pembelian
	$id_pelanggan = $_SESSION['user']['id_user'];
	$id_ongkir = $_POST['id_ongkir'];
	$tgl_beli = date("Y-m-d");
	$kode_pos_pembeli = $_POST['kode_pos'];
	$no_tlp_baru = $_POST['no_telepon'];
	$alamat_tujuan = $_POST['alamat_tujuan'];

	// jika user memasukan telepon atau alamat baru maka data user akan di update
	$no_tlp_pelanggan = $_SESSION['user']['no_tlp_user'];
	if ($no_tlp_baru  != $no_tlp_pelanggan) {
		$koneksi->query("UPDATE user SET no_tlp_user='$no_tlp_baru' WHERE id_user='$id_pelanggan'");
		$_SESSION['user']['no_tlp_user'] = $no_tlp_baru;
	}
	$alamat_pelanggan = $_SESSION['user']['alamat'];
	if ($alamat_tujuan != $alamat_pelanggan) {
		$koneksi->query("UPDATE user SET alamat='$alamat_tujuan' WHERE id_user='$id_pelanggan'");
		$_SESSION['user']['alamat'] = $alamat_tujuan;
	}

	// mengambil harga dari ongki dicari dengan id ongkir
	$sql_ongkir = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
	$ambil_ongkir = $sql_ongkir->fetch_assoc();
	$kota_pembeli = $ambil_ongkir['nama_kota'];
	$harga_ongkir = $ambil_ongkir['tarif'];

	// menjumlahkan total belanja dengan tarif untuk pengiriman
	$total_beli = $total_belanja + $harga_ongkir;

	// menentukan metode pembayaran sebelum insert pembelian
	$metode_pembayaran = $_POST['METODE'];
	if ($metode_pembayaran == "COD") {
		$metode_pembelian = "COD";
		$status = "sedang di proses";
	} else {
		$metode_pembelian = "BANK";
		$status = "pending";
	}

	// mamasukan data ke table pembelian
	$koneksi->query("INSERT INTO pembelian(id_user,tgl_pembelian,total_pembelian,alamat_pembelian,kode_pos,kota_pembelian,harga_ongkir,status_pembelian,metode_pembelian) VALUES('$id_pelanggan','$tgl_beli','$total_beli','$alamat_tujuan','$kode_pos_pembeli','$kota_pembeli','$harga_ongkir','$status','$metode_pembelian')");
	// mengambil id pembelian yang barusan datanya di insertkan
	$id_pembelian_produk = $koneksi->insert_id;

	// memasukan data ke table pembelian produk barang
	foreach ($_SESSION['keranjang'] as $id_barang => $jumlah) {
		// sebelum mennyimpan produk yang di beli akan di pindahkan terlebih dahulu ke pembelian barang
		// maka harus mengambil data terlebih dahulu dari table barang
		// bertujan jika seandainya sudah cekout maka saat terjadi perubahaan harga, harga tidak berubah
		$sql_brg = $koneksi->query("SELECT * FROM barang WHERE id_brg=$id_barang");
		$ambil_barang = $sql_brg->fetch_assoc();
		// mengambil data barang
		$nama_barang = $ambil_barang["nama_brg"];
		$jenis_barang = $ambil_barang["jenis_brg"];
		$harga_barang = $ambil_barang["harga_brg"];
		// menjumlahkan harga dengan jumlah yang dibeli
		$total_harga = $harga_barang * $jumlah;

		$koneksi->query("INSERT INTO pembelian_barang VALUES('','$id_pembelian_produk','$nama_barang','$jenis_barang','$jumlah','$harga_barang','$total_harga')");

		// update jumlah barang apabila di beli maka jumlah barang akan berkurang karna sudah di beli
		// update barang terbeli di table barang dari jumlah barang yang di kurangi
		$jumlah_brang_dibeli = $ambil_barang["jumlah_brg"] - $jumlah;
		$terjual = $ambil_barang['terjual'] + $jumlah;
		$koneksi->query("UPDATE barang SET jumlah_brg='$jumlah_brang_dibeli', terjual='$terjual' WHERE id_brg='$id_barang' ");
	}

	// jika barang sudah dibeli berarti di keranjang sudah tidak ada barang maka
	// barang yang ada di keranjang dihapus
	unset($_SESSION['keranjang']);

	// tapilan akan dialihkan ke nota pembayaran atau metode pembayaran
	echo "<script>alert('Pembelian Sukses');</script>";
	echo "<script>location = 'index.php?set=nota&id=$id_pembelian_produk';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<link rel="stylesheet" href="dist/css/checkout.css">
</head>

<body>

	<br clear="clr">
	<!-- ini dari content atau belanjaan yang akan dibeli -->
	<div class="container">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2><b>Keranjang Belanja</b></h2>
				<hr class="row">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<table class="table table-bordered">
					<thead>
						<tr class="success">
							<th>No</th>
							<th>Barang</th>
							<th>Harga</th>
							<th>Jumlah</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$nomor = 1;
						$total_belanja = 0;
						// mengambil isi array pada keranjang ke id_produk
						foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) :

							// menampilkan barang dengan id produk yang ada pada array
							$sql = $koneksi->query("SELECT*FROM barang WHERE id_brg='$id_produk'");
							$brg = $sql->fetch_assoc();
							// pada total julmah baran dibeli akan dikalikan pada harga barang tsb
							$total_harga = $brg['harga_brg'] * $jumlah;

							?>
							<tr>
								<!-- menampilkan barang yand dipilih untuk dibeli -->
								<td><?php echo $nomor; ?></td>
								<td><?php echo $brg['nama_brg']; ?></td>
								<td>Rp. <?php echo number_format($brg['harga_brg']); ?></td>
								<td><?php echo $jumlah; ?></td>
								<td>Rp. <?php echo number_format($total_harga); ?></td>
							</tr>
							<?php
							$nomor++;
							$total_belanja += $total_harga;
						endforeach;
						?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4">Total Belanja</th>
							<th>Rp. <?php echo number_format($total_belanja); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<hr class="soft">
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- membuat form tentang informasi untuk melanjutkan pembayaran -->
				<form method="post">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<!-- mengambil nama use dar user yang telah login atau session user -->
								<label>Nama Pembeli</label>
								<input type="text" class="form-control box-input" readonly="" name="username" value="<?php echo $_SESSION["user"]['username'] ?>">
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<!-- mengambil informasi kontak dari user yang telah login atau session user -->
								<label>Email Pembeli</label>
								<input type="text" class="form-control box-input" readonly="" name="email" value=" <?php echo $_SESSION["user"]['email'] ?> ">
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<!-- mengambil informasi kontak dari user yang telah login atau session user -->
								<label>Telepon</label>
								<input type="text" class="form-control box-input" name="no_telepon" value="<?php echo $_SESSION["user"]['no_tlp_user'] ?>" required="">
							</div>
						</div>

						<!-- onkos kirim dan kode pos -->
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>Pilih Kota</label>
										<select class="form-control box-input" name="id_ongkir" required="">
											<option value="">Pilih Ongkos Kirim</option>
											<?php
											$sql_ongkir = $koneksi->query("SELECT * FROM ongkir");
											while ($ongkir = $sql_ongkir->fetch_assoc()) :
												?>
												<option value=" <?php echo $ongkir['id_ongkir'] ?> ">
													<?php echo $ongkir['nama_kota']; ?> -
													Rp. <?php echo number_format($ongkir['tarif']); ?>
												</option>
											<?php endwhile; ?>
										</select>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<div class="form-group">
										<label>Kode Pos</label>
										<input type="text" class="form-control box-input" name="kode_pos" value="" required="">
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<!-- mengambil informasi kontak dari user yang telah login atau session user -->
								<label>Alamat Tujuan</label>
								<textarea name="alamat_tujuan" class="form-control box-textarea" required="" rows="5">
								<?php echo $_SESSION["user"]['alamat'] ?>
								</textarea>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="">Metode Pembayaran</label><br>
								<div class="btn-group btn-group-justified" data-toggle="buttons">
									<label class="btn btn-success box-input">
										<input type="radio" name="METODE" id="option1" autocomplete="off" value="COD"> CASH ON DELIVERY
									</label>
									<label class="btn btn-success box-input">
										<input type="radio" name="METODE" id="option2" autocomplete="off" value="BANK"> TRANSFER BANK
									</label>
								</div>
							</div>
						</div>


						<!-- informasi tentang checkout -->
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<br clear="clr">
							<br clear="clr">
							<div class="alert alert-success" role="alert">
								<label>Keterangan Belanja</label>
								<p>
									Besar ongkos pengiriman didasarkan pada kota tujuan pengiriman.
									Data harus terisi dengan lengkap,
									apa bila ada perubahaan maka secara default data pada pofile anda
									akan berubah sesuai dengan data yang dimasukan saat checkout.
									pastikan kembali barang belanjaan yang akan dibeli dan baca cara belanja sebelum membeli
								</p>
							</div>
						</div>


						<!-- button checkout -->
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<br clear="clr">
							<button class="btn btn-success btn-lg btn-block" name="checkout">
								Checkout Sekarang <i class="fa fa-arrow-right"></i>
							</button>
							<br clear="clr">
							<br clear="clr">
							<br clear="clr">
						</div>

					</div>
				</form>
			</div>

		</div>
	</div>
	<br clear="clr">
	<br clear="clr">

</body>

</html>