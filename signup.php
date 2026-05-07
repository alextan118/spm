<?php
include('header.php');
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nokp = $_POST['nokp'];
    $nama = $_POST['nama'];
    $katalaluan = $_POST['katalaluan'];

    $katalaluan_hash = password_hash($katalaluan, PASSWORD_DEFAULT);

    $semak = $condb->query("SELECT * FROM PENGGUNA WHERE nokp='$nokp'");

    if ($semak->num_rows > 0) {
        echo "<p class='error-msg'>No KP telah didaftarkan.</p>";
    } else {
        $sql = "INSERT INTO PENGGUNA (nokp, nama, katalaluan, tahap)
                VALUES ('$nokp', '$nama', '$katalaluan', 'Pengguna')";

        if ($condb->query($sql) === TRUE) {
            echo "<script>
                    alert('Pendaftaran Berjaya. Sila Log Masuk');
                    window.location.href='login-borang.php';
                  </script>";
        } else {
            echo "<p class='error-msg'>Ralat: " . $condb->error . "</p>";
        }
    }
}
?>

<link rel="stylesheet" href="style_signup.css">

<div class="register-wrapper">

    <div class="register-card">

        <h2 class="title">Pendaftaran Pengguna</h2>

        <form method="POST">

            <label>No KP</label>
            <input class="input-box" type="text" name="nokp"
                placeholder="Contoh: 12345"
                pattern="[0-9]{5}"
                required>

            <label>Nama</label>
            <input class="input-box" type="text" name="nama" required>

            <label>Katalaluan</label>
            <input class="input-box" type="password" name="katalaluan" required>

            <input class="btn" type="submit" value="DAFTAR">

        </form>

    </div>

</div>

<?php include('footer.php'); ?>