<?php
require '../koneksiDB/koneksi.php';

if (isset($_GET['id'])) {

    $nomor = 1;
    $subtotal = 0;

    // mengambil id untuk detail nota
    $ambil_id = $_GET["id"];
    $simpan = $koneksi->query("UPDATE pembelian SET status_pembelian='barang dikirim', resi_pengiriman='-' WHERE id_pembelian='$ambil_id'");
    if ($simpan) {
        // membuat query dengan join antara pembelian dan user
        $sql = $koneksi->query("SELECT * FROM pembelian JOIN user ON 
                    pembelian.id_user = user.id_user WHERE 
                    pembelian.id_pembelian ='$ambil_id'");

        // data di pecan dalam bentuk array
        $detail = $sql->fetch_assoc();
    } else {
        echo "<script>alert('PRINT GAGAL, TIDAK DAPAT MEMPROSES');</script>";
        exit();
    }
} else {
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Font-Awesome/css/font-awesome.min.css">
</head>

<body>
    <div class="">
        <div class="row">
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <hr class="soft">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <img src="../image/Icon_AgentDrink_MainMenu.png" class="img-responsive">
                    </div>
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="text-right">
                            <h3 style="margin-top: 8px;">
                                <b><?php echo strtoupper($detail["username"]); ?></b>
                            </h3>
                            <p><b>Tanggal Pembelian</b><br><?php echo $detail["tgl_pembelian"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <hr class="soft">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="text-center">
                            <p><b>No Pembelian</b><br><?php echo $detail["id_pembelian"]; ?></p>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="text-left">
                            <p><b>Kota</b><br><?php echo $detail["kota_pembelian"]; ?></p>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="text-left">
                            <p><b>Alamat Pengiriman</b><br><?php echo $detail["alamat_pembelian"]; ?></p>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="text-right text-danger">
                            <h3 style="margin-top : 8px;">
                                <b>Total : Rp. <?php echo number_format($detail["total_pembelian"]); ?></b>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <hr class="soft">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA BARANG</th>
                                <th>HARGA</th>
                                <th>JUMLAH</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ambil_barang = $koneksi->query("SELECT * FROM pembelian_barang WHERE id_pembelian='$ambil_id'"); ?>
                            <?php while ($detail_brg = $ambil_barang->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $nomor ?></td>
                                    <td><?php echo $detail_brg["nama_barang"]; ?></td>
                                    <td>Rp. <?php echo number_format($detail_brg["harga_barang"]); ?></td>
                                    <td><?php echo $detail_brg["jumlah"]; ?></td>
                                    <td>Rp. <?php echo number_format($detail_brg["total_harga"]); ?></td>
                                </tr>
                                <?php
                                $subtotal += $detail_brg['total_harga'];
                                $nomor++;
                            endwhile;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Sub Total</th>
                                <th>Rp. <?php echo number_format($subtotal); ?></th>
                            </tr>
                            <tr>
                                <th colspan="4">Harga Ongkos Kirim</th>
                                <th>Rp. <?php echo number_format($detail['harga_ongkir']); ?></th>
                            </tr>
                            <tr>
                                <?php $grandtotal = $subtotal + $detail['harga_ongkir']; ?>
                                <th colspan="4">Grand Total</th>
                                <th>Rp. <?php echo number_format($grandtotal); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <hr class="soft">
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                <div class="alert alert-warning">
                    <strong>Infomari Barang</strong>
                    <ol>
                        <li>
                            Barang yang sudah dibeli dapat dikembalikan selama satu hari pengiriman barang,
                            jika lebih dari satu hari maka barang tidak dapat dikembalikan
                        </li>
                        <li>
                            Info lebih lengkap baca syarat dan ketentuan berbelanja di www.AgentDrink.com
                        </li>
                    </ol>
                </div>
            </div>
            <br class="clr"><br class="clr">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Pengirim</th>
                            <th class="text-center">Penerima</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <br class="clr"><br class="clr">
                                <br class="clr"><br class="clr">
                            </td>
                            <td>
                                <br class="clr"><br class="clr">
                                <br class="clr"><br class="clr">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <hr class="soft">
            </div>
            


        </div>
    </div>

    <script src="My-Control/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>