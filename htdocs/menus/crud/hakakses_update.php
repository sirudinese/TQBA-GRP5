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

// Memproses permintaan POST untuk mengupdate data hak akses
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $hakAkses->idAkses = mysqli_real_escape_string($db, $_POST['id']);
    $hakAkses->namaAkses = mysqli_real_escape_string($db, $_POST['nama']);
    $hakAkses->keterangan = mysqli_real_escape_string($db, $_POST['keterangan']);

    // Mengupdate data hak akses berdasarkan IdAkses
    if ($hakAkses->update()) {
        // Berhasil mengupdate, arahkan kembali ke halaman hak akses
        header("Location: dashboard.php?page=hakakses");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
