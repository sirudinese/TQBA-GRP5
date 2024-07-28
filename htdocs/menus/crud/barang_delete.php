<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database
include('../class/database.php');
include('../class/Barang.php');

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Memproses permintaan GET untuk menghapus barang
if (isset($_GET['id'])) {
    $barang->idBarang = $_GET['id'];

    if ($barang->readOne()) {
        // Menghapus barang berdasarkan IdBarang
        $sql = "DELETE FROM Barang WHERE IdBarang=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $barang->idBarang);

        if ($stmt->execute()) {
            // Berhasil menghapus, arahkan kembali ke halaman barang
            header("Location: dashboard.php?page=barang");
            exit();
        } else {
            // Tampilkan pesan error jika terjadi kesalahan
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Data tidak ditemukan!";
    }
}
?>
