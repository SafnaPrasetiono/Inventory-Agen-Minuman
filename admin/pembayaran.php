<?php

if (isset($_GET['id'])) {
    $ambil_id = $_GET['id'];

    $sql = $koneksi->query("SELECT * FROM pembayaran WHERE id_pembelian='$ambil_id'");
    $ambil = $sql->fetch_assoc();

    $sql2 = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$ambil_id'");
    $pembelian = $sql2->fetch_assoc();
}

if (isset($_POST['proses'])) {

    if ($pembelian['metode_pembelian'] == "BANK") {
        $no_resi = $_POST['resi'];
        $status = $_POST['status'];

        $koneksi->query("UPDATE pembelian SET resi_pengiriman='$no_resi', status_pembelian='$status' WHERE id_pembelian='$ambil_id'");
        echo "<script>alert('Data Pembelian Terupdate');</script>";
        echo "<script>location= 'index.php?halaman=home';</script>";
    } elseif ($pembelian['metode_pembelian'] == "COD") {
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
                    $bukti = str_shuffle(date('YmdHis')) . $foto;
                    move_uploaded_file($file_tmp, '../image/pembayaran/' . $bukti);
                    $simpan = $koneksi->query("INSERT INTO pembayaran VALUES('','$ambil_id','$nama_penyetor','$bank','$harga','$tanggal','$bukti')");
                    if ($simpan) {
                        $koneksi->query("UPDATE pembelian SET status_pembelian='selesai' WHERE id_pembelian='$ambil_id'");
                        echo "<script>alert('PEMBAYARAN BERHASIL');</script>";
                        echo "<script>location = 'index.php?set=profile_user';</script>";
                    } else {
                        echo "<script>alert('KONEKSI BURUK COBA LAGI NANTI');</script>";
                        echo "<script>location = 'index.php?set=profile_user';</script>";
                    }
                } else {
                    echo "<script>alert('UKURAN FILE FOTO TERLALU BESAR');</script>";
                }
            } else {
                echo "<script>alert('FILE BUKAN FOTO PILIH PNG ATAU JPG');</script>";
            }
        } else {
            echo "<script>alert('MASUKAN BUKTI PEMBAYARAN');</script>";
        }
    }
}

?>

<head>
    <link rel="stylesheet" href="dist/css/form_upload.css">
</head>

<body>
    <div class="container-fluid">
        <br clear="clr">
        <div class="row">
            <form action="" method="POST" role="form" enctype="multipart/form-data">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2>Pembayaran</h2>
                    <hr class="soft">
                </div>

                <?php if ($pembelian['metode_pembelian'] == "BANK") : ?>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            <label for="">Penyetor</label>
                            <input type="text" class="form-control" id="" name="nama" value="<?php echo $ambil['penyetor']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Bank</label>
                            <input type="text" class="form-control" id="" name="bank" value="<?php echo $ambil['bank']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="text" class="form-control" id="" name="jumlah" value="Rp. <?php echo number_format($ambil['harga']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" id="" name="jumlah" value="<?php echo $ambil['tanggal']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Bukti Pembayaran</label>
                            <div class="bukti-pembayaran">
                                <img src="../image/pembayaran/<?php echo $ambil['bukti_pembayaran']; ?>" id="displayGambar" class="img-rounded img-responsive">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php if ($pembelian['resi_pengiriman'] !== "") : ?>
                            <div class="form-group">
                                <label for="">Input Resi Pengiriman</label>
                                <input type="text" class="form-control" name="resi" value="<?php echo $pembelian['resi_pengiriman']; ?>" readonly>
                            </div>
                        <?php else : ?>
                            <div class="form-group">
                                <label for="">Input Resi Pengiriman</label>
                                <input type="text" class="form-control" name="resi">
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="">Ubah Status</label>
                            <select name="status" id="jenibrg" class="form-control" required>
                                <option value="barang dikirim">Barang Dikirim</option>
                                <option value="selesai">Selesai</option>
                                <option value="Batal">Batal</option>
                            </select>
                        </div>
                    </div>
                <?php elseif ($pembelian['metode_pembelian'] == "COD") : ?>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            <label for="">Penyetor</label>
                            <input type="text" class="form-control" id="" name="nama" value="" require>
                        </div>
                        <div class="form-group">
                            <label for="">Bank</label>
                            <input type="text" class="form-control" id="" name="bank" value="<?php echo $pembelian['metode_pembelian']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="number" class="form-control" id="" name="jumlah" value="<?php echo $pembelian['total_pembelian']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Upload Bukti Pembayaran</label>
                            <label for="file-input" class="form-upload form-control">
                                <img src="../image/form_upload/upload_tunai.png" id="displayGambar" class="img-rounded img-responsive">
                            </label>
                            <p class="text-danger">Maximum upload 2MB</p>
                            <input type="file" name="foto" onchange="displayImage(this)" id="file-input">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="submit" name="proses" class="btn btn-primary btn-lg btn-block">PROSES</button>
                </div>

            </form>
        </div>
        <br clear="clr"><br clear="clr"><br clear="clr">
    </div>

    <!-- java skrip form-upload -->
    <script src="dist/js/form_upload.js"></script>
</body>