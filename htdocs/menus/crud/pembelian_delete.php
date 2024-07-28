<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas Pembelian
require_once('../class/database.php');
require_once('../class/pembelian.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance Pembelian
$database = new Database();
$db = $database->getConnection();
$pembelian = new Pembelian($db);

// Memproses permintaan GET untuk menghapus pembelian
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $pembelian->idPembelian = mysqli_real_escape_string($db, $_GET['id']);

    // Menghapus pembelian berdasarkan IdPembelian
    if ($pembelian->delete()) {
        // Berhasil menghapus, arahkan kembali ke halaman pembelian
        header("Location: dashboard.php?page=pembelian");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
