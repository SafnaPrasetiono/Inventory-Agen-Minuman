<?php

// pemanggilan koneksi wajib ada
require 'koneksiDB/koneksi.php';

// untu penyimpanan akun user yang ingin masuk ke agentmart
session_start();

if (isset($_SESSION['v_email'])) {
    $ambil_email = $_SESSION['v_email'];
    $excute = $koneksi->query("DELETE FROM user where email='$ambil_email'");
    unset($_SESSION['v_email']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="img/logo_title.png">
    <title>AgentDrink</title>

    <!-- koneksi ke css bootstrap dan ke css fontawesome -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <!-- konek ke css login -->
    <link rel="stylesheet" href="dist/css/login.css">
</head>

<body>
    <div class="inner">
        <div class="box-login">
            <div class="row">

                <!-- judul -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box-title">
                        <h1>GET PASSWORD</h1>
                        <p>layanan bantuan lupa password AgentDrink</p>
                        <hr class="soft">
                    </div>
                </div>
                <?php if (!isset($_SESSION['RePassword']) or empty($_SESSION['RePassword'])) : ?>
                    <form method="POST">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="vkey" class="form-control" id="" placeholder="Kode Verifikasi" required>
                            </div>
                            <div class="form-group">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Informasi</strong>
                                    <p>
                                        jika tidak mengetahui kode verifikasi terakhir, silahkan hubungi kami melalui
                                        kontak yang tersedia pada AgentDrink.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" name="proses" class="btn btn-primary form-control" id="myButton" data-loading-text="Loading..." autocomplete="off">Proses</button>
                            </div>
                        </div>
                    </form>
                <?php else : ?>
                    <form method="POST">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <input type="password" name="password" min="8" class="form-control" id="" placeholder="Password Baru" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="vpassword" min="8" class="form-control" id="" placeholder="Verifikasi Password" required>
                            </div>
                            <div class="form-group">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Informasi</strong>
                                    <p>
                                        Perubahan password hanya bisa di lakukan satu kali, jika terdapat kesalahan
                                        yang sama silahkan hubungi kami melalui kontak yang tersedia pada AgentDrink
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <a href="login.php" type="button" name="batal_ubah" class="btn btn-danger form-control">Batal</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <button type="submit" name="ubah_password" class="btn btn-primary form-control">Ubah Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- koneksi script ke bootstrap dan jqery -->
    <script type="text/javascript" src="dist/js/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php
if (isset($_POST['proses'])) {
    $email = $_POST['email'];
    $vkey = strtoupper($_POST['vkey']);

    // cekup login untuk admin bila login degnan akun admin
    $sql = "SELECT*FROM user WHERE email='$email' AND vkey='$vkey' ";
    $user = mysqli_query($koneksi, $sql);
    $akun_user = $user->num_rows;

    // jika data ditemukan maka diperbolehkan login sebagai admin
    if ($akun_user == 1) {
        $_SESSION['RePassword']['email'] = $email;
        $_SESSION['RePassword']['vkey'] = $vkey;

        // proses berhasil makan akan menampilkan ubah password
        echo "<script>alert('Silahkan Ubah Password!');</script>";
        echo "<meta http-equiv='refresh' content='1;url=lupa_password.php'> ";
    } else {
        unset($_SESSION['RePassword']);
        echo "<script>alert('Proses Gagal, Email dan Vkey Salah!');</script>";
        echo "<meta http-equiv='refresh' content='1;url=lupa_password.php'> ";
    }
} elseif (isset($_POST['ubah_password'])) {

    $ReEmail = $_SESSION['RePassword']['email'];
    $ReVkey = $_SESSION['RePassword']['vkey'];

    // memastikan kembali akun barusan
    $sql = "SELECT*FROM user WHERE email='$ReEmail' AND vkey='$ReVkey' ";
    $user = mysqli_query($koneksi, $sql);
    $akun_user = $user->num_rows;

    // jika data ditemukan maka diperbolehkan login sebagai admin
    if ($akun_user == 1) {
        $pecah = $user->fetch_assoc();
        $ambil_id_user = $pecah['id_user'];
        // mendapatkan password
        $password = $_POST['password'];
        $vpassword = $_POST['vpassword'];

        if ($password == $vpassword) {
            // merubah vkey agar hanya bisa 1 kali perubahan password
            $RandomVkey = md5(time() . $password);
            $ambilVkey = substr($RandomVkey, 0, 6);
            $Vkey = strtoupper($ambilVkey);

            // enkripsi password
            $realpassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET password='$realpassword', vkey='$Vkey' WHERE id_user='$ambil_id_user'";
            $insert = mysqli_query($koneksi, $sql);

            // proses berhasil makan akan dilarikan ke login
            unset($_SESSION['RePassword']);
            echo "<script>alert('Ubah Password Berhasil, Silahkan Login');</script>";
            echo "<script>location= 'login.php';</script>";
        } else {
            // proses gagal
            unset($_SESSION['RePassword']);
            echo "<script>alert('Verifikasi Password Tidak Sama!');</script>";
            echo "<script>location= 'lupa_password.php';</script>";
        }
    } else {
        unset($_SESSION['RePassword']);
        echo "<script>alert('Proses Gagal, Email dan Vkey Salah!');</script>";
        echo "<meta http-equiv='refresh' content='1;url=lupa_password.php'> ";
    }
}
?>