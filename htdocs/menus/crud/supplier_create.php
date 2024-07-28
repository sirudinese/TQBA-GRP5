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

// Memproses permintaan POST untuk menambahkan supplier baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $supplier->idSupplier = mysqli_real_escape_string($db, $_POST['id']);
    $supplier->namaSupplier = mysqli_real_escape_string($db, $_POST['nama']);
    $supplier->alamatSupplier = mysqli_real_escape_string($db, $_POST['alamat']);
    $supplier->noHpSupplier = mysqli_real_escape_string($db, $_POST['nohp']);

    // Menambahkan supplier baru
    if ($supplier->create()) {
        // Berhasil menambahkan, arahkan kembali ke halaman supplier
        header("Location: dashboard.php?page=supplier");
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
    <title>Create Supplier</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Create Supplier</h2>
        </header>
        <div class="content">
            <form method="POST" action="supplier_create.php">
                <label for="id">ID Supplier:</label>
                <input type="text" id="id" name="id" required>
                <br>
                <label for="nama">Nama Supplier:</label>
                <input type="text" id="nama" name="nama" required>
                <br>
                <label for="alamat">Alamat Supplier:</label>
                <input type="text" id="alamat" name="alamat" required>
                <br>
                <label for="nohp">No HP Supplier:</label>
                <input type="text" id="nohp" name="nohp" required>
                <br>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
