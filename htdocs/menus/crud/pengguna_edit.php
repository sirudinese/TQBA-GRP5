<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengimpor koneksi database dan kelas Pengguna
require_once('../class/database.php');
require_once('../class/pengguna.php');

// Mengarahkan pengguna ke halaman login jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Buat instance Pengguna
$database = new Database();
$db = $database->getConnection();
$pengguna = new Pengguna($db);

// Memproses permintaan GET untuk mengambil data pengguna yang akan diedit
if (isset($_GET['id'])) {
    // Mengamankan input dari pengguna
    $pengguna->idPengguna = mysqli_real_escape_string($db, $_GET['id']);

    // Mengambil data pengguna berdasarkan IdPengguna
    if ($pengguna->readOne()) {
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
    <title>Edit Pengguna</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Edit Pengguna</h2>
        </header>
        <div class="content">
            <form method="POST" action="pengguna_update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pengguna->idPengguna); ?>">
                <label for="namaPengguna">Nama Pengguna:</label>
                <input type="text" id="namaPengguna" name="namaPengguna" value="<?php echo htmlspecialchars($pengguna->namaPengguna); ?>" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($pengguna->password); ?>" required>
                <br>
                <label for="namaDepan">Nama Depan:</label>
                <input type="text" id="namaDepan" name="namaDepan" value="<?php echo htmlspecialchars($pengguna->namaDepan); ?>" required>
                <br>
                <label for="namaBelakang">Nama Belakang:</label>
                <input type="text" id="namaBelakang" name="namaBelakang" value="<?php echo htmlspecialchars($pengguna->namaBelakang); ?>">
                <br>
                <label for="noHp">No HP:</label>
                <input type="text" id="noHp" name="noHp" value="<?php echo htmlspecialchars($pengguna->noHp); ?>">
                <br>
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat"><?php echo htmlspecialchars($pengguna->alamat); ?></textarea>
                <br>
                <label for="idAkses">ID Akses:</label>
                <input type="text" id="idAkses" name="idAkses" value="<?php echo htmlspecialchars($pengguna->idAkses); ?>" required>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
