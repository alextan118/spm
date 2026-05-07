<?php
session_start();
include('connection.php');
include('kawalan-biasa.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['undi'])) {
    $nokp = mysqli_real_escape_string($condb, $_POST['nokp']);
    $undi = $_POST['undi']; // undi[id_calon] = nama_jawatan

    // Start transaction to ensure all votes are saved or none at all
    mysqli_begin_transaction($condb);

    try {
        // First, check if user has voted before
        $semak_undi = mysqli_query($condb, "SELECT * FROM undian WHERE nokp='$nokp'");
        if (mysqli_num_rows($semak_undi) > 0) {
            throw new Exception("Anda sudah mengundi sebelum ini.");
        }

        // Process each vote
        foreach ($undi as $id_calon => $nama_jawatan) {
            $id_calon = mysqli_real_escape_string($condb, $id_calon);
            $nama_jawatan = mysqli_real_escape_string($condb, $nama_jawatan);

            // Get idjawatan based on position name
            $jawatan_query = mysqli_query($condb, "SELECT idjawatan FROM jawatan WHERE nama_jawatan='$nama_jawatan'");

            if (!$jawatan_query || mysqli_num_rows($jawatan_query) == 0) {
                throw new Exception("Jawatan tidak ditemukan.");
            }

            $jawatan_data = mysqli_fetch_assoc($jawatan_query);
            $idjawatan = $jawatan_data['idjawatan'];

            // Save vote to database
            $insert_query = "INSERT INTO undian (nokp, id_calon, idjawatan) VALUES ('$nokp', '$id_calon', '$idjawatan')";

            if (!mysqli_query($condb, $insert_query)) {
                throw new Exception("Gagal menyimpan undian: " . mysqli_error($condb));
            }
        }

        // If all successful, commit transaction
        mysqli_commit($condb);
        echo "<script>alert('Undian anda telah direkodkan. Terima kasih!'); window.location='index.php';</script>";
    } catch (Exception $e) {
        // Rollback if there is error
        mysqli_rollback($condb);
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('Tiada data undian dihantar.'); window.location='undi_kedudukan.php';</script>";
}
?>