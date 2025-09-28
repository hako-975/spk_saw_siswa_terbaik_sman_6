<body>
<?php 
	require 'connection.php';
 	include_once 'include/head.php';
 	include_once 'include/script.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}
	
	$id_kelas = $_GET['id_kelas'];

    $data_kelas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kelas WHERE id_kelas = '$id_kelas'"));
    $kelas = $data_kelas['kelas'];

	$delete_kelas = mysqli_query($conn, "DELETE FROM kelas WHERE id_kelas = '$id_kelas'");

	if ($delete_kelas) {
        $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kelas $kelas berhasil dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

		echo "
	        <script>
	            Swal.fire({
	                icon: 'success',
	                title: 'Berhasil!',
	                text: 'Kelas " . $kelas . " berhasil dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'kelas.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	} else {
        $log_gagal = mysqli_query($conn, "INSERT INTO log VALUES ('', 'Kelas $kelas gagal dihapus!', CURRENT_TIMESTAMP(), " . $dataUser['id_user'] . ")");

	    echo "
	        <script>
	            Swal.fire({
	                icon: 'error',
	                title: 'Gagal!',
	                text: 'Kelas " . $kelas . " gagal dihapus!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    window.location.href = 'kelas.php';
	                }
	            });
	        </script>
	    ";
	    exit;
	}

?>
</body>
