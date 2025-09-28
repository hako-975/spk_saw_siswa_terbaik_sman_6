<body>
<?php 
	require 'connection.php';
 	include_once 'include/head.php';
 	include_once 'include/script.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}
	
	$id_alternatif = $_GET['id_alternatif'];

    $data_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif'"));
    $siswa = $data_siswa['nama_siswa'];

	$delete_siswa = mysqli_query($conn, "DELETE FROM alternatif WHERE id_alternatif = '$id_alternatif'");

	if ($delete_siswa) {
        $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kriteria $siswa berhasil dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

		echo "
	        <script>
	            Swal.fire({
	                icon: 'success',
	                title: 'Berhasil!',
	                text: 'Kriteria " . $siswa . " berhasil dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'siswa.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	} else {
        $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kriteria $siswa gagal dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

	    echo "
	        <script>
	            Swal.fire({
	                icon: 'error',
	                title: 'Gagal!',
	                text: 'Kriteria " . $siswa . " gagal dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'siswa.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	}

?>
</body>
