<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/barang.php');

$database = new Database();
$db = $database->getConnection();

$barang = new Barang($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan hapus
if (isset($_GET['delete'])) {
    $barang->idBarang = $_GET['delete'];
    if ($barang->delete()) {
        header("Location: dashboard.php?page=barang");
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Menangani permintaan buat dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $barang->idBarang = $_POST['id'];
    $barang->namaBarang = $_POST['nama'];
    $barang->keterangan = $_POST['keterangan'];
    $barang->satuan = $_POST['satuan'];
    $barang->idPengguna = $_POST['idPengguna'];

    if ($_POST['isEdit'] === 'true') {
        // Update barang yang ada
        if ($barang->update()) {
            header("Location: dashboard.php?page=barang");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        // Buat barang baru
        if ($barang->create()) {
            header("Location: dashboard.php?page=barang");
            exit();
        } else {
            echo "Error creating record.";
        }
    }
}

// Ambil semua barang
$result = $barang->read();

// Ambil pengguna untuk dropdown
$sqlPengguna = "SELECT IdPengguna FROM Pengguna";
$resultPengguna = mysqli_query($db, $sqlPengguna);
$penggunaList = [];
while ($row = mysqli_fetch_assoc($resultPengguna)) {
    $penggunaList[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
<div class="main-content">
    <header>
        <h2>Data Barang</h2>
        <button class="add-button" onclick="openForm()">Tambah Barang</button>
    </header>
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id Barang</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th>Satuan</th>
                    <th>Id Pengguna</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdBarang']); ?></td>
                        <td><?php echo htmlspecialchars($row['NamaBarang']); ?></td>
                        <td><?php echo htmlspecialchars($row['Keterangan']); ?></td>
                        <td><?php echo htmlspecialchars($row['Satuan']); ?></td>
                        <td><?php echo htmlspecialchars($row['IdPengguna']); ?></td>
                        <td>
                            <button class="edit-btn"
                                    data-id="<?php echo htmlspecialchars($row['IdBarang']); ?>"
                                    data-nama="<?php echo htmlspecialchars($row['NamaBarang']); ?>"
                                    data-keterangan="<?php echo htmlspecialchars($row['Keterangan']); ?>"
                                    data-satuan="<?php echo htmlspecialchars($row['Satuan']); ?>"
                                    data-idPengguna="<?php echo htmlspecialchars($row['IdPengguna']); ?>"
                                    onclick="editBarang(this)">Edit</button>
                            <a href="dashboard.php?page=barang&delete=<?php echo htmlspecialchars($row['IdBarang']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
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
            <label for="id">Id Barang:</label>
            <input type="text" id="id" name="id" required>
            <br>
            <label for="nama">Nama Barang:</label>
            <input type="text" id="nama" name="nama" required>
            <br>
            <label for="keterangan">Keterangan:</label>
            <textarea id="keterangan" name="keterangan" required></textarea>
            <br>
            <label for="satuan">Satuan:</label>
            <input type="text" id="satuan" name="satuan" required>
            <br>
            <label for="idPengguna">Id Pengguna:</label>
            <select id="idPengguna" name="idPengguna" required>
                <?php foreach ($penggunaList as $pengguna): ?>
                    <option value="<?php echo htmlspecialchars($pengguna['IdPengguna']); ?>"><?php echo htmlspecialchars($pengguna['IdPengguna']); ?></option>
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

// Fungsi untuk mengedit barang
function editBarang(button) {
    document.getElementById('isEdit').value = 'true'; // Menandai bahwa ini adalah mode edit
    document.getElementById('id').value = button.getAttribute('data-id'); // Mengisi field ID
    document.getElementById('id').readOnly = true; // Membuat field ID read-only
    document.getElementById('nama').value = button.getAttribute('data-nama'); // Mengisi field Nama
    document.getElementById('keterangan').value = button.getAttribute('data-keterangan'); // Mengisi field Keterangan
    document.getElementById('satuan').value = button.getAttribute('data-satuan'); // Mengisi field Satuan
    document.getElementById('idPengguna').value = button.getAttribute('data-idPengguna'); // Mengisi field Id Pengguna
    document.getElementById('modalOverlay').style.display = 'flex'; // Menampilkan form
    document.getElementById('submitButton').textContent = 'Update'; // Mengubah teks tombol menjadi "Update"
}

// Fungsi untuk membersihkan form
function clearForm() {
    document.getElementById('isEdit').value = 'false';
    document.getElementById('id').value = '';
    document.getElementById('id').readOnly = false;
    document.getElementById('nama').value = '';
    document.getElementById('keterangan').value = '';
    document.getElementById('satuan').value = '';
    document.getElementById('idPengguna').value = '';
    document.getElementById('submitButton').textContent = 'Simpan'; // Mengubah teks tombol menjadi "Simpan"
}
</script>
</body>
</html>
