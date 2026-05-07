<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

$id = $_GET['id'] ?? '';

$result = mysqli_query($condb, "SELECT * FROM jawatan WHERE idjawatan = '$id'");
$jawatan = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_jawatan = mysqli_real_escape_string($condb, $_POST['id_jawatan']);
    $nama_jawatan = mysqli_real_escape_string($condb, $_POST['nama_jawatan']);

    if ($id_jawatan != $id) {

        $check_sql = "SELECT idjawatan FROM jawatan WHERE idjawatan = '$id_jawatan'";
        $check_result = mysqli_query($condb, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {

            echo "<script>alert('ID jawatan sudah wujud!');</script>";

        } else {

            $sql = "UPDATE jawatan 
                    SET idjawatan = '$id_jawatan', 
                        nama_jawatan = '$nama_jawatan' 
                    WHERE idjawatan = '$id'";

            if (mysqli_query($condb, $sql)) {

                echo "<script>
                        alert('Berjaya dikemaskini!');
                        window.location.href='jawatan-daftar.php';
                      </script>";
            }
        }

    } else {

        $sql = "UPDATE jawatan 
                SET nama_jawatan = '$nama_jawatan' 
                WHERE idjawatan = '$id'";

        if (mysqli_query($condb, $sql)) {

            echo "<script>
                    alert('Berjaya dikemaskini!');
                    window.location.href='jawatan-daftar.php';
                  </script>";
        }
    }
}
?>

<link rel="stylesheet" href="style_jawatan_kemaskini.css">

<div class="page-title">
    KEMASKINI JAWATAN
</div>

<div class="form-container">

<form class="edit-form" method="POST" action="">

    <label>ID Jawatan</label>
    <input type="text"
           name="id_jawatan"
           value="<?php echo $jawatan['idjawatan']; ?>"
           required>

    <label>Nama Jawatan</label>
    <input type="text"
           name="nama_jawatan"
           value="<?php echo $jawatan['nama_jawatan']; ?>"
           required>

    <div class="btn-group">
        <button type="submit" class="btn-save">
            Kemaskini
        </button>

        <a href="jawatan-daftar.php" class="btn-cancel">
            Batal
        </a>
    </div>

</form>

</div>