<?php
session_start();
include('kawalan-admin.php');
include('connection.php');

// Dapatkan data calon
$id_calon = $_GET['id_calon'];
$result = mysqli_query($condb, "SELECT * FROM calon WHERE id_calon='$id_calon'");
$calon = mysqli_fetch_assoc($result);
?>

<link rel="stylesheet" href="style_calon_kemaskini.css">

<div class="page-title">
    KEMASKINI CALON
</div>

<div class="form-container">

<form class="edit-form"
      action="calon-kemaskini-proses.php"
      method="POST">

    <input type="hidden" name="id_calon" value="<?= $calon['id_calon'] ?>">

    <label>Nama Calon</label>
    <input type="text"
           name="name_calon"
           value="<?= $calon['nama_calon'] ?>"
           required>

    <label>Gambar Semasa</label>

    <div class="image-box">
        <?php if (!empty($calon['gambar'])): ?>
            <img src="<?= $calon['gambar'] ?>" alt="Gambar Calon">
        <?php else: ?>
            <p>Tiada gambar</p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn-save">
        Kemaskini
    </button>

    <a class="btn-cancel" href="calon-senarai.php">
        Batal
    </a>

</form>

</div>