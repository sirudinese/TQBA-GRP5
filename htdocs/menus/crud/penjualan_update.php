<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas Penjualan
include('../mydatabase/databasetk4.php');
require_once('../class/penjualan.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance Penjualan
$database = new Database();
$db = $database->getConnection();
$penjualan = new Penjualan($db);

// Memproses permintaan GET untuk mengambil data penjualan yang akan diedit
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $penjualan->idPenjualan = mysqli_real_escape_string($db, $_GET['id']);

    // Mengambil data penjualan berdasarkan IdPenjualan
    if (!$penjualan->readOne()) {
        echo "Data tidak ditemukan!";
        exit();
    }
}

// Memproses permintaan POST untuk mengupdate data penjualan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $penjualan->idPenjualan = mysqli_real_escape_string($db, $_POST['id']);
    $penjualan->jumlahPenjualan = mysqli_real_escape_string($db, $_POST['jumlah']);
    $penjualan->hargaJual = mysqli_real_escape_string($db, $_POST['harga']);
    $penjualan->idPengguna = mysqli_real_escape_string($db, $_POST['idPengguna']);
    $penjualan->idPelanggan = mysqli_real_escape_string($db, $_POST['idPelanggan']);

    // Mengupdate data penjualan berdasarkan IdPenjualan
    if ($penjualan->update()) {
        // Berhasil mengupdate, arahkan kembali ke halaman penjualan
        header("Location: dashboard.php?page=penjualan");
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
    <title>Update Penjualan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Update Penjualan</h2>
        </header>
        <div class="content">
            <form method="POST" action="penjualan_update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($penjualan->idPenjualan); ?>">
                <label for="jumlah">Jumlah Penjualan:</label>
                <input type="number" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($penjualan->jumlahPenjualan); ?>" required>
                <br>
                <label for="harga">Harga Jual:</label>
                <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($penjualan->hargaJual); ?>" required>
                <br>
                <label for="idPengguna">ID Pengguna:</label>
                <input type="text" id="idPengguna" name="idPengguna" value="<?php echo htmlspecialchars($penjualan->idPengguna); ?>" required>
                <br>
                <label for="idPelanggan">ID Pelanggan:</label>
                <input type="text" id="idPelanggan" name="idPelanggan" value="<?php echo htmlspecialchars($penjualan->idPelanggan); ?>" required>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
