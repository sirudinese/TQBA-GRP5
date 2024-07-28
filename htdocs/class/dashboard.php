<?php
class Dashboard {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mendapatkan Nama Akses pengguna dari database
    public function getNamaAkses($idAkses) {
        $query = "SELECT NamaAkses FROM hakakses WHERE IdAkses = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idAkses);
        $stmt->execute();
        $result = $stmt->get_result();
        $namaAkses = $result->fetch_assoc()['NamaAkses'] ?? '';
        $stmt->close();
        return $namaAkses;
    }

    // Mendapatkan total pesanan
    public function getTotalPesanan() {
        $query = "SELECT COUNT(*) AS totalPesanan FROM penjualan";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['totalPesanan'];
    }

    // Mendapatkan total pemasukan
    public function getTotalPemasukan() {
        $query = "SELECT SUM(JumlahPenjualan * HargaJual) AS totalPemasukan FROM penjualan";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['totalPemasukan'];
    }

    // Mendapatkan total pelanggan
    public function getTotalPelanggan() {
        $query = "SELECT COUNT(*) AS totalPelanggan FROM pelanggan";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['totalPelanggan'];
    }

    // Mengambil data penjualan per barang
    public function getPenjualan() {
        $query = "SELECT penjualan.IdPenjualan, penjualan.JumlahPenjualan, penjualan.HargaJual, barang.IdBarang, barang.NamaBarang 
                  FROM penjualan
                  JOIN barang ON penjualan.IdPengguna = barang.IdPengguna";
        $result = $this->conn->query($query);
        $penjualan = [];
        while ($row = $result->fetch_assoc()) {
            $penjualan[] = $row;
        }
        return $penjualan;
    }

    // Mengambil data pembelian per barang
    public function getPembelian() {
        $query = "SELECT pembelian.IdPembelian, pembelian.JumlahPembelian, pembelian.HargaBeli, barang.IdBarang, barang.NamaBarang 
                  FROM pembelian
                  JOIN barang ON pembelian.IdPengguna = barang.IdPengguna";
        $result = $this->conn->query($query);
        $pembelian = [];
        while ($row = $result->fetch_assoc()) {
            $pembelian[] = $row;
        }
        return $pembelian;
    }

    // Menghitung laba rugi per barang
    public function getLabaRugi() {
        $penjualan = $this->getPenjualan();
        $pembelian = $this->getPembelian();
        
        $barangData = [];
        foreach ($penjualan as $row) {
            $idBarang = $row['IdBarang'];
            if (!isset($barangData[$idBarang])) {
                $barangData[$idBarang] = ['NamaBarang' => $row['NamaBarang'], 'Pendapatan' => 0, 'Biaya' => 0];
            }
            $barangData[$idBarang]['Pendapatan'] += $row['JumlahPenjualan'] * $row['HargaJual'];
        }

        foreach ($pembelian as $row) {
            $idBarang = $row['IdBarang'];
            if (!isset($barangData[$idBarang])) {
                $barangData[$idBarang] = ['NamaBarang' => $row['NamaBarang'], 'Pendapatan' => 0, 'Biaya' => 0];
            }
            $barangData[$idBarang]['Biaya'] += $row['JumlahPembelian'] * $row['HargaBeli'];
        }

        return $barangData;
    }
}
?>
