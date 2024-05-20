<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - HotelWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="gambar/logo.svg" alt="Logo" class="logo">
        </div>
        <div class="navbar-right">
            <p>Staff</p>
        </div>
    </nav>

    <div class="sidebar">
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="booking.php">Booking</a></li>
        </ul>
        <a href="logout.php" class="logout">Keluar <<</a>
    </div>

    <div class="main-content">
        <h2>Riwayat Pemesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php';
                $sql = "SELECT p.id_pemesanan, p.nama_pemesan, p.action, k.tipe_kamar FROM pemesanan p LEFT JOIN kamar k ON p.id_kamar = k.id_kamar;";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Error executing query: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $no++ . "</td>
                                <td>" . $row["nama_pemesan"] . "</td>
                                <td>" . $row["tipe_kamar"] . "</td>
                                <td>" . $row["action"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data available</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
