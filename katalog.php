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

$maskapai = mysqli_query($conn, "SELECT * FROM maskapai"); 
$total_maskapai = mysqli_num_rows($maskapai);
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
        .btn {
            text-decoration: none;
            padding: 5px 10px;
            background-color: red;
        }
        .flex {
            display: flex;
            flex-direction: column;
        }
        .btn-beli {
            text-decoration: none;
            padding: 5px 10px;
            background-color: green;
        }
        body {
          background-image: url("images/bg.jpeg");
          background-size: contain;
        }
        th, td {
            padding: 10px 40px;
            text-align: justify;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="pesanan.php">Pesanan Saya <span class="jumlah_bookings"><?= $total_bookings; ?></span></a></li>
                <li><a href="tentang.php">Tentang Kami</a></li>
                <li><a href="logout.php" class="btn" style="border-bottom: none;">Logout <i class="fas fa-power-off fa-1x"></i></a></li>
            </ul>
        </nav>
        <div class="jumbotron">
            <h3>Rifqa Travel <i class="fab fa-accusoft"></i></h3>
            <p>Hai,
            <?php
                    if (isset($_SESSION['username'])) {
                     $username = $_SESSION['username'];

                     $query = mysqli_query($conn, "SELECT nama FROM user WHERE username = '$username'"); 
                     foreach ($query as $cf) {}

                     if($query->num_rows > 0) {
                      echo $cf['nama'];
                      }
                  }
                ?>
            </p>
        </div>
    </header>

    <main>
         <article class="card">
                <center><h3 style="color:royalblue;">Pilih Maskapai</h3></center>
        </article>

       <div id="content">
            <?php foreach ($maskapai as $pesawat) : ?>
            <div class="flex">
                <div class="card">
                    <center>
                       <table>
                           <tr>
                               <th>Kode Maskapai</th>
                               <th>Nama Pesawat</th>
                               <th>Harga Tiket</th>
                               <th>Aksi</th>
                           </tr>
                           <tr>
                               <td><span style="color: royalblue;cursor: pointer;"><?= $pesawat["kode"]; ?></span></td>
                               <td><?= $pesawat["nama_maskapai"]; ?></td>
                               <td><?= $pesawat["harga"]; ?></td>
                               <td>
                                <a href="produk.php?id=<?= $pesawat["id"]; ?>" class="btn btn-beli">Lihat  Detail</a>
                            </td>
                           </tr>
                       </table>
                    </center>
               </div>
            </div>
            <?php endforeach; ?>
        </div>

        <aside>
            <div class="card">
                <center><p>Jumlah Maskapai : <b><span style="color: #royalblue;"><?= $total_maskapai; ?></span></b></p></center>
            </div>
        </aside>
           
    </main>

    <footer>
        <p>&#169 Rifqa Travel <i class="fab fa-accusoft"></i> 2021</p>
    </footer>
</body>
</html>