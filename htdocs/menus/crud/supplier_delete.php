<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas Supplier
require_once('../class/database.php');
require_once('../class/supplier.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance Supplier
$database = new Database();
$db = $database->getConnection();
$supplier = new Supplier($db);

// Memproses permintaan GET untuk menghapus supplier
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $supplier->idSupplier = mysqli_real_escape_string($db, $_GET['id']);

    // Menghapus supplier berdasarkan IdSupplier
    if ($supplier->delete()) {
        // Berhasil menghapus, arahkan kembali ke halaman supplier
        header("Location: dashboard.php?page=supplier");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
