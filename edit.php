<?php
    require "koneksi.php";

    session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'admin') {
    // Jika belum login atau bukan admin, arahkan ke index.php
    header('Location: index.php');
    exit;
}

    // Mengambil ID yang dilempar oleh link
    $id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT * FROM mhs WHERE id = $id");
    
    $mahasiswa = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $mahasiswa[] = $row;
    }

    // Karena $mahasiswa adalah sebuah array yang berisi array
    // Untuk mengeluarkan datanya maka dilakukan cara berikut
    $mahasiswa = $mahasiswa[0];

    if (isset($_POST['ubah'])) {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $prodi = $_POST['prodi'];

    $oldImg = $_POST['oldimg'];



    function updateMahasiswa($conn, $id, $nama, $nim, $kelas, $prodi, $file_name) {
      // Query UPDATE
      $sql = "UPDATE mhs SET nama='$nama', nim='$nim', kelas='$kelas', prodi='$prodi', foto='$file_name' WHERE id=$id";
  
      // Eksekusi query
      $result = mysqli_query($conn, $sql);
  
      // Pengecekan hasil
      if ($result) {
          // Pesan sukses dan redirect
          echo "
          <script>
              alert('Data berhasil diubah!');
              document.location.href = 'CRUDAdmin.php';
          </script>";
      } else {
          // Pesan gagal dan redirect
          echo "
          <script>
              alert('Data gagal diubah!');
              document.location.href = 'CRUDAdmin.php';
          </script>";
      }
  }

    if ($_FILES['foto']['error'] === 4) { // cek apakah ada file yg diupload
      $file_name = $oldImg; // kalo tidak, akan mengambil gambar lama
      updateMahasiswa($conn, $id, $nama, $nim, $kelas, $prodi, $file_name);
    } else {
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
        move_uploaded_file($tmp_name, 'images/' . $newFileName);
        unlink('images/'.$oldImg); // menghapus gambar lama dari folder images
        updateMahasiswa($conn, $id, $nama, $nim, $kelas, $prodi, $newFileName);
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
      Ubah Data Mahasiswa
    </h1>

    <div class="container">
      <a href="CRUDAdmin.php">
        <button class="back">
          <p>Back</p>
        </button>
      </a>
    </div>

    <div class="form-mhs">
      <form action="" method="post" enctype="multipart/form-data">

        <!-- menambahkan input hidden untuk menyimpan foto lama -->
        <input type="hidden" name="oldimg" value="<?= $mahasiswa['foto'] ?>">

        <div class="input-field">
          <label class="label-field" for="nama">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" value="<?php echo $mahasiswa['nama'] ?>" required>
        </div>
        <div class="input-field">
          <label class="label-field" for="nim">NIM</label>
          <input type="number" name="nim" id="nim" value="<?php echo $mahasiswa['nim'] ?>" required>
        </div>
        <div class="input-field">
          <label class="label-field" for="kelas">Kelas</label>
          <div class="form-check">
            <input type="radio" name="kelas" id="kelasA" value="A" 
            <?php if ($mahasiswa['kelas'] == "A") echo "checked";?>/>
            <label for="kelasA">A</label></br>
            <input type="radio" name="kelas" id="kelasB" value="B" 
            <?php if ($mahasiswa['kelas'] == "B") echo "checked";?>/>
            <label for="kelasB">B</label></br>
            <input type="radio" name="kelas" id="kelasC" value="C" 
            <?php if ($mahasiswa['kelas'] == "C") echo "checked";?>/>
            <label for="kelasC">C</label>
          </div>
        </div>
        <div class="input-field">
          <label class="label-field" for="prodi">Program Studi</label>
          <select name="prodi" id="prodi" required>
            <option value="<?php echo $mahasiswa['prodi'] ?>" selected><?= $mahasiswa['prodi'] ?></option>
            <option value="Informatika">Informatika</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
          </select>
        </div>

        <!-- menambahkan input type file -->
         <div class="input-field" style="border: 1px solid rgba(0, 0, 0, 0.6); border-radius: 9px; padding: 7px 10px; font-size:16px">
          <label for="foto" class="label-field">Foto</label>
          <input type="file" name="foto" id="foto">
          <br>
          <img src="images/<?= $mahasiswa['foto'] ?>" alt="<?= $mahasiswa['foto'] ?>" width="80px" height="100px">
         </div>
        <input class="button" type="submit" value="Ubah" name="ubah">
      </form>
    </div>

  </main>

  <script src="/scripts/script.js"></script>
</body>

</html>