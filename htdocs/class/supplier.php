<?php
class Supplier {
    private $conn;
    private $table_name = "Supplier";

    // Properti supplier
    public $idSupplier;
    public $namaSupplier;
    public $alamatSupplier;
    public $noHpSupplier;

    // Konstruktor dengan $db sebagai koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua supplier
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY IdSupplier ASC";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    // Buat supplier baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET IdSupplier=?, NamaSupplier=?, AlamatSupplier=?, NoHpSupplier=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idSupplier = htmlspecialchars(strip_tags($this->idSupplier));
        $this->namaSupplier = htmlspecialchars(strip_tags($this->namaSupplier));
        $this->alamatSupplier = htmlspecialchars(strip_tags($this->alamatSupplier));
        $this->noHpSupplier = htmlspecialchars(strip_tags($this->noHpSupplier));

        // Mengikat parameter
        $stmt->bind_param("ssss", $this->idSupplier, $this->namaSupplier, $this->alamatSupplier, $this->noHpSupplier);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update supplier yang ada
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET NamaSupplier=?, AlamatSupplier=?, NoHpSupplier=? WHERE IdSupplier=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idSupplier = htmlspecialchars(strip_tags($this->idSupplier));
        $this->namaSupplier = htmlspecialchars(strip_tags($this->namaSupplier));
        $this->alamatSupplier = htmlspecialchars(strip_tags($this->alamatSupplier));
        $this->noHpSupplier = htmlspecialchars(strip_tags($this->noHpSupplier));

        // Mengikat parameter
        $stmt->bind_param("ssss", $this->namaSupplier, $this->alamatSupplier, $this->noHpSupplier, $this->idSupplier);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Hapus supplier
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE IdSupplier = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idSupplier = htmlspecialchars(strip_tags($this->idSupplier));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idSupplier);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ambil satu supplier berdasarkan IdSupplier
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE IdSupplier = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idSupplier = htmlspecialchars(strip_tags($this->idSupplier));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idSupplier);

        // Eksekusi query
        $stmt->execute();

        // Mendapatkan hasil
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mengatur nilai properti
            $this->idSupplier = $row['IdSupplier'];
            $this->namaSupplier = $row['NamaSupplier'];
            $this->alamatSupplier = $row['AlamatSupplier'];
            $this->noHpSupplier = $row['NoHpSupplier'];

            return true;
        }

        return false;
    }
}
?>
