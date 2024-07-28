<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas Pengguna
require_once('../class/database.php');
require_once('../class/pengguna.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance Pengguna
$database = new Database();
$db = $database->getConnection();
$pengguna = new Pengguna($db);

// Memproses permintaan GET untuk menghapus pengguna
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $pengguna->idPengguna = mysqli_real_escape_string($db, $_GET['id']);

    // Menghapus pengguna berdasarkan IdPengguna
    if ($pengguna->delete()) {
        // Berhasil menghapus, arahkan kembali ke halaman pengguna
        header("Location: dashboard.php?page=pengguna");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
