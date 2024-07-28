<?php
class Penjualan {
    private $conn;
    private $table_name = "Penjualan";

    // Properti penjualan
    public $idPenjualan;
    public $jumlahPenjualan;
    public $hargaJual;
    public $idPengguna;
    public $idPelanggan;

    // Konstruktor dengan $db sebagai koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua penjualan
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY IdPenjualan ASC";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    // Buat penjualan baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET IdPenjualan=?, JumlahPenjualan=?, HargaJual=?, IdPengguna=?, IdPelanggan=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPenjualan = htmlspecialchars(strip_tags($this->idPenjualan));
        $this->jumlahPenjualan = htmlspecialchars(strip_tags($this->jumlahPenjualan));
        $this->hargaJual = htmlspecialchars(strip_tags($this->hargaJual));
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));
        $this->idPelanggan = htmlspecialchars(strip_tags($this->idPelanggan));

        // Mengikat parameter
        $stmt->bind_param("sssss", $this->idPenjualan, $this->jumlahPenjualan, $this->hargaJual, $this->idPengguna, $this->idPelanggan);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update penjualan yang ada
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET JumlahPenjualan=?, HargaJual=?, IdPengguna=?, IdPelanggan=? WHERE IdPenjualan=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPenjualan = htmlspecialchars(strip_tags($this->idPenjualan));
        $this->jumlahPenjualan = htmlspecialchars(strip_tags($this->jumlahPenjualan));
        $this->hargaJual = htmlspecialchars(strip_tags($this->hargaJual));
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));
        $this->idPelanggan = htmlspecialchars(strip_tags($this->idPelanggan));

        // Mengikat parameter
        $stmt->bind_param("sssss", $this->jumlahPenjualan, $this->hargaJual, $this->idPengguna, $this->idPelanggan, $this->idPenjualan);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Hapus penjualan
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE IdPenjualan = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPenjualan = htmlspecialchars(strip_tags($this->idPenjualan));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPenjualan);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ambil satu penjualan berdasarkan IdPenjualan
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE IdPenjualan = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPenjualan = htmlspecialchars(strip_tags($this->idPenjualan));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPenjualan);

        // Eksekusi query
        $stmt->execute();

        // Mendapatkan hasil
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mengatur nilai properti
            $this->idPenjualan = $row['IdPenjualan'];
            $this->jumlahPenjualan = $row['JumlahPenjualan'];
            $this->hargaJual = $row['HargaJual'];
            $this->idPengguna = $row['IdPengguna'];
            $this->idPelanggan = $row['IdPelanggan'];

            return true;
        }

        return false;
    }
}
?>
