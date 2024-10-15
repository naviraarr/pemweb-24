<?php
  require "koneksi.php";

  session_start();
  if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'admin') {
      // Jika belum login atau bukan admin, arahkan ke index.php
      header('Location: index.php');
      exit;
  }
  // Untuk melakukan perintah SQL
  $sql = mysqli_query($conn, "SELECT * FROM mhs");

  // Menyiapkan array assosiatif
  $mahasiswa = [];
  // Memindahkan data dari $sql ke array rows
  while ($row = mysqli_fetch_assoc($sql)) {
      $mahasiswa[] = $row;
  }
  
    // Cek apakah form search disubmit
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

  $time = date("d/m/Y h:i:sa")
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

  <main class="data-mahasiswa-section">
    <h1 class="data-mahasiswa-title">
      Data Mahasiswa
    </h1>

    <form action="" method="GET" class="search-bar-mahasiswa">
      <input type="text" name="search" placeholder="Cari nama atau NIM di sini" class="search-input-mahasiswa" />
      <button type="submit" class="search-button-mahasiswa">
        <i class="fa-solid fa-magnifying-glass fa-xl"></i>
      </button>
    </form>


    <div id="jam">
      <?php
        echo "tanggal dan jam : " . date("d/m/Y h:i:sa")
      ?>
    </div>

    <div class="container">
      <a href="tambah.php">
        <button class="tambah">
          <p>Tambah</p>
        </button>
      </a>
      <a href="index.php">
        <button class="back">
          <p>Back</p>
        </button>
      </a>
      <a href="logout.php">
        <button class="logout">
          <p>Logout</p>
        </button>
      </a>
    </div>

    <table class="table-mahasiswa">
      <thead>
        <tr class="table-mahasiswa-row">
          <th class="table-mahasiswa-header">No</th>
          <th class="table-mahasiswa-header">Foto</th>
          <th class="table-mahasiswa-header">Nama</th>
          <th class="table-mahasiswa-header">NIM</th>
          <th class="table-mahasiswa-header">Kelas</th>
          <th class="table-mahasiswa-header">Prodi</th>
          <th class="table-mahasiswa-header">Aksi</th>
        </tr>
      </thead>

      <tbody>
        <?php $i = 1; foreach($mahasiswa as $mhs) : ?>
          <tr class="table-mahasiswa-row">
            <td class="table-mahasiswa-data"><?php echo $i ?></td>
            <td class="table-mahasiswa-data">
              <img src="images/<?= $mhs['foto'] ?>" alt="<?= $mhs['foto'] ?>" width="80px" height="100px" style="display: block; margin: 0 auto;">
            </td>
            <td class="table-mahasiswa-data"><?php echo $mhs['nama'] ?></td>
            <td class="table-mahasiswa-data"><?php echo $mhs['nim'] ?></td>
            <td class="table-mahasiswa-data"><?php echo $mhs['kelas'] ?></td>
            <td class="table-mahasiswa-data"><?php echo $mhs['prodi'] ?></td>
            <td class="table-mahasiswa-data">
              <div class="button-UD">
                <a href="edit.php?id=<?php echo $mhs['id']?>">
                  <button class="edit-data">
                    <i class="fa-solid fa-pen" style="color: #ffffff;"></i>
                  </button>
                </a>
                <a href="delete.php?id=<?php echo $mhs['id']?>" 
                onclick="return confirm('Yakin ingin menghapus data ini?');">
                  <button class="hapus-data">
                    <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                  </button>
                </a>
              </div>
            </td>
          </tr>
        <?php $i++; endforeach ?>
      </tbody>
    </table>
  </main>

  <script src="/scripts/script.js"></script>
</body>

</html>