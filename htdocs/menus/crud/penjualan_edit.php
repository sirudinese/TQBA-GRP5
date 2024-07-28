<?php
include_once '../classs/database.php';
include_once '../classs/penjualan.php';

$database = new Database();
$db = $database->getConnection();

$penjualan = new Penjualan($db);

if (isset($_GET['id'])) {
    $penjualan->id = $_GET['id'];
    $stmt = $penjualan->read();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $penjualan->idBarang = $row['idBarang'];
    $penjualan->jumlah = $row['jumlah'];
    $penjualan->harga = $row['harga'];
    $penjualan->tanggal = $row['tanggal'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penjualan->id = $_POST['id'];
    $penjualan->idBarang = $_POST['idBarang'];
    $penjualan->jumlah = $_POST['jumlah'];
    $penjualan->harga = $_POST['harga'];
    $penjualan->tanggal = $_POST['tanggal'];

    if ($penjualan->update()) {
        header("Location: ../menus/penjualan.php");
        exit();
    } else {
        echo "Error updating record.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Penjualan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Edit Penjualan</h2>
        </header>
        <div class="content">
            <form method="POST" action="">
                <label for="id">Id Penjualan:</label>
                <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($penjualan->id); ?>" readonly>
                <br>
                <label for="idBarang">Id Barang:</label>
                <input type="text" id="idBarang" name="idBarang" value="<?php echo htmlspecialchars($penjualan->idBarang); ?>" required>
                <br>
                <label for="jumlah">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($penjualan->jumlah); ?>" required>
                <br>
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($penjualan->harga); ?>" required>
                <br>
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($penjualan->tanggal); ?>" required>
                <br>
                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>
