<?php
    require "koneksi.php";

    session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'admin') {
    // Jika belum login atau bukan admin, arahkan ke index.php
    header('Location: index.php');
    exit;
}

    $id = $_GET['id'];

    $query = mysqli_query($conn, "SELECT * FROM mhs WHERE id=$id");
    $mahasiswa = [];
    while ($mhs = mysqli_fetch_assoc($query)) {
        $mahasiswa[] = $mhs;
    }

    unlink('images/' . $mahasiswa[0]['foto']);

    $result = mysqli_query($conn, "DELETE FROM mhs WHERE id = $id");

    if ($result) {
        echo "
        <script>
            alert('Data berhasil dihapus!');
            document.location.href = 'CRUDAdmin.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal dihapus!');
            document.location.href = 'CRUDAdmin.php';
        </script>";
    }
?>