<?php
//memanggil koneksi.php agar isi yang ada di dalam koneksi.php
//dapat digunakan pada halaman ini
require '../koneksiDB/koneksi.php';
//memberikan variable untuk sql untuk eksekusi cari barang
$sql;
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="dist/css/data_barang.css">
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2>Data barang</h2>
				<hr class="soft">
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<form class="navbar-form navbar-right" action="" method="POST" role="search">
			<div class="input-group">
				<input type="text" name="caribrg" class="form-control" placeholder="Search for...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" name="caribtn">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div><!-- /input-group -->
		</form>
	</div>

	<div class="container-fluid over-table">
		<table class="table table-striped">
			<!-- membuat atribut pada table -->
			<thead>
				<tr class="success">
					<th>No </th>
					<th>Nama </th>
					<th>Jenis </th>
					<th>Jumlah</th>
					<th>Harga </th>
					<th>Foto </th>
					<th>Aksi </th>
				</tr>
			</thead>

			<tbody>
				<?php
				// pada kolom cari apa bila btn cari di klik maka aka di ksekusi pada cari brg
				// jik tidak maka akan menampilkan hanya data barang yang tidak di cari
				if (isset($_POST["caribtn"])) {
					$hasilcari = $_POST["caribrg"];
					$sql = $koneksi->query("SELECT * FROM barang WHERE nama_brg LIKE '%$hasilcari%'");
				} else {
					$sql = $koneksi->query("SELECT * FROM barang");
				}
				$nomor = 1;
				?>
				<!-- membuat perulangan pada barang selama barang masih ada akan ditampikan sampai proses -->
				<!-- dari prulangan while dihentikan -->
				<?php while ($brg = $sql->fetch_assoc()) : ?>
					<tr>
						<td><?php echo $nomor; ?></td>
						<td><?php echo $brg["nama_brg"];  ?></td>
						<td><?php echo $brg["jenis_brg"]; ?></td>
						<td><?php echo $brg["jumlah_brg"]; ?></td>
						<td><?php echo $brg["harga_brg"]; ?></td>
						<td>
							<div class="gambar_brg">
								<img src="../image/produk/<?php echo $brg['foto_brg']; ?>">
							</div>
						</td>
						<td>
							<a href="index.php?halaman=ubah_data_barang&id=<?php echo $brg["id_brg"]; ?>" class="btn btn-warning">
								<i class="fa fa-refresh"></i>
							</a>
							<a href="index.php?halaman=hapus_data_barang&id=<?php echo $brg["id_brg"]; ?>" class="btn btn-danger">
								<i class="fa fa-trash"></i>
							</a>
						</td>
					</tr>
					<!-- mengakhiri perulangan while serta memberikan increment atau penambahan pada variable $nomor -->
					<?php
					$nomor++;
				endwhile;
				?>
			</tbody>
		</table>

	</div>
</body>

</html>