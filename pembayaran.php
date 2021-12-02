<?php
// pembayaran pelangan yang bersangkutan yang bisa akses halaman ini
if (!isset($_SESSION['user']) or empty($_SESSION['user'])) {
    header("Location: index.php?set=profile_user");
} else {
    $id_user = $_SESSION['user']['id_user'];
}

if (isset($_GET['id'])) {
    $ambil_id = $_GET['id'];

    $sql = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$ambil_id'");
    $ambil = $sql->fetch_assoc();
    // ambil id pelanggan di table pembelian
    $id_pelanggan = $ambil['id_user'];

    // memastikan bahwa pembayaran punya user yang bersangkutan
    if ($id_user != $id_pelanggan) {
        echo "
            <script>location= 'index.php?set=profile_user';</script>
            ";
    }
}

?>

<head>
    <link rel="stylesheet" type="text/css" href="dist/css/pembayaran.css">
</head>

<body>
    <div class="container">
        <br clear="clr">
        <div class="row">
            <form method="POST" enctype="multipart/form-data">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2>Pembayaran</h2>
                    <hr class="soft">
                </div>

                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="alert alert-warning">
                        <label for="">Harga Pembayaran</label>
                        <p>Total Pembayaran Sebesar Rp. <b><?php echo number_format($ambil['total_pembelian']); ?></b> </p>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Penyetor</label>
                        <input type="text" class="form-control" id="" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="">Bank</label>
                        <input type="text" class="form-control" id="" name="bank">
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" id="" name="jumlah">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>Upload Bukti Pembayaran</label>
                        <label for="file-input" class="form-upload form-control">
                            <img src="image/form_upload/upload_tunai.png" id="displayGambar" class="img-rounded img-responsive">
                        </label>
                        <p class="text-danger">Maximum upload 2MB</p>
                        <input type="file" name="foto" onchange="displayImage(this)" id="file-input">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <br class="clr"><br class="clr">
                    <button type="submit" name="bayar" class="btn btn-primary btn-lg btn-block">PROSES</button>
                </div>

            </form>
        </div>
        <br clear="clr"><br clear="clr"><br clear="clr">
    </div>

    <!-- java skrip form-upload -->
    <script type="text/javascript" src="dist/js/form_upload.js"></script>
</body>

<?php
if (isset($_POST['bayar'])) {
    $nama_penyetor = htmlspecialchars($_POST['nama']);
    $bank = $_POST['bank'];
    $harga = $_POST['jumlah'];
    $tanggal = date('Y-m-d');
    $foto = $_FILES['foto']['name'];

    if ($foto !== "") {
        // upload foto
        $ekstensi_diperbolehkan = array('jpg', 'png');
        $x = explode('.', $foto);
        $ekstensi = strtolower(end($x));
        $ukuran    = $_FILES['foto']['size'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 2097152) {
                // nama foto di gabungkan concat dengan tanggal
                $bukti = date('YmdHis') . $foto;
                move_uploaded_file($file_tmp, 'image/pembayaran/'.$bukti);
                $simpan = $koneksi->query("INSERT INTO pembayaran VALUES('','$ambil_id','$nama_penyetor','$bank','$harga','$tanggal','$bukti')");
                if ($simpan) {
                    $koneksi->query("UPDATE pembelian SET status_pembelian='sudah bayar' WHERE id_pembelian='$ambil_id'");
                    echo "<script>alert('PEMBAYARAN BERHASIL');</script>";
                    echo "<script>location = 'index.php?set=profile_user';</script>";
                } else {
                    echo "<script>alert('PEMBAYARAN GAGAL ULANGI!');</script>";
                    echo "<script>location = 'index.php?set=profile_user';</script>";
                }
            } else {
                echo "<script>alert('UKURAN FILE FOTO TERLALU BESAR');</script>";
            }
        } else {
            echo "<script>alert('FILE BUKAN FOTO PILIH PNG ATAU JPG');</script>";
        }
    }else{
        echo "<script>alert('MASUKAN BUKTI PEMBAYARAN');</script>";
    }
}

?>