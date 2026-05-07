<?php
session_start();

include ("header.php");
include ("connection.php");

$query_jawatan = "
SELECT
    j.idjawatan,
    j.nama_jawatan,
    c.id_calon,
    c.nama_calon,
    c.gambar,
    COUNT(u.id_undi) AS jumlah_undian
FROM undian u
JOIN jawatan j ON u.idjawatan = j.idjawatan
JOIN calon c ON u.id_calon = c.id_calon
GROUP BY j.idjawatan, j.nama_jawatan, c.id_calon, c.nama_calon, c.gambar
ORDER BY j.idjawatan, jumlah_undian DESC";

$result_jawatan = mysqli_query($condb, $query_jawatan);

if (!$result_jawatan) {
    die("SQL Error: " . mysqli_error($condb));
}

$undian_jawatan = [];
while ($row = mysqli_fetch_assoc($result_jawatan)) {
    $idjawatan = $row['idjawatan'];

    if (!isset($undian_jawatan[$idjawatan])) {
        $undian_jawatan[$idjawatan] = [
            'nama_jawatan' => $row['nama_jawatan'],
            'calon' => []
        ];
    }

    $undian_jawatan[$idjawatan]['calon'][] = $row;
}

ksort($undian_jawatan);
?>

<link rel="stylesheet" href="style.css">

<!-- HERO -->
<div class="hero">
    <div class="hero-left">
        <img src="banner.jpg" class="banner-img">
    </div>

    <div class="hero-right">
        <h3>Daftar Sebagai Pengundi</h3>
        <p>Klik pautan di bawah</p>
        <a href="login-borang.php" class="btn">Log Masuk</a>
        <a href="signup.php" class="btn-outline">Daftar Pengguna Baharu</a>
    </div>
</div>

<!-- UNDIAN -->
<div class="container">
    <h2 class="title">UNDIAN SEMASA MENGIKUT JAWATAN</h2>

    <?php foreach ($undian_jawatan as $idjawatan => $data_jawatan): ?>
        <div class="card">
            <h3 class="card-title">
                <?= $data_jawatan['nama_jawatan'] ?>
            </h3>

            <div class="calon-grid">
                <?php foreach ($data_jawatan['calon'] as $undian): ?>
                    <div class="calon-card">
                        <img src="<?= $undian['gambar'] ?>" class="calon-img">

                        <div class="calon-info">
                            <h4><?= $undian['nama_calon'] ?></h4>
                            <p>Undian: <span><?= $undian['jumlah_undian'] ?></span></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include ("footer.php"); ?>