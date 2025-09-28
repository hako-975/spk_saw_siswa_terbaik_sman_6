<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>SPK SAW Siswa Terbaik SMAN 6 - Kriteria</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Kriteria</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <?php if ($dataUser['jabatan'] == 'Admin'): ?>
                                        <a href="tambah_kriteria.php" class="btn btn-primary mb-3"><i class="fas fa-fw fa-plus"></i> Tambah Kriteria</a>
                                    <?php endif ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Kriteria</th>
                                                    <th class="text-center">Bobot</th>
                                                    <th class="text-center">Atribut</th>
                                                    <?php if ($dataUser['jabatan'] == 'Admin'): ?>
                                                        <th class="text-center">Aksi</th>
                                                    <?php endif ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($kriteria as $dk): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i++; ?>.</td>
                                                        <td><?= $dk['kriteria']; ?></td>
                                                        <td><?= $dk['bobot']; ?></td>
                                                        <td><?= $dk['atribut']; ?></td>
                                                        <?php if ($dataUser['jabatan'] == 'Admin'): ?>
                                                            <td>
                                                                <a href="ubah_kriteria.php?id_kriteria=<?= $dk['id_kriteria']; ?>" class="btn btn-success"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                                <a href="hapus_kriteria.php?id_kriteria=<?= $dk['id_kriteria']; ?>" class="btn btn-danger btn-delete" data-nama="<?= $dk['kriteria']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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