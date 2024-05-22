<?php
session_start();

include 'koneksi.php';

// Check if the user is logged in and has a session id_client
if (!isset($_SESSION['id_client'])) {
    // Redirect to login page if the session does not exist
    header("Location: login.php");
    exit();
}

$id_client = $_SESSION['id_client'];

$query = "SELECT * FROM client WHERE id_client = '$id_client'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    $nama_lengkap = $data['nama_lengkap'];
    $email = $data['email'];
    $no_telp = $data['no_telp'];
    $tgl_lahir = $data['tgl_lahir'];
    $jenis_kelamin = $data['jenis_kelamin'];
} else {
    $nama_lengkap = '';
    $email = '';
    $no_telp = '';
    $tgl_lahir = '';
    $jenis_kelamin = '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpan'])) {
    // Capture the edited values from the form
    $nama_lengkap = isset($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $no_telp = isset($_POST['no_telp']) ? $_POST['no_telp'] : '';
    $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';

    // Update query to update data in the database
    $updateQuery = "UPDATE client SET nama_lengkap='$nama_lengkap', email='$email', no_telp='$no_telp', tgl_lahir='$tgl_lahir', jenis_kelamin='$jenis_kelamin' WHERE id_client='$id_client'";

    if (mysqli_query($conn, $updateQuery)) {
        echo '<script>alert("Profil berhasil disimpan");</script>';
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
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
                <a href="home.php">Home</a>
                <a href="profil.php">Profil</a>
                <a href="contact.php">Contact</a>
                <a href="riwayat.php">Riwayat Booking</a>
                <a href="index.html">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="content">
        <h1>Profil</h1>
        <form id="profile-form" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="nama_lengkap">Nama</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control form-field" value="<?php echo $nama_lengkap; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control form-field" value="<?php echo $email; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telp</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control form-field" value="<?php echo $no_telp; ?>" disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control form-field" value="<?php echo $tgl_lahir; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control form-field" disabled>
                        <option value="Laki-laki" <?php if($jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if($jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="button-container">
                <button type="button" id="edit-btn">Edit Profil</button>
                <button type="submit" name="simpan" id="simpan-btn" style="display: none;">Simpan Profil</button>
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

            const form = document.getElementById('profile-form');

            form.addEventListener('submit', (e) => {
                // No need to prevent default if you're just submitting the form
            });
        });
    </script>
</body>
</html>
