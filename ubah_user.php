<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_user = $_GET['id_user'];
    $user = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'");
    $data_user = mysqli_fetch_assoc($user);

    $username = $data_user['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>Ubah User - <?= $data_user['username']; ?></title>

</head>

<body id="page-top">

    <?php
        if (isset($_POST['btnUbahUser'])) {
            $jabatan = htmlspecialchars($_POST['jabatan']);
            
            $nama = htmlspecialchars($_POST['nama']);

            $insert_user = mysqli_query($conn, "UPDATE user SET nama = '$nama', jabatan = '$jabatan' WHERE id_user = '$id_user'");

            if ($insert_user) {
                $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'User $username berhasil diubah!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'User " . $username . " berhasil diubah!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'user.php';
                            }
                        });
                    </script>
                ";
                exit;
            } else {
                $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'User $username gagal diubah!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'User " . $username . " gagal diubah!'
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
                        <h1 class="h3 mb-0 text-gray-800">Ubah User</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input style="cursor: not-allowed;" disabled type="text" class="form-control" id="username" name="username" value="<?= $data_user['username']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan</label>
                                            <select class="custom-select" id="jabatan" name="jabatan" required>
                                                <?php if ($data_user['jabatan'] == 'admin'): ?>
                                                    <option value="Admin">Admin</option>
                                                    <option value="Petugas">Petugas</option>
                                                <?php else: ?>
                                                    <option value="Petugas">Petugas</option>
                                                    <option value="Admin">Admin</option>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $data_user['nama']; ?>" required>
                                        </div>
                                        <button type="submit" name="btnUbahUser" class="btn btn-primary">Ubah User</button>
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