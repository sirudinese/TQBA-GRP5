<?php
// Memulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Menghubungkan ke database
include('../class/database.php');

$database = new Database();
$conn = $database->getConnection();

// Mengecek jika pengguna sudah login, arahkan ke halaman dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

// Inisialisasi variabel error
$error = '';

// Memproses form login saat dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form dan menghindari SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk memeriksa pengguna dengan username dan password yang diberikan
    $sql = "SELECT * FROM Pengguna WHERE NamaPengguna='$username' AND Password='$password'";
    $result = mysqli_query($conn, $sql);

    // Mengecek apakah query menemukan satu hasil
    if (mysqli_num_rows($result) === 1) {
        // Menyimpan informasi pengguna ke sesi
        $_SESSION['user'] = mysqli_fetch_assoc($result);
        // Mengarahkan ke dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Menyimpan pesan error jika username atau password salah
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="login-image"></div>
        <div class="login-form">
            <!-- Form untuk login -->
            <form method="post" action="">
                <h2>Member Login</h2>
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Your password" required>
                </div>
                <button type="submit">Sign in</button>
                <!-- Menampilkan pesan error jika ada -->
                <?php if (!empty($error)): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <a href="#">Lupa Password? Klik Disini</a>
            </form>
        </div>
    </div>
</body>
</html>
