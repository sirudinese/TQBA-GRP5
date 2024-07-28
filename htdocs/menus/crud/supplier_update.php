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

// Memproses permintaan POST untuk mengupdate data supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $supplier->idSupplier = mysqli_real_escape_string($db, $_POST['id']);
    $supplier->namaSupplier = mysqli_real_escape_string($db, $_POST['nama']);
    $supplier->alamatSupplier = mysqli_real_escape_string($db, $_POST['alamat']);
    $supplier->noHpSupplier = mysqli_real_escape_string($db, $_POST['nohp']);

    // Mengupdate data supplier berdasarkan IdSupplier
    if ($supplier->update()) {
        // Berhasil mengupdate, arahkan kembali ke halaman supplier
        header("Location: dashboard.php?page=supplier");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
