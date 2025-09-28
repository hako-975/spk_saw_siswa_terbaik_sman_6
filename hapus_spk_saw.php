<body>
<?php 
	require 'connection.php';
 	include_once 'include/head.php';
 	include_once 'include/script.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}
	
	$id_hasil_saw = $_GET['id_hasil_saw'];

    $data_hasil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hasil_saw INNER JOIN alternatif ON hasil_saw.id_alternatif = alternatif.id_alternatif WHERE hasil_saw.id_hasil_saw = '$id_hasil_saw'"));
    $nama_siswa = $data_hasil['nama_siswa'];

	$delete_hasil = mysqli_query($conn, "DELETE FROM hasil_saw WHERE id_hasil_saw = '$id_hasil_saw'");

	if ($delete_hasil) {
		$delete_hasil_penilaian = mysqli_query($conn, "DELETE FROM penilaian WHERE id_hasil_saw = '$id_hasil_saw'");
        $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Hasil SPK SAW $nama_siswa berhasil dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

		echo "
	        <script>
	            Swal.fire({
	                icon: 'success',
	                title: 'Berhasil!',
	                text: 'Hasil SPK SAW " . $nama_siswa . " berhasil dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'spk_saw.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	} else {
        $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Hasil SPK SAW $nama_siswa gagal dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

	    echo "
	        <script>
	            Swal.fire({
	                icon: 'error',
	                title: 'Gagal!',
	                text: 'Hasil SPK SAW " . $nama_siswa . " gagal dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'spk_saw.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	}

?>
</body>
