<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HotelWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <nav class="navbar">
            <div class="navbar-left">
                <img src="gambar/logo.svg" alt="Logo" class="logo">
            </div>
            <div class="navbar-right">
                <img src="gambar/bar.svg" alt="Icon" class="icon" id="dropdown-icon">
                <div class="separator"></div>
                <?php if (isset($_SESSION['namaP'])): ?>
                <span class="hello" style="color: #ABCDF6; text-transform: capitalize; font-size: 18px;">Halo, <span style="font-weight: bold;"><?php echo $_SESSION['namaP']; ?></span></span>
                <?php endif; ?>
                <div class="dropdown" id="dropdown-menu">
                    <a href="profil.php">Profil</a>
                    <a href="contact.php">Contact</a>
                    <a href="riwayat.php">Riwayat Booking</a>
                    <a href="index.html">Keluar</a>
                </div>
            </div>
        </nav>

        <div class="content">
            <h2>Formulir Pemesanan</h2>
            <form>
                <div class="form-group">
                    <label>Saya memesan untuk:</label>
                    <div class="radio-group">
                        <label><input type="radio" name="orderFor" value="sendiri" checked> Saya sendiri</label>
                        <label><input type="radio" name="orderFor" value="orangLain"> Orang lain</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="jokopurwanto@gmail.com">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="Tuan">
                </div>
                <div class="form-group">
                    <label for="firstName">Nama Depan</label>
                    <input type="text" id="firstName" name="firstName" value="Joko">
                </div>
                <div class="form-group">
                    <label for="lastName">Nama Belakang</label>
                    <input type="text" id="lastName" name="lastName" value="Purwanto">
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="088832145678">
                </div>
                <div class="form-group">
                    <label for="nationality">Kebangsaan</label>
                    <input type="text" id="nationality" name="nationality" value="Indonesia">
                </div>
                <div class="form-group">
                    <label for="dana">Dana</label>
                    <input type="text" id="dana" name="dana" value="087748672761" readonly>
                </div>
                <div class="form-group">
                    <label for="accountName">a.n</label>
                    <input type="text" id="accountName" name="accountName" value="Robby Hidayat" readonly>
                </div>
                <div class="form-group file-upload">
                    <label for="file">Upload Bukti Pembayaran</label>
                    <input type="file" id="file" name="file">
                </div>
                <button type="submit" class="submit-btn">Konfirmasi Pembayaran</button>
            </form>
        </div>
    </body>
</html>