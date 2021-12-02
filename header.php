<!DOCTYPE html>
<html>

<head>
  <title></title>
</head>

<body>

  <div class="container">
    <div class="row">
      <!-- logo atau judul dari program yang dibuat -->
      <div class="col-md-3 col-xs-8 col-sm-5 pull-left">
        <a href="index.php" class="">
          <img src="image/Logo_AgentDrink.png" alt="..." class="img-responsive">
        </a>
      </div>


      <!-- membuat notifikasi dari kranjang atau barang yang sudah di beli -->
      <div class="col-md-2 col-xs-4 col-sm-4  pull-right">
        <div class="btn-block" id="cart">
          <!-- jika diklik maka akan muncul box-shopping -->
          <a class="btn btn-default btn-block shopping-btn">
            <div class="row">
              <div class=" col-md-12 col-xs-12 col-sm-12">
                <i class="fa fa-shopping-basket fa-2x"></i>
                <span class="shopping-title">KERANJANG <br> BELANJA </span>
                <?php
                // jika masuk notifikasi akan akan musul serta total barangnya
                $jml_brg = 0;
                if (isset($_SESSION['keranjang'])) {
                  foreach ($_SESSION["keranjang"] as $produk_brg => $jmlbrg) {
                    $jml_brg++;
                  }
                  if ($jml_brg > 0) {
                    echo "<span class='animated infinite heartBeat slower shopping-notify'>";
                    echo $jml_brg;
                    echo "</span>";
                  }
                }
                ?>
              </div>
            </div>
          </a>

          <!-- jika di klik muncul div shoppinng -->
          <div class="box-shopping-show" id="shopping-show">
            <div class="row">
              <!-- jika session keranjang kosong maka akan di tampilkan keranjang kososng -->
              <?php if (empty($_SESSION['keranjang']) or !isset($_SESSION['keranjang'])) : ?>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <span class="keranjang-kosong">
                      <br clear="clr">
                      <h3><b>Belum Ada Barang</b></h3>
                      <h4><b>Keranjang Kosong</b></h4>
                      <br clear="clr">
                    </span>
                  </div>
                </div>
              </div>
              <?php else : ?>

              <?php
                // jika ada belanja maka akan muncul tentang barang yang dibeli
                $total_belanja = 0;
                // mengambil isi array pada keranjang ke id_produk
                foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) :

                  // menampilkan barang dengan id produk yang ada pada array
                  $sql = $koneksi->query("SELECT*FROM barang WHERE id_brg='$id_produk'");
                  $brg = $sql->fetch_assoc();
                  // pada total julmah baran dibeli akan dikalikan pada harga barang tsb
                  $total_harga = $brg['harga_brg'] * $jumlah;
                  ?>
              <!-- barang dan harga barang -->
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3 col-xs-3 col-sm-3">
                    <div class="btn-block">
                      <!-- menampilkan foto barang -->
                      <img src="image/produk/<?php echo $brg['foto_brg']; ?>" class="img-responsive">
                    </div>
                  </div>
                  <div class="col-md-7 col-xs-7 col-sm-7">
                    <label for="">
                      <!-- menampilkan nama barang -->
                      <?php echo $brg['nama_brg']; ?>
                    </label>
                    <p>
                      <!-- menampilkan jumlah barang yang dibeli dan dikalikan -->
                      <?php echo $jumlah; ?> x Rp. <?php echo number_format($brg['harga_brg']); ?>
                      <?php $total_belanja += $total_harga; ?>
                    </p>
                  </div>
                  <div class="col-md-2 col-xs-2 col-sm-2">
                    <!-- menghapus kolom keranjang -->
                    <a href="hapuskeranjang.php?id=<?php echo $id_produk ?>">
                      <i class="fa fa-times"></i>
                    </a>
                  </div>
                </div>
              </div>
              <!-- mengakhiri progam foreach -->
              <?php endforeach; ?>

              <!-- total harga barang -->
              <div class="col-md-12">
                <hr class="soft">
                <div class="row">
                  <div class="col-md-6 col-xs-6 col-sm-6">
                    <span>Total Harga </span>
                  </div>
                  <div class="col-md-6 col-xs-6 col-sm-6">
                    <!-- menampilkan total harga -->
                    <span>Rp. <?php echo number_format($total_belanja); ?></span>
                  </div>
                </div>
                <hr class="soft">
              </div>
              <!-- melanjutkan keranjang ataou checkout -->
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6 col-xs-6 col-sm-6">
                    <a href="index.php?set=keranjang" class="btn btn-default btn-block">
                      <i class="fa fa-shopping-cart"></i> Keranjang
                    </a>
                  </div>
                  <div class="col-md-6 col-xs-6 col-sm-6">
                    <?php if (empty($_SESSION['user']) or !isset($_SESSION['keranjang'])) : ?>
                    <a href="login.php" class="btn btn-primary btn-block">Checkout</a>
                    <?php else : ?>
                    <a href="index.php?set=checkout" class="btn btn-primary btn-block">Checkout</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <!-- mengakhiri perogram logika if -->
              <?php endif; ?>


            </div>
          </div>

        </div>
      </div>

      <!-- Meanampilkan Kolom pencarian pabarang -->
      <div class="col-md-6 col-xs-12 col-sm-12 col-md-offset-1 pull-left">
        <br clear="clr">
        <form action="" class="block" method="post">
          <div class="input-group">
            <input type="text" name="search" placeholder="Search..." class="form-control input-search" required="">
            <span class="input-group-btn">
              <button class="btn btn-default btn-search" name="btnsearch"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </form>
        <br clear="clr">
      </div>

</body>

</html>
<?php
// mengeksekusi kolom cari pada saat di eksekusi akan dialihkan ke kategori yang akan di tampilkan barang
// yang berdasarkan nama barang tersebut
if (isset($_POST['btnsearch'])) {
  $caribarang = $_POST['search'];
  echo "
 <script>
 location= 'index.php?set=pencarian&ctg_search=$caribarang';
 </script>
 ";
}

?>