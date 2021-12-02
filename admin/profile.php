<?php
if (isset($_POST['proses'])) {
    $id_admin = $_SESSION['admin']['id_admin'];
    
    $first_name = htmlspecialchars($_POST['nama_depan']);
    $last_name = htmlspecialchars($_POST['nama_belakang']);
    $full_name = htmlspecialchars($_POST['nama_lengkap']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);

    //pendefinisian untuk upload foto atau upload data foto
    $namafoto = $_FILES['foto']['name'];
    $errorfoto = $_FILES['foto']['error'];
    $sizefoto = $_FILES['foto']['size'];
    $datafoto = $_FILES['foto']['tmp_name'];

    //mencari extensi foto yang nantinya yang di perbolehkan saja
    $fileExp = explode('.', $namafoto);
    $filekstensi = strtolower(end($fileExp));
    $filediperbolehkan = array('jpg', 'jpeg', 'png');

    if ($namafoto !== "") {
        //logika untuk memastikan foto atau bukan foto serta insert data semua
        if (in_array($filekstensi, $filediperbolehkan) === true) {
            if ($errorfoto === 0) {
                if ($sizefoto < 10000000) {
                    // nama foto upload gabung tanggal
                    $upload = date('YmdHis') . $namafoto;
                    // upload ke image produk
                    move_uploaded_file($datafoto, 'Image/foto_admin/' . $upload);
                    // memasukan data baik itu data foto dan data ttg barang tsb
                    $simpan = $koneksi->query("UPDATE admin SET first_name='$first_name',
                    last_name='$last_name', full_name='$full_name', telepon='$telepon',
                    foto='$upload', alamat='$alamat' WHERE id_admin='$id_admin'");
                    if ($simpan) {
                        // update pada session
                        $_SESSION['admin']['first_name'] = $first_name;
                        $_SESSION['admin']['last_name'] = $last_name;
                        $_SESSION['admin']['full_name'] = $full_name;
                        $_SESSION['admin']['telepon'] = $telepon;
                        $_SESSION['admin']['foto'] = $upload;
                        $_SESSION['admin']['alamat'] = $alamat;
                        // memberitahukan bahwa data telah berhasil disimpan
                        echo "<script>alert('DATA BERHASIL DI UBAH');</script>";
                        echo "<script>location= 'index.php?halaman=profile';</script>";
                    } else {
                        echo "<script>alert('DATABASES ERROR ULANGI LAGI NANTI!');</script>";
                        echo "<script>location= 'index.php';</script>";
                    }
                } else {
                    // apabila file lebih dari 100mb makan akan diberitahukan bahwa
                    echo "<script>alert('UKURAN FOTO TERLALU BESAR!');</script>";
                }
            } else {
                // jika gagal upload atau foto error
                echo "<script>alert('GAGAL, UBAH FOTO ERROR!');</script>";
            }
        } else {
            // apabila fil yang akhiranya bukan allowed maka file tidak
            // akan di eksekusi oleh sistem
            echo "<script>alert('FILE BUKAN FOTO, ULANGI!');</script>";
        }
    } else {
        // menyimpan tanpa data foto
        $simpan = $koneksi->query("UPDATE admin SET first_name='$first_name',
        last_name='$last_name',full_name='$full_name',telepon='$telepon',
        alamat='$alamat' WHERE id_admin='$id_admin'");
        if ($simpan) {
            // update pada session
            $_SESSION['admin']['first_name'] = $first_name;
            $_SESSION['admin']['last_name'] = $last_name;
            $_SESSION['admin']['full_name'] = $full_name;
            $_SESSION['admin']['telepon'] = $telepon;
            $_SESSION['admin']['alamat'] = $alamat;
            // memberitahukan bahwa data telah berhasil disimpan
            echo "<script>alert('DATA BERHASIL DI UBAH');</script>";
            echo "<script>location= 'index.php?halaman=profile';</script>";
        } else {
            echo "<script>alert('DATABASES ERROR ULANGI LAGI NANTI!');</script>";
            echo "<script>location= 'index.php';</script>";
        }
    }
}

?>
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
                <h1>Data Admin</h1>
                <hr class="soft">
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
                    <div class="form-group">
                        <label>Foto Admin</label>
                        <label for="file-input" class="form-upload form-control">
                            <?php $foto = $_SESSION['admin']['foto']; ?>
                            <img src="Image/foto_admin/<?php echo $foto; ?>" alt="" id="displayGambar">
                        </label>
                        <input type="file" name="foto" onchange="displayImage(this)" id="file-input">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Nama Depan</label>
                                <input name="nama_depan" type="text" class="form-control" id="" value="<?php echo $_SESSION['admin']['first_name']; ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Nama Belakang</label>
                                <input name="nama_belakang" type="text" class="form-control" id="" value="<?php echo $_SESSION['admin']['last_name']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Lengkap</label>
                        <input name="nama_lengkap" type="text" class="form-control" id="" value="<?php echo $_SESSION['admin']['full_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" id="" value="<?php echo $_SESSION['admin']['email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Telepon</label>
                        <input name="telepon" type="text" class="form-control" id="" value="<?php echo $_SESSION['admin']['telepon']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input name="alamat" type="text" class="form-control" id="" value="<?php echo $_SESSION['admin']['alamat']; ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <button name="proses" type="submit" class="btn btn-success form-control">SIMPAN</button>
                    </div>
                </div>
            </form>

            <!-- table data admin -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <hr class="soft">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3>Data Karyawan</h3>
                <hr class="soft">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <a href="index.php?halaman=tambah_admin" class="btn btn-info">Tambah Data</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <form class="navbar-form navbar-right" action="" method="POST" role="search">
                    <div class="input-group">
                        <input type="text" name="cariadmin" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="caribtn">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Karyawan</th>
                                <th>Nama Karyawan</th>
                                <th>Email</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST["caribtn"])) {
                                $hasilcari = $_POST["cariadmin"];
                                $sql = $koneksi->query("SELECT * FROM admin WHERE full_name LIKE '%$hasilcari%'");
                            } else {
                                $sql = $koneksi->query("SELECT * FROM admin");
                            }
                            ?>
                            <?php while ($admin = $sql->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $admin["id_admin"];  ?></td>
                                    <td><?php echo $admin["full_name"]; ?></td>
                                    <td><?php echo $admin["email"]; ?></td>
                                    <td><?php echo $admin["alamat"]; ?></td>
                                </tr>
                                <!-- mengakhiri perulangan while serta memberikan increment atau penambahan pada variable $nomor -->
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <script src="dist/js/form_upload.js"></script>
</body>

</html>