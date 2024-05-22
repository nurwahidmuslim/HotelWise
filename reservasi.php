<?php
session_start();
include 'koneksi.php'; // File to connect to the database

// Fetch room data from the database
$query = "
    SELECT k.no_kamar, k.status, t.tipe_kamar, t.harga, t.foto, t.size, t.bed, t.kategori, t.fasilitas
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
            width: 400px; 
            text-align: center;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); 
        }

        .close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #333; 
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

        #payment-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); 
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            display: none;
        }

        #payment-overlay-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 400px;
            position: relative;
        }

        #payment-close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        .payment-details h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .payment-details form > div {
            margin-bottom: 15px;
        }

        .payment-details label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .payment-details input[type="text"],
        .payment-details select,
        .payment-details input[type="file"] {
            width: calc(100% - 10px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin: 0 5px;
        }

        .payment-details .confirm-booking {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .payment-details .confirm-booking:hover {
            background-color: #218838;
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
                <a href="home.php">Home</a>
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
                <p class="price"><span>Harga mulai dari:</span><br>
                <span style="font-size: 20px; font-weight: bold;">Rp <?php echo number_format($room['harga'], 2, ',', '.'); ?></span><br>
                <span>per malam</span></p>
                <button class="button" onclick="showOverlay('<?php echo htmlspecialchars($room['tipe_kamar']); ?>', '<?php echo number_format($room['harga'], 2, ',', '.'); ?>')">Pesan Sekarang</button>
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
        <div class="overlay-content" id="payment-overlay-content">
            <span class="close-icon" id="payment-close-icon">&times;</span>
            <div class="payment-details">
                <h2>Detail Pembayaran</h2>
                <form id="payment-form" enctype="multipart/form-data">
                    <div>
                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($_SESSION['namaL']); ?>" readonly>
                    </div>
                    <div>
                        <label for="jenis_pembayaran">Metode Pembayaran:</label>
                        <select id="jenis_pembayaran" name="jenis_pembayaran" required>
                            <option value="Rekening">Rekening</option>
                            <option value="E-wallet">E-wallet</option>
                        </select>
                    </div>
                    <div>
                        <label for="norek_e_wallet">No Rekening/E-wallet:</label>
                        <input type="text" id="norek_e_wallet" name="norek_e_wallet" required>
                    </div>
                    <div>
                        <label for="total">Total:</label>
                        <input type="text" id="total" name="total" readonly>
                    </div>
                    <div>
                        <label for="bukti">Upload Bukti Pembayaran:</label>
                        <input type="file" id="bukti" name="bukti" required>
                    </div>
                    <input type="hidden" id="tipe_kamar" name="tipe_kamar">
                    <input type="hidden" id="overlay-no-kamar" name="no_kamar">
                    <input type="hidden" id="id_client" name="id_client" value="<?php echo $_SESSION['id_client']; ?>">
                    <input type="hidden" id="checkin_date" name="checkin_date" value="">
                    <input type="hidden" id="checkout_date" name="checkout_date" value="">
                    <input type="hidden" id="tanggal_pemesanan" name="tanggal_pemesanan" value="">
                    <p style="font-size: 16px;">Rek: 0987654321              Dana: 08888888888</p>
                    <button type="button" class="confirm-booking">Konfirmasi</button>
                </form>
            </div>
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

            fetchAvailableRoomNumbers(roomType);
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

        function fetchAvailableRoomNumbers(roomType) {
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

                    // Auto select the first room number and set it to hidden input
                    if (roomNumbers.length > 0) {
                        selectedRoomNumber = roomNumbers[0];
                        document.getElementById('overlay-no-kamar').value = selectedRoomNumber;
                    }
                }
            };
            request.send(`roomType=${roomType}`);
        }

        document.querySelector('.confirm-booking').addEventListener('click', function(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('payment-form'));

            fetch('pembayaran.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Pembayaran berhasil dikonfirmasi.");
                window.location.href = "riwayat.php";
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        function showPaymentOverlay() {
            const paymentOverlay = document.getElementById('payment-overlay');
            const totalPrice = document.getElementById('overlay-price').innerText;
            const roomType = document.getElementById('overlay-room-type').innerText;
            const checkinDate = document.getElementById('checkin-date').value;
            const checkoutDate = document.getElementById('checkout-date').value;
            
            document.getElementById('total').value = totalPrice;
            document.getElementById('tipe_kamar').value = roomType;
            document.getElementById('checkin_date').value = checkinDate;
            document.getElementById('checkout_date').value = checkoutDate;

            const currentDate = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_pemesanan').value = currentDate;

            paymentOverlay.style.display = 'flex';
        }
    </script>
</body>
</html>
