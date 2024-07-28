<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/Supplier.php');

$database = new Database();
$db = $database->getConnection();

$supplier = new Supplier($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan hapus
if (isset($_GET['delete'])) {
    $supplier->idSupplier = $_GET['delete'];
    if ($supplier->delete()) {
        header("Location: dashboard.php?page=supplier");
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Menangani permintaan buat dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier->idSupplier = $_POST['id'];
    $supplier->namaSupplier = $_POST['nama'];
    $supplier->alamatSupplier = $_POST['alamat'];
    $supplier->noHpSupplier = $_POST['nohp'];

    if ($_POST['isEdit'] === 'true') {
        // Update supplier yang ada
        if ($supplier->update()) {
            header("Location: dashboard.php?page=supplier");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        // Buat supplier baru
        if ($supplier->create()) {
            header("Location: dashboard.php?page=supplier");
            exit();
        } else {
            echo "Error creating record.";
        }
    }
}

// Ambil semua supplier
$result = $supplier->read();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
<div class="main-content">
    <header>
        <h2>Data Supplier</h2>
        <button class="add-button" onclick="openForm()">Tambah Supplier</button>
    </header>
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat Supplier</th>
                    <th>No HP Supplier</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdSupplier']); ?></td>
                        <td><?php echo htmlspecialchars($row['NamaSupplier']); ?></td>
                        <td><?php echo htmlspecialchars($row['AlamatSupplier']); ?></td>
                        <td><?php echo htmlspecialchars($row['NoHpSupplier']); ?></td>
                        <td>
                            <button class="edit-btn"
                                    data-id="<?php echo htmlspecialchars($row['IdSupplier']); ?>"
                                    data-nama="<?php echo htmlspecialchars($row['NamaSupplier']); ?>"
                                    data-alamat="<?php echo htmlspecialchars($row['AlamatSupplier']); ?>"
                                    data-nohp="<?php echo htmlspecialchars($row['NoHpSupplier']); ?>"
                                    onclick="editSupplier(this)">Edit</button>
                            <a href="dashboard.php?page=supplier&delete=<?php echo htmlspecialchars($row['IdSupplier']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">Hapus</a>
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
            <label for="id">Id Supplier:</label>
            <input type="text" id="id" name="id" required>
            <br>
            <label for="nama">Nama Supplier:</label>
            <input type="text" id="nama" name="nama" required>
            <br>
            <label for="alamat">Alamat Supplier:</label>
            <input type="text" id="alamat" name="alamat" required>
            <br>
            <label for="nohp">No HP Supplier:</label>
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

// Fungsi untuk mengedit supplier
function editSupplier(button) {
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
