<?php

if (isset($_GET['id'])) {
	// ambil id
	$ambil_id = $_GET['id'];
	// memanggil atau memeilih barang dengan kode barang yang di tentukan sesuai id
	$databrg = $koneksi->query("SELECT * FROM barang WHERE id_brg='$_GET[id]'");
	$brg = $databrg->fetch_assoc();
} else {
	echo "<script>alert('PRODUK TIDAK ADA PILIH YANG LAIN');</script>";
	echo "<script>location= 'index.php?halaman=data_barang';</script>";
}

if (isset($_POST["updatebtn"])) {
	// mendeklarasiakan semua isi dari barang dalam variable baru
	$nama_barang = htmlspecialchars($_POST["namabrg"]);
	$jenis_barang = htmlspecialchars($_POST["jenisbrg"]);
	$jumlah_barang = htmlspecialchars($_POST["jumlahbrg"]);
	$harga_barang = htmlspecialchars($_POST["hargabrg"]);
	$article_barang = htmlspecialchars($_POST["articlebrg"]);
	$foto_barang = $_FILES['fotobrg']['tmp_name'];

	// jika pada input foto terisi atau foto dipilih kembali maka akan terjadi update
	if (!empty($foto_barang)) {
		//pendefinisian untuk upload foto atau upload data foto
		$namafoto = $_FILES['fotobrg']['name'];
		$errorfoto = $_FILES['fotobrg']['error'];
		$sizefoto = $_FILES['fotobrg']['size'];
		$datafoto = $_FILES['fotobrg']['tmp_name'];

		//mencari extensi foto yang nantinya yang di perbolehkan saja
		$fileExp = explode('.', $namafoto);
		$ekstensi = strtolower(end($fileExp));
		$filediperbolehkan = array('jpg', 'jpeg', 'png');

		//logika untuk memastikan foto atau bukan foto serta insert data semua
		if (in_array($ekstensi, $filediperbolehkan) === true) {
			if ($errorfoto === 0) {
				if ($sizefoto < 10000000) {
					// nama foto upload gabung tanggal
					$upload = date('YmdHis') . $namafoto;
					// upload ke image produk
					move_uploaded_file($datafoto, '../image/produk/' . $upload);
					$simpanbrg = $koneksi->query("UPDATE barang set nama_brg='$nama_barang',
					jenis_brg='$jenis_barang',
					jumlah_brg='$jumlah_barang',
					harga_brg='$harga_barang',
					foto_brg='$upload',
					article_brg='$article_barang' WHERE id_brg='$ambil_id'");
					if ($simpanbrg) {
						// memberitahukan bahwa data telah berhasil disimpan
						echo "<script>alert('DATA BERHASIL DI UPDATE!');</script>";
						echo "<script>location='index.php?halaman=data_barang';</script>";
					} else {
						// memberitahukan bahwa data telah berhasil disimpan
						echo "<script>alert('PROSES UPDATE BARANG GAGAL!');</script>";
						echo "<script>location='index.php?halaman=data_barang';</script>";
					}
				} else {
					// apabila file lebih dari 100mb makan akan diberitahukan bahwa
					echo "<script>alert('FILE GAMBAR TERLALU BESAR');</script>";
				}
			} else {
				// juka gagal upload atau foto tida ada maka gagal upload
				echo "<script>alert('UPLOAD GAGAL GAMBAR ERROR!');</script>";
			}
		} else {
			// apabila fil yang akhiranya bukan allowed maka file tidak
			// akan di eksekusi oleh sistem
			echo "<script>alert('FILE BUKAN GAMBAR ULANGI!');</script>";
		}
	}
	// jika pada input foto tidak teisi makan foto tidak akan di upload lagi
	else {
		$simpanbrg = $koneksi->query("UPDATE barang set nama_brg='$nama_barang',
		jenis_brg='$jenis_barang',
		jumlah_brg='$jumlah_barang',
		harga_brg='$harga_barang',
		article_brg='$article_barang' WHERE id_brg='$ambil_id'");
		if ($simpanbrg) {
			// memberitahukan bahwa data telah berhasil disimpan
			echo "<script>alert('DATA BERHASIL DI UPDATE!');</script>";
			echo "<script>location='index.php?halaman=data_barang';</script>";
		} else {
			// memberitahukan bahwa data telah berhasil disimpan
			echo "<script>alert('PROSES UPDATE BARANG GAGAL!');</script>";
			echo "<script>location='index.php?halaman=data_barang';</script>";
		}
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<link rel="stylesheet" href="dist/css/update.css">
	<link rel="stylesheet" href="dist/css/form_upload.css">
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2>Ubah Data Barang</h2>
				<hr class="soft">
			</div>
		</div>
	</div>

	<!-- membuat input text yang sudah terisi pada data yang di pilih berdasarkan id -->
	<div class="container-fluid">
		<div class="row">
			<form action="#" method="post" enctype="multipart/form-data">
				<!-- bagian utama nama, harga, jenis, jumlah -->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="namabrg">Nama Barang</label>
						<input type="text" class="form-control" name="namabrg" id="namabrg" value="<?php echo $brg['nama_brg']; ?>">
					</div>
					<div class="form-group">
						<label for="jenisbrg">Jenis Barang</label>
						<select name="jenisbrg" id="jenibrg" class="form-control">
							<option value="mineral" <?php if ($brg['jenis_brg'] == 'mineral') {
														echo 'selected';
													} ?>>Mineral</option>
							<option value="susu" <?php if ($brg['jenis_brg'] == 'susu') {
														echo 'selected';
													} ?>>Susu</option>
							<option value="kopi" <?php if ($brg['jenis_brg'] == 'kopi') {
														echo 'selected';
													} ?>>Kopi</option>
							<option value="soda" <?php if ($brg['jenis_brg'] == 'soda') {
														echo 'selected';
													} ?>>Soda</option>
							<option value="buah" <?php if ($brg['jenis_brg'] == 'buah') {
														echo 'selected';
													} ?>>Buah</option>
							<option value="teh" <?php if ($brg['jenis_brg'] == 'teh') {
													echo 'selected';
												} ?>>Teh</option>
							<option value="isotonic" <?php if ($brg['jenis_brg'] == 'isotonic') {
															echo 'selected';
														} ?>>Isotonic</option>
						</select>
					</div>
					<div class="form-group">
						<label for="jumlahbrg">Jumlah Barang</label>
						<input type="text" class="form-control" name="jumlahbrg" id="jumlahbrg" value="<?php echo $brg['jumlah_brg']; ?>">
					</div>
					<div class="form-group">
						<label for="hargabrg">Harga Barang</label>
						<input type="text" class="form-control" name="hargabrg" id="hargabrg" value="<?php echo $brg['harga_brg']; ?>">
					</div>
				</div>
				<!-- bagian2 foto dan ubah foto -->
				<!-- Foto -->
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group">
						<label>Foto Barang</label>
						<label for="file-input" class="form-upload form-control">
							<img src="../image/produk/<?php echo $brg['foto_brg']; ?>" alt="" id="displayGambar">
						</label>
						<input type="file" name="fotobrg" onchange="displayImage(this)" id="file-input">
					</div>
				</div>
				<!-- bagian3 article dan btn simpan -->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label for="articlebrg">Atricle Barang</label>
						<textarea class="form-control" name="articlebrg" rows="10">
                    	<?php echo $brg['article_brg']; ?>
                    </textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-success form-control" type="submit" name="updatebtn">Ubah Data</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script src="dist/js/form_upload.js"></script>
</body>

</html>