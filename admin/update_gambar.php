<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room Image</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Poppins, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: left;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color : #042048;
        }
        input[type="file"], select, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }
        button {
            background-color: #042048;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #004080;
        }
    </style>
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
            <li><a href="riwayat_reservasi.php">Dashboard</a></li>
            <li><a href="update_gambar.php">Kamar</a></li>
            <li><a href="home_admin.php">Keluar <<</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Edit Informasi Kamar</h2>
    <div class="container">
        <form id="imageUploadForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="room-id">Select Room</label>
                <select id="room-id" name="room_id" required>
                    <?php
                    $query = "SELECT id_kamar, tipe_kamar FROM tipe_kamar";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['id_kamar'] . '">' . htmlspecialchars($row['tipe_kamar']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Select Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit">Upload</button>
        </form>
    </div>
    </div>

    <script>
        document.getElementById('imageUploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('upload_gambar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    // Optionally, refresh the page or update the image display dynamically
                    location.reload(); // Simple approach to refresh the page
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the image.');
            });
        });
    </script>
</body>
</html>
