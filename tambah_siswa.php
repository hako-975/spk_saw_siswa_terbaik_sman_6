<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY kelas ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>Tambah Siswa</title>

</head>

<body id="page-top">

    <?php
        if (isset($_POST['btnTambahSiswa'])) {
            $nama_siswa = htmlspecialchars($_POST['nama_siswa']);
            $id_kelas = htmlspecialchars($_POST['id_kelas']);

            $insert_alternatif = mysqli_query($conn, "INSERT INTO alternatif VALUES ('', '$nama_siswa', '$id_kelas')");

            if ($insert_alternatif) {
                $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Siswa $nama_siswa berhasil ditambahkan!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Siswa " . $nama_siswa . " berhasil ditambahkan!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'siswa.php';
                            }
                        });
                    </script>
                ";
                exit;
            } else {
                $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Siswa $nama_siswa gagal ditambahkan!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Siswa " . $nama_siswa . " gagal ditambahkan!'
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
                        <h1 class="h3 mb-0 text-gray-800">Tambah Siswa</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="nama_siswa">Siswa</label>
                                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_kelas">Kelas</label>
                                            <select name="id_kelas" id="id_kelas" class="custom-select">
                                                <?php foreach ($kelas as $dk): ?>
                                                    <option value="<?= $dk['id_kelas']; ?>"><?= $dk['kelas']; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="btnTambahSiswa" class="btn btn-primary">Tambah Siswa</button>
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