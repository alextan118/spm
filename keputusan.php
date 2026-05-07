<?php
session_start();
include("header.php");
include("connection.php");
include("kawalan-admin.php");

if (isset($_POST['padam_semua'])) {

    $sql_padam = "DELETE FROM undian";

    if (mysqli_query($condb, $sql_padam)) {
        echo "<script>
                alert('Semua undian telah dipadam!');
                window.location.href='keputusan.php';
              </script>";
    } else {
        echo "<script>alert('Ralat: ".mysqli_error($condb)."');</script>";
    }
}

$query_pemenang = "
SELECT c.id_calon, c.nama_calon, c.gambar,
COUNT(u.id_undi) AS jumlah_undian
FROM undian u
JOIN calon c ON u.id_calon = c.id_calon
GROUP BY c.id_calon, c.nama_calon, c.gambar
ORDER BY jumlah_undian DESC
LIMIT 1
";

$result_pemenang = mysqli_query($condb, $query_pemenang);
$pemenang_keseluruhan = mysqli_fetch_assoc($result_pemenang);

$query_jawatan = "
SELECT j.idjawatan, j.nama_jawatan,
c.id_calon, c.nama_calon, c.gambar,
COUNT(u.id_undi) AS jumlah_undian
FROM undian u
JOIN jawatan j ON u.idjawatan = j.idjawatan
JOIN calon c ON u.id_calon = c.id_calon
GROUP BY j.idjawatan, j.nama_jawatan,
c.id_calon, c.nama_calon, c.gambar
ORDER BY j.nama_jawatan, jumlah_undian DESC
";

$result_jawatan = mysqli_query($condb, $query_jawatan);

$pemenang_jawatan = [];

while ($row = mysqli_fetch_assoc($result_jawatan)) {

    $jawatan = $row['nama_jawatan'];

    if (!isset($pemenang_jawatan[$jawatan]) ||
        $row['jumlah_undian'] > $pemenang_jawatan[$jawatan]['jumlah_undian']) {
        $pemenang_jawatan[$jawatan] = $row;
    }
}
?>

<link rel="stylesheet" href="style_keputusan.css">

<div class="page-title">
    KEPUTUSAN UNDIAN
</div>

<!-- ================= PEMENANG KESELURUHAN ================= -->
<div class="section-card">

<h2 class="section-title">PEMENANG KESELURUHAN</h2>

<?php if ($pemenang_keseluruhan): ?>

<div class="winner-box">

    <img src="<?= $pemenang_keseluruhan['gambar'] ?>">

    <div class="winner-info">
        <h3><?= $pemenang_keseluruhan['nama_calon'] ?></h3>
        <p>Jumlah Undian: <b><?= $pemenang_keseluruhan['jumlah_undian'] ?></b></p>
    </div>

</div>

<?php else: ?>
<p class="empty">Tiada data pemenang keseluruhan.</p>
<?php endif; ?>

</div>

<!-- ================= PEMENANG JAWATAN ================= -->
<div class="section-card">

<h2 class="section-title">PEMENANG MENGIKUT JAWATAN</h2>

<?php foreach ($pemenang_jawatan as $jawatan => $pemenang): ?>

<div class="jawatan-box">

    <div class="jawatan-title">
        <?= $jawatan ?>
    </div>

    <div class="jawatan-content">

        <img src="<?= $pemenang['gambar'] ?>">

        <div>
            <h4><?= $pemenang['nama_calon'] ?></h4>
            <p>Undian: <b><?= $pemenang['jumlah_undian'] ?></b></p>
        </div>

    </div>

</div>

<?php endforeach; ?>

</div>

<!-- ================= ADMIN BUTTON ================= -->
<?php if ($_SESSION['tahap'] == "ADMIN"): ?>

<div class="admin-panel">

<form method="POST"
onsubmit="return confirm('Padam semua undian?');">

<button type="submit" name="padam_semua" class="danger-btn">
Padam Semua Undian
</button>

</form>

<button onclick="window.print()" class="print-btn">
Cetak Laporan
</button>

</div>

<?php endif; ?>

<?php include("footer.php"); ?>