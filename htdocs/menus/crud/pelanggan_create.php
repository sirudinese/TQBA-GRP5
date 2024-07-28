<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas Pelanggan
require_once('../class/database.php');
require_once('../class/pelanggan.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance Pelanggan
$database = new Database();
$db = $database->getConnection();
$pelanggan = new Pelanggan($db);

// Memproses permintaan POST untuk menambahkan pelanggan baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $pelanggan->idPelanggan = mysqli_real_escape_string($db, $_POST['id']);
    $pelanggan->namaPelanggan = mysqli_real_escape_string($db, $_POST['nama']);
    $pelanggan->alamatPelanggan = mysqli_real_escape_string($db, $_POST['alamat']);
    $pelanggan->noHpPelanggan = mysqli_real_escape_string($db, $_POST['nohp']);

    // Menambahkan pelanggan baru
    if ($pelanggan->create()) {
        // Berhasil menambahkan, arahkan kembali ke halaman pelanggan
        header("Location: dashboard.php?page=pelanggan");
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
    <title>Create Pelanggan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Create Pelanggan</h2>
        </header>
        <div class="content">
            <form method="POST" action="pelanggan_create.php">
                <label for="id">ID Pelanggan:</label>
                <input type="text" id="id" name="id" required>
                <br>
                <label for="nama">Nama Pelanggan:</label>
                <input type="text" id="nama" name="nama" required>
                <br>
                <label for="alamat">Alamat Pelanggan:</label>
                <input type="text" id="alamat" name="alamat" required>
                <br>
                <label for="nohp">No HP Pelanggan:</label>
                <input type="text" id="nohp" name="nohp" required>
                <br>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
