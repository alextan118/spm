<?php
session_start();

include('header.php');
include('kawalan-admin.php');
?>

<link rel="stylesheet" href="style_upload.css">

<div class="page-title">
    MUAT NAIK DATA PENGGUNA (.TXT)
</div>

<div class="upload-container">

<form class="upload-box"
      action=''
      method='post'
      enctype='multipart/form-data'>

    <h3>Pilih fail TXT untuk diupload</h3>

    <input type='file' name='data_admin'>

    <button type='submit' name='btn-upload'>
        MUAT NAIK
    </button>

</form>

</div>

<?php include("footer.php"); ?>

<?php
if(isset($_POST['btn-upload']))
{
    include('connection.php');

    $namafailsementara = $_FILES["data_admin"]["tmp_name"];
    $namafail = $_FILES['data_admin']['name'];
    $jenisfail = pathinfo($namafail, PATHINFO_EXTENSION);

    if($_FILES["data_admin"]["size"] > 0 && $jenisfail == "txt")
    {
        $fail = fopen($namafailsementara, "r");

        $success = true;
        $total_data = 0;
        $data_berjaya = 0;

        while(!feof($fail))
        {
            $baris = trim(fgets($fail));

            if(empty($baris)) continue;

            $pecahkanbaris = explode('|', $baris);

            if(count($pecahkanbaris) < 4){
                $success = false;
                continue;
            }

            list($nama,$nokp,$katalaluan,$tahap) = $pecahkanbaris;

            $nama = trim($nama);
            $nokp = trim($nokp);
            $katalaluan = trim($katalaluan);
            $tahap = trim($tahap);

            $sql = "INSERT INTO pengguna (nama,nokp,katalaluan,tahap)
                    VALUES ('$nama','$nokp','$katalaluan','$tahap')";

            $run = mysqli_query($condb, $sql);

            if($run){
                $data_berjaya++;
            }else{
                $success = false;
            }

            $total_data++;
        }

        fclose($fail);

        if($success){
            echo "<script>
                alert('$data_berjaya rekod berjaya diimport');
                window.location.href='pengguna-senarai.php';
            </script>";
        }else{
            echo "<script>
                alert('Sebahagian data gagal diimport');
                window.location.href='pengguna-senarai.php';
            </script>";
        }
    }
    else
    {
        echo "<script>alert('Hanya fail .txt dibenarkan');</script>";
    }
}
?>