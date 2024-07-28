<?php
// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    // Jika pengguna sudah login, arahkan ke halaman dashboard
    header('Location: dashboard.php');
} else {
    // Jika pengguna belum login, arahkan ke halaman login
    header('Location: login.php');
}
// Menghentikan eksekusi skrip setelah pengalihan
exit();
