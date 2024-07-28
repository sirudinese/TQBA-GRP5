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

// Memproses permintaan GET untuk menghapus pelanggan
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $pelanggan->idPelanggan = mysqli_real_escape_string($db, $_GET['id']);

    // Menghapus pelanggan berdasarkan IdPelanggan
    if ($pelanggan->delete()) {
        // Berhasil menghapus, arahkan kembali ke halaman pelanggan
        header("Location: dashboard.php?page=pelanggan");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
