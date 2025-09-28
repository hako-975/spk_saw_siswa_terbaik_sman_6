<?php
include 'connection.php'; // Sesuaikan dengan koneksi database Anda

if (isset($_POST['id_kelas'])) {
    $id_kelas = $_POST['id_kelas'];

    // Ambil alternatif berdasarkan id_kelas
    $alternatif = mysqli_query($conn, "SELECT * FROM alternatif WHERE id_kelas = '$id_kelas' ORDER BY nama_siswa ASC");

    if (mysqli_num_rows($alternatif) > 0) {
        while ($da = mysqli_fetch_assoc($alternatif)) {
            echo '
                <input type="hidden" name="penilaian['.$da['id_alternatif'].'][id_alternatif]" value="'.$da['id_alternatif'].'">
                <div class="row">
                    <div class="col">
                        <h5 class="fw-bold text-dark">'.htmlspecialchars($da['nama_siswa']).'</h5>
                    </div>
                </div>
                <div class="row">
            ';

            // Ambil data kriteria
            $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
            $i = 1;
            while ($dk = mysqli_fetch_assoc($kriteria)) {
                echo '
                    <input type="hidden" name="penilaian['.$da['id_alternatif'].']['.$dk['id_kriteria'].'][id_kriteria]" value="'.$dk['id_kriteria'].'">
                    <div class="mb-3 col">
                        <label for="nilai_'.$da['id_alternatif'].'_'.$dk['id_kriteria'].'" class="form-label">
                            '.htmlspecialchars($dk['kriteria']).' (C'.$i++.' - '.$dk['atribut'].')
                        </label>
                        <input type="number" step="0.01" id="nilai_'.$da['id_alternatif'].'_'.$dk['id_kriteria'].'" class="form-control" name="penilaian['.$da['id_alternatif'].']['.$dk['id_kriteria'].'][nilai]" min="0" value="0" required>
                    </div>
                ';
            }

            echo '</div><hr>';
        }
    } else {
        echo '<p class="text-danger">Tidak ada siswa di kelas ini.</p>';
    }
}
?>
