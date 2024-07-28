<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/pengguna.php');

$database = new Database();
$db = $database->getConnection();

$pengguna = new Pengguna($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan hapus
if (isset($_GET['delete'])) {
    $pengguna->idPengguna = $_GET['delete'];
    if ($pengguna->delete()) {
        header("Location: dashboard.php?page=pengguna");
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Menangani permintaan buat dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pengguna->idPengguna = $_POST['id'];
    $pengguna->namaPengguna = $_POST['namaPengguna'];
    $pengguna->password = $_POST['password'];
    $pengguna->namaDepan = $_POST['namaDepan'];
    $pengguna->namaBelakang = $_POST['namaBelakang'];
    $pengguna->noHp = $_POST['noHp'];
    $pengguna->alamat = $_POST['alamat'];
    $pengguna->idAkses = $_POST['idAkses'];

    if ($_POST['isEdit'] === 'true') {
        // Update pengguna yang ada
        if ($pengguna->update()) {
            header("Location: dashboard.php?page=pengguna");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        // Buat pengguna baru
        if ($pengguna->create()) {
            header("Location: dashboard.php?page=pengguna");
            exit();
        } else {
            echo "Error creating record.";
        }
    }
}

// Ambil semua pengguna
$result = $pengguna->read();

// Ambil hak akses untuk dropdown
$sqlHakAkses = "SELECT IdAkses, NamaAkses FROM HakAkses";
$resultHakAkses = mysqli_query($db, $sqlHakAkses);
$hakAksesList = [];
while ($row = mysqli_fetch_assoc($resultHakAkses)) {
    $hakAksesList[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pengguna</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
<div class="main-content">
    <header>
        <h2>Data Pengguna</h2>
        <button class="add-button" onclick="openForm()">Tambah Pengguna</button>
    </header>
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id Pengguna</th>
                    <th>Nama Pengguna</th>
                    <th>Password</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Id Akses</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdPengguna']); ?></td>
                        <td><?php echo htmlspecialchars($row['NamaPengguna']); ?></td>
                        <td><?php echo htmlspecialchars($row['Password']); ?></td>
                        <td><?php echo htmlspecialchars($row['NamaDepan']); ?></td>
                        <td><?php echo htmlspecialchars($row['NamaBelakang']); ?></td>
                        <td><?php echo htmlspecialchars($row['NoHp']); ?></td>
                        <td><?php echo htmlspecialchars($row['Alamat']); ?></td>
                        <td><?php echo htmlspecialchars($row['IdAkses']); ?></td>
                        <td>
                            <button class="edit-btn"
                                    data-id="<?php echo htmlspecialchars($row['IdPengguna']); ?>"
                                    data-namaPengguna="<?php echo htmlspecialchars($row['NamaPengguna']); ?>"
                                    data-password="<?php echo htmlspecialchars($row['Password']); ?>"
                                    data-namaDepan="<?php echo htmlspecialchars($row['NamaDepan']); ?>"
                                    data-namaBelakang="<?php echo htmlspecialchars($row['NamaBelakang']); ?>"
                                    data-noHp="<?php echo htmlspecialchars($row['NoHp']); ?>"
                                    data-alamat="<?php echo htmlspecialchars($row['Alamat']); ?>"
                                    data-idAkses="<?php echo htmlspecialchars($row['IdAkses']); ?>"
                                    onclick="editPengguna(this)">Edit</button>
                            <a href="dashboard.php?page=pengguna&delete=<?php echo htmlspecialchars($row['IdPengguna']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
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
            <label for="id">Id Pengguna:</label>
            <input type="text" id="id" name="id" required>
            <br>
            <label for="namaPengguna">Nama Pengguna:</label>
            <input type="text" id="namaPengguna" name="namaPengguna" required>
            <br>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required>
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
            <label for="idAkses">Id Akses:</label>
            <select id="idAkses" name="idAkses" required>
                <?php foreach ($hakAksesList as $hakAkses): ?>
                    <option value="<?php echo htmlspecialchars($hakAkses['IdAkses']); ?>"><?php echo htmlspecialchars($hakAkses['NamaAkses']); ?></option>
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

// Fungsi untuk mengedit pengguna
function editPengguna(button) {
    document.getElementById('isEdit').value = 'true';
    document.getElementById('id').value = button.getAttribute('data-id');
    document.getElementById('id').readOnly = true; // Set readOnly saat mengedit
    document.getElementById('namaPengguna').value = button.getAttribute('data-namaPengguna');
    document.getElementById('password').value = button.getAttribute('data-password');
    document.getElementById('namaDepan').value = button.getAttribute('data-namaDepan');
    document.getElementById('namaBelakang').value = button.getAttribute('data-namaBelakang');
    document.getElementById('noHp').value = button.getAttribute('data-noHp');
    document.getElementById('alamat').value = button.getAttribute('data-alamat');
    document.getElementById('idAkses').value = button.getAttribute('data-idAkses');
    document.getElementById('submitButton').innerText = 'Update'; // Mengubah teks tombol menjadi Update
    document.getElementById('modalOverlay').style.display = 'flex';
}

// Fungsi untuk membersihkan form
function clearForm() {
    document.getElementById('isEdit').value = 'false';
    document.getElementById('id').value = '';
    document.getElementById('id').readOnly = false; // Pastikan ini tidak readonly saat menambahkan data baru
    document.getElementById('namaPengguna').value = '';
    document.getElementById('password').value = '';
    document.getElementById('namaDepan').value = '';
    document.getElementById('namaBelakang').value = '';
    document.getElementById('noHp').value = '';
    document.getElementById('alamat').value = '';
    document.getElementById('idAkses').value = '';
    document.getElementById('submitButton').innerText = 'Simpan'; // Mengubah teks tombol menjadi Simpan
}
</script>
</body>
</html>
