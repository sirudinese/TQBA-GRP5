<?php
class Pembelian {
    private $conn;
    private $table_name = "Pembelian";

    // Properti pembelian
    public $idPembelian;
    public $jumlahPembelian;
    public $hargaBeli;
    public $idPengguna;
    public $idSupplier;

    // Konstruktor dengan $db sebagai koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua pembelian
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY IdPembelian ASC";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    // Buat pembelian baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET IdPembelian=?, JumlahPembelian=?, HargaBeli=?, IdPengguna=?, IdSupplier=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPembelian = htmlspecialchars(strip_tags($this->idPembelian));
        $this->jumlahPembelian = htmlspecialchars(strip_tags($this->jumlahPembelian));
        $this->hargaBeli = htmlspecialchars(strip_tags($this->hargaBeli));
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));
        $this->idSupplier = htmlspecialchars(strip_tags($this->idSupplier));

        // Mengikat parameter
        $stmt->bind_param("sssss", $this->idPembelian, $this->jumlahPembelian, $this->hargaBeli, $this->idPengguna, $this->idSupplier);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update pembelian yang ada
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET JumlahPembelian=?, HargaBeli=?, IdPengguna=?, IdSupplier=? WHERE IdPembelian=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPembelian = htmlspecialchars(strip_tags($this->idPembelian));
        $this->jumlahPembelian = htmlspecialchars(strip_tags($this->jumlahPembelian));
        $this->hargaBeli = htmlspecialchars(strip_tags($this->hargaBeli));
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));
        $this->idSupplier = htmlspecialchars(strip_tags($this->idSupplier));

        // Mengikat parameter
        $stmt->bind_param("sssss", $this->jumlahPembelian, $this->hargaBeli, $this->idPengguna, $this->idSupplier, $this->idPembelian);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Hapus pembelian
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE IdPembelian = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPembelian = htmlspecialchars(strip_tags($this->idPembelian));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPembelian);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ambil satu pembelian berdasarkan IdPembelian
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE IdPembelian = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPembelian = htmlspecialchars(strip_tags($this->idPembelian));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPembelian);

        // Eksekusi query
        $stmt->execute();

        // Mendapatkan hasil
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mengatur nilai properti
            $this->idPembelian = $row['IdPembelian'];
            $this->jumlahPembelian = $row['JumlahPembelian'];
            $this->hargaBeli = $row['HargaBeli'];
            $this->idPengguna = $row['IdPengguna'];
            $this->idSupplier = $row['IdSupplier'];

            return true;
        }

        return false;
    }
}
?>
