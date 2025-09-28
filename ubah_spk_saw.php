<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_hasil_saw = $_GET['id_hasil_saw'];

    $data_hasil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hasil_saw INNER JOIN alternatif ON hasil_saw.id_alternatif = alternatif.id_alternatif INNER JOIN kelas ON hasil_saw.id_kelas = kelas.id_kelas WHERE hasil_saw.id_hasil_saw = '$id_hasil_saw'"));

    if ($data_hasil == null) {
        header("Location: spk_saw.php");
        exit;
    }
    
    $id_kelas = $data_hasil['id_kelas'];

    $alternatif = mysqli_query($conn, "SELECT * FROM alternatif WHERE id_kelas = '$id_kelas' ORDER BY nama_siswa ASC");
    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY kriteria ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>Ubah SPK SAW - Kelas <?= $data_hasil['kelas']; ?></title>

</head>

<body id="page-top">

    <?php
        if (isset($_POST['btnUbahSPKSAW'])) {
            $penilaian_data = $_POST['penilaian'];
            $error = false;
            mysqli_query($conn, "DELETE FROM penilaian WHERE id_hasil_saw = '$id_hasil_saw'");
            foreach ($penilaian_data as $id => $data) {
                $id_alternatif = $data['id_alternatif'];
                foreach ($data as $key => $nilai_data) {
                    // Abaikan 'id_alternatif' karena bukan array nilai
                    if (!is_array($nilai_data)) {
                        continue;
                    }

                    $id_kriteria = $nilai_data['id_kriteria'];
                    $nilai = $nilai_data['nilai'];

                    // Query insert
                    $query = "INSERT INTO penilaian VALUES ('', '$id_kriteria', '$id_alternatif', '$nilai', '', '$id_hasil_saw')";

                    if (!mysqli_query($conn, $query)) {
                        $error = true;
                        break;
                    }
                }
            }

            if (!$error) {
                $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'SPK SAW Berhasil diubah!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");
                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'SPK SAW berhasil diubah!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'hasil_spk_saw.php?id_hasil_saw=$id_hasil_saw';
                            }
                        });
                    </script>
                ";
                exit;
            } else {
                $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'SAW gagal dihitung!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'SPK SAW gagal diubah!'
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
                        <h1 class="h3 mb-0 text-gray-800">Ubah SPK SAW  - Kelas <?= $data_hasil['kelas']; ?></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="card-body">
                                            <?php foreach ($alternatif as $da): ?>
                                                <input type="hidden" name="penilaian[<?= $da['id_alternatif']; ?>][id_alternatif]" value="<?= $da['id_alternatif']; ?>">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="fw-bold text-dark"><?= htmlspecialchars($da['nama_siswa']); ?></h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <?php $i = 1; ?>
                                                    <?php foreach ($kriteria as $dk): ?>
                                                        <input type="hidden" name="penilaian[<?= $da['id_alternatif']; ?>][<?= $dk['id_kriteria']; ?>][id_kriteria]" value="<?= $dk['id_kriteria']; ?>">
                                                        <div class="mb-3 col">
                                                            <label for="nilai_<?= $da['id_alternatif']; ?>_<?= $dk['id_kriteria']; ?>" class="form-label">
                                                                <?= htmlspecialchars($dk['kriteria']); ?> (C<?= $i++; ?> - <?= $dk['atribut']; ?>)
                                                            </label>
                                                            <?php 
                                                                $id_alternatif = $da['id_alternatif'];
                                                                $id_kriteria = $dk['id_kriteria'];
                                                                $penilaian = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM penilaian WHERE id_hasil_saw = '$id_hasil_saw' AND id_alternatif = '$id_alternatif' AND id_kriteria = '$id_kriteria'"));
                                                            ?>
                                                            <input type="number" step="0.01" id="nilai_<?= $da['id_alternatif']; ?>_<?= $dk['id_kriteria']; ?>" class="form-control" name="penilaian[<?= $da['id_alternatif']; ?>][<?= $dk['id_kriteria']; ?>][nilai]" min="0" value="<?= $penilaian['nilai']; ?>" required>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <hr>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="card-footer pt-3 text-end">
                                            <button type="submit" name="btnUbahSPKSAW" class="btn btn-primary">
                                                <i class="fas fa-fw fa-save"></i> Submit
                                            </button>
                                        </div>
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