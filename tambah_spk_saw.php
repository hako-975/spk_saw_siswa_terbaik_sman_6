<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $alternatif = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY nama_siswa ASC");
    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
    $kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY kelas ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>Tambah SPK SAW</title>

</head>

<body id="page-top">

    <?php
        if (isset($_POST['btnTambahSPKSAW'])) {
            $id_kelas = $_POST['id_kelas'];
            $hasil = mysqli_query($conn, "INSERT INTO hasil_saw VALUES ('', '', '$id_kelas', '', CURRENT_TIMESTAMP())");
            $id_hasil_saw = mysqli_insert_id($conn);
            
            $penilaian_data = $_POST['penilaian'];
            $error = false;
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
                $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'SPK SAW Berhasil ditambahkan!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");
                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'SPK SAW berhasil ditambahkan!'
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
                            text: 'SPK SAW gagal ditambahkan!'
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
                        <h1 class="h3 mb-0 text-gray-800">Tambah SPK SAW</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="kelas">Kelas</label>
                                                <select name="id_kelas" id="id_kelas" class="custom-select">
                                                    <option value="0">-- Pilih Kelas --</option>
                                                    <?php foreach ($kelas as $dk): ?>
                                                        <option value="<?= $dk['id_kelas']; ?>"><?= $dk['kelas']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div id="alternatif-container">
                                            </div>
                                        </div>
                                        <div class="card-footer pt-3 text-end">
                                            <button type="submit" name="btnTambahSPKSAW" class="btn btn-primary">
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
    <script>
        $(document).ready(function() {
            $("#id_kelas").change(function() {
                var id_kelas = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "get_alternatif.php",
                    data: { id_kelas: id_kelas },
                    beforeSend: function() {
                        $("#alternatif-container").html("<p class='text-muted'>Memuat data...</p>");
                    },
                    success: function(response) {
                        $("#alternatif-container").html(response);
                    },
                    error: function() {
                        $("#alternatif-container").html("<p class='text-danger'>Gagal mengambil data.</p>");
                    }
                });
            });
        });
    </script>

</body>

</html>