<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas HakAkses
require_once('../class/database.php');
require_once('../class/hakakses.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance HakAkses
$database = new Database();
$db = $database->getConnection();
$hakAkses = new HakAkses($db);

// Memproses permintaan GET untuk mengambil data hak akses yang akan diedit
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $hakAkses->idAkses = mysqli_real_escape_string($db, $_GET['id']);

    // Mengambil data hak akses berdasarkan IdAkses
    if ($hakAkses->readOne()) {
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
    <title>Edit Hak Akses</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Edit Hak Akses</h2>
        </header>
        <div class="content">
            <form method="POST" action="hakakses_update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($hakAkses->idAkses); ?>">
                <label for="nama">Nama Akses:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($hakAkses->namaAkses); ?>" required>
                <br>
                <label for="keterangan">Keterangan:</label>
                <textarea id="keterangan" name="keterangan" required><?php echo htmlspecialchars($hakAkses->keterangan); ?></textarea>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
