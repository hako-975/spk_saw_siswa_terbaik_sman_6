<body>
<?php 
	require 'connection.php';
 	include_once 'include/head.php';
 	include_once 'include/script.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}
	
	$id_kriteria = $_GET['id_kriteria'];

    $data_kriteria = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kriteria WHERE id_kriteria = '$id_kriteria'"));
    $kriteria = $data_kriteria['kriteria'];

	$delete_kriteria = mysqli_query($conn, "DELETE FROM kriteria WHERE id_kriteria = '$id_kriteria'");

	if ($delete_kriteria) {
        $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kriteria $kriteria berhasil dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

		echo "
	        <script>
	            Swal.fire({
	                icon: 'success',
	                title: 'Berhasil!',
	                text: 'Kriteria " . $kriteria . " berhasil dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'kriteria.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	} else {
        $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kriteria $kriteria gagal dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

	    echo "
	        <script>
	            Swal.fire({
	                icon: 'error',
	                title: 'Gagal!',
	                text: 'Kriteria " . $kriteria . " gagal dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'kriteria.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	}

?>
</body>
