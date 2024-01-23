<?php
session_start();
require 'functions.php';

//cek cookie untuk user
if (isset($_COOKIE['$pws5d']) && isset($_COOKIE['$ssl'])) {
    $id = $_COOKIE['$pws5d'];
    $key = $_COOKIE['$ssl'];

    // ambil data admin berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash("sha256", $row['username'])) {
        $_SESSION['user'] = true;
    }
}

// cek cookie untuk admin
if (!isset($_COOKIE['$pws5d']) && isset($_COOKIE['$ssl'])) {
    $key = $_COOKIE['$ssl'];

    // ambil data admin berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM admin WHERE username = '$key'");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash("sha256", $row['username'])) {
        $_SESSION['admin'] = true;
    }
}

// cek session

if (isset($_SESSION["admin"])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}


if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $admin = query("SELECT * FROM admin");
    foreach ($admin as $a) {
        if ($username == $a["username"]) {
            $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");


            if (mysqli_num_rows($result) === 1) {


                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row["password"])) {

                    // set session

                    $_SESSION["login"] = true;
                    $_SESSION["admin"] = true;
                    $_SESSION["username"] = $username;



                    // cek remember me
                    if (isset($_POST['remember'])) {
                        // buat cookie
                        // $pws5d dan $ssl artinya adalah id dan username, disamarkan agar tidak mudah ditebak oleh penjahat
                        setcookie('$pws5d', hash('sha256', $row['id']), time() + 3600);
                        setcookie('$ssl', hash('sha256', $row['username']), time() + 3600);
                    }

                    echo "<script>
                        alert('Berhasil Login');
                        window.location = 'admin/index.php'
                    </script>";

                    exit;
                } else {
                    echo "<script>
                        alert('Gagal Login');
                        window.location = 'login.php'
                    </script>";
                }
            }
        } else {
            $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");


            if (mysqli_num_rows($result) === 1) {


                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row["password"])) {


                    $_SESSION["login"] = true;
                    $_SESSION["user"] = true;
                    $_SESSION["username"] = $username;

                    // cek remember me
                    if (isset($_POST['remember'])) {
                        // buat cookie
                        // $pws5d dan $ssl artinya adalah id dan username, disamarkan agar tidak mudah ditebak oleh penjahat
                        setcookie('$pws5d', $row['id'], time() + 3600);
                        setcookie('$ssl', hash('sha256', $row['username']), time() + 3600);
                    }
                    
                    echo "<script type='text/javascript'>
                        setTimeout(function(){
                            swal({
                                    title: 'Berhasil Login!',
                                    type: 'success',
                                    timer: 3200,
                                    showConfirmButton: true
                                )};
                            },10);
                            window.setTimeout(function(){
                                window.location('index.php');
                            }, 3000);
                            </script>";
                    exit;
                } else {
                    echo "<script>
                        alert('Gagal Login');
                        window.location = 'login.php'
                    </script>";
                }
            }
            $error = true;
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Icon dari Fontawesome -->
    <script src="https://kit.fontawesome.com/348c676099.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.22/dist/sweetalert2.all.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <title>Rifqa Travel</title>
    <style>
        #content {
            width: 100%;
            padding: 0 350px;
        }

        @media screen and (max-width: 1000px) {
            #content {
                padding: 0 10px;
            }
        }

        body {
            background-image: url("images/bg.jpeg");
            background-size: contain;
        }
    </style>
</head>

<body>
    <header>
        <div class="jumbotron">
            <h3>Rifqa Travel <i class="fab fa-accusoft"></i></h3>
        </div>
    </header>

    <main>
        <div id="content">
            <h2 class="judul">Login</h2>

            <article class="card">
                <form action="" method="post">
                    <div class="jarak">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
                    </div>
                    <div class="jarak">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                    </div>
                    <div class="jarak">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember Me</label>
                    </div>
                    <button type="submit" name="login" id="tombol" class="btn" style="width: 100%;">Login</button>

                </form>
            </article>

            <center>Belum mempunyai akun? <a href="register.php">Registrasi Disini</a></center>
        </div>
    </main>


    <footer>
        <p>&#169 Rifqa Travel <i class="fa-solid fa-car"></i> 2021</p>
    </footer>
</body>

</html>