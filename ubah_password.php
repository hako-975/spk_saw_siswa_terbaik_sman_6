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

    <title>SPK SAW Siswa Terbaik SMAN 6 - Ubah Password <?= $dataUser['username']; ?></title>

</head>

<body id="page-top">

	<?php 
        if (isset($_POST['btnUbahPassword'])) {
            $password_lama = htmlspecialchars($_POST['password_lama']);
            $password = htmlspecialchars($_POST['password']);
            $ulangi_password = htmlspecialchars($_POST['ulangi_password']);
            
            // check password lama
            $username = $dataUser['username']; // or wherever you store the current user's username
            $query = mysqli_query($conn, "SELECT password FROM user WHERE username = '$username'");
            
            $row = mysqli_fetch_assoc($query);
            $password_hash = $row['password']; // assuming the password is stored hashed
            
            // Check if the old password is correct
            if (password_verify($password_lama, $password_hash)) {
                if ($password == $ulangi_password) {
                    // Passwords match, update the password
                    $new_password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $update_query = mysqli_query($conn, "UPDATE user SET password = '$new_password_hash' WHERE username = '$username'");
                    
                    if ($update_query) {
                        $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Password berhasil diperbaharui!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                        echo "
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Password berhasil diperbaharui!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'profile.php';
                                    }
                                });
                            </script>
                        ";
                        exit;
                    } else {
                        $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Password gagal diperbaharui!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

                        echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Password gagal diperbaharui!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.history.back();
                                    }
                                });
                            </script>
                        ";
                        exit;
                    }
                } else {
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Password tidak sama dengan ulangi password!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.history.back();
                                }
                            });
                        </script>
                    ";
                    exit;
                }
            } else {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Password lama salah!'
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
                        <h1 class="h3 mb-0 text-gray-800">Ubah Password <?= $dataUser['username']; ?></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="container-fluid">
                        <form method="post" enctype="multipart/form-data"> 
                            <div class="card-body">
                                <div class="form-group"> 
                                    <label for="password_lama" class="form-label">Password Lama</label> 
                                    <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                                </div>
                                <div class="form-group"> 
                                    <label for="password" class="form-label">Password</label> 
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group"> 
                                    <label for="password" class="form-label">Verifikasi Password</label> 
                                    <input type="password" class="form-control" id="password" name="ulangi_password" required>
                                </div>
                            </div> 
                            <div class="card-footer pt-3 text-end">
                                <button type="submit" name="btnUbahPassword" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Submit</button>
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