<?php
// pemanggilan koneksi wajib ada
require 'koneksiDB/koneksi.php';

// untu penyimpanan akun user yang ingin masuk ke agentmart
session_start();

// jika sedang dalam verifikasi tetapi kembali atau tidak jadi verifikasi maka
if (isset($_SESSION['v_email'])) {
  $ambil_email = $_SESSION['v_email'];
  $excute = $koneksi->query("DELETE FROM user where email='$ambil_email'");
  unset($_SESSION['v_email']);
}

// jika ada proses prubahan password  dan langsung masuk kesini maka dinyatakan batal
if (isset($_SESSION['RePassword'])) {
  unset($_SESSION['RePassword']);
  echo "<script>alert('Proses Ubah Password di Batalkan!');</script>";
}

// jika sudah login maka tidak bisa masuk ke login
if (isset($_SESSION['user'])) {
  header('Location: index.php');
}

// jika button pada login ditekan akan melakukan aksi ini
if (isset($_POST['login_button'])) {
  $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
  $password = mysqli_real_escape_string($koneksi, $_POST["password"]);


  // cekup login untuk admin bila login dengan akun admin
  $sql = "SELECT*FROM admin WHERE email='$email'";
  $admin = mysqli_query($koneksi, $sql);
  $akun_admin = $admin->num_rows;

  // jika data ditemukan maka diperbolehkan login sebagai admin
  if ($akun_admin == 1) {

    $admin_akun = $admin->fetch_assoc();
    // jika password admin sama maka iya telah login sebagai admin
    // password_verify($password, $admin_akun['password'])
    if (password_verify($password, $admin_akun['password'])) {
      $_SESSION['admin'] = $admin_akun;
      echo "<script>alert('Login Sukses');</script>";
      echo "<meta http-equiv='refresh' content='1;url=admin/index.php'> ";
    } else {
      // jika password admin salah
      echo "<script>alert('Login Gagal');</script>";
      echo "<meta http-equiv='refresh' content='1;url=login.php'> ";
    }
  } else {

    // cekup login jika akun admin tidak ditemukan maka akan mencari akun user atau pembeli
    $sql = "SELECT*FROM user WHERE email='$email'";
    $user = mysqli_query($koneksi, $sql);
    $akun_user = $user->num_rows;

    // jika data ditemukan maka diperbolehkan login sebagai user
    if ($akun_user == 1) {
      $user_akun = $user->fetch_assoc();
      // jika password user benar maka iya telah login
      if (password_verify($password, $user_akun['password'])) {
        $account_active = $user_akun['active'];
        if ($account_active == 1) {
          $_SESSION['user'] = $user_akun;
          // jika terdapat session keranjang berarti iya siap checkout
          if (!isset($_SESSION['keranjang']) or empty($_SESSION['keranjang'])) {
            echo "<script>alert('Login Sukses');</script>";
            echo "<meta http-equiv='refresh' content='1;url=index.php'> ";
          } else {
            echo "<script>alert('Login Sukses');</script>";
            echo "<meta http-equiv='refresh' content='1;url=index.php?set=checkout'> ";
          }
        } else {
          // account belum verifikasi maka gagal
          echo "<script>alert('Akun Belum Terverifikasi!');</script>";
          echo "<meta http-equiv='refresh' content='1;url=login.php'> ";
        }
      } else {
        // jika password pada akun user salah
        echo "<script>alert('Login Gagal!');</script>";
        echo "<meta http-equiv='refresh' content='1;url=login.php'> ";
      }
    } else {
      // jika tidak ditemukan akun user
      echo "<script>alert('Login Gagal');</script>";
      echo "<meta http-equiv='refresh' content='1;url=login.php'> ";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

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
  <link rel="stylesheet" href="dist/css/login.css">
  <!-- pemanggilan css pada animate -->
  <link rel="stylesheet" type="text/css" href="dist/css/animate.css">
</head>

<body>

  <div class="inner">
    <div class="row">
      <span class="balon1"></span>
      <span class="balon2"></span>
    </div>
  </div>

  <div class="box-login">
    <div class="row">
      <form method="POST">

        <!-- judul -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="box-title">
            <h1>LOGIN</h1>
            <p>selamat datang di login AgentDrink</p>
          </div>
        </div>

        <!-- main form -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="form-group">
            <input type="text" name="email" class="form-control" value="" id="e" placeholder="Email" required="">
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" value="" id="p" placeholder="Password" required="">
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="check"> Remember Me
            </label>
          </div>
          <div class="btn-login form-group">
            <button class="form-control btn btn-primary" name="login_button">Login</button>
          </div>
          <div class="form-group">
            <h5 class="text-center"><b>-- OR --</b></h5>
          </div>

          <div class="row">
            <!-- lupa password -->
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="btn-signup form-group">
                <a class="form-control btn btn-danger" href="lupa_password.php">Lupa Password!</a>
              </div>
            </div>
            <!-- daftar menjadi pelanggan -->
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="btn-signup form-group">
                <a class="form-control btn btn-success" href="signup.php">SignUp</a>
              </div>
            </div>
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