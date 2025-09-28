<?php 
    require_once 'connection.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_hasil_saw = $_GET['id_hasil_saw'];
    $data_hasil_saw = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hasil_saw INNER JOIN kelas ON hasil_saw.id_kelas = kelas.id_kelas WHERE id_hasil_saw = '$id_hasil_saw'"));
    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
    $penilaian = mysqli_query($conn, "SELECT * FROM penilaian INNER JOIN kriteria ON penilaian.id_kriteria = kriteria.id_kriteria INNER JOIN alternatif ON penilaian.id_alternatif = alternatif.id_alternatif WHERE penilaian.id_hasil_saw = '$id_hasil_saw' GROUP BY penilaian.id_alternatif ORDER BY alternatif.nama_siswa ASC");

    $alternatif = mysqli_query($conn, "SELECT * FROM alternatif");


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.13.18/dist/katex.min.css">

    <title>Hasil SPK SAW Siswa Terbaik SMAN 6 - Kelas <?= $data_hasil_saw['kelas']; ?></title>

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
                        <h1 class="h3 mb-0 text-gray-800">Hasil SPK SAW Siswa Terbaik SMAN 6 - Kelas <?= $data_hasil_saw['kelas']; ?></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header text-center">
                                    <h4 class="mb-0">Data Awal</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Alternatif</th>
                                                    <?php $i = 1; ?>
                                                    <?php foreach ($kriteria as $dk): ?>
                                                        <th class="text-center"><?= $dk['kriteria']; ?> (C<?= $i++; ?> - <?= $dk['atribut']; ?>)</th>
                                                    <?php endforeach ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($penilaian as $dp): ?>
                                                    <tr>
                                                        <td><?= $dp['nama_siswa']; ?></td>
                                                        <?php foreach ($kriteria as $dk): ?>
                                                            <?php 
                                                                $id_kriteria_dk = $dk['id_kriteria'];
                                                                $id_alternatif_dp = $dp['id_alternatif'];
                                                                $nilai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nilai FROM penilaian WHERE id_kriteria = '$id_kriteria_dk' AND id_alternatif = '$id_alternatif_dp' AND id_hasil_saw = '$id_hasil_saw'"));
                                                            ?>
                                                            <td><?= $nilai['nilai']; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header text-center">
                                    <h4 class="mb-0">Bobot Kriteria (<span class="formula">w</span>)</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <?php $i = 1; ?>
                                                    <?php foreach ($kriteria as $dk): ?>
                                                        <th class="text-center"><?= $dk['kriteria']; ?> (C<?= $i++; ?> - <?= $dk['atribut']; ?>)</th>
                                                    <?php endforeach ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach ($kriteria as $dk): ?>
                                                        <td><?= $dk['bobot']; ?></td>
                                                    <?php endforeach ?>
                                                </tr>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header text-center">
                                    <h4 class="mb-0">Normalisasi Matriks (<span class="formula">R</span>)</h4>
                                </div>
                                <div class="card-body">
                                    <h5>Rumus:</h5>
                                    <h5>Benefit: <span class="formula">r_{ij} = \frac{x_{ij}}{x_{max}}</span></h5>
                                    <h5>Cost: <span class="formula">r_{ij} = \frac{x_{min}}{x_{ij}}</span></h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Alternatif</th>
                                                    <?php $i = 1; ?>
                                                    <?php foreach ($kriteria as $dk): ?>
                                                        <th class="text-center"><?= $dk['kriteria']; ?> (C<?= $i++; ?> - <?= $dk['atribut']; ?>)</th>
                                                    <?php endforeach ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                // Menentukan nilai maksimum dan minimum per kriteria
                                                $nilai_kriteria = [];
                                                foreach ($kriteria as $dk) {
                                                    $id_kriteria_dk = $dk['id_kriteria'];
                                                    $result = mysqli_query($conn, "SELECT nilai FROM penilaian WHERE id_kriteria = '$id_kriteria_dk' AND id_hasil_saw = '$id_hasil_saw'");
                                                    $nilai_list = [];
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $nilai_list[] = $row['nilai'];
                                                    }
                                                    $nilai_kriteria[$id_kriteria_dk]['max'] = max($nilai_list);
                                                    $nilai_kriteria[$id_kriteria_dk]['min'] = min($nilai_list);
                                                }

                                                // Proses Normalisasi
                                                foreach ($penilaian as $dp): ?>
                                                    <tr>
                                                        <td><?= $dp['nama_siswa']; ?></td>
                                                        <?php foreach ($kriteria as $dk): ?>
                                                            <?php 
                                                                $id_kriteria_dk = $dk['id_kriteria'];
                                                                $id_alternatif_dp = $dp['id_alternatif'];
                                                                $nilai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nilai FROM penilaian WHERE id_kriteria = '$id_kriteria_dk' AND id_alternatif = '$id_alternatif_dp' AND id_hasil_saw = '$id_hasil_saw'"));
                                                                
                                                                $nilai_asli = $nilai['nilai'];
                                                                $max = $nilai_kriteria[$id_kriteria_dk]['max'];
                                                                $min = $nilai_kriteria[$id_kriteria_dk]['min'];

                                                                // Normalisasi berdasarkan atribut
                                                                if ($dk['atribut'] == 'Benefit') {
                                                                    $nilai_normalisasi = $nilai_asli / $max;
                                                                } else { // cost
                                                                    $nilai_normalisasi = $min / $nilai_asli;
                                                                }
                                                            ?>
                                                            <td><?= number_format($nilai_asli, 3); ?> / <?= number_format($max, 3); ?> = <?= number_format($nilai_normalisasi, 3); ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody> 
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header text-center">
                                    <h4 class="mb-0">Perhitungan Nilai Preferensi (<span class="formula">V</span>)</h4>
                                </div>
                                <div class="card-body">
                                    <h5>Rumus:</h5>
                                    <h5 class="formula">V_i=∑(w_j×r_{ij})</h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Alternatif</th>
                                                    <th class="text-center">Perhitungan Nilai Preferensi</th>
                                                    <th class="text-center">Nilai Preferensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                // Ambil bobot dari database
                                                $bobot_kriteria = [];
                                                foreach ($kriteria as $dk) {
                                                    $bobot_kriteria[$dk['id_kriteria']] = $dk['bobot']; // Simpan bobot kriteria
                                                }

                                                // Menentukan nilai maksimum dan minimum per kriteria
                                                $nilai_kriteria = [];
                                                foreach ($kriteria as $dk) {
                                                    $id_kriteria_dk = $dk['id_kriteria'];
                                                    $result = mysqli_query($conn, "SELECT nilai FROM penilaian WHERE id_kriteria = '$id_kriteria_dk' AND id_hasil_saw = '$id_hasil_saw'");
                                                    $nilai_list = [];
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $nilai_list[] = $row['nilai'];
                                                    }
                                                    $nilai_kriteria[$id_kriteria_dk]['max'] = max($nilai_list);
                                                    $nilai_kriteria[$id_kriteria_dk]['min'] = min($nilai_list);
                                                }

                                                // Perhitungan SAW
                                                foreach ($penilaian as $dp): 
                                                    $total_nilai = 0; // Menyimpan total nilai preferensi
                                                    $perhitungan_detail = "";
                                                ?>
                                                    <tr>
                                                        <td><?= $dp['nama_siswa']; ?></td>
                                                        <td>
                                                            <?php foreach ($kriteria as $dk): 
                                                                $id_kriteria_dk = $dk['id_kriteria'];
                                                                $id_alternatif_dp = $dp['id_alternatif'];
                                                                $nilai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nilai FROM penilaian WHERE id_kriteria = '$id_kriteria_dk' AND id_alternatif = '$id_alternatif_dp' AND id_hasil_saw = '$id_hasil_saw'"));
                                                                
                                                                $nilai_asli = $nilai['nilai'];
                                                                $max = $nilai_kriteria[$id_kriteria_dk]['max'];
                                                                $min = $nilai_kriteria[$id_kriteria_dk]['min'];

                                                                // Normalisasi berdasarkan atribut
                                                                if ($dk['atribut'] == 'Benefit') {
                                                                    $nilai_normalisasi = $nilai_asli / $max;
                                                                } else { // Cost
                                                                    $nilai_normalisasi = $min / $nilai_asli;
                                                                }

                                                                // Perhitungan nilai preferensi
                                                                $bobot = $bobot_kriteria[$id_kriteria_dk]; 
                                                                $nilai_preferensi = $bobot * $nilai_normalisasi;
                                                                $total_nilai += $nilai_preferensi;

                                                                // Tambahkan ke string perhitungan detail
                                                                $perhitungan_detail .= "({$bobot} × " . number_format($nilai_normalisasi, 3) . ") + ";
                                                            ?>
                                                            <?php endforeach ?>
                                                            <?= rtrim($perhitungan_detail, " + "); ?> <!-- Menghapus simbol '+' terakhir -->
                                                        </td>
                                                        <td><?= number_format($total_nilai, 3); ?></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody> 
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header text-center">
                                    <h4 class="mb-0">Hasil Ranking</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Ranking</th>
                                                    <th class="text-center">Alternatif</th>
                                                    <th class="text-center">Nilai Preferensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                // Ambil bobot dari database
                                                $bobot_kriteria = [];
                                                foreach ($kriteria as $dk) {
                                                    $bobot_kriteria[$dk['id_kriteria']] = $dk['bobot']; // Simpan bobot kriteria
                                                }

                                                // Menentukan nilai maksimum dan minimum per kriteria
                                                $nilai_kriteria = [];
                                                foreach ($kriteria as $dk) {
                                                    $id_kriteria_dk = $dk['id_kriteria'];
                                                    $result = mysqli_query($conn, "SELECT nilai FROM penilaian WHERE id_kriteria = '$id_kriteria_dk' AND id_hasil_saw = '$id_hasil_saw'");
                                                    $nilai_list = [];
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $nilai_list[] = $row['nilai'];
                                                    }
                                                    $nilai_kriteria[$id_kriteria_dk]['max'] = max($nilai_list);
                                                    $nilai_kriteria[$id_kriteria_dk]['min'] = min($nilai_list);
                                                }

                                                // Menyimpan hasil perhitungan ke dalam array
                                                $hasil_ranking = [];

                                                // Perhitungan SAW
                                                foreach ($penilaian as $dp) { 
                                                    $total_nilai = 0; // Menyimpan total nilai preferensi
                                                    $perhitungan_detail = "";

                                                    foreach ($kriteria as $dk) { 
                                                        $id_kriteria_dk = $dk['id_kriteria'];
                                                        $id_alternatif_dp = $dp['id_alternatif'];
                                                        $nilai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nilai FROM penilaian WHERE id_kriteria = '$id_kriteria_dk' AND id_alternatif = '$id_alternatif_dp' AND id_hasil_saw = '$id_hasil_saw'"));
                                                        
                                                        $nilai_asli = $nilai['nilai'];
                                                        $max = $nilai_kriteria[$id_kriteria_dk]['max'];
                                                        $min = $nilai_kriteria[$id_kriteria_dk]['min'];

                                                        // Normalisasi berdasarkan atribut
                                                        if ($dk['atribut'] == 'Benefit') {
                                                            $nilai_normalisasi = $nilai_asli / $max;
                                                        } else { // Cost
                                                            $nilai_normalisasi = $min / $nilai_asli;
                                                        }

                                                        // Perhitungan nilai preferensi
                                                        $bobot = $bobot_kriteria[$id_kriteria_dk]; 
                                                        $nilai_preferensi = $bobot * $nilai_normalisasi;
                                                        $total_nilai += $nilai_preferensi;

                                                        // Tambahkan ke string perhitungan detail
                                                        $perhitungan_detail .= "({$bobot} × " . number_format($nilai_normalisasi, 3) . ") + ";
                                                    }

                                                    // Simpan ke array ranking
                                                    $hasil_ranking[] = [
                                                        'nama' => $dp['nama_siswa'],
                                                        'id_alternatif' => $dp['id_alternatif'],
                                                        'perhitungan' => rtrim($perhitungan_detail, " + "),
                                                        'nilai' => $total_nilai
                                                    ];
                                                }

                                                // Urutkan hasil berdasarkan nilai tertinggi
                                                usort($hasil_ranking, function($a, $b) {
                                                    return $b['nilai'] <=> $a['nilai']; // Sorting Descending
                                                });


                                                // Ambil ranking 1 dari array hasil_ranking
                                                $ranking_tertinggi = $hasil_ranking[0];
                                                $id_alternatif_tertinggi = $ranking_tertinggi['id_alternatif']; // Pastikan ada di hasil_ranking
                                                $nilai_tertinggi = $ranking_tertinggi['nilai'];

                                                // Update tabel hasil_saw dengan ranking 1
                                                mysqli_query($conn, "UPDATE hasil_saw SET id_alternatif = '$id_alternatif_tertinggi', nilai_preferensi_tertinggi = '$nilai_tertinggi' WHERE id_hasil_saw = '$id_hasil_saw'");


                                                // Tampilkan hasil dengan ranking
                                                $ranking = 1;
                                                foreach ($hasil_ranking as $hasil) {
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $ranking++; ?></td>
                                                        <td><?= $hasil['nama']; ?></td>
                                                        <td><?= number_format($hasil['nilai'], 3); ?></td>
                                                    </tr>
                                                <?php } ?>
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
    <!-- KaTeX JS -->
    <script src="js/katex.js"></script>
    <!-- KaTeX Auto-Render JS -->
    <script>
        $(document).ready(function() {
            // Render LaTeX inside elements with id "formula"
            $('.formula').each(function() {
                var formula = $(this).html(); // Get the LaTeX string
                // Render the LaTeX string using KaTeX
                katex.render(formula, this);
            });
        });
    </script>
</body>

</html>