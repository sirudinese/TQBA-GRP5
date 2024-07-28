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

// Memproses permintaan POST untuk mengupdate data pengguna
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $pengguna->idPengguna = mysqli_real_escape_string($db, $_POST['id']);
    $pengguna->namaPengguna = mysqli_real_escape_string($db, $_POST['namaPengguna']);
    $pengguna->password = mysqli_real_escape_string($db, $_POST['password']);
    $pengguna->namaDepan = mysqli_real_escape_string($db, $_POST['namaDepan']);
    $pengguna->namaBelakang = mysqli_real_escape_string($db, $_POST['namaBelakang']);
    $pengguna->noHp = mysqli_real_escape_string($db, $_POST['noHp']);
    $pengguna->alamat = mysqli_real_escape_string($db, $_POST['alamat']);
    $pengguna->idAkses = mysqli_real_escape_string($db, $_POST['idAkses']);

    // Mengupdate data pengguna berdasarkan IdPengguna
    if ($pengguna->update()) {
        // Berhasil mengupdate, arahkan kembali ke halaman pengguna
        header("Location: dashboard.php?page=pengguna");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>
