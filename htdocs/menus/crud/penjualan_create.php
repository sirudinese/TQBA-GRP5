<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas Penjualan
include('../mydatabase/databasetk4.php');
require_once('../class/penjualan.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance Penjualan
$database = new Database();
$db = $database->getConnection();
$penjualan = new Penjualan($db);

// Memproses permintaan POST untuk menambahkan penjualan baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $penjualan->idPenjualan = mysqli_real_escape_string($db, $_POST['id']);
    $penjualan->jumlahPenjualan = mysqli_real_escape_string($db, $_POST['jumlah']);
    $penjualan->hargaJual = mysqli_real_escape_string($db, $_POST['harga']);
    $penjualan->idPengguna = mysqli_real_escape_string($db, $_POST['idPengguna']);
    $penjualan->idPelanggan = mysqli_real_escape_string($db, $_POST['idPelanggan']);

    // Menambahkan penjualan baru ke dalam tabel Penjualan
    if ($penjualan->create()) {
        // Berhasil menambahkan, arahkan kembali ke halaman penjualan
        header("Location: dashboard.php?page=penjualan");
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
    <title>Create Penjualan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Create Penjualan</h2>
        </header>
        <div class="content">
            <form method="POST" action="penjualan_create.php">
                <label for="id">ID Penjualan:</label>
                <input type="text" id="id" name="id" required>
                <br>
                <label for="jumlah">Jumlah Penjualan:</label>
                <input type="number" id="jumlah" name="jumlah" required>
                <br>
                <label for="harga">Harga Jual:</label>
                <input type="number" id="harga" name="harga" required>
                <br>
                <label for="idPengguna">ID Pengguna:</label>
                <input type="text" id="idPengguna" name="idPengguna" required>
                <br>
                <label for="idPelanggan">ID Pelanggan:</label>
                <input type="text" id="idPelanggan" name="idPelanggan" required>
                <br>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
