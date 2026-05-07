<?php
session_start();
include('connection.php');
include('kawalan-admin.php');

# semak data GET
if (!empty($_GET['nokp'])) {

    $nokp = mysqli_real_escape_string($condb, $_GET['nokp']);

    # =========================
    # 1. PADAM DATA ANAK (undian)
    # =========================
    $sql1 = "DELETE FROM undian WHERE nokp='$nokp'";
    mysqli_query($condb, $sql1);

    # =========================
    # 2. PADAM DATA PARENT (pengguna)
    # =========================
    $sql2 = "DELETE FROM pengguna WHERE nokp='$nokp'";

    if (mysqli_query($condb, $sql2)) {

        echo "<script>
            alert('Padam data berjaya');
            window.location.href='pengguna-senarai.php';
        </script>";

    } else {

        echo "<script>
            alert('Padam data gagal: ".mysqli_error($condb)."');
            window.location.href='pengguna-senarai.php';
        </script>";
    }

} else {

    echo "<script>
        alert('Ralat! Akses tidak dibenarkan');
        window.location.href='pengguna-senarai.php';
    </script>";
}
?>