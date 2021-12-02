<?php
	session_start();
	// menghapus session atau akun yang tersimpan
	session_destroy();
	if (isset($_SESSION['user'])) {
		echo "<script>alert('Anda Telah LogOut');</script>";

		echo "<script>location= 'index.php';</script>";
	}else{
		echo "<script>location= 'index.php';</script>";
	}
?>