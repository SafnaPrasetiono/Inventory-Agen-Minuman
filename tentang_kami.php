<head>
    <title>AgentDrink</title>
    <link rel="stylesheet" type="text/css" href="dist/css/home.css">
    <link rel="stylesheet" type="text/css" href="dist/css/tentang_kami.css">
</head>

<body>
    <!-- slide show tentang minuman terbaik atau terjual -->
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="image/Toko/Gambar_toko_1.png" class="img-responsive">
                <div class="carousel-caption">
                    <h3>AgentDrink</h3>
                    <p>Agent Penjual Miniman Terbaik di Indonesia</p>
                </div>
            </div>
            <div class="item">
                <img src="image/Toko/Gambar_toko_2.png" class="img-responsive">
                <div class="carousel-caption">
                    <h3>AgentDrink</h3>
                    <p>Agent Penjual Miniman Terbaik di Indonesia</p>
                </div>
            </div>
            <div class="item">
                <img src="image/Toko/Gambar_toko_3.png" class="img-responsive">
                <div class="carousel-caption">
                    <h3>AgentDrink</h3>
                    <p>Agent Penjual Miniman Terbaik di Indonesia</p>
                </div>
            </div>
        </div>
        <!-- Controls atau button slide-->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- akhir div slide barang -->
    <div class="box-rekomen">
        <div class="container">
            <h3 class="text-center"><b>TENTANG KAMI</b></h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="box-foto">
                <?php for ($i = 1; $i <= 6; $i++) : ?>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                    <div class="thumbnail">
                        <img src="image/Toko/Gambar_toko_<?php echo $i; ?>.png" alt="">
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <hr class="soft">
        <div class="plain-text">
            <label class="lead">AgentDrink</label>
            <p class="lead text-justify">
                Perusahaan AgentDrink berdiri sejak tahun 2006 yang merupakan perusahaan distributor penjulan berbagai macam
                produk minuman ke para pengecer maupun konsumen. Sejak didirikannya perusahaan ini sampai tahun 2010, perusahaan
                ini belum dikenal oleh para pembelinnya dikarnakan teknik pemasarannya yang hanya menggunakan banner atau pun
                dari mulut ke-mulut. namun pada tahun 2012 perusahaan AgentDrink sudah berkembang dan di kenal banyak pembeli
                di daerah sekitarnnya. Hingga pada saat ini AgentDrink akan mengembangkan prusahaanya melalui belanja online untuk
                mempermudah para pelanggannya atau para pembelinnya.
            </p>
            <label class="lead">AgentDrink - Toko Penjualan Minuman Terbaik di Indonesia</label>
            <p class="lead text-justify">
                Dengan berkembanya teknologi secara global, dapat memberikan kemudahan bagi masyarakat sehingga banyak
                hal yang bisa dilakukan secara praktis. Kini anda tidak perlu repot - repot untuk datang ke-toko dalam
                mencari produk minuman, anda tidak perlu untuk menghabiskan banyak biaya dan tenaga dalam
                berbelanja produk minuman. Hanya dengan menggunakan perakat elektronik yang terhubung dengan internet
                anda dapat berbelanja produk minuman secara online, hanya di AgentDrink. Kini AgentDrink menyediakan tempat
                berbelanja online yang aman dan terjamin sehingga anda tidak perlu khwatir untuk berbelanja di AgentDrink.
                belanja cepat hanya di AgentDrink sekali klik barang sampai tujuan.
            </p>
        </div>
        <hr class="soft">

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <h4><b>Jam Kerja Perusahaan</b></h4>
                <i class="fa fa-clock-o fa-5x pull-left location" aria-hidden="true"></i>
                <p>
                    Senin - Jumat <br>
                    8:00 AM – 7:00 PM <br><br>
                    Sabtu - Minggu <br>
                    8:00 AM – 5:00 PM<br>
                </p>
                <br class="clr">
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <h4><b>Pemilik Perusahaan</b></h4>
                <i class="fa fa-user fa-5x pull-left location" aria-hidden="true"></i>
                <p>
                    Nama Pemilik <br>
                    <b>Dila Safitri</b><br><br>
                    Pembuat Website <br>
                    <b>Safna Prasetiono</b> <br>
                </p>
                <br class="clr">
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <h4><b>Alamat Perusahaan</b></h4>
                <i class="fa fa-map-marker fa-5x pull-left location" aria-hidden="true"></i>
                <p>
                    Jl. Cemp. Putih Tengah No.40 <br>
                    RT.1/RW.8, Cemp. Putih Tim. <br>
                    Kec. Cemp. Putih <br>
                    Kota Jakarta Pusat <br>
                    Daerah Khusus Ibukota Jakarta 10510 <br>
                </p>
                <br class="clr">
            </div>
        </div>

        <br clear="clr"><br clear="clr"><br clear="clr">
    </div>
</body>