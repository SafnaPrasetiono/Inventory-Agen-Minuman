<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "agentdrink";

    $koneksi = mysqli_connect($host, $username, $password, $database);
    if (!$koneksi) {
        echo "<h2 style='display:block; color:red; top:50%; left:50%;
        transform:translate(-50%, -50%);position:absolute;
        text-align:center; padding:20px;
        border: 4px solid red; font-family:tahoma;'>
        WEBSITE TIDAK DAPAT DI BUKA DATABASE ERROR<br>ULANGI LAGI NANTI !!!
        </h2>";
        exit();
    }
?>