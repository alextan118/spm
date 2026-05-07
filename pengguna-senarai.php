<?php
session_start();

include('header.php');
include('connection.php');
include('kawalan-admin.php');

if (!isset($condb)) {
    die("Kesalahan sambungan ke pangkalan data.");
}
?>

<link rel="stylesheet" href="style_senarai_pengguna.css">

<div class="page-title">
    SENARAI PENGGUNA
</div>

<div class="table-container">

<table class="user-table">

<!-- SEARCH -->
<tr class="top-bar">
    <td colspan="5">
        <form method="POST" class="search-form">
            <input type="text" name="nama" placeholder="Cari Nama Pengguna">
            <button type="submit">Cari</button>
        </form>
    </td>
</tr>

<!-- ACTION BAR -->
<tr class="action-bar">
    <td colspan="5">
        <a class="link-btn" href="upload.php">Muat Naik Pengguna</a>
        <?php include('butang-saiz.php'); ?>
    </td>
</tr>

<!-- HEADER -->
<tr class="table-header">
    <th>Nama</th>
    <th>No KP</th>
    <th>Katalaluan</th>
    <th>Tahap</th>
    <th>Tindakan</th>
</tr>

<?php
$tambahan = "";
if (!empty($_POST['nama'])) {
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);
    $tambahan = " WHERE pengguna.nama LIKE '%$nama%'";
}

$arahan_papar = "SELECT * FROM pengguna $tambahan";
$laksana = mysqli_query($condb, $arahan_papar);

while ($m = mysqli_fetch_array($laksana)) {
    echo "<tr class='data-row'>
        <td>".htmlspecialchars($m['nama'])."</td>
        <td>".htmlspecialchars($m['nokp'])."</td>
        <td>".htmlspecialchars($m['katalaluan'])."</td>
        <td>".htmlspecialchars($m['tahap'])."</td>
        <td>
            <a class='delete-btn'
            href='pengguna_padam.php?nokp=".urlencode($m['nokp'])."'
            onclick=\"return confirm('Anda pasti ingin memadam?')\">
            Hapus
            </a>
        </td>
    </tr>";
}
?>

</table>
</div>

<?php include('footer.php'); ?>