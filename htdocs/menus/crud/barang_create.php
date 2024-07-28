<?php
// Memulai sesi hanya jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/Barang.php');

$database = new Database();
$db = $database->getConnection();

$barang = new Barang($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan buat barang baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['keterangan']) && isset($_POST['satuan']) && isset($_POST['idPengguna'])) {
        $barang->idBarang = $_POST['id'];
        $barang->namaBarang = $_POST['nama'];
        $barang->keterangan = $_POST['keterangan'];
        $barang->satuan = $_POST['satuan'];
        $barang->idPengguna = $_POST['idPengguna'];

        // Memastikan IdPengguna ada di tabel Pengguna
        $checkPengguna = "SELECT IdPengguna FROM Pengguna WHERE IdPengguna='" . mysqli_real_escape_string($db, $_POST['idPengguna']) . "'";
        $resultPengguna = mysqli_query($db, $checkPengguna);

        if (mysqli_num_rows($resultPengguna) > 0) {
            if ($barang->create()) {
                // Berhasil menambahkan, arahkan kembali ke halaman barang
                header("Location: dashboard.php?page=barang");
                exit();
            } else {
                echo "Error creating record.";
            }
        } else {
            echo "IdPengguna tidak valid.";
        }
    } else {
        echo "Semua field harus diisi.";
    }
}
?>
