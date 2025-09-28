<?php 
    require_once 'connection.php';

    if (isset($_SESSION['id_user'])) {
        echo "
            <script>
                window.location='index.php'
            </script>
        ";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'include/head.php'; ?>

    <title>SPK SAW Siswa Terbaik SMAN 6 - Login</title>
    

</head>

<body class="bg-gradient-primary">

    <?php 
        if (isset($_POST['btnLogin'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query_login = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
            
            if ($data_user = mysqli_fetch_assoc($query_login)) {
                if (password_verify($password, $data_user['password'])) {
                    $log_berhasil = mysqli_query($conn, "INSERT INTO log VALUES ('', 'User $username berhasil login!', CURRENT_TIMESTAMP(), " . $data_user['id_user'] . ")");
                    $_SESSION['id_user'] = $data_user['id_user'];
                    header("Location: index.php");
                    exit;
                } else {
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Login!',
                                text: 'Username atau Password salah!',
                                confirmButtonText: 'Kembali'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.history.back();
                                }
                            });
                        </script>
                    ";
                    exit;
                }
            } else {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Login!',
                            text: 'Username atau Password salah!',
                            confirmButtonText: 'Kembali'
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

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img style="width: 150px;" src="img/logo.png" alt="logo">
                                        <h1 class="h4 text-gray-900 my-3">SPK SAW Siswa Terbaik SMAN 6</h1>
                                        <h3 class="text-gray-900 my-3">Login</h3>
                                    </div>
                                    <form method="post" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <button type="submit" name="btnLogin" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php include_once 'include/script.php'; ?>

</body>

</html>