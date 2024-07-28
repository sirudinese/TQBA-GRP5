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

// Memproses permintaan POST untuk menambahkan pembelian baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $pembelian->idPembelian = mysqli_real_escape_string($db, $_POST['id']);
    $pembelian->jumlahPembelian = mysqli_real_escape_string($db, $_POST['jumlah']);
    $pembelian->hargaBeli = mysqli_real_escape_string($db, $_POST['harga']);
    $pembelian->idPengguna = mysqli_real_escape_string($db, $_POST['idPengguna']);
    $pembelian->idSupplier = mysqli_real_escape_string($db, $_POST['idSupplier']);

    // Menambahkan pembelian baru
    if ($pembelian->create()) {
        // Berhasil menambahkan, arahkan kembali ke halaman pembelian
        header("Location: dashboard.php?page=pembelian");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Pembelian</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Create Pembelian</h2>
        </header>
        <div class="content">
            <form method="POST" action="pembelian_create.php">
                <label for="id">ID Pembelian:</label>
                <input type="text" id="id" name="id" required>
                <br>
                <label for="jumlah">Jumlah Pembelian:</label>
                <input type="number" id="jumlah" name="jumlah" required>
                <br>
                <label for="harga">Harga Beli:</label>
                <input type="number" id="harga" name="harga" required>
                <br>
                <label for="idPengguna">ID Pengguna:</label>
                <input type="text" id="idPengguna" name="idPengguna" required>
                <br>
                <label for="idSupplier">ID Supplier:</label>
                <input type="text" id="idSupplier" name="idSupplier" required>
                <br>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
