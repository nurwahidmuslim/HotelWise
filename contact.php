<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking History</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
        body {
            background-color: #042048;
            color: #fff;
            font-family: "Poppins", sans-serif;
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
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: #042048;
            color: #ABCDF6;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .navbar-left {
            display: flex;
            align-items: center;
        }
        .logo {
            height: 50px;
        }
        .navbar-right {
            display: flex;
            align-items: center;
            position: relative;
            margin-right: 100px;
        }
        .icon {
            height: 16px;
            margin-right: 10px;
            cursor: pointer;
        }
        .btn {
            display: inline-block;
            background-color: #1A4473;
            color: #ABCDF6;
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn:hover {
            background-color: #ABCDF6;
            color: #1A4473;
        }
        .separator {
            width: 2px;
            height: 36px;
            background-color: #ABCDF6;
            margin-right: 10px;
        }
        .navbar-right span {
            font-size: 16px;
        }
        .dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background-color: transparent;
            border: 1px solid #ABCDF6;
            color: #ABCDF6;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1;
            min-width: 200px;
            border-radius: 5px;
        }
        .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #ABCDF6;
            border-radius: 5px;
            border-bottom: 1px solid #ABCDF6;
        }
        .dropdown a:hover {
            background-color: #17448F;
            border-radius: 5px;
        }
        .dropdown a:last-child {
            border-bottom: none;
        }
        .dropdown.active {
            display: block;
        }
        .card {
            background-color: #1A4473;
            border: none;
            margin-bottom: 1rem;
            border-radius: 15px;
            width: 477px;
            height: 100px;
        }
        .card-header {
            font-weight: bold;
        }
        .card-body {
            margin-top: 25px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .card-header, .card-body {
            color: #ABCDF6;
        }
        .status-pending {
            font-size: 10px;
            color: #FF0000;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .status-complete {
            font-size: 10px;
            color: green;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .container {
            margin-top: 120px;
        }
        h1 {
            font-size: 25px;
            color: #fff;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .alert {
            background-color: #ABCDF6;
            color: #042048;
            font-weight: bold;
            text-align: left;
            font-size: 12px;
        }

        .bi-geo-alt {
            margin-left: 5px;
            font-size: 20px;
            color: #ABCDF6;
        }

        .footer {
            padding: 10px 0;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #042048;
            color: #ABCDF6;
            margin-bottom: -30px;
            text-align: center;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }
        .footer h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .footer p {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .footer img {
            margin: 5px;
            cursor: pointer;
        }
        .footer-bottom p {
            font-size: 12px;
            margin-top: 5px;
            margin-bottom: 0;
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
                <a href="#">Contact</a>
                <a href="#">Riwayat Booking</a>
                <a href="daftar.php">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container">
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
        <div class="footer-img">
            <img src="gambar/ig.svg" alt="Instagram">
            <img src="gambar/twt.svg" alt="Twitter">
            <img src="gambar/fb.svg" alt="Facebook">
        </div>
        <div class="footer-bottom">
            <p>Copyright 2024 by WiseHotel Teams. All rights reserved</p>
        </div>
    </footer>
    
    <script src="dropdown.js"></script>
</body>
</html>