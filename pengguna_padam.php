<?php
session_start();
include('kawalan-admin.php');

#menyemak kewujudan data get nokp ahli
if(!empty($_GET)){
    #memanggil fail connection.php
    include('connection.php');

    #arahan sql untuk memadamkan ahli mengikut nokp yang dihantar
    $arahan = "delete from pengguna where nokp ='".$_GET['nokp']."'";

    #melaksanakan arahan sql padam data dan emguji proses padam data
    if(mysqli_query($condb,$arahan)){
        #jika data berjaya dipadam
        echo "<script> alert('Padam data berjaya');
        window.location.href = 'pengguna-senarai.php';</script>";
    }else{
        #jika data gagal dipadam
        echo "<script> alert('Padam data gagal');
        window.location.href = 'pengguna-senarai.php';</script>";
    }
}else{
    #jika data get tidak wujud
    die("<script> alert('Ralat! Akses secara terus');
    window.location.href = 'pengguna-senarai.php';</script>");
}
?>
