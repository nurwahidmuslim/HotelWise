<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    <body class="index-page">
        <nav>
            <div class="navbar-left">
                <span class="navbar-brand">WiseHotel</span>
            </div>
        </nav>
        <div class="navbar-right">
            <?php if (isset($_SESSION['namaP'])): ?>
            <span class="hello" style="color: #ABCDF6; text-transform: capitalize; font-size: 18px;">Halo, <span style="font-weight: bold;"><?php echo $_SESSION['namaP']; ?></span></span>
            <?php endif; ?>
        </div>
        <div class="content">
            <div class="left-content">
                <h1>Tingkatkan Pengalaman Menginap Anda<br>
                Temukan Kenyamanan Tanpa Batas<br>di Hotel Kami!</h1>
                <div class="box">
                    <span class="box-left" id="checkin_box">
                        <p>Check In</p>
                        <input type="text" id="checkin_date" readonly>
                    </span>
                    <span class="box-right" id="checkout_box">
                        <p>Check Out</p>
                        <input type="text" id="checkout_date" readonly>
                    </span>                                      
                    <div class="box-bottom" onclick="toggleOptions()">
                        <p>Rooms</p>
                        <h3 id="selectedOption">1 Room, 2 Guests</h3>
                        <div class="options" id="options">
                            <p style="font-weight: bold; font-size: 14px;">Rooms</p>
                            <div class="option" onclick="selectRoomOption('1 Room,')">1 Room</div>
                            <div class="option" onclick="selectRoomOption('2 Rooms,')">2 Rooms</div>
                    
                            <p style="font-weight: bold; font-size: 14px;">Guests</p>
                            <div class="option" onclick="selectGuestOption('1 Guest')">1 Guest</div>
                            <div class="option" onclick="selectGuestOption('2 Guests')">2 Guests</div>
                            <div class="option" onclick="selectGuestOption('3 Guests')">3 Guests</div>
                            <div class="option" onclick="selectGuestOption('4 Guests')">4 Guests</div>
                        </div>
                    </div>
                    <a href="#" class="btn-cari"><img src="cari.svg"> Cari</a>
                </div>
            </div>
            <div class="right-content">
                <img src="HoteWise Logo.svg">
            </div>
        </div>

        <footer class="footer">
            <div class="footer-top">
                <img src="ig.svg">
                <img src="twt.svg">
                <img src="fb.svg">
            </div>
            <div class="footer-bottom">
                <p>Copyright 2024 by WiseHotel Teams. All rights reserved</p>
            </div>
        </footer>

        <script>
            $(function() {
                var today = new Date();
                var tomorrow = new Date(today);
                tomorrow.setDate(today.getDate() + 1);
        
                $("#checkin_box").click(function() {
                    $("#checkin_date").datepicker("show");
                });
        
                $("#checkout_box").click(function() {
                    $("#checkout_date").datepicker("show");
                });
        
                $("#checkin_date").datepicker({
                    dateFormat: 'dd MM yy',
                    minDate: 0,
                    onSelect: function(date) {
                        var selectedDate = new Date(date);
                        var endDate = new Date(selectedDate);
                        endDate.setDate(selectedDate.getDate() + 1);
                        $("#checkout_date").datepicker("option", "minDate", endDate);
                    }
                });
        
                $("#checkout_date").datepicker({
                    dateFormat: 'dd MM yy',
                    minDate: 1
                });
        
                $("#checkin_date").datepicker("setDate", today);
                $("#checkout_date").datepicker("setDate", tomorrow);
            });
        </script>        

        <script>
            let selectedOption = document.getElementById('selectedOption');
            selectedOption.innerText = "1 Room, 2 Guests";

            function toggleOptions() {
                let options = document.getElementById('options');
                if (options.style.display === 'block') {
                    options.style.display = 'none';
                } else {
                    options.style.display = 'block';
                }
            }

            document.addEventListener('click', function(event) {
                let options = document.getElementById('options');
                let boxBottom = document.querySelector('.box-bottom');
                if (!options.contains(event.target) && !boxBottom.contains(event.target)) {
                    options.style.display = 'none';
                }
            });
            function selectRoomOption(option) {
                selectedOption.innerText = option + selectedOption.innerText.split(',')[1];
                toggleOptions();
            }

            function selectGuestOption(option) {
                selectedOption.innerText = selectedOption.innerText.split(',')[0] + ', ' + option;
                toggleOptions();
            }
        </script>   
    </body>
</html>
