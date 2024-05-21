<?php
    $servername = "sql12.freesqldatabase.com"; 
    $username = "sql12708056";
    $password = "MV99vXfbvB";
    $dbname = "sql12708056";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
?>
