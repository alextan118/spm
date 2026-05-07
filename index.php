<?php
session_start();

include ("header.php");
include ("connection.php");

// Query undian mengikut jawatan dengan ORDER BY idjawatan
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
ORDER BY j.idjawatan, jumlah_undian DESC"; // Perubahan di sini - ORDER BY idjawatan dahulu

$result_jawatan = mysqli_query($condb, $query_jawatan);

if (!$result_jawatan) {
    die("SQL Error: " . mysqli_error($condb));
}

// Susun data undian mengikut idjawatan
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

// Urutkan array berdasarkan idjawatan (jika perlu)
ksort($undian_jawatan);
?>

<table width="100%">
    <tr>
        <td width="70%" bgcolor=" #D8C4B8" align="center">
            <img src="banner.jpg" style="width:50%; max-width:400px;">
        </td>
        <td align="center" bgcolor=" #D8C4B8">
            <h3>Daftar Sebagai Pengundi</h3>
            <h3>Klik Pautan Dibawah</h3>
            <a href="login-borang.php">Log Masuk</a><br>
            <a href="signup.php">Daftar Pengguna Baharu</a>
        </td>
    </tr>
</table>

<!-- Paparan Undian Mengikut Jawatan -->
<div style="padding: 20px; background-color: #f5f5f5; margin-top: 20px;">
    <h2 style="text-align: center; color: #2c3e50;">UNDIAN SEMASA MENGIKUT JAWATAN</h2>

    <?php foreach ($undian_jawatan as $idjawatan => $data_jawatan): ?>
        <div style="margin-bottom: 30px; background-color: white; padding: 15px;
                border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3 style="color: #31708f; border-bottom: 2px solid
                    #D8C4B8; padding-bottom: 5px;">
                <?= $data_jawatan['nama_jawatan'] ?>
            </h3>

            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px;">
                <?php foreach ($data_jawatan['calon'] as $undian): ?>
                    <div style="flex: 1; min-width: 200px; background-color: #f9f9f9;
                            padding: 10px; border-radius: 5px; border-left: 4px solid #D8C4B8;">
                        <div style="display: flex; align-items: center;">
                            <img src="<?= $undian['gambar'] ?>"
                                alt="<?= $undian['nama_calon'] ?>" 
                                style="width: 60px; height: 75px;  object-fit: cover;
                                       border-radius: 5px; margin-right: 10px;">
                            <div>
                                <h4 style="margin: 0;"><?= $undian['nama_calon'] ?></h4>
                                <p style="margin: 5px 0; color: #e74c3c; font-weight: bold;">
                                    Undian: <?= $undian['jumlah_undian'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include ("footer.php"); ?>
