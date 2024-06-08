<?php
include 'db/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare('UPDATE pemesanan SET action = ? WHERE id_pemesanan = ?');
    $stmt->bind_param('si', $status, $id);
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
}
?>
