<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
        body {
            height: 100%;
            margin: 0;
            justify-content: center;
            align-items: center;
            background-color: #042048;
        }
        .navbar-right {
            margin-right: 0px;
        }
        body::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 500px;
            height: 500px;
            background: url('gambar/HoteWise Logo.svg') no-repeat center center;
            background-size: contain;
            margin-top: 50px;
            transform: translate(-50%, -50%);
            opacity: 0.5;
            z-index: -1;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            text-align: center;
            color: #ABCDF6;
        }

        .bi-geo-alt {
            margin-left: 5px;
            font-size: 20px;
            color: #ABCDF6;
        }

        .text-center {
            font-weight: 600;
        }

        .contact-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            color: #fff;
            font-weight: 500;
        }

        .contact-info div {
            flex: 1;
            margin: 20px;
            margin-left: 30px;
        }

        .contact-info h3 {
            margin-top: 0;
        }

        h3{
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 30px;
        }

        p a{
            color: #ABCDF6;
        }
        
        .contact-info a[href^="mailto"]{
            font-weight: bold;
            color: #fff;
        }

        .h-line { 
            width: 90px; 
            height: 2px; 
            background-color: #fff; 
            margin: 0 auto; 
            margin-bottom: 15px; 
        }

        .h-line2 { 
            width: 150px; 
            height: 2px; 
            background-color: #fff; 
            margin: 0 auto; 
        }

        .bi-envelope-fill{
            color: #ABCDF6;
        }

        .bi-telephone-fill{
            color: #ABCDF6;
        }
    </style>
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
        <div class="text-center mb-4">
            <h1>Contact</h1>
            <div class="h-line"></div>
            <div class="h-line2"></div>
        </div>
        <div class="contact-info">
            <p class="text-center">
                Silahkan hubungi kami langsung jika anda memiliki pertanyaan mengenai layanan dan kerjasama, Kami akan dengan senang hati menerima anda.
            </p>
            <div>
                <h3>Alamat</h3>
                <i class="bi bi-geo-alt"></i><p>Jl. Prof. Dr. Ir. Sumantri Brojonegoro No.1,<br>Gedong Meneng, Kec. Rajabasa,<br>Kota Bandar Lampung, Lampung 35141</p>
                <p><a href="https://g.co/kgs/8k1xvC4" target="_blank">View on map</a></p>
            </div>
            <div>
                <h3>Narahubung</h3>
                <i class="bi bi-telephone-fill"></i>
                <p>
                    Robby Hidayat: <a href="tel:087748672761">087748672761</a><br>
                    Pradya Hening: <a href="tel:082177555903">082177555903</a><br>
                    Nurwahid Muslim: <a href="tel:089515323978">089515323978</a><br>
                    Wayan Santie Arif
                </p>
            </div>
            <div>
                <h3>Email</h3>
                <i class="bi bi-envelope-fill"></i><p><a href="mailto:wisehotel@gmail.com">wisehotel@gmail.com</a></p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-top">
            <h3>MEET US</h3>
            <p>Jl. Prof. Dr. Ir. Sumantri Brojonegoro No.1,<br>
                Gedong Meneng, Kec. Rajabasa,<br>
                Kota Bandar Lampung,<br>
                Lampung 35141</p>
        </div>
        <div class="footer-img">
            <img src="gambar/ig.svg">
            <img src="gambar/twt.svg">
            <img src="gambar/fb.svg">
        </div>
        <div class="footer-bottom">
            <p>Copyright 2024 by WiseHotel Teams. All rights reserved</p>
        </div>
    </footer>
    
    <script src="dropdown.js"></script>
</body>
</html>
