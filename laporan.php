<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $hasil_saw = mysqli_query($conn, "SELECT * FROM hasil_saw INNER JOIN kelas ON hasil_saw.id_kelas = kelas.id_kelas LEFT JOIN alternatif ON hasil_saw.id_alternatif = alternatif.id_alternatif");
    $kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY kelas ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>SPK SAW Siswa Terbaik SMAN 6 - Laporan</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row mb-5">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Nama Siswa</th>
                                                    <th class="text-center">Kelas</th>
                                                    <th class="text-center">Nilai Preferensi</th>
                                                    <th class="text-center">Dibuat Pada</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($hasil_saw as $dk): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i++; ?>.</td>
                                                        <td class="text-center"><?= $dk['nama_siswa']; ?></td>
                                                        <td class="text-center"><?= $dk['kelas']; ?></td>
                                                        <td class="text-center"><?= $dk['nilai_preferensi_tertinggi']; ?></td>
                                                        <td class="text-center"><?= $dk['dibuat_pada']; ?></td>
                                                        <td class="text-center">
                                                            <a href="print.php?id_hasil_saw=<?= $dk['id_hasil_saw']; ?>" target="_blank" class="mr-3 btn btn-success"><i class="fas fa-fw fa-print"></i> Print</a>
                                                            <a href="print.php?id_hasil_saw=<?= $dk['id_hasil_saw']; ?>&file_excel=true" target="_blank" class="mr-3 btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Excel</a>
                                                        </td>
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