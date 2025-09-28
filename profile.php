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

    <title>SPK SAW Siswa Terbaik SMAN 6 - Profile</title>

</head>

<body id="page-top">

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
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="container-fluid">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Nama Lengkap: <?= $dataUser['nama']; ?></li>
                                <li class="list-group-item">Username: <?= $dataUser['username']; ?></li>
                                <li class="list-group-item">Jabatan: <?= $dataUser['jabatan']; ?></li>
                            </ul>
                        </div>
                        <br>
                        <!-- Button trigger modal -->
                        <a href="ubah_profile.php" class="btn btn-success">
                            <i class="fas fa-fw fa-edit"></i> Edit
                        </a>

                        <a href="ubah_password.php" class="btn btn-danger">
                            <i class="fas fa-fw fa-lock"></i> Change Password
                        </a>
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