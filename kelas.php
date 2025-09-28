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

    <title>SPK SAW Siswa Terbaik SMAN 6 - Kelas</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Kelas</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="tambah_kelas.php" class="btn btn-primary mb-3"><i class="fas fa-fw fa-plus"></i> Tambah Kelas</a>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="150" class="text-center">No.</th>
                                                    <th class="text-center">Kelas</th>
                                                    <?php if ($dataUser['jabatan'] == 'Admin'): ?>
                                                        <th width="250" class="text-center">Aksi</th>
                                                    <?php endif ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($kelas as $dk): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i++; ?>.</td>
                                                        <td class="text-center"><?= $dk['kelas']; ?></td>
                                                        <?php if ($dataUser['jabatan'] == 'Admin'): ?>
                                                            <td class="text-center">
                                                                <a href="ubah_kelas.php?id_kelas=<?= $dk['id_kelas']; ?>" class="btn btn-success"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                                <a href="hapus_kelas.php?id_kelas=<?= $dk['id_kelas']; ?>" class="btn btn-danger btn-delete" data-nama="<?= $dk['kelas']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                            </td>
                                                        <?php endif ?>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
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