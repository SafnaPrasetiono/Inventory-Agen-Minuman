<!DOCTYPE html>
<html lang="en">

<head>
 <title>profile</title>
 <link rel="stylesheet" href="dist/css/profile.css">
</head>

<body>
 <div class="container-fluid main-page">
  <div class="row">

   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h1>Tambah Admin</h1>
    <hr class="soft">
   </div>

   <form action="" method="POST" enctype="multipart/form-data">
    <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6 pull-right">
     <div class="form-group">
      <label for="file-input" class="form-upload form-control">
       <?php $foto = $_SESSION['admin']['foto']; ?>
       <img src="Image/upload.png" alt="" id="displayGambar">
      </label>
      <input type="file" name="foto" onchange="displayImage(this)" id="file-input" required="">
     </div>
    </div>
    <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6 pull-left">
     <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
       <div class="form-group">
        <input type="text" name="nama_depan" class="form-control" required="" placeholder="Nama Depan">
       </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
       <div class="form-group">
        <input type="text" name="nama_belakang" class="form-control" required="" placeholder="Nama Belakang">
       </div>
      </div>
     </div>
     <div class="form-group">
      <input type="text" name="nama_lengkap" class="form-control" required="" placeholder="Nama Lengkap">
     </div>
     <div class="form-group">
      <input type="text" name="telepon" class="form-control" required="" placeholder="Telepon">
     </div>
     <div class="form-group">
      <input type="text" name="alamat" class="form-control" required="" placeholder="Alamat">
     </div>
     <div class="form-group">
      <input type="email" name="email" class="form-control" required="" placeholder="Email">
     </div>
     <div class="form-group">
      <input type="password" name="password" class="form-control" min="8" required="" placeholder="Password">
     </div>
     <div class="form-group">
      <input type="password" name="Vpassword" class="form-control" min="8" required="" placeholder="Verifikasi Password">
     </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
     <div class="form-group">
      <button type="submit" name="tambahadmin" class="btn btn-success form-control">Submit</button>
     </div>
    </div>

   </form>

  </div>
 </div>

 <script src="dist/js/form_upload.js"></script>
</body>

</html>

<?php

if (isset($_POST["tambahadmin"])) {
 $first_name = htmlspecialchars($_POST['nama_depan']);
 $last_name = htmlspecialchars($_POST['nama_belakang']);
 $full_name = htmlspecialchars($_POST['nama_lengkap']);
 $telepon = htmlspecialchars($_POST['telepon']);
 $alamat = htmlspecialchars($_POST['alamat']);
 $email = htmlspecialchars($_POST['email']);
 $password1 = mysqli_real_escape_string($koneksi, $_POST['password']);
 $password2 = mysqli_real_escape_string($koneksi, $_POST['Vpassword']);

 if ($password1 !== $password2) {
  echo "<script>alert('VERIFIKASI PASSWORD GAGAL!');</script>";
  echo "<script>location= 'index.php';</script>";
 } else {
  // merubah password
  $realpassword = password_hash($password1, PASSWORD_DEFAULT);

  //pendefinisian untuk upload foto atau upload data foto
  $namafoto = $_FILES['foto']['name'];
  $errorfoto = $_FILES['foto']['error'];
  $sizefoto = $_FILES['foto']['size'];
  $datafoto = $_FILES['foto']['tmp_name'];

  //mencari extensi foto yang nantinya yang di perbolehkan saja
  $fileExp = explode('.', $namafoto);
  $filekstensi = strtolower(end($fileExp));
  $filediperbolehkan = array('jpg', 'jpeg', 'png');

  //logika untuk memastikan foto atau bukan foto serta insert data semua
  if (in_array($filekstensi, $filediperbolehkan) === true) {
   if ($errorfoto === 0) {
    if ($sizefoto < 10000000) {
     // nama foto upload gabung tanggal
     $upload = date('YmdHis') . $namafoto;
     // upload ke image produk
     move_uploaded_file($datafoto, 'Image/foto_admin/' . $upload);
     // memasukan data baik itu data foto dan data ttg barang tsb
     $simpan = $koneksi->query("INSERT INTO admin VALUES ('','$first_name','$last_name','$full_name','$email','$telepon','$realpassword','$upload','$alamat')");
     if ($simpan) {
      // memberitahukan bahwa data telah berhasil disimpan
      mysqli_query($koneksi, $simpanbrg);
      echo "<script>alert('DATA TELAH DI TAMBAHKAN');</script>";
      echo "<script>location= 'index.php';</script>";
     } else {
      echo "<script>alert('DATABASES ERROR ULANGI LAGI NANTI!');</script>";
      echo "<script>location= 'index.php';</script>";
     }
    } else {
     // apabila file lebih dari 100mb makan akan diberitahukan bahwa
     echo "<script>alert('UKURAN FILE TERLALU BESAR!');</script>";
    }
   } else {
    // juka gagal upload atau foto tida ada maka gagal upload
    echo "<script>alert('GAGAL, TIDAK ADA FOTO DIPILIH!');</script>";
   }
  } else {
   // apabila fil yang akhiranya bukan allowed maka file tidak
   // akan di eksekusi oleh sistem
   echo "<script>alert('FILE BUKAN FOTO, ULANGI!');</script>";
  }
 }
}

?>