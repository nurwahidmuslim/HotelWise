<?php
include 'db/db.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil level pengguna dari session
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT level FROM `hw-admin` WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Periksa level pengguna, jika bukan staff, arahkan kembali ke login
if ($user['level'] != 2) {
    header("Location: login.php");
    exit;
}

// Ambil username dari session
$username = $_SESSION['username'];

$sql = "SELECT * FROM pemesanan ORDER BY waktu_input DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pemesanan - Staff</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">HotelWise</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    Staff, <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($username); ?></span>
                </a><!-- End Profile Image Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link " href="forms-elements.html">
                <i class="bi bi-journal-text"></i>
                <span>Pemesanan</span>
            </a>
        </li><!-- End Form Nav -->
    </ul>
</aside><!-- End Sidebar-->

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Pemesanan</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Daftar Pemesanan</h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Tipe Kamar</th>
                                            <th scope="col">Tanggal Waktu Pemesanan</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $badgeClass = $row["action"] == "Diterima" ? "bg-success" : ($row["action"] == "Ditolak" ? "bg-danger" : "bg-secondary");
                                                echo "<tr>
                                                    <th scope='row'>#" . $row["id_pemesanan"] . "</th>
                                                    <td>" . $row["nama"] . "</td>
                                                    <td>" . $row["tipe_kamar"] . "</td>
                                                    <td>" . $row["waktu_input"] . "</td>
                                                    <td><span class='badge $badgeClass status-badge' data-id='" . $row["id_pemesanan"] . "' data-status='" . $row["action"] . "'>" . $row["action"] . "</span></td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
</main><!-- End #main -->

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Ubah Status Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <input type="hidden" id="pemesananId">
                    <div id="detailPemesanan">
                        <!-- Detail Pemesanan will be populated here -->
                    </div>
                    <div class="mb-3 mt-2">
                        <label for="statusSelect" class="form-label" style="font-weight: bold">Status</label>
                        <select class="form-select" id="statusSelect">
                            <option value="Pending">Pending</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
        document.querySelectorAll('.status-badge').forEach(function (badge) {
            badge.addEventListener('click', function () {
                var pemesananId = this.getAttribute('data-id');
                var currentStatus = this.getAttribute('data-status');
                document.getElementById('pemesananId').value = pemesananId;
                document.getElementById('statusSelect').value = currentStatus;

                // Fetch and display details
                fetch('detail_pemesanan.php?id=' + pemesananId)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('detailPemesanan').innerHTML = data;
                        statusModal.show();
                    });
            });
        });

        document.getElementById('statusForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var pemesananId = document.getElementById('pemesananId').value;
            var newStatus = document.getElementById('statusSelect').value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send("id=" + pemesananId + "&status=" + newStatus);
        });
    });
</script>

</body>
</html>
