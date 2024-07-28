<?php
// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Menghubungkan ke database
include('../class/database.php');

$database = new Database();
$conn = $database->getConnection();

// Mengecek jika pengguna belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$idAkses = $user['IdAkses'];

// Mendapatkan Nama Akses pengguna dari database
$sql = "SELECT NamaAkses FROM HakAkses WHERE IdAkses='$idAkses'";
$result = mysqli_query($conn, $sql);
$hakAkses = mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result)['NamaAkses'] : '';

// Mendapatkan total pesanan
$sqlTotalPesanan = "SELECT COUNT(*) AS totalPesanan FROM Penjualan";
$resultTotalPesanan = mysqli_query($conn, $sqlTotalPesanan);
$totalPesanan = mysqli_fetch_assoc($resultTotalPesanan)['totalPesanan'];

// Mendapatkan total pemasukan
$sqlTotalPemasukan = "SELECT SUM(JumlahPenjualan * HargaJual) AS totalPemasukan FROM Penjualan";
$resultTotalPemasukan = mysqli_query($conn, $sqlTotalPemasukan);
$totalPemasukan = mysqli_fetch_assoc($resultTotalPemasukan)['totalPemasukan'];

// Mendapatkan total pelanggan
$sqlTotalPelanggan = "SELECT COUNT(*) AS totalPelanggan FROM Pelanggan";
$resultTotalPelanggan = mysqli_query($conn, $sqlTotalPelanggan);
$totalPelanggan = mysqli_fetch_assoc($resultTotalPelanggan)['totalPelanggan'];

// Mengambil data penjualan per barang
$sqlPenjualan = "SELECT Penjualan.IdPenjualan, Penjualan.JumlahPenjualan, Penjualan.HargaJual, Barang.IdBarang, Barang.NamaBarang 
                 FROM Penjualan
                 JOIN Barang ON Penjualan.IdPengguna = Barang.IdPengguna";
$resultPenjualan = mysqli_query($conn, $sqlPenjualan);

// Mengambil data pembelian per barang
$sqlPembelian = "SELECT Pembelian.IdPembelian, Pembelian.JumlahPembelian, Pembelian.HargaBeli, Barang.IdBarang, Barang.NamaBarang 
                 FROM Pembelian
                 JOIN Barang ON Pembelian.IdPengguna = Barang.IdPengguna";
$resultPembelian = mysqli_query($conn, $sqlPembelian);

// Menghitung laba rugi per barang
$barangData = [];
while ($rowPenjualan = mysqli_fetch_assoc($resultPenjualan)) {
    $idBarang = $rowPenjualan['IdBarang'];
    if (!isset($barangData[$idBarang])) {
        $barangData[$idBarang] = ['NamaBarang' => $rowPenjualan['NamaBarang'], 'Pendapatan' => 0, 'Biaya' => 0];
    }
    $barangData[$idBarang]['Pendapatan'] += $rowPenjualan['JumlahPenjualan'] * $rowPenjualan['HargaJual'];
}

while ($rowPembelian = mysqli_fetch_assoc($resultPembelian)) {
    $idBarang = $rowPembelian['IdBarang'];
    if (!isset($barangData[$idBarang])) {
        $barangData[$idBarang] = ['NamaBarang' => $rowPembelian['NamaBarang'], 'Pendapatan' => 0, 'Biaya' => 0];
    }
    $barangData[$idBarang]['Biaya'] += $rowPembelian['JumlahPembelian'] * $rowPembelian['HargaBeli'];
}

// Menyiapkan data untuk chart
$namaBarang = [];
$pendapatan = [];
$biaya = [];
foreach ($barangData as $data) {
    $namaBarang[] = $data['NamaBarang'];
    $pendapatan[] = $data['Pendapatan'];
    $biaya[] = $data['Biaya'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/crud.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>MYSTORE</h2>
        </div>
        <ul>
            <li><a href="dashboard.php?page=beranda"><i class="fas fa-home"></i> Beranda</a></li>
            <?php if (in_array($hakAkses, ['Admin', 'Manager', 'Supervisor', 'HRD', 'IT Support'])): ?>
                <li><a href="dashboard.php?page=barang"><i class="fas fa-box"></i> Barang</a></li>
                <li><a href="dashboard.php?page=penjualan"><i class="fas fa-chart-line"></i> Penjualan</a></li>
                <li><a href="dashboard.php?page=pembelian"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
                <li><a href="dashboard.php?page=pengguna"><i class="fas fa-users"></i> Pengguna</a></li>
                <li><a href="dashboard.php?page=hakakses"><i class="fas fa-key"></i> Hak Akses</a></li>
                <li><a href="dashboard.php?page=supplier"><i class="fas fa-truck"></i> Supplier</a></li>
                <li><a href="dashboard.php?page=pelanggan"><i class="fas fa-user-friends"></i> Pelanggan</a></li>
            <?php elseif ($hakAkses == 'Karyawan'): ?>
                <li><a href="dashboard.php?page=penjualan"><i class="fas fa-chart-line"></i> Penjualan</a></li>
                <li><a href="dashboard.php?page=pembelian"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
            <?php elseif ($hakAkses == 'Gudang'): ?>
                <li><a href="dashboard.php?page=barang"><i class="fas fa-box"></i> Barang</a></li>
            <?php elseif ($hakAkses == 'Kasir'): ?>
                <li><a href="dashboard.php?page=penjualan"><i class="fas fa-chart-line"></i> Penjualan</a></li>
            <?php endif; ?>
            <li><a href="../menus/logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h2>Selamat Datang, <?php echo htmlspecialchars($user['NamaDepan'] . " " . $user['NamaBelakang']); ?></h2>
            <h3>Role: <?php echo htmlspecialchars($hakAkses); ?></h3>
        </header>
        <div class="content">
            <?php
            // Menampilkan halaman sesuai parameter 'page'
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'barang':
                        include('barang.php');
                        break;
                    case 'penjualan':
                        include('penjualan.php');
                        break;
                    case 'pembelian':
                        include('pembelian.php');
                        break;
                    case 'pengguna':
                        include('pengguna.php');
                        break;
                    case 'hakakses':
                        include('hakakses.php');
                        break;
                    case 'supplier':
                        include('supplier.php');
                        break;
                    case 'pelanggan':
                        include('pelanggan.php');
                        break;
                    case 'beranda':
                    default:
                        // Menampilkan beranda atau halaman default
                        ?>
                        <div class="dashboard-cards">
                            <div class="card purple">
                                <div class="card-info">
                                    <div class="card-icon">
                                        <i class="fas fa-shopping-basket"></i>
                                    </div>
                                    <div class="card-details">
                                        <h3><?php echo number_format($totalPesanan); ?></h3>
                                        <p>Total Pesanan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card blue">
                                <div class="card-info">
                                    <div class="card-icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="card-details">
                                        <h3>Rp <?php echo number_format($totalPemasukan, 0, ',', '.'); ?></h3>
                                        <p>Total Pemasukan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card magenta">
                                <div class="card-info">
                                    <div class="card-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="card-details">
                                        <h3><?php echo number_format($totalPelanggan); ?></h3>
                                        <p>Total Pelanggan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="productSalesChart"></canvas>
                        </div>
                        <div class="content">
                            <div class="content-header">
                                <h3>Laporan Laba Rugi Per Barang</h3>
                            </div>
                            <div class="table-container">
                                <table class="profit-loss-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Total Pendapatan</th>
                                            <th>Total Biaya</th>
                                            <th>Laba Kotor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($barangData as $data) {
                                            $labaKotor = $data['Pendapatan'] - $data['Biaya'];
                                            $status = $labaKotor >= 0 ? 'Profit' : 'Rugi';
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($data['NamaBarang']); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($data['Pendapatan'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($data['Biaya'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($labaKotor, 2)); ?></td>
                                                <td class="<?php echo strtolower($status); ?>"><?php echo htmlspecialchars($status); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        break;
                }
            } else {
                // Menampilkan beranda jika tidak ada parameter 'page'
                ?>
                <div class="dashboard-cards">
                    <div class="card purple">
                        <div class="card-info">
                            <div class="card-icon">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                            <div class="card-details">
                                <h3><?php echo number_format($totalPesanan); ?></h3>
                                <p>Total Pesanan</p>
                            </div>
                        </div>
                    </div>
                    <div class="card blue">
                        <div class="card-info">
                            <div class="card-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-details">
                                <h3>Rp <?php echo number_format($totalPemasukan, 0, ',', '.'); ?></h3>
                                <p>Total Pemasukan</p>
                            </div>
                        </div>
                    </div>
                    <div class="card magenta">
                        <div class="card-info">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-details">
                                <h3><?php echo number_format($totalPelanggan); ?></h3>
                                <p>Total Pelanggan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="productSalesChart"></canvas>
                </div>
                <div class="content">
                    <div class="content-header">
                        <h3>Laporan Laba Rugi Per Barang</h3>
                    </div>
                    <div class="table-container">
                        <table class="profit-loss-table">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Total Pendapatan</th>
                                    <th>Total Biaya</th>
                                    <th>Laba Kotor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($barangData as $data) {
                                    $labaKotor = $data['Pendapatan'] - $data['Biaya'];
                                    $status = $labaKotor >= 0 ? 'Profit' : 'Rugi';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($data['NamaBarang']); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($data['Pendapatan'], 2)); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($data['Biaya'], 2)); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($labaKotor, 2)); ?></td>
                                        <td class="<?php echo strtolower($status); ?>"><?php echo htmlspecialchars($status); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <script>
        // Membuat chart menggunakan Chart.js
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('productSalesChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($namaBarang); ?>,
                    datasets: [{
                        label: 'Jumlah Penjualan',
                        data: <?php echo json_encode($pendapatan); ?>,
                        backgroundColor: [
                            'rgba(106, 27, 154, 0.8)',
                            'rgba(30, 136, 229, 0.8)',
                            'rgba(194, 24, 91, 0.8)',
                            'rgba(255, 87, 34, 0.8)',
                            'rgba(76, 175, 80, 0.8)',
                            'rgba(255, 235, 59, 0.8)',
                            'rgba(0, 188, 212, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(121, 85, 72, 0.8)',
                            'rgba(158, 158, 158, 0.8)'
                        ],
                        borderColor: [
                            'rgba(106, 27, 154, 1)',
                            'rgba(30, 136, 229, 1)',
                            'rgba(194, 24, 91, 1)',
                            'rgba(255, 87, 34, 1)',
                            'rgba(76, 175, 80, 1)',
                            'rgba(255, 235, 59, 1)',
                            'rgba(0, 188, 212, 1)',
                            'rgba(255, 193, 7, 1)',
                            'rgba(121, 85, 72, 1)',
                            'rgba(158, 158, 158, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
