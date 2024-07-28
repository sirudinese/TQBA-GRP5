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

// Memproses permintaan POST untuk mengupdate data pelanggan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $pelanggan->idPelanggan = mysqli_real_escape_string($db, $_POST['id']);
    $pelanggan->namaPelanggan = mysqli_real_escape_string($db, $_POST['nama']);
    $pelanggan->alamatPelanggan = mysqli_real_escape_string($db, $_POST['alamat']);
    $pelanggan->noHpPelanggan = mysqli_real_escape_string($db, $_POST['nohp']);

    // Mengupdate data pelanggan berdasarkan IdPelanggan
    if ($pelanggan->update()) {
        // Berhasil mengupdate, arahkan kembali ke halaman pelanggan
        header("Location: dashboard.php?page=pelanggan");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
