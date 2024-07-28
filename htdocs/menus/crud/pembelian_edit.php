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

// Memproses permintaan GET untuk mengambil data pembelian yang akan diedit
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $pembelian->idPembelian = mysqli_real_escape_string($db, $_GET['id']);

    // Mengambil data pembelian
    $pembelian->readOne();
}

// Memproses permintaan POST untuk mengupdate data pembelian
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $pembelian->idPembelian = mysqli_real_escape_string($db, $_POST['id']);
    $pembelian->jumlahPembelian = mysqli_real_escape_string($db, $_POST['jumlah']);
    $pembelian->hargaBeli = mysqli_real_escape_string($db, $_POST['harga']);
    $pembelian->idPengguna = mysqli_real_escape_string($db, $_POST['idPengguna']);
    $pembelian->idSupplier = mysqli_real_escape_string($db, $_POST['idSupplier']);

    // Mengupdate data pembelian berdasarkan IdPembelian
    if ($pembelian->update()) {
        // Berhasil mengupdate, arahkan kembali ke halaman pembelian
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
    <title>Update Pembelian</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Update Pembelian</h2>
        </header>
        <div class="content">
            <form method="POST" action="pembelian_update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pembelian->idPembelian); ?>">
                <label for="jumlah">Jumlah Pembelian:</label>
                <input type="number" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($pembelian->jumlahPembelian); ?>" required>
                <br>
                <label for="harga">Harga Beli:</label>
                <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($pembelian->hargaBeli); ?>" required>
                <br>
                <label for="idPengguna">ID Pengguna:</label>
                <input type="text" id="idPengguna" name="idPengguna" value="<?php echo htmlspecialchars($pembelian->idPengguna); ?>" required>
                <br>
                <label for="idSupplier">ID Supplier:</label>
                <input type="text" id="idSupplier" name="idSupplier" value="<?php echo htmlspecialchars($pembelian->idSupplier); ?>" required>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
