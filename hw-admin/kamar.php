<?php
include 'db/db.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Ambil username dari session
$username = $_SESSION['username'];

// Fungsi untuk mengubah tipe_kamar dari angka menjadi teks
function getRoomType($type) {
  switch ($type) {
    case 1:
      return "Standard Single/Twin Room";
    case 2:
      return "Superior Double Room";
    case 3:
      return "Comfort Triple Room";
    default:
      return "Unknown Type";
  }
}

// Fungsi untuk menyimpan data kamar ke database
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_kamar'])) {
  $no_kamar = $_POST['no_kamar'];
  $tipe_kamar = $_POST['tipe_kamar'];
  $status = "tersedia";

  // Cek apakah nomor kamar sudah ada
  $sql_check = "SELECT * FROM kamar WHERE no_kamar = ?";
  $stmt_check = $conn->prepare($sql_check);
  $stmt_check->bind_param("i", $no_kamar);
  $stmt_check->execute();
  $result_check = $stmt_check->get_result();

  if ($result_check->num_rows > 0) {
    $error = "Nomor kamar sudah tersedia.";
  } else {
    $sql = "INSERT INTO kamar (no_kamar, tipe_kamar, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $no_kamar, $tipe_kamar, $status);

    if ($stmt->execute()) {
      $error = "Kamar berhasil ditambahkan";
    } else {
      $error = "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
  }

  $stmt_check->close();
}

// Fungsi untuk menghapus data kamar dari database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_kamar'])) {
  $no_kamar = $_POST['no_kamar'];

  $sql_delete = "DELETE FROM kamar WHERE no_kamar = ?";
  $stmt_delete = $conn->prepare($sql_delete);
  $stmt_delete->bind_param("i", $no_kamar);

  if ($stmt_delete->execute()) {
    $error = "Kamar berhasil dihapus";
  } else {
    $error = "Error: " . $sql_delete . "<br>" . $conn->error;
  }

  $stmt_delete->close();
}

// Fungsi untuk mengupdate status kamar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_kamar'])) {
  $no_kamar = $_POST['no_kamar'];
  $status = $_POST['status'];

  $sql_update = "UPDATE kamar SET status = ? WHERE no_kamar = ?";
  $stmt_update = $conn->prepare($sql_update);
  $stmt_update->bind_param("si", $status, $no_kamar);

  if ($stmt_update->execute()) {
    $error = "Status kamar berhasil diubah";
  } else {
    $error = "Error: " . $sql_update . "<br>" . $conn->error;
  }

  $stmt_update->close();
}

$sql = "SELECT * FROM kamar";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kamar - Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">HotelWise</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            Admin, <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($username); ?></span>
          </a><!-- End Profile Iamge Icon -->

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
          <span>Kamar</span>
        </a>
      </li><!-- End Form Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tambah Kamar</h5>

              <!-- General Form Elements -->
              <form method="POST" action="">
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Nomor Kamar</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name="no_kamar" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Tipe Kamar</label>
                  <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" name="tipe_kamar" required>
                      <option selected disabled>Pilih tipe kamar</option>
                      <option value="1">Standard Single/Twin Room</option>
                      <option value="2">Superior Double Room</option>
                      <option value="3">Comfort Triple Room</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" name="add_kamar" class="btn btn-primary">Tambah</button>
                  </div>
                </div>

              </form><!-- End General Form Elements -->

            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data semua kamar</h5>

              <?php if (!empty($error)): ?>
                <div class="alert alert-info" role="alert">
                  <?php echo $error; ?>
                </div>
              <?php endif; ?>
              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No Kamar</th>
                    <th scope="col">Tipe Kamar</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>
                          <th scope='row'>" . $row["no_kamar"] . "</th>
                          <td>" . getRoomType($row["tipe_kamar"]) . "</td>
                          <td>" . $row["status"] . "</td>
                          <td>
                            <a href='#' class='edit-link' data-id='" . $row["no_kamar"] . "' data-status='" . $row["status"] . "'><i class='bi bi-pencil-square'></i></a> |
                            <a href='#' class='delete-link' data-id='" . $row["no_kamar"] . "'><i class='bi bi-trash'></i></a>
                          </td>
                        </tr>";
                    }
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>

        </div>

      </div>
    </section>

  </main><!-- End #main -->

  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus kamar ini? <br>
          Nomor Kamar : <strong id="deleteRoomNumber"></strong>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <form method="POST" action="">
            <input type="hidden" name="no_kamar" id="deleteNoKamar">
            <button type="submit" name="delete_kamar" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Status Kamar -->
  <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editStatusModalLabel">Edit Status Kamar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">
            <input type="hidden" name="no_kamar" id="editNoKamar">
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Status Kamar</label>
              <div class="col-sm-8">
                <select class="form-select" aria-label="Default select example" name="status" id="editStatus" required>
                  <option value="tersedia">Tersedia</option>
                  <option value="tidak tersedia">Tidak Tersedia</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" name="update_kamar" class="btn btn-primary">Update</button>
            </div>
          </form>
          <div>
            <strong>Nomor Kamar: </strong><span id="editRoomNumber"></span>
          </div>
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

  <!-- Script for Edit and Delete Confirmation Modal -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Delete Confirmation
      var deleteLinks = document.querySelectorAll('.delete-link');
      deleteLinks.forEach(function(link) {
        link.addEventListener('click', function() {
          var noKamar = this.getAttribute('data-id');
          document.getElementById('deleteNoKamar').value = noKamar;
          document.getElementById('deleteRoomNumber').innerText = noKamar;
          var confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
          confirmDeleteModal.show();
        });
      });

      // Edit Status
      var editLinks = document.querySelectorAll('.edit-link');
      editLinks.forEach(function(link) {
        link.addEventListener('click', function() {
          var noKamar = this.getAttribute('data-id');
          var status = this.getAttribute('data-status');
          document.getElementById('editNoKamar').value = noKamar;
          document.getElementById('editStatus').value = status;
          document.getElementById('editRoomNumber').innerText = noKamar;
          var editStatusModal = new bootstrap.Modal(document.getElementById('editStatusModal'));
          editStatusModal.show();
        });
      });
    });
  </script>

</body>

</html>
