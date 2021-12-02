<?php
	// memulai session
	session_start();

	// mengambil id produk yang di beli
	$id_produk = $_GET['id'];

	// jika di keranjang sudah ada produk tsb maka di +1
	if (isset($_SESSION['keranjang'][$id_produk])) {
		$_SESSION['keranjang'][$id_produk] += 1;
	}
	// jika tidak ttp diangap 1
	else
	{
		$_SESSION['keranjang'][$id_produk] = 1;
	}

	echo "<script>alert('Cek Shopping Cart');</script>";

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
	}elseif(isset($_GET['detail_produk'])) {
		echo "
			<script>
				location='index.php?set=detail_produk&id=$id_produk';
			</script>
		";
	}else{
		echo "<script>location='index.php';</script>";
	}

?>