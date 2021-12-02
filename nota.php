<?php
// pemanggilan koneksi wajib
require 'koneksiDB/koneksi.php';

$nomor = 1;

// mengambil id untuk detail nota
if (isset($_GET['id'])) {
	$ambil_id = $_GET["id"];

	// membuat query dengan join antara pembelian dan user
	$sql = $koneksi->query("SELECT * FROM pembelian JOIN user ON 
		pembelian.id_user = user.id_user WHERE 
		pembelian.id_pembelian ='$ambil_id'");

	// data di pecan dalam bentuk array
	$detail = $sql->fetch_assoc();


	// jika id_user dipembelian tidak sama dengan id_user yang berada di session login
	// makan akan dilarikan ke riwayat belanja
	$id_user_cek = $_SESSION['user']['id_user'];
	$id_pembelian_cek = $detail['id_user'];
	if ($id_user_cek !== $id_pembelian_cek) {
		echo "<script>location='index.php?set=profile_user';</script>";
	}
} else {
	echo "<script>alert('TERJADI KESALAHAN ULANGI LAGI!');</script>";
	echo "<script>location='index.php?set=profile_user';</script>";
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>AgentDrink</title>
	<link rel="stylesheet" href="dist/css/nota.css">
</head>

<body>

	<div class="container set-page">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2><b>Nota Pembelian</b></h2>
				<hr class="soft">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 class="text-left">
							<b>Pembelian</b>
							<hr class="soft">
						</h3>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
								<p><b>No Pembelian</b><br><?php echo $detail["id_pembelian"]; ?></p>
								<p><b>Tanggal Pembelian</b><br><?php echo $detail["tgl_pembelian"]; ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
								<p><b>Total Pembelian</b><br>Rp. <?php echo number_format($detail["total_pembelian"]); ?></p>
								<p><b>Status Pembelian</b><br><?php echo $detail["status_pembelian"]; ?></p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 class="text-left">
							<b>Pelanggan</b>
							<hr class="soft">
						</h3>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Nama Pelanggan</b><br><?php echo $detail["username"]; ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>No Telepon</b><br><?php echo $detail["no_tlp_user"]; ?></p>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p><b>Email</b><br> <?php echo $detail["email"]; ?> </p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 class="text-leftr">
							<b>Pengiriman</b>
							<hr class="soft">
						</h3>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Kota</b><br><?php echo $detail["kota_pembelian"]; ?></p>
								<p><b>Kode Pos </b><br><?php echo $detail["kode_pos"]; ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Harga Ongkos Kirim</b><br>Rp. <?php echo number_format($detail["harga_ongkir"]); ?></p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><b>Alamat Pengiriman</b><br><?php echo $detail["alamat_pembelian"]; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<hr class="soft">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr class="success">
								<th>NO</th>
								<th>NAMA BARANG</th>
								<th>JENIS</th>
								<th>HARGA</th>
								<th>JUMLAH</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// mengambil data dari hasil checkout yang telah disimpan di pembelian_barang
							// dan ditampilkan sebagai informasi tentang barang yang sudah dibeli
							$sub_harga = 0;
							$ambil_barang = $koneksi->query("SELECT * FROM pembelian_barang WHERE id_pembelian='$ambil_id'");
							?>
							<?php while ($detail_brg = $ambil_barang->fetch_assoc()) : ?>
								<tr>
									<td><?php echo $nomor ?></td>
									<td><?php echo $detail_brg["nama_barang"]; ?></td>
									<td><?php echo $detail_brg["jenis_barang"]; ?></td>
									<td>Rp. <?php echo number_format($detail_brg["harga_barang"]); ?></td>
									<td><?php echo $detail_brg["jumlah"]; ?></td>
									<td>Rp. <?php echo number_format($detail_brg["total_harga"]); ?></td>
								</tr>
								<?php
								$sub_harga += $detail_brg["total_harga"];
								$nomor++;
							endwhile;
							?>
						</tbody>
					</table>
				</div>
			</div>

			<?php if ($detail['metode_pembelian'] !== "COD") : ?>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="alert alert-warning" role="alert">
						<label>info belanja</label>
						<p>Silahkan melakukan pembayaran melalui rekening</p>
						<label for="">BANK MANDIRI 123-234567-6789 AN. AGENTDRINK</label>
					</div>
				</div>
			<?php endif; ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="alert alert-success">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h4><strong>Informasi Harga</strong></h4>
						</div>
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
							<span>Sub Harga</span>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<span>Rp. <?php echo number_format($sub_harga); ?></span>
						</div>
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
							<span>Ongkos Pengiriman</span>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<span>Rp. <?php echo number_format($detail["harga_ongkir"]); ?></span>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<hr class="soft">
						</div>
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
							<span>Total Harga</span>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<span>Rp. <?php echo number_format($detail['total_pembelian']); ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php if ($detail['status_pembelian'] == "pending" and $detail['metode_pembelian'] == "BANK") : ?>
					<a href="index.php?set=pembayaran&id=<?php echo $detail['id_pembelian'] ?>" class="btn btn-primary btn-lg btn-block">BAYAR</a>
				<?php elseif ($detail['status_pembelian'] == "barang dikirim"  and $detail['metode_pembelian'] == "BANK") : ?>
					<a href="index.php?set=lihat_pembayaran&id=<?php echo $detail['id_pembelian'] ?>" class="btn btn-success btn-lg btn-block">Lihat Pembayaran</a>
				<?php elseif ($detail['status_pembelian'] == "sudah bayar" and $detail['metode_pembelian'] == "BANK") : ?>
					<a href="index.php?set=lihat_pembayaran&id=<?php echo $detail['id_pembelian'] ?>" class="btn btn-success btn-lg btn-block">Lihat Pembayaran</a>
				<?php elseif ($detail['status_pembelian'] == "selesai") : ?>
					<a href="index.php?set=lihat_pembayaran&id=<?php echo $detail['id_pembelian'] ?>" class="btn btn-success btn-lg btn-block">Lihat Pembayaran</a>
				<?php endif; ?>
			</div>

		</div>
	</div>

</body>

</html>