<?php
if (isset($_POST["insertbtn"])) {
    // mendeklarasiakan semua isi dari barang dalam variable baru
    $nama_barang = htmlspecialchars($_POST["namabrg"]);
    $jenis_barang = htmlspecialchars($_POST["jenisbrg"]);
    $jumlah_barang = htmlspecialchars($_POST["jumlahbrg"]);
    $harga_barang = htmlspecialchars($_POST["hargabrg"]);
    $article_barang = htmlspecialchars($_POST["articlebrg"]);

    //pendefinisian untuk upload foto atau upload data foto
    $namafoto = $_FILES['fotobrg']['name'];
    $errorfoto = $_FILES['fotobrg']['error'];
    $sizefoto = $_FILES['fotobrg']['size'];
    $datafoto = $_FILES['fotobrg']['tmp_name'];

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
                move_uploaded_file($datafoto, '../image/produk/' . $upload);
                // memasukan data baik itu data foto dan data ttg barang tsb
                $simpanbrg = $koneksi->query("INSERT INTO barang VALUES('',
                    '$nama_barang','$jenis_barang',
                    '$jumlah_barang','$harga_barang',
                    '$upload','0','$article_barang')");

                // memberitahukan bahwa data telah berhasil disimpan
                if ($simpanbrg) {
                    // memberitahukan bahwa data telah berhasil disimpan
                    echo "<script>alert('DATA BERHASIL DI SIMPAN');</script>";
                    echo "<script>location= 'index.php?halaman=data_barang';</script>";
                } else {
                    // memberitahukan bahwa data gagal di simpan
                    echo "<script>alert('DATABASES ERROR ULANGI LAGI NANTI!');</script>";
                    echo "<script>location= 'index.php';</script>";
                }
            } else {
                // apabila file lebih dari 100mb makan akan diberitahukan bahwa
                echo "<script>alert('FILE TERLALU BESAR');</script>";
            }
        } else {
            // juka gagal upload atau foto tida ada maka gagal upload
            echo "<script>alert('UPLOAD GAMBAR GAGAL');</script>";
        }
    } else {
        // apabila fil yang akhiranya bukan allowed maka file tidak
        // akan di eksekusi oleh sistem
        echo "<script>alert('FILE BUKAN GAMBAR ULANGI!');</script>";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>AgentDrink</title>
    <link rel="stylesheet" href="dist/css/form_upload.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Tambah Data Barang</h2>
                <hr class="soft">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <form method="post" enctype="multipart/form-data">

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="namabrg">Nama Barang</label>
                        <input type="text" class="form-control" name="namabrg" id="namabrg" required>
                    </div>
                    <div class="form-group">
                        <label for="jenisbrg">Jenis Barang</label>
                        <select name="jenisbrg" id="jenibrg" class="form-control" required>
                            <option value="mineral">Mineral</option>
                            <option value="susu">Susu</option>
                            <option value="kopi">Kopi</option>
                            <option value="soda">Soda</option>
                            <option value="buah">Buah</option>
                            <option value="teh">Teh</option>
                            <option value="isotonic">Isotonic</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlahbrg">Jumlah Barang</label>
                        <input type="text" class="form-control" name="jumlahbrg" id="jumlahbrg" required>
                    </div>
                    <div class="form-group">
                        <label for="hargabrg">Harga Barang</label>
                        <input type="text" class="form-control" name="hargabrg" id="hargabrg" required>
                    </div>
                </div>

                <!-- Foto -->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Foto Barang</label>
                        <label for="file-input" class="form-upload form-control">
                            <img src="Image/upload.png" alt="" id="displayGambar">
                        </label>
                        <input type="file" name="fotobrg" onchange="displayImage(this)" id="file-input" required>
                    </div>
                </div>

                <!-- deskripsi dan submit -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="articlebrg">Atricle Barang</label>
                        <textarea class="form-control" name="articlebrg" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success form-control" type="submit" name="insertbtn">SIMPAN</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script src="dist/js/form_upload.js"></script>
</body>

</html>