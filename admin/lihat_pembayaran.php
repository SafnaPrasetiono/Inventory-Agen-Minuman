<?php

if (isset($_GET['id'])) {
    $ambil_id = $_GET['id'];

    $sql = $koneksi->query("SELECT * FROM pembayaran WHERE id_pembelian='$ambil_id'");
    $ambil = $sql->fetch_assoc();
}

?>

<head>
    <link rel="stylesheet" href="dist/css/form_upload.css">
</head>

<body>
    <div class="container-fluid main-page">
        <br clear="clr">
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2>Bukti Pembayaran</h2>
                <hr class="soft">
            </div>

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
        </div>
    </div>

    <!-- java skrip form-upload -->
    <script src="My-Control/js/form_upload.js"></script>
</body>