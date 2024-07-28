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

// Memproses permintaan POST untuk menambahkan pengguna baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input dari pengguna
    $pengguna->idPengguna = mysqli_real_escape_string($db, $_POST['id']);
    $pengguna->namaPengguna = mysqli_real_escape_string($db, $_POST['namaPengguna']);
    $pengguna->password = mysqli_real_escape_string($db, $_POST['password']);
    $pengguna->namaDepan = mysqli_real_escape_string($db, $_POST['namaDepan']);
    $pengguna->namaBelakang = mysqli_real_escape_string($db, $_POST['namaBelakang']);
    $pengguna->noHp = mysqli_real_escape_string($db, $_POST['noHp']);
    $pengguna->alamat = mysqli_real_escape_string($db, $_POST['alamat']);
    $pengguna->idAkses = mysqli_real_escape_string($db, $_POST['idAkses']);

    // Menambahkan pengguna baru
    if ($pengguna->create()) {
        // Berhasil menambahkan, arahkan kembali ke halaman pengguna
        header("Location: dashboard.php?page=pengguna");
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
    <title>Create Pengguna</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Create Pengguna</h2>
        </header>
        <div class="content">
            <form method="POST" action="pengguna_create.php">
                <label for="id">ID Pengguna:</label>
                <input type="text" id="id" name="id" required>
                <br>
                <label for="namaPengguna">Nama Pengguna:</label>
                <input type="text" id="namaPengguna" name="namaPengguna" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <label for="namaDepan">Nama Depan:</label>
                <input type="text" id="namaDepan" name="namaDepan" required>
                <br>
                <label for="namaBelakang">Nama Belakang:</label>
                <input type="text" id="namaBelakang" name="namaBelakang">
                <br>
                <label for="noHp">No HP:</label>
                <input type="text" id="noHp" name="noHp">
                <br>
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat"></textarea>
                <br>
                <label for="idAkses">ID Akses:</label>
                <input type="text" id="idAkses" name="idAkses" required>
                <br>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
