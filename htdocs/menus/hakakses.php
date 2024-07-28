<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/HakAkses.php');

$database = new Database();
$db = $database->getConnection();

$hakAkses = new HakAkses($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan hapus
if (isset($_GET['delete'])) {
    $hakAkses->idAkses = $_GET['delete'];
    if ($hakAkses->delete()) {
        header("Location: dashboard.php?page=hakakses");
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Menangani permintaan buat dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hakAkses->idAkses = $_POST['id'];
    $hakAkses->namaAkses = $_POST['nama'];
    $hakAkses->keterangan = $_POST['keterangan'];

    if ($_POST['isEdit'] === 'true') {
        // Update hak akses yang ada
        if ($hakAkses->update()) {
            header("Location: dashboard.php?page=hakakses");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        // Buat hak akses baru
        if ($hakAkses->create()) {
            header("Location: dashboard.php?page=hakakses");
            exit();
        } else {
            echo "Error creating record.";
        }
    }
}

// Ambil semua hak akses
$result = $hakAkses->read();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Hak Akses</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
<div class="main-content">
    <header>
        <h2>Data Hak Akses</h2>
        <button class="add-button" onclick="openForm()">Tambah Hak Akses</button>
    </header>
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id Akses</th>
                    <th>Nama Akses</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdAkses']); ?></td>
                        <td><?php echo htmlspecialchars($row['NamaAkses']); ?></td>
                        <td><?php echo htmlspecialchars($row['Keterangan']); ?></td>
                        <td>
                            <button class="edit-btn"
                                    data-id="<?php echo htmlspecialchars($row['IdAkses']); ?>"
                                    data-nama="<?php echo htmlspecialchars($row['NamaAkses']); ?>"
                                    data-keterangan="<?php echo htmlspecialchars($row['Keterangan']); ?>"
                                    onclick="editHakAkses(this)">Edit</button>
                            <a href="dashboard.php?page=hakakses&delete=<?php echo htmlspecialchars($row['IdAkses']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus hak akses ini?')">Hapus</a>
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
            <label for="id">Id Akses:</label>
            <input type="text" id="id" name="id" required>
            <br>
            <label for="nama">Nama Akses:</label>
            <input type="text" id="nama" name="nama" required>
            <br>
            <label for="keterangan">Keterangan:</label>
            <textarea id="keterangan" name="keterangan" required></textarea>
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

// Fungsi untuk mengedit hak akses
function editHakAkses(button) {
    document.getElementById('isEdit').value = 'true'; // Menandai bahwa ini adalah mode edit
    document.getElementById('id').value = button.getAttribute('data-id'); // Mengisi field ID
    document.getElementById('id').readOnly = true; // Membuat field ID read-only
    document.getElementById('nama').value = button.getAttribute('data-nama'); // Mengisi field Nama
    document.getElementById('keterangan').value = button.getAttribute('data-keterangan'); // Mengisi field Keterangan
    document.getElementById('submitButton').innerText = 'Update'; // Mengubah teks tombol menjadi Update
    document.getElementById('modalOverlay').style.display = 'flex'; // Menampilkan form
}

// Fungsi untuk membersihkan form
function clearForm() {
    document.getElementById('isEdit').value = 'false';
    document.getElementById('id').value = '';
    document.getElementById('id').readOnly = false;
    document.getElementById('nama').value = '';
    document.getElementById('keterangan').value = '';
    document.getElementById('submitButton').innerText = 'Simpan'; // Mengubah teks tombol menjadi Simpan
}
</script>
</body>
</html>
