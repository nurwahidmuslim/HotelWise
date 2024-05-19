<?php
// fetch_room_numbers.php
include 'koneksi.php'; // File to connect to the database

$roomType = $_POST['roomType'];

// Fetch available room numbers based on the selected room type and status
$query = "
    SELECT no_kamar 
    FROM kamar 
    WHERE tipe_kamar = (
        SELECT id_kamar 
        FROM tipe_kamar 
        WHERE tipe_kamar = ?
    ) AND status = 'tersedia'
";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $roomType);
$stmt->execute();
$result = $stmt->get_result();

$roomNumbers = [];
while ($row = $result->fetch_assoc()) {
    $roomNumbers[] = $row['no_kamar'];
}

echo json_encode($roomNumbers);
?>
