<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda | Pendataan Mahasiswa Universitas Mulawarman</title>

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="styles/base.css" />

  <link rel="stylesheet" href="styles/home.css" />
</head>

<body>
  <!-- Navbar -->
  <?php include("navbar.php"); ?>

  <!-- Hero  -->
  <main class="hero-section">
    <img
      src="assets/unmul-gedung.jpeg"
      alt="Universitas Mulawarman"
      class="hero-image" />

    <div class="hero-container">
      <hgroup>
        <h1 class="hero-title">
          Pendataan Mahasiswa <br />
          Universitas Mulawarman
        </h1>

        <p class="hero-description">
          Temukan informasi mahasiswa dengan mudah dan cepat <br />
          hanya dengan mengetik nama atau NIM
        </p>
      </hgroup>

      <search>
        <form action="" class="search-bar-mahasiswa">
          <input
            type="text"
            placeholder="Ketik nama atau NIM di sini"
            class="search-input-mahasiswa" />
          <button type="submit" class="search-button-mahasiswa">
            <i class="fa-solid fa-magnifying-glass fa-xl"></i>
          </button>
        </form>
      </search>
    </div>
  </main>

  <!-- Footbar -->
  <?php include("footer.php") ?>

  <script src="/scripts/script.js"></script>
</body>

</html>