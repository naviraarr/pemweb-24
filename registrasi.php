<!-- file untuk registrasi user -->

<?php
require "koneksi.php";

// Cek apakah tombol submit sudah ditekan
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password
    $role = $_POST["role"];

    // Cek apakah username sudah digunakan
    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Jika username sudah digunakan
        echo "
        <script>
            alert('Username sudah digunakan! Silakan gunakan username lain.');
            document.location.href = 'registrasi.php';
        </script>
        ";
    } else {
        // Jika username belum digunakan, lanjutkan proses registrasi
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

        if (mysqli_query($conn, $query)) {
            echo "
            <script>
                alert('Registrasi berhasil!');
                document.location.href = 'login.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Registrasi gagal!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Pendataan Mahasiswa Universitas Mulawarman</title>

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="styles/base.css" />

  <link rel="stylesheet" href="styles/login.css" />
</head>

<body>
  <section class="login-card">
    <hgroup>
      <h1 class="login-title">Form Registrasi User</h1>
      <p class="login-description">Silakan masukkan data user</p>
    </hgroup>

    <form action="" method="post" class="login-form-container">
      <div class="login-form-group">
        <label for="username" class="login-form-title">Username</label>
        <input
          type="text"
          placeholder="Username"
          name="username"
          id="username"
          class="login-form-input" />
      </div>

      <div class="login-form-group">
        <label for="password" class="login-form-title">Password</label>
        <input
          type="password"
          placeholder="Password"
          name="password"
          id="password"
          class="login-form-input" />
      </div>

      <div class="login-form-group">
        <label for="role" class="login-form-title">Role</label>
        <select name="role" id="prodi" class="login-form-input" required>
            <option name="role" value="Admin">Admin</option>
            <option name="role" value="User">User</option>
          </select>
      </div>

      <button type="submit" name="submit" class="login-button">LOGIN</button>
    </form>
  </section>

  <script src="/scripts/script.js"></script>
</body>

</html>