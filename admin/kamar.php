<?php
// Sambungkan ke database
include 'koneksi.php';

// Periksa apakah formulir telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $roomName = $_POST['room_name'];
    $roomType = $_POST['room_type'];
    $roomPrice = $_POST['room_price'];
    $roomDescription = $_POST['room_description'];

    // Mengunggah gambar kamar
    $targetDir = "uploads";
    $targetFile = $targetDir . basename($_FILES["room_image"]["name"]);

    // Simpan data ke database jika gambar berhasil diunggah
    if (move_uploaded_file($_FILES["room_image"]["tmp_name"], $targetFile)) {
        // Query SQL untuk menyimpan data ke database
        $query = "INSERT INTO kamar (nama_kamar, tipe_kamar, harga, deskripsi, foto) 
                  VALUES ('$roomName', '$roomType', '$roomPrice', '$roomDescription', '$targetFile')";

        if (mysqli_query($koneksi, $query)) {
            echo "Data kamar berhasil ditambahkan.";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }

    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar - HotelWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="gambar/logo.svg" alt="Logo" class="logo">
        </div>
        <div class="navbar-right">
            <p>Admin</p>
        </div>
    </nav>

    <div class="sidebar">
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="kamar.php">Kamar</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Edit informasi kamar hotel</h2>
        <form action="edit_kamar.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="room_name">Room Name:</label>
                <input type="text" id="room_name" name="room_name" required>
            </div>
            <div class="form-group">
                <label for="room_type">Room Type:</label>
                <select id="room_type" name="room_type" required>
                    <option value="Standard Single/Twin Room">Standard Single/Twin Room</option>
                    <option value="Superior Double Room">Superior Double Room</option>
                    <option value="Comfort Triple Room">Comfort Triple Room</option>
                </select>
            </div>

            <div class="form-group">
                <label for="room_price">Room Price (per night):</label>
                <input type="number" id="room_price" name="room_price" min="0" required>
            </div>
            <div class="form-group">
                <label for="room_description">Room Description:</label>
                <textarea id="room_description" name="room_description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="room_image">Foto Kamar:</label>
                <input type="file" id="room_image" name="room_image" accept="image/*" required>
            </div>
            <button type="submit">Update Room</button>
        </form>
    </div>
</body>
</html>
