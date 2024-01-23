<?php 
session_start();

if (isset($_SESSION["admin"])) {
  echo "<script>
         window.location.replace('admin');
       </script>";
  exit;
}
if (!isset($_SESSION['user'])) {
   echo "<script>
         window.location.replace('login.php');
       </script>";
  exit;
}
require 'functions.php';

 if (isset($_SESSION['username'])) {
     $username = $_SESSION['username'];

     $bookings = mysqli_query($conn, "SELECT * FROM bookings WHERE username = '$username'"); 

  }

$total_bookings = mysqli_num_rows($bookings);
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

    <title>Rifqa Travel</title>
    <style>
      body {
          background-image: url("images/bg.jpeg");
          background-size: contain;
        }
        #content {
            width: 100%;
        }
        .btn {
            text-decoration: none;
            padding: 5px 10px;
            background-color: red;
        } 
        .featured-image {
          transition: 1s;
          cursor: pointer;
        }
        .featured-image:hover {
          transition: 1s;
          transform: scale(1.5);
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="katalog.php">Tiket Pesawat</a></li>
                <li><a href="pesanan.php">Pesanan Saya <span class="jumlah_bookings"><?= $total_bookings; ?></span></a></li>
                <li><a href="logout.php" class="btn" style="border-bottom: none;">Logout <i class="fas fa-power-off fa-1x"></i></a></li>
            </ul>
        </nav>
        <div class="jumbotron">
            <h3>Rifqa Travel <i class="fab fa-accusoft"></i></h3>
            <p>Apa Kabar,
            <?php
                    if (isset($_SESSION['username'])) {
                     $username = $_SESSION['username'];

                     $query = mysqli_query($conn, "SELECT nama FROM user WHERE username = '$username'"); 
                     foreach ($query as $cf) {}

                     if($query->num_rows > 0) {
                      echo $cf['nama'];
                      }
                  }
                ?> ?
            </p>
        </div>
    </header>

    <main>
        <div id="content">
            <div class="card" style="margin: 100px 0;">
                <h3 class="judul">Siapa Kami?</h3>
                <p style="text-indent: 1.2rem;text-align: justify;">Rifqa Travel adalah layanan travel yang berdiri sejak tahun 2021, kami terus berupaya meningkatkan kualitas layanan kami agar dapat berguna di masyarakat Indonesia.</p>
                <center>
                <h2>Owner</h2>
                <img src="images/profile.jpeg" class="featured-image">
                <p><b>Riko Gimin Dwi Putra</b></p>
                <p>Mahasiswa Smester 3 di STMIK Banjarbaru</p>
                </center>
            </div>
        </div>
    </main>

    <footer>
        <p>&#169 Rifqa Travel <i class="fab fa-accusoft"></i> 2021</p>
    </footer>
</body>
</html>