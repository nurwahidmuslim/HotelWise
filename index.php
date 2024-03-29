<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-left">
        <span class="navbar-brand"><span class="wise">Wise</span><span class="hotel">Hotel</span></span>
    </div>
    <div class="navbar-right">
        <?php if (isset($_SESSION['namaP'])): ?>
        <span class="hello" style="color: #FA7070; text-transform: capitalize; font-size: 18px;">Halo, <span style="font-weight: bold;"><?php echo $_SESSION['namaP']; ?></span></span>
        <?php endif; ?>

    </div>

</nav>
<div class="content">
<div class="left-content">
        <h1>Tingkatkan<br>Pengalaman<br>Menginap Anda:<br>
        Temukan<br>Kenyamanan Tanpa<br>Batas di Hotel Kami!</h1>
        <div class="box">
            <div class="box-left">
                <p>Check In</p>
                <h3>Sabtu, 30 Maret</h3>
            </div>
            <div class="box-right">
                <p>Check Out</p>
                <h3>Minggu, 31 Maret</h3>
            </div>
            <div class="box-bottom">
                <p>Rooms</p>
                <h3>1 Room, 2 Guest</h3>
            </div>
            <a href="#" class="btn-cari">Cari</a>
        </div>
    </div>
    <div class="right-content">
        <img src="HoteWise_Logo.png" alt="Gambar Hotel">
    </div>
</div>
</body>
</html>
