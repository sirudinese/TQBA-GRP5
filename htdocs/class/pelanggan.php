<?php
class Pelanggan {
    private $conn;
    private $table_name = "Pelanggan";

    // Properti pelanggan
    public $idPelanggan;
    public $namaPelanggan;
    public $alamatPelanggan;
    public $noHpPelanggan;

    // Konstruktor dengan $db sebagai koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua pelanggan
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY IdPelanggan ASC";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    // Buat pelanggan baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET IdPelanggan=?, NamaPelanggan=?, AlamatPelanggan=?, NoHpPelanggan=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPelanggan = htmlspecialchars(strip_tags($this->idPelanggan));
        $this->namaPelanggan = htmlspecialchars(strip_tags($this->namaPelanggan));
        $this->alamatPelanggan = htmlspecialchars(strip_tags($this->alamatPelanggan));
        $this->noHpPelanggan = htmlspecialchars(strip_tags($this->noHpPelanggan));

        // Mengikat parameter
        $stmt->bind_param("ssss", $this->idPelanggan, $this->namaPelanggan, $this->alamatPelanggan, $this->noHpPelanggan);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update pelanggan yang ada
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET NamaPelanggan=?, AlamatPelanggan=?, NoHpPelanggan=? WHERE IdPelanggan=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPelanggan = htmlspecialchars(strip_tags($this->idPelanggan));
        $this->namaPelanggan = htmlspecialchars(strip_tags($this->namaPelanggan));
        $this->alamatPelanggan = htmlspecialchars(strip_tags($this->alamatPelanggan));
        $this->noHpPelanggan = htmlspecialchars(strip_tags($this->noHpPelanggan));

        // Mengikat parameter
        $stmt->bind_param("ssss", $this->namaPelanggan, $this->alamatPelanggan, $this->noHpPelanggan, $this->idPelanggan);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Hapus pelanggan
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE IdPelanggan = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPelanggan = htmlspecialchars(strip_tags($this->idPelanggan));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPelanggan);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ambil satu pelanggan berdasarkan IdPelanggan
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE IdPelanggan = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPelanggan = htmlspecialchars(strip_tags($this->idPelanggan));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPelanggan);

        // Eksekusi query
        $stmt->execute();

        // Mendapatkan hasil
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mengatur nilai properti
            $this->namaPelanggan = $row['NamaPelanggan'];
            $this->alamatPelanggan = $row['AlamatPelanggan'];
            $this->noHpPelanggan = $row['NoHpPelanggan'];

            return true;
        }

        return false;
    }
}
?>
