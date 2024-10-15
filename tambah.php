<?php
require "koneksi.php";

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'admin') {
    // Jika belum login atau bukan admin, arahkan ke index.php
    header('Location: index.php');
    exit;
}

if (isset($_POST['tambah'])) { // Mengecek apakah $_POST['tambah'] bernilai true
  $nama = $_POST['nama']; // Mengambil data dari form nama
  $nim = $_POST['nim']; // mengambil data dari form nim
  $kelas = $_POST['kelas']; // mengambil data dari form kelas
  $prodi = $_POST['prodi']; // mengambil data dari form prodi

  $tmp_name = $_FILES['foto']['tmp_name']; // mengambil path temporary file
  $file_name = $_FILES['foto']['name']; // mengambil nama file

  // cek apakah yang diupload adalah file gambar
  $validExtensions = ['png', 'jpg', 'jpeg'];
  $fileExtension = explode('.', $file_name);
  $fileExtension = strtolower(end($fileExtension));
  if (!in_array($fileExtension, $validExtensions)) {
    echo "
            <script>
                alert('Tolong upload file gambar!');
            </script>";
  } else {
    $newFileName = date('d-m-Y') . '-' . $file_name;
    if (move_uploaded_file($tmp_name, 'images/'.$newFileName)) {
      // Menulis query SQL
      $sql = "INSERT INTO mhs VALUES (null, '$nama', '$nim', '$kelas', '$prodi', '$newFileName')";
    
      // Mengeksekusi query SQL pada database
      $result = mysqli_query($conn, $sql);
    
      if ($result) {
        echo "
              <script>
                  alert('Berhasil menambah data mahasiswa!');
                  document.location.href = 'CRUDAdmin.php';
              </script>";
      } else {
        echo "
              <script>
                  alert('Gagal menambah data mahasiswa!');
                  document.location.href = 'CRUDAdmin.php';
              </script>";
      }
    } else {
      echo "
              <script>
                  alert('File tidak valid!');
              </script>";
    }
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

  <link rel="stylesheet" href="styles/crud.css">
</head>

<body>

  <main class="data-mahasiswa-section">
    <h1 class="data-mahasiswa-title">
      Tambah Data Mahasiswa
    </h1>

    <div class="container">
      <a href="CRUDAdmin.php">
        <button class="back">
          <p>Back</p>
        </button>
      </a>
    </div>

    <div class="form-mhs">
      <!-- menambahkan enctype -->
      <form action="" method="post" enctype="multipart/form-data">
        <div class="input-field">
          <label class="label-field" for="nama">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" value="" required>
        </div>
        <div class="input-field">
          <label class="label-field" for="nim">NIM</label>
          <input type="number" name="nim" id="nim" value="" required>
        </div>
        <div class="input-field">
          <label class="label-field" for="kelas">Kelas</label>
          <div class="form-check">
            <input type="radio" name="kelas" id="kelasA" value="A" required/>
            <label for="kelasA">A</label></br>
            <input type="radio" name="kelas" id="kelasB" value="B"/>
            <label for="kelasB">B</label></br>
            <input type="radio" name="kelas" id="kelasC" value="C"/>
            <label for="kelasC">C</label>
          </div>
        </div>
        <div class="input-field">
          <label class="label-field" for="prodi">Program Studi</label>
          <select name="prodi" id="prodi" required>
            <option name="prodi" value="Informatika">Informatika</option>
            <option name="prodi" value="Sistem Informasi">Sistem Informasi</option>
          </select>
        </div>
        
        <!-- menambahkan input type file -->
        <div class="input-field">
          <label for="foto" class="label-field">Foto</label>
          <input type="file" name="foto" id="foto" accept="image/*" style="border: 1px solid rgba(0, 0, 0, 0.6); border-radius: 9px; padding: 7px 10px; font-size:16px" required>
        </div>

        <input class="button" type="submit" value="Tambah" name="tambah">
      </form>
    </div>

  </main>

  <script src="/scripts/script.js"></script>
</body>

</html>