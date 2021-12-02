<?php
	// menghapus session atau akun yang tersimpan
	session_destroy();

	echo "
	<script>
		alert('Anda Telah LogOut');
	</script>
	";

	echo "
	<script>
		location= '../index.php';
	</script>
	";

?>