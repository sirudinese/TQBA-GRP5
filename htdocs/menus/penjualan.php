<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/penjualan.php');

$database = new Database();
$db = $database->getConnection();

$penjualan = new Penjualan($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan hapus
if (isset($_GET['delete'])) {
    $penjualan->idPenjualan = $_GET['delete'];
    if ($penjualan->delete()) {
        header("Location: dashboard.php?page=penjualan");
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Menangani permintaan buat dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penjualan->idPenjualan = $_POST['id'];
    $penjualan->jumlahPenjualan = $_POST['jumlah'];
    $penjualan->hargaJual = $_POST['harga'];
    $penjualan->idPengguna = $_POST['idPengguna'];
    $penjualan->idPelanggan = $_POST['idPelanggan'];

    if ($_POST['isEdit'] === 'true') {
        // Update penjualan yang ada
        if ($penjualan->update()) {
            header("Location: dashboard.php?page=penjualan");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        // Buat penjualan baru
        if ($penjualan->create()) {
            header("Location: dashboard.php?page=penjualan");
            exit();
        } else {
            echo "Error creating record.";
        }
    }
}

// Ambil semua penjualan
$result = $penjualan->read();

// Ambil pengguna dan pelanggan untuk dropdown
$penggunaList = [];
$pelangganList = [];

$sqlPengguna = "SELECT IdPengguna FROM Pengguna";
$resultPengguna = mysqli_query($db, $sqlPengguna);
while ($row = mysqli_fetch_assoc($resultPengguna)) {
    $penggunaList[] = $row;
}

$sqlPelanggan = "SELECT IdPelanggan FROM Pelanggan";
$resultPelanggan = mysqli_query($db, $sqlPelanggan);
while ($row = mysqli_fetch_assoc($resultPelanggan)) {
    $pelangganList[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
<div class="main-content">
    <header>
        <h2>Data Penjualan</h2>
        <button class="add-button" onclick="openForm()">Tambah Penjualan</button>
    </header>
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id Penjualan</th>
                    <th>Jumlah Penjualan</th>
                    <th>Harga Jual</th>
                    <th>Id Pengguna</th>
                    <th>Id Pelanggan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdPenjualan']); ?></td>
                        <td><?php echo htmlspecialchars($row['JumlahPenjualan']); ?></td>
                        <td><?php echo htmlspecialchars($row['HargaJual']); ?></td>
                        <td><?php echo htmlspecialchars($row['IdPengguna']); ?></td>
                        <td><?php echo htmlspecialchars($row['IdPelanggan']); ?></td>
                        <td>
                            <button class="edit-btn"
                                    data-id="<?php echo htmlspecialchars($row['IdPenjualan']); ?>"
                                    data-jumlah="<?php echo htmlspecialchars($row['JumlahPenjualan']); ?>"
                                    data-harga="<?php echo htmlspecialchars($row['HargaJual']); ?>"
                                    data-idPengguna="<?php echo htmlspecialchars($row['IdPengguna']); ?>"
                                    data-idPelanggan="<?php echo htmlspecialchars($row['IdPelanggan']); ?>"
                                    onclick="editPenjualan(this)">Edit</button>
                            <a href="dashboard.php?page=penjualan&delete=<?php echo htmlspecialchars($row['IdPenjualan']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Form Popup -->
<div class="modal-overlay" id="modalOverlay" style="display: none;">
    <div class="modal-content">
        <form method="POST" action="">
            <input type="hidden" name="isEdit" id="isEdit" value="false">
            <label for="id">Id Penjualan:</label>
            <input type="text" id="id" name="id" required>
            <br>
            <label for="jumlah">Jumlah Penjualan:</label>
            <input type="number" id="jumlah" name="jumlah" required>
            <br>
            <label for="harga">Harga Jual:</label>
            <input type="number" id="harga" name="harga" required>
            <br>
            <label for="idPengguna">Id Pengguna:</label>
            <select id="idPengguna" name="idPengguna" required>
                <?php foreach ($penggunaList as $pengguna): ?>
                    <option value="<?php echo htmlspecialchars($pengguna['IdPengguna']); ?>"><?php echo htmlspecialchars($pengguna['IdPengguna']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="idPelanggan">Id Pelanggan:</label>
            <select id="idPelanggan" name="idPelanggan" required>
                <?php foreach ($pelangganList as $pelanggan): ?>
                    <option value="<?php echo htmlspecialchars($pelanggan['IdPelanggan']); ?>"><?php echo htmlspecialchars($pelanggan['IdPelanggan']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <button type="submit" id="submitButton">Simpan</button>
            <button type="button" onclick="closeForm()">Batal</button>
        </form>
    </div>
</div>

<script>
// Fungsi untuk membuka form popup
function openForm() {
    clearForm();
    document.getElementById('modalOverlay').style.display = 'flex';
}

// Fungsi untuk menutup form popup
function closeForm() {
    document.getElementById('modalOverlay').style.display = 'none';
}

// Fungsi untuk mengedit penjualan
function editPenjualan(button) {
    document.getElementById('isEdit').value = 'true'; // Menandai bahwa ini adalah mode edit
    document.getElementById('id').value = button.getAttribute('data-id'); // Mengisi field ID
    document.getElementById('id').readOnly = true; // Membuat field ID read-only
    document.getElementById('jumlah').value = button.getAttribute('data-jumlah'); // Mengisi field Jumlah Penjualan
    document.getElementById('harga').value = button.getAttribute('data-harga'); // Mengisi field Harga Jual
    document.getElementById('idPengguna').value = button.getAttribute('data-idPengguna'); // Mengisi field Id Pengguna
    document.getElementById('idPelanggan').value = button.getAttribute('data-idPelanggan'); // Mengisi field Id Pelanggan
    document.getElementById('submitButton').innerText = 'Update'; // Mengubah teks tombol menjadi Update
    document.getElementById('modalOverlay').style.display = 'flex'; // Menampilkan form
}

// Fungsi untuk membersihkan form
function clearForm() {
    document.getElementById('isEdit').value = 'false';
    document.getElementById('id').value = '';
    document.getElementById('id').readOnly = false;
    document.getElementById('jumlah').value = '';
    document.getElementById('harga').value = '';
    document.getElementById('idPengguna').value = '';
    document.getElementById('idPelanggan').value = '';
    document.getElementById('submitButton').innerText = 'Simpan'; // Mengubah teks tombol menjadi Simpan
}
</script>
</body>
</html>
