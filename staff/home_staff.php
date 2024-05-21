<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HotelWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="gambar/logo.svg" alt="Logo" class="logo">
        </div>
        <div class="navbar-right">
            <a href="masuk.php" class="btn" id="masuk-btn">Masuk</a>
        </div>
    </nav>

    <div class="sidebar">
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="booking.php">Booking</a></li>
        </ul>
    </div>
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <img src="gambar/alert.svg">
            <span class="close">&times;</span>
            <p>Anda harus login terlebih dahulu!</p>
    </div>
</body>
</html>
