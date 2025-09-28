<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>SPK SAW Siswa Terbaik SMAN 6 - Ubah Profile <?= $dataUser['username']; ?></title>

</head>

<body id="page-top">

	<?php 
        if (isset($_POST['btnUbahProfile'])) {
            $nama = htmlspecialchars($_POST['nama']);
        
            $id_user = $dataUser['id_user'];
            $update_profile = mysqli_query($conn, "UPDATE user SET nama = '$nama' WHERE id_user = '$id_user'");

            if ($update_profile) {
                $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Profile berhasil diperbaharui!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Profile berhasil diperbaharui!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'profile.php';
                            }
                        });
                    </script>
                ";
                exit;
            } else {
                $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Profile gagal diperbaharui!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Profile gagal diperbaharui!'
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
                        <h1 class="h3 mb-0 text-gray-800">Ubah Profile <?= $dataUser['username']; ?></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="container-fluid">
                        <form method="post" enctype="multipart/form-data"> 
                            <div class="card-body">
                                <div class="form-group"> 
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" disabled style="cursor: not-allowed;"  class="form-control" id="username" name="username" value="<?= $dataUser['username']; ?>" required>
                                </div>
                                <div class="form-group"> 
                                    <label for="jabatan" class="form-label">Jabatan</label> 
                                    <select disabled style="cursor: not-allowed;"  class="custom-select" id="jabatan" name="jabatan">
                                        <option value="<?= $dataUser['jabatan']; ?>"><?= ucwords($dataUser['jabatan']); ?></option>
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    <label for="nama" class="form-label">Nama</label> 
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $dataUser['nama']; ?>" required>
                                </div>
                            </div> 
                            <div class="card-footer pt-3 text-end">
                                <button type="submit" name="btnUbahProfile" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Submit</button>
                            </div> 
                        </form> 
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->
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