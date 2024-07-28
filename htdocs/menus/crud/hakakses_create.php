<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas HakAkses
require_once('../class/database.php');
require_once('../class/hakakses.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance HakAkses
$database = new Database();
$db = $database->getConnection();
$hakAkses = new HakAkses($db);

// Memproses permintaan POST untuk menambahkan hak akses baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $hakAkses->idAkses = mysqli_real_escape_string($db, $_POST['id']);
    $hakAkses->namaAkses = mysqli_real_escape_string($db, $_POST['nama']);
    $hakAkses->keterangan = mysqli_real_escape_string($db, $_POST['keterangan']);

    // Menambahkan hak akses baru
    if ($hakAkses->create()) {
        // Berhasil menambahkan, arahkan kembali ke halaman hak akses
        header("Location: dashboard.php?page=hakakses");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Hak Akses</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Create Hak Akses</h2>
        </header>
        <div class="content">
            <form method="POST" action="hakakses_create.php">
                <label for="id">ID Akses:</label>
                <input type="text" id="id" name="id" required>
                <br>
                <label for="nama">Nama Akses:</label>
                <input type="text" id="nama" name="nama" required>
                <br>
                <label for="keterangan">Keterangan:</label>
                <textarea id="keterangan" name="keterangan" required></textarea>
                <br>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
