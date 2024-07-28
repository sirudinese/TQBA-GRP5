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

// Memproses permintaan GET untuk mengambil data supplier yang akan diedit
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $supplier->idSupplier = mysqli_real_escape_string($db, $_GET['id']);

    // Mengambil data supplier berdasarkan IdSupplier
    if ($supplier->readOne()) {
        // Data ditemukan
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Edit Supplier</h2>
        </header>
        <div class="content">
            <form method="POST" action="supplier_update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($supplier->idSupplier); ?>">
                <label for="nama">Nama Supplier:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($supplier->namaSupplier); ?>" required>
                <br>
                <label for="alamat">Alamat Supplier:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($supplier->alamatSupplier); ?>" required>
                <br>
                <label for="nohp">No HP Supplier:</label>
                <input type="text" id="nohp" name="nohp" value="<?php echo htmlspecialchars($supplier->noHpSupplier); ?>" required>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
