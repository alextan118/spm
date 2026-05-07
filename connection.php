<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

#nama host.localhost = default
$servername = "localhost";
#username = default
$nama_sql="root";
#password = default
$pass_sql="";
#nama pangkalan data
$nama_db = "undi_ajk";
$condb = mysqli_connect($servername, $nama_sql, $pass_sql, $nama_db);

if(!$condb){
    die("Sambungan ke pangkalan data gagal" );
}
else{
    //echo "Sambungan ke pangkalan data berjaya";
}
?>
