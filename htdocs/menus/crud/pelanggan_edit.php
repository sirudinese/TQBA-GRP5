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

// Memproses permintaan GET untuk mengambil data pelanggan yang akan diedit
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $pelanggan->idPelanggan = mysqli_real_escape_string($db, $_GET['id']);

    // Mengambil data pelanggan berdasarkan IdPelanggan
    if ($pelanggan->readOne()) {
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
    <title>Edit Pelanggan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Edit Pelanggan</h2>
        </header>
        <div class="content">
            <form method="POST" action="pelanggan_update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pelanggan->idPelanggan); ?>">
                <label for="nama">Nama Pelanggan:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pelanggan->namaPelanggan); ?>" required>
                <br>
                <label for="alamat">Alamat Pelanggan:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($pelanggan->alamatPelanggan); ?>" required>
                <br>
                <label for="nohp">No HP Pelanggan:</label>
                <input type="text" id="nohp" name="nohp" value="<?php echo htmlspecialchars($pelanggan->noHpPelanggan); ?>" required>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
