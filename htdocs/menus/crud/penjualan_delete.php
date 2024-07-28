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

// Memproses permintaan GET untuk menghapus penjualan
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $penjualan->idPenjualan = mysqli_real_escape_string($db, $_GET['id']);

    // Menghapus penjualan berdasarkan IdPenjualan
    if ($penjualan->delete()) {
        // Berhasil menghapus, arahkan kembali ke halaman penjualan
        header("Location: dashboard.php?page=penjualan");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
