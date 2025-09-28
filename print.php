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
    <title>Print Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .print-container {
            width: 100%;
            margin: 0 auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<?php
    if (isset($_GET['file_excel'])) {
        if ($_GET['file_excel'] == true) {
            header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=hasil_ujian_export.xls"); 
        }
    }
?>
    <div class="print-container">
        <h2 class="text-center">Laporan Hasil SPK SAW</h2>
        <?php if (isset($_GET['dari_tanggal'])) : ?>
            <p class="text-right">Dari Tanggal: <?= date('d-m-Y', strtotime($dari_tanggal)); ?> Sampai Tanggal: <?= date('d-m-Y', strtotime($sampai_tanggal)); ?></p>
        <?php endif ?>
        <table class="table table-bordered" border="1">
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
                        <td class="text-center"><?= $ranking++; ?>.</td>
                        <td class="text-center"><?= $hasil['nama']; ?></td>
                        <td class="text-center"><?= number_format($hasil['nilai'], 3); ?></td>
                    </tr>
                <?php } ?>
            </tbody> 
        </table>
    </div>
    <script>
        window.print()
    </script>
</body>
</html>
