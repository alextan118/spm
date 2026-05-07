<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-biasa.php');

// Ambil calon
$calon = mysqli_query($condb, "SELECT * FROM CALON");
$senarai = [];
while ($row = mysqli_fetch_assoc($calon)) {
    $senarai[] = $row;
}

// Ambil jawatan
$jawatan_query = mysqli_query($condb, "SELECT * FROM jawatan");
$jawatan = [];
while ($row = mysqli_fetch_assoc($jawatan_query)) {
    $jawatan[] = $row['nama_jawatan'];
}
?>

<link rel="stylesheet" href="style_undi.css">

<div class="page-title">
    BORANG UNDIAN KADET BOMBA SMJK JIT SIN II
</div>

<form class="undi-form"
      action="proses_undi_kedudukan.php"
      method="POST"
      onchange="enforceSingleJawatanPerCalon()">

    <input type="hidden" name="nokp" value="<?=$_SESSION['nokp']?>">

    <div class="undi-container">

    <?php foreach ($senarai as $cl) { ?>

        <div class="calon-card">

            <img class="calon-img"
                 src="<?=$cl['gambar']?>"
                 alt="<?=$cl['nama_calon']?>">

            <div class="calon-name">
                <?=$cl['nama_calon']?>
            </div>

            <div class="jawatan-list">

                <?php foreach ($jawatan as $j) { ?>

                    <label class="jawatan-btn">
                        <input type="checkbox"
                               name="undi[<?=$cl['id_calon']?>]"
                               value="<?=$j?>"
                               onclick="handleCheckboxClick(this)">
                        <span><?=$j?></span>
                    </label>

                <?php } ?>

            </div>

        </div>

    <?php } ?>

    </div>

    <button type="submit" class="submit-btn">
        SUBMIT UNDIAN
    </button>

</form>

<script>
const MAX_VOTE = 3;

/* =========================
   COUNT SELECTED VOTES
========================= */
function countChecked() {
    return document.querySelectorAll('input[type="checkbox"]:checked').length;
}

/* =========================
   LIMIT TOTAL VOTES (MAX 3)
========================= */
function enforceVoteLimit() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const checkedCount = countChecked();

    checkboxes.forEach(cb => {
        if (!cb.checked && checkedCount >= MAX_VOTE) {
            cb.disabled = true;
        } else {
            cb.disabled = false;
        }
    });
}

/* =========================
   ONLY 1 JAWATAN PER CALON
========================= */
function enforceSingleJawatanPerCalon() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const selected = {};

    checkboxes.forEach(cb => {
        const match = cb.name.match(/\[(.*?)\]/);
        if (!match) return;

        const id = match[1];

        if (!selected[id]) {
            selected[id] = { selected: null, list: [] };
        }

        selected[id].list.push(cb);

        if (cb.checked) {
            selected[id].selected = cb.value;
        }
    });

    Object.values(selected).forEach(group => {
        group.list.forEach(cb => {
            if (group.selected && cb.value !== group.selected) {
                cb.disabled = true;
            } else {
                cb.disabled = false;
            }
        });
    });

    enforceVoteLimit();
}

/* =========================
   CLICK HANDLER
========================= */
function handleCheckboxClick(checkbox) {

    const match = checkbox.name.match(/\[(.*?)\]/);
    if (!match) return;

    const id = match[1];

    const list = document.querySelectorAll(`input[name="undi[${id}]"]`);

    list.forEach(cb => {
        if (cb !== checkbox) {
            cb.checked = false;
        }
    });

    enforceSingleJawatanPerCalon();
}

/* run once on load */
window.onload = enforceSingleJawatanPerCalon;
</script>