<?php
session_start();

include 'koneksi.php';

$query = "SELECT * FROM client";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    
    $id = $data ['id_client'];
    $nama = $data['nama_lengkap'];
    $email = $data['email'];
    $no_telp = $data['no_telp'];
    $tgl_lahir = $data['tgl_lahir'];
    $jenis_kelamin = $data['jenis_kelamin'];
} else {
    $id = '';
    $nama = '';
    $email = '';
    $no_telp = '';
    $tgl_lahir = '';
    $jenis_kelamin = '';
}
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

    <style>
        body {
            height: 100%;
            margin: 0;
            justify-content: center;
            align-items: center;
            background-color: #042048;
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
    </style>

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
                    <a href="daftar.php">Keluar</a>
                </div>
            </div>
        </nav>

        <div class="content">
        <h1>Profil</h1>
        <form id="profile-form" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" class="form-control" value="<?php echo $nama; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" value="<?php echo $email; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telp</label>
                    <input type="text" id="no_telp" class="form-control" value="<?php echo $no_telp; ?>" disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tg;_lahir">Tanggal Lahir</label>
                    <input type="date" id="tg;_lahir" class="form-control" value="<?php echo $tgl_lahir; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" class="form-control" disabled>
                        <option value="Laki-laki" <?php if($jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if($jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group"></div>
            </div>
            <div class="button-container">
                <button type="button" id="edit-btn">Edit Profil</button>
                <button type="button" id="simpan-btn" style="display: none;">Simpan Profil</button>
            </div>
        </form>
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
        <script>
            document.addEventListener('DOMContentLoaded', () => {
            const editBtn = document.getElementById('edit-btn');
            const simpanBtn = document.getElementById('simpan-btn');
            const formFields = document.querySelectorAll('.form-field');

            editBtn.addEventListener('click', () => {
                formFields.forEach(field => field.disabled = false);
                editBtn.style.display = 'none';
                simpanBtn.style.display = 'inline';
            });

            simpanBtn.addEventListener('click', () => {
                formFields.forEach(field => field.disabled = true);
                alert('Profil berhasil disimpan');
                editBtn.style.display = 'inline';
                simpanBtn.style.display = 'none';
            });
        });
        </script>
    </body>
</html>