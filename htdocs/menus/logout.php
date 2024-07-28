<?php
// Memulai sesi, pastikan hanya ada satu sesi yang berjalan
session_start();

// Menghancurkan semua data sesi
session_destroy();

// Mengarahkan pengguna ke halaman login setelah logout
header("Location: login.php");

// Menghentikan eksekusi skrip lebih lanjut
exit();
?>
