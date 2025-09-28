<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_kriteria = $_GET['id_kriteria'];
    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria WHERE id_kriteria = '$id_kriteria'");
    $data_kriteria = mysqli_fetch_assoc($kriteria);

    $kriteria = $data_kriteria['kriteria'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>Ubah Kriteria - <?= $kriteria; ?></title>

</head>

<body id="page-top">

    <?php
        if (isset($_POST['btnUbahKriteria'])) {
            $kriteria = htmlspecialchars($_POST['kriteria']);
            $bobot = htmlspecialchars($_POST['bobot']);
            $atribut = htmlspecialchars($_POST['atribut']);

            $update_kriteria = mysqli_query($conn, "UPDATE kriteria SET kriteria = '$kriteria', bobot = '$bobot', atribut = '$atribut' WHERE id_kriteria = '$id_kriteria'");

            if ($update_kriteria) {
                $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kriteria $kriteria berhasil diubah!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Kriteria " . $kriteria . " berhasil diubah!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'kriteria.php';
                            }
                        });
                    </script>
                ";
                exit;
            } else {
                $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kriteria $kriteria gagal diubah!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Kriteria " . $kriteria . " gagal diubah!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.history.back();
                            }
                        });
                    </script>
                ";
                exit;
            }
        }
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once 'include/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once 'include/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Ubah Kriteria</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="kriteria">Kriteria</label>
                                            <input type="text" class="form-control" id="kriteria" value="<?= $data_kriteria['kriteria']; ?>" name="kriteria" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="bobot">Bobot</label>
                                            <input type="number" step="0.01" class="form-control" id="bobot" name="bobot" required value="<?= $data_kriteria['bobot']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="atribut">Atribut</label>
                                            <select class="custom-select" id="atribut" name="atribut" required>
                                                <?php if ($data_kriteria['atribut'] == 'Benefit'): ?>
                                                    <option value="Benefit">Benefit</option>
                                                    <option value="Cost">Cost</option>
                                                <?php else: ?>
                                                    <option value="Cost">Cost</option>
                                                    <option value="Benefit">Benefit</option>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="btnUbahKriteria" class="btn btn-primary">Ubah Kriteria</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SPK SAW Siswa Terbaik SMAN 6 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php include_once 'include/script.php'; ?>

</body>

</html>