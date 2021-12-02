<?php 

	$koneksi = mysqli_connect("localhost","root","","agentdrink");

	if(!$koneksi){
		echo "<script>alert('SORRY, SERVER NOT OPEN');</script>";
		echo "<script>location= '../logout.php';</script>";
	}

?>