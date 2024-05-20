<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'svg'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array($filetype, $allowed)) {
            $new_filename = uniqid() . "." . $filetype;
            $upload_path = '../gambar/' . $new_filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $roomId = $_POST['room_id'];

                // Fetch the current image filename from the database
                $query = "SELECT foto FROM tipe_kamar WHERE id_kamar = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $roomId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row && $row['foto']) {
                    $current_image = $row['foto'];
                    $current_image_path = '../gambar/' . $current_image;

                    // Delete the current image file if it exists
                    if (file_exists($current_image_path)) {
                        unlink($current_image_path);
                    }
                }

                // Update the database with the new image filename
                $query = "UPDATE tipe_kamar SET foto = ? WHERE id_kamar = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $new_filename, $roomId);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Image uploaded successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'File move failed.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
    }
}
?>
