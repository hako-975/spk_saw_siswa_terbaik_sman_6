<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_alternatif = $_GET['id_alternatif'];
    $alternatif = mysqli_query($conn, "SELECT * FROM alternatif INNER JOIN kelas ON alternatif.id_kelas = kelas.id_kelas WHERE id_alternatif = '$id_alternatif'");
    $data_alternatif = mysqli_fetch_assoc($alternatif);
    $kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY kelas ASC");

    $alternatif = $data_alternatif['nama_siswa'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>Ubah Siswa - <?= $alternatif; ?></title>

</head>

<body id="page-top">

    <?php
        if (isset($_POST['btnUbahSiswa'])) {
            $nama_siswa = htmlspecialchars($_POST['nama_siswa']);
            $id_kelas = htmlspecialchars($_POST['id_kelas']);

            $update_alternatif = mysqli_query($conn, "UPDATE alternatif SET nama_siswa = '$nama_siswa', id_kelas = '$id_kelas' WHERE id_alternatif = '$id_alternatif'");

            if ($update_alternatif) {
                $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Siswa $alternatif berhasil diubah!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Siswa " . $alternatif . " berhasil diubah!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'siswa.php';
                            }
                        });
                    </script>
                ";
                exit;
            } else {
                $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Siswa $alternatif gagal diubah!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Siswa " . $alternatif . " gagal diubah!'
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
                        <h1 class="h3 mb-0 text-gray-800">Ubah Siswa</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="nama_siswa">Nama Siswa</label>
                                            <input type="text" class="form-control" id="nama_siswa" value="<?= $data_alternatif['nama_siswa']; ?>" name="nama_siswa" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kelas">Kelas</label>
                                            <select name="id_kelas" id="id_kelas" class="custom-select">
                                                <option value="<?= $data_alternatif['id_kelas']; ?>"><?= $data_alternatif['kelas']; ?></option>
                                                <?php foreach ($kelas as $dk): ?>
                                                    <?php if ($dk['id_kelas'] != $data_alternatif['id_kelas']): ?>
                                                        <option value="<?= $dk['id_kelas']; ?>"><?= $dk['kelas']; ?></option>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="btnUbahSiswa" class="btn btn-primary">Ubah Siswa</button>
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