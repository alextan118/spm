<?php
session_start();
include("header.php");
include("connection.php");
include("kawalan-admin.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_jawatan = mysqli_real_escape_string($condb, $_POST['nama_jawatan']);

    $result = mysqli_query($condb, "SELECT MAX(idjawatan) AS max_id FROM jawatan");
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];

    if ($max_id) {
        $num = (int) substr($max_id, 1) + 1;
        $next_id = 'K' . $num;
    } else {
        $next_id = 'K1';
    }

    $sql = "INSERT INTO jawatan(idjawatan, nama_jawatan)
            VALUES ('$next_id', '$nama_jawatan')";

    if (mysqli_query($condb, $sql)) {
        echo "<script>alert('Jawatan berjaya didaftarkan');</script>";
    } else {
        echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
    }
}

$jawatan = mysqli_query($condb, "SELECT * FROM jawatan ORDER BY idjawatan");
?>

<link rel="stylesheet" href="style_jawatan_daftar.css">

<div class="page-title">
    BORANG DAFTAR JAWATAN
</div>

<div class="form-container">

<form class="form-box" method="POST" action="">

    <label>Nama Jawatan</label>

    <input type="text"
           name="nama_jawatan"
           required>

    <button type="submit">
        Daftar Jawatan
    </button>

</form>

</div>

<div class="table-title">
    SENARAI JAWATAN
</div>

<table class="jawatan-table" width="100%">

    <tr class="header-row">
        <th>ID Jawatan</th>
        <th>Nama Jawatan</th>
        <th>Tindakan</th>
    </tr>

<?php
if (mysqli_num_rows($jawatan) > 0) {
    while ($row = mysqli_fetch_assoc($jawatan)) {
        echo "<tr class='data-row'>";
        echo "<td>".$row['idjawatan']."</td>";
        echo "<td>".$row['nama_jawatan']."</td>";
        echo "<td>
            <a class='edit-btn'
               href='jawatan-kemaskini.php?id=".$row['idjawatan']."'>
               Kemaskini
            </a> |

            <a class='delete-btn'
               href='jawatan-padam.php?id=".$row['idjawatan']."'
               onclick='return confirm(\"Anda pasti?\")'>
               Padam
            </a>
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>Tiada jawatan</td></tr>";
}
?>

</table>