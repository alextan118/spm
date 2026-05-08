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

        <!-- ================= FONT TOOL ================= -->
        <style>
        .size-tool {
            display: inline-block;
            margin-left: 10px;
        }

        .size-tool button {
            padding: 6px 12px;
            margin: 0 3px;

            border: none;
            border-radius: 8px;

            cursor: pointer;

            background: linear-gradient(135deg, #fbbf24, #f97316);
            color: #000;

            font-weight: bold;

            transition: 0.2s;
        }

        .size-tool button:hover {
            transform: translateY(-2px);
        }
        </style>

        <script>
        /* =========================
           TABLE FONT CONTROL (SAFE)
        ========================= */

        function ubahsaiz(type){

            let table = document.querySelector(".user-table");

            if(!table){
                alert("Table tidak dijumpai");
                return;
            }

            let current = window.getComputedStyle(table).fontSize;
            let size = parseFloat(current);

            // RESET
            if(type === "reset"){
                table.style.fontSize = "14px";
                return;
            }

            // PLUS
            if(type === "plus"){
                table.style.fontSize = (size + 1) + "px";
            }

            // MINUS
            if(type === "minus"){
                table.style.fontSize = (size - 1) + "px";
            }
        }
        </script>

        <div class="size-tool">
            | ubah saiz table |

            <button type="button" onclick="ubahsaiz('reset')">reset</button>
            <button type="button" onclick="ubahsaiz('plus')">+</button>
            <button type="button" onclick="ubahsaiz('minus')">-</button>

            |

            <button type="button" onclick="window.print()">Cetak</button>
        </div>

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