<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../class/database.php');
require_once('../class/pembelian.php');

$database = new Database();
$db = $database->getConnection();

$pembelian = new Pembelian($db);

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Menangani permintaan hapus
if (isset($_GET['delete'])) {
    $pembelian->idPembelian = $_GET['delete'];
    if ($pembelian->delete()) {
        header("Location: dashboard.php?page=pembelian");
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Menangani permintaan buat dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pembelian->idPembelian = $_POST['id'];
    $pembelian->jumlahPembelian = $_POST['jumlah'];
    $pembelian->hargaBeli = $_POST['harga'];
    $pembelian->idPengguna = $_POST['idPengguna'];
    $pembelian->idSupplier = $_POST['idSupplier'];

    if ($_POST['isEdit'] === 'true') {
        // Update pembelian yang ada
        if ($pembelian->update()) {
            header("Location: dashboard.php?page=pembelian");
            exit();
        } else {
            echo "Error updating record.";
        }
    } else {
        // Buat pembelian baru
        if ($pembelian->create()) {
            header("Location: dashboard.php?page=pembelian");
            exit();
        } else {
            echo "Error creating record.";
        }
    }
}

// Ambil semua pembelian
$result = $pembelian->read();

// Ambil pengguna dan supplier untuk dropdown
$penggunaList = [];
$supplierList = [];

$sqlPengguna = "SELECT IdPengguna FROM Pengguna";
$resultPengguna = mysqli_query($db, $sqlPengguna);
while ($row = mysqli_fetch_assoc($resultPengguna)) {
    $penggunaList[] = $row;
}

$sqlSupplier = "SELECT IdSupplier FROM Supplier";
$resultSupplier = mysqli_query($db, $sqlSupplier);
while ($row = mysqli_fetch_assoc($resultSupplier)) {
    $supplierList[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pembelian</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
<div class="main-content">
    <header>
        <h2>Data Pembelian</h2>
        <button class="add-button" onclick="openForm()">Tambah Pembelian</button>
    </header>
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id Pembelian</th>
                    <th>Jumlah Pembelian</th>
                    <th>Harga Beli</th>
                    <th>Id Pengguna</th>
                    <th>Id Supplier</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdPembelian']); ?></td>
                        <td><?php echo htmlspecialchars($row['JumlahPembelian']); ?></td>
                        <td><?php echo htmlspecialchars($row['HargaBeli']); ?></td>
                        <td><?php echo htmlspecialchars($row['IdPengguna']); ?></td>
                        <td><?php echo htmlspecialchars($row['IdSupplier']); ?></td>
                        <td>
                            <button class="edit-btn"
                                    data-id="<?php echo htmlspecialchars($row['IdPembelian']); ?>"
                                    data-jumlah="<?php echo htmlspecialchars($row['JumlahPembelian']); ?>"
                                    data-harga="<?php echo htmlspecialchars($row['HargaBeli']); ?>"
                                    data-idPengguna="<?php echo htmlspecialchars($row['IdPengguna']); ?>"
                                    data-idSupplier="<?php echo htmlspecialchars($row['IdSupplier']); ?>"
                                    onclick="editPembelian(this)">Edit</button>
                            <a href="dashboard.php?page=pembelian&delete=<?php echo htmlspecialchars($row['IdPembelian']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus pembelian ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Form Popup -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-content">
        <form method="POST" action="">
            <input type="hidden" name="isEdit" id="isEdit" value="false">
            <label for="id">Id Pembelian:</label>
            <input type="text" id="id" name="id" required>
            <br>
            <label for="jumlah">Jumlah Pembelian:</label>
            <input type="number" id="jumlah" name="jumlah" required>
            <br>
            <label for="harga">Harga Beli:</label>
            <input type="number" id="harga" name="harga" required>
            <br>
            <label for="idPengguna">Id Pengguna:</label>
            <select id="idPengguna" name="idPengguna" required>
                <?php foreach ($penggunaList as $pengguna): ?>
                    <option value="<?php echo htmlspecialchars($pengguna['IdPengguna']); ?>"><?php echo htmlspecialchars($pengguna['IdPengguna']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="idSupplier">Id Supplier:</label>
            <select id="idSupplier" name="idSupplier" required>
                <?php foreach ($supplierList as $supplier): ?>
                    <option value="<?php echo htmlspecialchars($supplier['IdSupplier']); ?>"><?php echo htmlspecialchars($supplier['IdSupplier']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <button type="submit" id="submitButton">Simpan</button>
            <button type="button" onclick="closeForm()">Batal</button>
        </form>
    </div>
</div>

<script>
function openForm() {
    clearForm();
    document.getElementById('modalOverlay').style.display = 'flex';
}

function closeForm() {
    document.getElementById('modalOverlay').style.display = 'none';
}

function editPembelian(button) {
    document.getElementById('isEdit').value = 'true';
    document.getElementById('id').value = button.getAttribute('data-id');
    document.getElementById('id').readOnly = true;
    document.getElementById('jumlah').value = button.getAttribute('data-jumlah');
    document.getElementById('harga').value = button.getAttribute('data-harga');
    document.getElementById('idPengguna').value = button.getAttribute('data-idPengguna');
    document.getElementById('idSupplier').value = button.getAttribute('data-idSupplier');
    document.getElementById('submitButton').innerText = 'Update'; // Mengubah teks tombol menjadi Update
    document.getElementById('modalOverlay').style.display = 'flex';
}

function clearForm() {
    document.getElementById('isEdit').value = 'false';
    document.getElementById('id').value = '';
    document.getElementById('id').readOnly = false;
    document.getElementById('jumlah').value = '';
    document.getElementById('harga').value = '';
    document.getElementById('idPengguna').value = '';
    document.getElementById('idSupplier').value = '';
    document.getElementById('submitButton').innerText = 'Simpan'; // Mengubah teks tombol menjadi Simpan
}
</script>
</body>
</html>
