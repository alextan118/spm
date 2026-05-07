<?php
session_start();
include('kawalan-admin.php');
include('connection.php');
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_calon = $_POST['id_calon'];
    $nama = $_POST['nama_calon'];

    $nama_gambar = $_FILES['gambar']['name'];
    $sementara = $_FILES['gambar']['tmp_name'];
    $lokasi = 'gambar/' . basename($nama_gambar);

    if (move_uploaded_file($sementara, $lokasi)) {
        $query = "INSERT INTO calon (id_calon, nama_calon, gambar)
                  VALUES ('$id_calon', '$nama', '$lokasi')";

        if (mysqli_query($condb, $query)) {
            echo "<script>alert('Pendaftaran berjaya!');
            window.location.href='calon-senarai.php';</script>";
        } else {
            if (mysqli_errno($condb) == 1062) {
                echo "<script>alert('ID calon sudah wujud. Guna ID lain.');</script>";
            } else {
                echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Gagal muat naik gambar.');</script>";
    }
}
?>

<link rel="stylesheet" href="style_calon_daftar.css">

<div class="page-title">
    DAFTAR CALON PERTANDINGAN
</div>

<div class="form-container">

<form class="register-form"
      action=""
      method="POST"
      enctype="multipart/form-data">

    <label>ID Calon</label>
    <input type="text" name="id_calon" required>

    <label>Nama Calon</label>
    <input type="text" name="nama_calon" required>

    <label>Muat Naik Gambar</label>
    <input type="file" name="gambar" accept="image/*" required>

    <button type="submit" class="btn-submit">
        DAFTAR
    </button>

</form>

</div>