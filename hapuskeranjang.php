<?php
	// memulai session
	session_start();
	// mengambil id prodik pada link
	$id_produk = $_GET['id'];

	// untuk menghapus session bisa di gunakan unset
	unset($_SESSION['keranjang'][$id_produk]);

	// menampilkan pesan
	echo "
	<script>
		alert('Produk telah dihapus dari keranjang');
	</script>
	";

	// jika di temukan ctg maka akan di larikan ke kategori.php
	// dan jika di temukan ctg_search maka akan dilarikan ke kategori_cari.php
	// selain itu akan dialihkan ke halaman utama 
	if (isset($_GET['ctg'])) {
		$ctg = $_GET['ctg'];
		echo "
			<script>
				location='index.php?set=kategori&ctg=$ctg';
			</script>
			";
	}elseif(isset($_GET['ctg_search'])) {
		$ctg_search = $_GET['ctg_search'];
			echo "
			<script>
				location='index.php?set=kategori_cari&ctg_search=$ctg_search';
			</script>
			";
	}else{
		echo "<script>location='index.php?set=keranjang';</script>";
	}

?>