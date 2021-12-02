<?php
// pemanggilan koneksi wajib
require 'koneksiDB/koneksi.php';
session_start();

// jika ada proses prubahan password  dan langsung masuk kesini maka dinyatakan batal
if (isset($_SESSION['RePassword'])) {
  unset($_SESSION['RePassword']);
  echo "<script>alert('Proses Ubah Password di Batalkan!');</script>";
}

// jika sedang dalam verifikasi tetapi kembali atau tidak jadi verifikasi maka
if (isset($_SESSION['v_email'])) {
  $ambil_email = $_SESSION['v_email'];
  $excute = $koneksi->query("DELETE FROM user where email='$ambil_email'");
  unset($_SESSION['v_email']);
}
// jika sudah login maka tidak bisa masuk ke login
if (isset($_SESSION['user'])) {
  header('Location: index.php');
}

if (isset($_POST["SingUp_button"])) {
  // merubah string menjadi huruf kecil dan karakterbebas pasa email dan user
  // pada password string yang dimasukan real atau karakter asli serta simbol maupun angka
  $username = strtolower(stripslashes($_POST["username"]));
  $useremail = strtolower(stripslashes($_POST["email"]));
  $password1 = mysqli_real_escape_string($koneksi, $_POST["password1"]);
  $password2 = mysqli_real_escape_string($koneksi, $_POST["password2"]);

  // mencari email yang sudah ada pada table di database agentmart
  $sql = "SELECT * FROM user WHERE email='$useremail'";
  $adaemail = mysqli_query($koneksi, $sql);

  // apa bila email sudah terdaftar maka email tidak bisa dipakai
  if (mysqli_fetch_assoc($adaemail)) {
    echo  "<script>
    alert('Email sudah terdaftar!');
    </script>";
  } else {
    // jika email tidak ada maka email baru akan di proses
    // pada tahapan ini memverifikasi password apabila password sama dengan
    // password verifikasi maka data di perbolehkan untuk daftar
    if ($password1 !== $password2) {
      echo "<script>
      alert('Veryfikasi Password Gagal!');
      </script>";
    } else {
      // membuat verifikasi password yang secara acak dengan md5
      // dan di ambil karakter sebanyak 6 karakter
      $RandomVkey = md5(time() . $username);
      $ambilVkey = substr($RandomVkey, 0, 6);
      $Vkey = strtoupper($ambilVkey);

      // pada password akan di enkripsi atau merubah data string menggunakan algoritma khusus
      // sehingga password tidak bisa dibaca oleh orang lain
      $realpassword = password_hash($password1, PASSWORD_DEFAULT);
      $sql = "INSERT INTO user(username,email,password,vkey) VALUES ('$username','$useremail','$realpassword','$Vkey')";
      $insert = mysqli_query($koneksi, $sql);

      if ($insert) {

        $to = $useremail;
        $subject = "Verifikasi Email";
        $message = "
        <h1>SELAMAT DATANG DI AGENTDRINK</h1>
        <p>Aktifkan email mu segera, belanaja cepat hanya di agentdrink sekali klik produk sampai dirumah </p>
        <h3><b>kode Verifikasi : $Vkey</b></h3>
        <br>
        <p>Trimakasih telah mendaftar di agentdrink</p>
        ";
        $headers = "From: safnaprasetiono71@gmail.com \r \n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=utf-8" . "\r\n";

        mail($to, $subject, $message, $headers);

        $_SESSION['v_email'] = $useremail;
        echo "<script>
        alert('Verifikasi Sudah Dikirim Melalui Email');
        location= 'verifikasi.php';
        </script>";
      } else {
        echo "<script>
        alert('proses signup gagal! ulangi beberapa saat');
        </script>";
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="image/logo_title.png">
  <title>AgentDrink</title>

  <!-- koneksi ke css bootstrap dan ke css fontawesome -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <!-- konek ke css login -->
  <link rel="stylesheet" href="dist/css/signup.css">
</head>

<body>
  <div class="inner">
    <div class="row">
      <span class="balon1">></span>
      <span class="balon2"></span>
    </div>
  </div>

  <div class="box-signup">
    <div class="row">
      <form action="" method="POST">

        <!-- judul -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="box-title">
            <h1>SIGNUP</h1>
            <p>selamat datang di signup AgentDrink</p>
          </div>
        </div>

        <!-- main form -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="form-group">
            <input type="text" name="username" class="form-control" value="" id="e" placeholder="User Name" required="">
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" value="" id="e" placeholder="Email" required="">
          </div>
          <div class="form-group">
            <input type="password" name="password1" class="form-control" value="" id="p" min="10" placeholder="Password" required="">
          </div>
          <div class="form-group">
            <input type="password" name="password2" class="form-control" value="" id="vp" min="10" placeholder="verifikasi Password" required="">
          </div>
          <div class="btn-signup form-group">
            <button class="form-control btn btn-success" type="submit" name="SingUp_button">Sign Up</button>
          </div>
          <div class="form-group lainnya">
            <h5 class="text-center"><b>-- OR --</b></h5>
          </div>
          <div class="btn-login form-group">
            <a class="form-control btn btn-primary" href="login.php">Login</a>
          </div>
        </div>

      </form>
    </div>
  </div>

  <!-- koneksi script ke bootstrap dan jqery -->
  <script type="text/javascript" src="dist/js/jquery.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>