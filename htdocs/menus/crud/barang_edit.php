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

// Memproses permintaan GET untuk mengambil data barang yang akan diedit
if (isset($_GET['id'])) {
    $barang->idBarang = $_GET['id'];

    if ($barang->readOne()) {
        // Data barang ditemukan, lanjutkan ke form edit
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
}

// Memproses permintaan POST untuk mengupdate data barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $barang->idBarang = $_POST['id'];
    $barang->namaBarang = $_POST['nama'];
    $barang->keterangan = $_POST['keterangan'];
    $barang->satuan = $_POST['satuan'];
    $barang->idPengguna = $_POST['idPengguna'];

    if ($barang->update()) {
        // Berhasil mengupdate, arahkan kembali ke halaman barang
        header("Location: dashboard.php?page=barang");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Barang</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Update Barang</h2>
        </header>
        <div class="content">
            <form method="POST" action="barang_edit.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($barang->idBarang); ?>">
                <label for="nama">Nama Barang:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($barang->namaBarang); ?>" required>
                <br>
                <label for="keterangan">Keterangan:</label>
                <textarea id="keterangan" name="keterangan" required><?php echo htmlspecialchars($barang->keterangan); ?></textarea>
                <br>
                <label for="satuan">Satuan:</label>
                <input type="text" id="satuan" name="satuan" value="<?php echo htmlspecialchars($barang->satuan); ?>" required>
                <br>
                <label for="idPengguna">Id Pengguna:</label>
                <input type="text" id="idPengguna" name="idPengguna" value="<?php echo htmlspecialchars($barang->idPengguna); ?>" required>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
