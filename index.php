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

    <title>SPK SAW Siswa Terbaik SMAN 6 - Dashboard</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row mb-5">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0">Sistem Pendukung Keputusan Siswa Terbaik SMAN 6 metode Simple Additive Weighting (SAW)</h5>
                                </div>
                                <div class="card-body">
                                    <h5>📌 Apa Itu Metode SAW?</h5>
                                    <p>
                                        Metode <strong>Simple Additive Weighting (SAW)</strong> adalah salah satu metode dalam <strong>Sistem Pendukung Keputusan (SPK)</strong> yang digunakan untuk menentukan alternatif terbaik berdasarkan kriteria yang telah ditentukan. Metode ini sering disebut sebagai <em>metode penjumlahan terbobot</em>, karena menghitung total bobot dari setiap kriteria setelah dilakukan normalisasi nilai.
                                    </p>

                                    <h5>🔍 Langkah-Langkah Perhitungan SAW</h5>
                                    <ol>
                                        <li><strong>Menentukan Kriteria dan Bobot</strong> - Setiap alternatif dinilai berdasarkan beberapa kriteria dengan bobot tertentu.</li>
                                        <li><strong>Membentuk Matriks Keputusan</strong> - Matriks dibuat berdasarkan nilai yang diperoleh setiap alternatif pada masing-masing kriteria.</li>
                                        <li><strong>Melakukan Normalisasi Matriks Keputusan</strong> - Nilai pada matriks dinormalisasi agar memiliki skala yang sama.</li>
                                        <li><strong>Menghitung Nilai Preferensi (V)</strong> - Menghitung nilai preferensi dengan menjumlahkan hasil perkalian antara nilai normalisasi dan bobot masing-masing kriteria.</li>
                                        <li><strong>Menentukan Ranking</strong> - Alternatif dengan nilai preferensi tertinggi adalah yang terbaik.</li>
                                    </ol>

                                    <h5>📌 Keunggulan Metode SAW</h5>
                                    <ul>
                                        <li>✅ <strong>Mudah dipahami & dihitung</strong></li>
                                        <li>✅ <strong>Menggunakan konsep pembobotan yang logis</strong></li>
                                        <li>✅ <strong>Cocok untuk banyak kasus pengambilan keputusan</strong></li>
                                    </ul>

                                    <p>
                                        Dengan metode ini, penilaian menjadi lebih objektif dan transparan.
                                    </p>

                                    <h5>🎯 Kesimpulan</h5>
                                    <p>
                                        Metode <strong>Simple Additive Weighting (SAW)</strong> adalah metode efektif dalam <strong>Sistem Pendukung Keputusan (SPK)</strong> untuk menentukan alternatif terbaik berdasarkan kriteria yang telah ditentukan. Dengan metode ini, pengambilan keputusan menjadi lebih <strong>mudah, cepat, dan akurat</strong>.
                                    </p>
                                    <p>🚀 <strong>Dengan SAW, pemilihan siswa terbaik dalam Siswa Terbaik SMAN 6 menjadi lebih objektif dan terukur!</strong> 🕌📖</p>
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