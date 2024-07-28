<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/Pelanggan.php');

$database = new Database();
$db = $database->getConnection();

$pelanggan = new Pelanggan($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan hapus
if (isset($_GET['delete'])) {
    $pelanggan->idPelanggan = $_GET['delete'];
    if ($pelanggan->delete()) {
        header("Location: dashboard.php?page=pelanggan");
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Menangani permintaan buat dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelanggan->idPelanggan = $_POST['id'];
    $pelanggan->namaPelanggan = $_POST['nama'];
    $pelanggan->alamatPelanggan = $_POST['alamat'];
    $pelanggan->noHpPelanggan = $_POST['nohp'];

    if ($_POST['isEdit'] === 'true') {
        // Update pelanggan yang ada
        if ($pelanggan->update()) {
            header("Location: dashboard.php?page=pelanggan");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        // Buat pelanggan baru
        if ($pelanggan->create()) {
            header("Location: dashboard.php?page=pelanggan");
            exit();
        } else {
            echo "Error creating record.";
        }
    }
}

// Ambil semua pelanggan
$result = $pelanggan->read();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
<div class="main-content">
    <header>
        <h2>Data Pelanggan</h2>
        <button class="add-button" onclick="openForm()">Tambah Pelanggan</button>
    </header>
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat Pelanggan</th>
                    <th>No HP Pelanggan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdPelanggan']); ?></td>
                        <td><?php echo htmlspecialchars($row['NamaPelanggan']); ?></td>
                        <td><?php echo htmlspecialchars($row['AlamatPelanggan']); ?></td>
                        <td><?php echo htmlspecialchars($row['NoHpPelanggan']); ?></td>
                        <td>
                            <button class="edit-btn"
                                    data-id="<?php echo htmlspecialchars($row['IdPelanggan']); ?>"
                                    data-nama="<?php echo htmlspecialchars($row['NamaPelanggan']); ?>"
                                    data-alamat="<?php echo htmlspecialchars($row['AlamatPelanggan']); ?>"
                                    data-nohp="<?php echo htmlspecialchars($row['NoHpPelanggan']); ?>"
                                    onclick="editPelanggan(this)">Edit</button>
                            <a href="dashboard.php?page=pelanggan&delete=<?php echo htmlspecialchars($row['IdPelanggan']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Hapus</a>
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
            <label for="id">Id Pelanggan:</label>
            <input type="text" id="id" name="id" required>
            <br>
            <label for="nama">Nama Pelanggan:</label>
            <input type="text" id="nama" name="nama" required>
            <br>
            <label for="alamat">Alamat Pelanggan:</label>
            <input type="text" id="alamat" name="alamat" required>
            <br>
            <label for="nohp">No HP Pelanggan:</label>
            <input type="text" id="nohp" name="nohp" required>
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

// Fungsi untuk mengedit pelanggan
function editPelanggan(button) {
    document.getElementById('isEdit').value = 'true'; // Menandai bahwa ini adalah mode edit
    document.getElementById('id').value = button.getAttribute('data-id'); // Mengisi field ID
    document.getElementById('id').readOnly = true; // Membuat field ID read-only
    document.getElementById('nama').value = button.getAttribute('data-nama'); // Mengisi field Nama
    document.getElementById('alamat').value = button.getAttribute('data-alamat'); // Mengisi field Alamat
    document.getElementById('nohp').value = button.getAttribute('data-nohp'); // Mengisi field No HP
    document.getElementById('submitButton').innerText = 'Update'; // Mengubah teks tombol menjadi Update
    document.getElementById('modalOverlay').style.display = 'flex'; // Menampilkan form
}

// Fungsi untuk membersihkan form
function clearForm() {
    document.getElementById('isEdit').value = 'false';
    document.getElementById('id').value = '';
    document.getElementById('id').readOnly = false;
    document.getElementById('nama').value = '';
    document.getElementById('alamat').value = '';
    document.getElementById('nohp').value = '';
    document.getElementById('submitButton').innerText = 'Simpan'; // Mengubah teks tombol menjadi Simpan
}
</script>
</body>
</html>
