<?php
session_start();
include('header.php');
?>

<link rel="stylesheet" href="style_login.css">

<div class="login-wrapper">

    <div class="login-card">

        <h3 class="login-title">Login Pengguna dan Admin</h3>

        <form action="login-proses.php" method="POST">

            <label>Nombor Kad Pengenalan</label>
            <input class="input-box" type="text" name="nokp" placeholder="Contoh: xxxxx">

            <label>Katalaluan</label>
            <input class="input-box" type="password" name="katalaluan" placeholder="Masukkan katalaluan">

            <input class="login-btn" type="submit" value="LOGIN">

        </form>

    </div>

</div>

<?php include('footer.php'); ?>