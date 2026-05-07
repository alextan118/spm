<?php
session_start();
error_reporting(0);

include('header.php');
include('connection.php');
include('kawalan-admin.php');
?>

<link rel="stylesheet" href="style_calon_senarai.css">

<h3 class="page-title">Senarai Calon</h3>

<table class="calon-table" align='center' width='70%' border='1' id='saiz'>

    <tr class="top-bar">
        <td colspan='2' align='right'>
            <form action='' method='POST' style='margin:0; padding:0;'>
                <input type='text' name='nama_calon' placeholder='Carian calon'>
                <input type='submit' value='Cari'>
            </form>
        </td>

        <td colspan='5' align='right'>
            | <a href='calon-daftar.php'>Daftar Calon Baru</a> |
            <?php include('butang-saiz.php'); ?>
        </td>
    </tr>

    <tr class="header-row">
        <td>ID Calon</td>
        <td>Nama Calon</td>
        <td>Gambar</td>
        <td>Tindakan</td>
    </tr>

<?php
$tambahan = "";
if(!empty($_POST['nama_calon'])) {
    $tambahan = "WHERE nama_calon LIKE '%".$_POST['nama_calon']."%'";
}

$arahan_papar = "SELECT * FROM calon $tambahan";
$laksana = mysqli_query($condb, $arahan_papar);

while($row = mysqli_fetch_array($laksana)) {
    echo "<tr class='data-row'>
        <td>{$row['id_calon']}</td>
        <td>{$row['nama_calon']}</td>
        <td class='gambar-cell'>
            <img src='{$row['gambar']}' alt='{$row['nama_calon']}'>
        </td>
        <td>

            | <a href='calon-padam.php?id_calon=".$row['id_calon']."' 
             onClick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">Hapus</a> |

            | <a href='calon-kemaskini-borang.php?id_calon=".$row['id_calon']."'>Kemaskini</a> |

        </td>
    </tr>";
}
?>

</table>

<?php include('footer.php'); ?>