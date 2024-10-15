<?php
  require "koneksi.php";

  $sql = mysqli_query($conn, "SELECT * FROM mhs");

  $mahasiswa = [];
  while ($row = mysqli_fetch_assoc($sql)) {
      $mahasiswa[] = $row;
  }

  if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Query SQL untuk mencari data berdasarkan nama atau NIM
    $sql = mysqli_query($conn, "SELECT * FROM mhs WHERE nama LIKE '%$search%' OR nim LIKE '%$search%'");

    // Menyiapkan array untuk menyimpan hasil pencarian
    $mahasiswa = [];
    
    // Memindahkan data dari $sql ke array $mahasiswa
    while ($row = mysqli_fetch_assoc($sql)) {
        $mahasiswa[] = $row;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tentang Kami | Pendataan Mahasiswa Unversitas Mulawarman</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="styles/base.css" />

  <link rel="stylesheet" href="styles/home.css" />

  <link rel="stylesheet" href="styles/admin.css">
</head>

<body>
  <!-- Navbar -->
  <?php include("navbar.php") ?>

  <main class="data-mahasiswa-section">

    <h1 class="data-mahasiswa-title">
      Data Mahasiswa Universitas Mulawarman
    </h1>

    <form action="" method="GET" class="search-bar-mahasiswa">
      <input type="text" name="search" placeholder="Cari nama atau NIM di sini" class="search-input-mahasiswa" />
      <button type="submit" class="search-button-mahasiswa">
        <i class="fa-solid fa-magnifying-glass fa-xl"></i>
      </button>
    </form>

    <table class="table-mahasiswa">
      <thead>
        <tr class="table-mahasiswa-row">
          <th class="table-mahasiswa-header">No</th>
          <th class="table-mahasiswa-header">Foto</th>
          <th class="table-mahasiswa-header">Nama</th>
          <th class="table-mahasiswa-header">NIM</th>
          <th class="table-mahasiswa-header">Kelas</th>
          <th class="table-mahasiswa-header">Prodi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach($mahasiswa as $mhs) : ?>
          <tr class="table-mahasiswa-row">
            <td class="table-mahasiswa-data"><?php echo $i ?></td>
            <td class="table-mahasiswa-data"></td>
            <td class="table-mahasiswa-data"><?php echo $mhs['nama'] ?></td>
            <td class="table-mahasiswa-data"><?php echo $mhs['nim'] ?></td>
            <td class="table-mahasiswa-data"><?php echo $mhs['kelas'] ?></td>
            <td class="table-mahasiswa-data"><?php echo $mhs['prodi'] ?></td>
          </tr>
        <?php $i++; endforeach ?>
      </tbody>
    </table>
  </main>

  <!-- Footbar -->
  <?php include("footer.php") ?>

  <script src="/scripts/script.js"></script>
</body>

</html>