

<style>
/* ===== BUTTON STYLE (UNIFIED SYSTEM) ===== */

input[type="button"], button {
    padding: 8px 14px;
    font-size: 14px;

    background: linear-gradient(135deg, #fbbf24, #f97316);

    color: #000;

    border: none;
    border-radius: 10px;

    cursor: pointer;

    margin-right: 6px;

    transition: 0.25s;

    box-shadow: 0 10px 20px rgba(0,0,0,0.4),
                0 0 15px rgba(251,191,36,0.15);
}

input[type="button"]:hover,
button:hover {
    transform: translateY(-2px);

    box-shadow: 0 15px 30px rgba(0,0,0,0.6),
                0 0 25px rgba(251,191,36,0.3);
}

</style>

<script>

function ubahsaiz(gandaan) {

    var saiz = document.getElementById("saiz");

    if (!saiz) {
        console.error("Element id='saiz' tidak wujud");
        return;
    }

    var style = window.getComputedStyle(saiz);
    var saiz_semasa = parseFloat(style.fontSize);

    // reset
    if (gandaan == 2) {
        saiz.style.fontSize = "16px";
    }
    else {
        saiz.style.fontSize = (saiz_semasa + (gandaan * 2)) + "px";
    }
}

</script>

<!-- =========================
     UI BUTTON BAR
========================= -->

<div style="text-align:center; margin:10px 0; color:#fbbf24;">
    | ubah saiz tulisan |
    
    <input type="button" value="reset" onclick="ubahsaiz(2)" />
    <input type="button" value="+" onclick="ubahsaiz(1)" />
    <input type="button" value="-" onclick="ubahsaiz(-1)" />

    |

    <button type="button" onclick="window.print()">Cetak</button>
</div>