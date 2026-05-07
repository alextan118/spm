<link rel="stylesheet" href="style_header.css">

<header class="main-header">
    <h1 class="title">
        SISTEM PENGUNDIAN KELAB TARIAN SINGA SMJK JIT SIN II
    </h1>

    <?php if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "ADMIN") { ?>
        <nav class="nav">
            <a href='index.php'>Laman Utama</a>
            <a href='calon-senarai.php'>Senarai Calon</a>
            <a href='pengguna-senarai.php'>Senarai Pengguna</a>
            <a href='jawatan-daftar.php'>Senarai Jawatan</a>
            <a href='keputusan.php'>Keputusan</a>
            <a href='logout.php' class="logout">Logout</a>
        </nav>

    <?php } else if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "PENGGUNA") { ?>
        <nav class="nav">
            <a href='index.php'>Laman Utama</a>
            <a href='undi_kedudukan.php'>Borang Pengundian</a>
            <a href='logout.php' class="logout">Logout</a>
        </nav>

    <?php } else { ?>
        <nav class="nav">
            <a href='index.php'>Laman Utama</a>
        </nav>
    <?php } ?>
</header>