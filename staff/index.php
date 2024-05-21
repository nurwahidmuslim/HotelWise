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
            <p>Staff</p>
        </div>
    </nav>

    <div class="sidebar">
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="booking.php">Booking</a></li>
            </li><a href="home_staff.php" class="logout">Keluar <<</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Data Pemesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php';
                $sql = "SELECT id_pemesanan, nama_pemesan, tanggal FROM pemesanan";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $no++ . "</td>
                                <td>" . $row["nama_pemesan"] . "</td>
                                <td>" . $row["tanggal"] . "</td>
                                <td><a href='#' class='detail-link' data-id='" . $row["id_pemesanan"] . "'>Detail</a></td>
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

    <div class="overlay" id="overlay">
        <div class="modal">
            <div class="modal-content" id="modal-content">
                <!-- Dynamic content will be loaded here -->
            </div>
            <div class="modal-actions">
                <button id="accept-btn">Terima</button>
                <button id="pending-btn">Pending</button>
                <button id="reject-btn">Tolak</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
