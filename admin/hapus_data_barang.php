<?php 
	
	require '../koneksiDB/koneksi.php';
	$hapusdata = $koneksi->query("DELETE FROM barang WHERE id_brg='$_GET[id]'");
	if (hapusdata) {
		echo "<script>alert('BARANG BERHASIL DIAPUS');</script>";
		echo "<script> location='index.php?halaman=data_barang';</script>";
	}else{
		echo "<script>alert(BARANG GAGAL DIHAPUS');</script>";
		echo "<script> location='index.php?halaman=data_barang';</script>";
	}

?>