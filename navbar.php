<?php
if (isset($_POST['btnsearch'])) {
	$caribarang = $_POST['search'];
	echo "
 <script>
 location= 'index.php?set=pencarian&ctg_search=$caribarang';
 </script>
 ";
}
?>
<div class="navbar navbar-default">
	<div class="container">

		<div class="navbar-header">

			<a class="navbar-brand hidden-lg hidden-md hidden-sm" href="index.php">
				<img src="image/logo/logo_768px.png" alt="img-responsive">
			</a>

			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<i class="fa fa-bars box-ico"></i>
			</button>
			<a href="index.php?set=keranjang" class="navbar-toggle">
				<i class="fa fa-shopping-cart box-ico"></i>
				<?php
				// jika masuk notifikasi akan akan musul serta total barangnya
				$jml_brg = 0;
				if (isset($_SESSION['keranjang'])) {
					foreach ($_SESSION["keranjang"] as $produk_brg => $jmlbrg) {
						$jml_brg++;
					}
					if ($jml_brg > 0) {
						echo "<span class='animated infinite heartBeat slower navigation-cart'>";
						echo $jml_brg;
						echo "</span>";
					}
				}
				?>
			</a>
		</div>

		<!-- membuat navigasi atau pilihan kategori pada jenis barang -->
		<div class="collapse navbar-collapse">
			<form action="" class="navbar navbar-form navbar-search  hidden-lg hidden-md hidden-sm" method="post">
				<div class="input-group">
					<input type="text" name="search" placeholder="Search..." class="form-control input-car" required="">
					<span class="input-group-btn">
						<button class="btn btn-default btn-car" name="btnsearch"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>
			<ul class="nav navbar-nav">
				<li><a href="home">Home</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">kategori <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?set=kategori&ctg=Mineral">Mineral</a></li>
						<li><a href="index.php?set=kategori&ctg=Susu">Susu</a></li>
						<li><a href="index.php?set=kategori&ctg=Kopi">Kopi</a></li>
						<li><a href="index.php?set=kategori&ctg=Soda">Soda</a></li>
						<li><a href="index.php?set=kategori&ctg=Buah">Buah</a></li>
						<li><a href="index.php?set=kategori&ctg=Teh">Teh</a></li>
						<li><a href="index.php?set=kategori&ctg=Isotonic">Isotonic</a></li>
					</ul>
				</li>
			</ul>
			<!-- login atau sudah login -->
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['user'])) : ?>
				<li class="dropdown">
					<a href="#" class="foto-user dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="fa fa-user-circle-o fa-2x"></span>
						<span class="user-name"><?php echo $_SESSION['user']['username']; ?></span>
						<span class="caret user-name"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="index.php?set=profile_user">Profile</a></li>
						<li><a href="index.php?set=profile_user#riwayat-belanja">Riwayat Belanja</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="logout.php">LogOut</a></li>
					</ul>
				</li>
				<?php else : ?>
				<li><a href="signup.php">Daftar</a></li>
				<li><a href="login.php">Login</a></li>
				<?php endif; ?>
			</ul>
		</div> <!-- penutup container collapse -->

	</div> <!-- penutup container -->
</div>