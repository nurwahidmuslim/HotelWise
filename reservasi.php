<?php
session_start();
include 'koneksi.php'; // File to connect to the database

// Fetch room data from the database
$query = "
    SELECT k.no_kamar, k.status, t.id_kamar, t.tipe_kamar, t.harga, t.foto, t.size, t.bed, t.kategori, t.fasilitas
    FROM kamar k
    JOIN tipe_kamar t ON k.tipe_kamar = t.id_kamar
";
$result = $conn->query($query);
$rooms = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Group rooms by type
        if (!isset($rooms[$row['tipe_kamar']])) {
            $rooms[$row['tipe_kamar']] = $row;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .room-card {
            background-color: #d9d9d9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .room-card img {
            border-radius: 10px;
            margin-right: 20px;
        }
        .room-info {
            flex: 1;
        }
        .room-info h2 {
            color: #042048;
            margin-top: -20px;
            margin-bottom: 10px;
        }
        .room-info p {
            margin: 10px 0;
            font-size: 14px;
            color: #042048;
        }
        .price {
            font-size: 16px;
            font-style: italic;
            text-align: left;
            color: #042048;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: right;
            margin-top: -50px;
        }
        .button {
            background-color: #042048;
            color: #d9d9d9;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 50px;
            margin-bottom: -25px
        }

        .container {
            display: flex;
            align-items: center;
        }
        .container img {
            margin-right: 10px;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            display: none;
            justify-content: center;
            align-items: center;
        }

        .overlay-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            width: 400px; /* Adjust width as needed */
            text-align: center;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Drop shadow for a raised effect */
        }

        .close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #333; /* Dark color for the close icon */
        }

        .order-details h2 {
            color: #002b59;
        }

        .room-infoo {
            background-color: #e5e5e5;
            border-radius: 10px;
            margin: 20px 0;
            padding: 10px;
        }

        .check-in-out {
            display: flex;
            justify-content: space-between;
        }

        .check-in, .check-out {
            width: 45%;
        }

        .room-type {
            margin-top: 10px;
        }

        .room-type p {
            margin: 5px 0;
        }

        .room-number {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #e5e5e5;
            border-radius: 10px;
        }

        .number {
            font-size: 18px;
            font-weight: bold;
            color: #002b59;
        }

        .book-now {
            background-color: #002b59;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .book-now:hover {
            background-color: #004080;
        }

        .payment-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            display: none;
            justify-content: center;
            align-items: center;
        }

        .payment-overlay-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            width: 400px; /* Adjust width as needed */
            text-align: center;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Drop shadow for a raised effect */
        }

        .payment-close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }

        .payment-details h2 {
            color: #002b59;
        }

        .payment-info {
            background-color: #e5e5e5;
            border-radius: 10px;
            margin: 20px 0;
            padding: 10px;
        }

        .payment-info p {
            margin: 5px 0;
        }

        .payment-method {
            margin: 10px 0;
            text-align: left;
        }

        .payment-method label {
            margin-right: 10px;
        }

        .payment-method input {
            margin-right: 5px;
        }

        .confirm-payment {
            background-color: #002b59;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .confirm-payment:hover {
            background-color: #004080;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="gambar/logo.svg" alt="Logo" class="logo">
        </div>
        <div class="navbar-middle">
            <label for="checkin-date" style="color: #fff;">Check-in:</label>
            <input type="date" id="checkin-date" name="checkin-date">
            <label for="checkout-date" style="color: #fff;">Check-out:</label>
            <input type="date" id="checkout-date" name="checkout-date">
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
        <?php foreach ($rooms as $room): ?>
        <div class="room-card">
        <img src="gambar/<?php echo htmlspecialchars($room['foto']); ?>" width="300">
            <div class="room-info">
                <h2><?php echo htmlspecialchars($room['tipe_kamar']); ?></h2>
                <div class="container">
                    <img src="gambar/size.svg" alt="Size">
                    <p>Size: <?php echo htmlspecialchars($room['size']); ?>m²</p>
                </div>
                <div class="container">
                    <img src="gambar/bed.svg" alt="Bed Type">
                    <p>Bed Type: <?php echo htmlspecialchars($room['bed']); ?></p>
                </div>
                <div class="container">
                    <img src="gambar/cate.svg" alt="Categories">
                    <p>Categories: <?php echo htmlspecialchars($room['kategori']); ?></p>
                </div>
                <div class="container">
                    <img src="gambar/star.svg" alt="Amenities">
                    <p>Amenities: <?php echo htmlspecialchars($room['fasilitas']); ?></p>
                </div>
            </div>
            <div class="button-container">
                <p class="price">
                    <span>Harga mulai dari:</span><br>
                    <span style="font-size: 20px; font-weight: bold;">Rp <?php echo number_format($room['harga'], 2, ',', '.'); ?></span><br>
                    <span>per malam</span>
                </p>
                <button class="button" onclick="showOverlay('<?php echo htmlspecialchars($room['id_kamar']); ?>', '<?php echo number_format($room['harga'], 2, ',', '.'); ?>')">Pesan Sekarang</button>
            </div>
        </div>
        <?php endforeach; ?>

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
    </div>

    <div class="overlay" id="overlay">
        <div class="overlay-content" id="overlay-content">
            <span class="close-icon" id="close-icon">&times;</span>
            <div class="order-details">
                <h2>Detail Pesanan</h2>
                <p class="price" id="overlay-price"></p>
                <div class="room-infoo">
                    <div class="check-in-out">
                        <div class="check-in">
                            <p>Check in</p>
                            <p id="overlay-checkin-date"></p>
                        </div>
                        <div class="check-out">
                            <p>Check Out</p>
                            <p id="overlay-checkout-date"></p>
                        </div>
                    </div>
                    <div class="room-type">
                        <p>Tipe Kamar</p>
                        <p id="overlay-room-type"></p>
                    </div>
                </div>
                <div class="room-number">
                    <span>No Kamar</span>
                    <select id="overlay-room-number"></select>
                </div>
                <button class="book-now" onclick="showPaymentOverlay()">Pesan Sekarang</button>
            </div>
        </div>
    </div>

    <div class="overlay" id="payment-overlay">
        <div class="overlay-content">
            <span class="close-icon" id="payment-close-icon">&times;</span>
            <form id="payment-form" action="pembayaran.php" method="post" enctype="multipart/form-data">
                <h2>Payment Details</h2>
                <input type="hidden" name="tipe_kamar" id="payment-room-type-value">
                <input type="hidden" name="total" id="payment-total-value">
                <div>
                    <label for="nama">Name</label>
                    <input type="text" id="payment-nama" name="nama" value="<?php echo htmlspecialchars($_SESSION['namaL']); ?>" readonly>
                </div>
                <div>
                    <label for="jenis_pembayaran">Payment Method</label>
                    <select id="jenis_pembayaran" name="jenis_pembayaran">
                        <option value="Rekening">Rekening</option>
                        <option value="E-wallet">E-wallet</option>
                    </select>
                </div>
                <div>
                    <label for="no_rek_e_wallet">Account/E-wallet Number</label>
                    <input type="text" id="no_rek_e_wallet" name="no_rek_e_wallet" required>
                </div>
                <div>
                    <label for="bukti">Upload Proof of Payment</label>
                    <input type="file" id="bukti" name="bukti" required>
                </div>
                <div>
                    <label>Total</label>
                    <p id="payment-total"></p>
                </div>
                <button type="submit">Confirm</button>
            </form>
        </div>
    </div>

    <script src="dropdown.js"></script>
    <script>
        document.getElementById('close-icon').addEventListener('click', function() {
            document.getElementById('overlay').style.display = 'none';
        });

        document.getElementById('payment-close-icon').addEventListener('click', function() {
            document.getElementById('payment-overlay').style.display = 'none';
        });

        // Set the minimum and default check-in date to today
        const today = new Date().toISOString().split('T')[0];
        const checkinDateInput = document.getElementById('checkin-date');
        const checkoutDateInput = document.getElementById('checkout-date');
        checkinDateInput.setAttribute('min', today);
        checkinDateInput.value = today;

        // Set the default check-out date to one day after today
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const formattedTomorrow = tomorrow.toISOString().split('T')[0];
        checkoutDateInput.setAttribute('min', formattedTomorrow);
        checkoutDateInput.value = formattedTomorrow;

        // Update the minimum check-out date based on the selected check-in date
        checkinDateInput.addEventListener('change', function() {
            const checkinDate = new Date(this.value);
            const checkoutDate = new Date(checkinDate);
            checkoutDate.setDate(checkoutDate.getDate() + 1); // Add one day
            const formattedCheckoutDate = checkoutDate.toISOString().split('T')[0];
            checkoutDateInput.setAttribute('min', formattedCheckoutDate);
            checkoutDateInput.value = formattedCheckoutDate;
        });

        function showOverlay(roomType, price) {
            const overlay = document.getElementById('overlay');
            document.getElementById('overlay-room-type').innerText = roomType;
            document.getElementById('overlay-price').innerText = `Rp ${price}`;
            document.getElementById('overlay-checkin-date').innerText = checkinDateInput.value;
            document.getElementById('overlay-checkout-date').innerText = checkoutDateInput.value;
            const cleanPrice = price.replace('Rp ', '').replace('.', '');
            const totalPrice = calculateTotalPrice(parseFloat(cleanPrice));
            document.getElementById('overlay-price').innerText = `Rp ${totalPrice}`;
            overlay.style.display = 'flex';

            fetchAvailableRoomNumbers(roomTypeId);
        }

        function calculateTotalPrice(pricePerNight) {
            const checkinDate = new Date(checkinDateInput.value);
            const checkoutDate = new Date(checkoutDateInput.value);
            const duration = (checkoutDate - checkinDate) / (1000 * 3600 * 24);
            const totalPrice = pricePerNight * duration;
            return totalPrice.toLocaleString('id-ID', {minimumFractionDigits: 2});
        }

        checkinDateInput.addEventListener('change', updateTotalPrice);
        checkoutDateInput.addEventListener('change', updateTotalPrice);

        function updateTotalPrice() {
            const pricePerNight = parseFloat(document.getElementById('overlay-price').innerText.replace('Rp ', '').replace('.', '').replace(',', '.'));
            const totalPrice = calculateTotalPrice(pricePerNight);
            document.getElementById('overlay-price').innerText = `Rp ${totalPrice}`;
        }

        function fetchAvailableRoomNumbers(roomTypeId) {
            const request = new XMLHttpRequest();
            request.open('POST', 'pilih_nomor.php', true);
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    const roomNumbers = JSON.parse(this.responseText);
                    const roomNumberSelect = document.getElementById('overlay-room-number');
                    roomNumberSelect.innerHTML = ''; // Clear previous options
                    roomNumbers.forEach(function(number) {
                        const option = document.createElement('option');
                        option.value = number;
                        option.text = number;
                        roomNumberSelect.add(option);
                    });
                }
            };
            request.send(`roomType=${roomTypeId}`);
        }

        // Show payment overlay
        function showPaymentOverlay() {
            // Hide the order details overlay
            document.getElementById('overlay').style.display = 'none';

            // Populate payment overlay fields
            const paymentOverlay = document.getElementById('payment-overlay');
            const roomType = document.getElementById('overlay-room-type').innerText;
            const total = document.getElementById('overlay-price').innerText.replace('Rp ', '').replace(',', '.');

            document.getElementById('payment-room-type-value').value = roomType;
            document.getElementById('payment-total-value').value = total;
            document.getElementById('payment-total').innerText = `Rp ${total}`;

            // Show the payment overlay
            paymentOverlay.style.display = 'flex';
        }

        // Add event listener to "Pesan Sekarang" button in the order details overlay
        document.querySelector('.book-now').addEventListener('click', showPaymentOverlay);
    </script>
</body>
</html>
