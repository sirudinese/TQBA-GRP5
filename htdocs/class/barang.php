<?php
class Barang {
    private $conn;
    private $table_name = "Barang";

    // Properti barang
    public $idBarang;
    public $namaBarang;
    public $keterangan;
    public $satuan;
    public $idPengguna;

    // Konstruktor dengan $db sebagai koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Metode untuk membuat barang baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (IdBarang, NamaBarang, Keterangan, Satuan, IdPengguna) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idBarang = htmlspecialchars(strip_tags($this->idBarang));
        $this->namaBarang = htmlspecialchars(strip_tags($this->namaBarang));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));
        $this->satuan = htmlspecialchars(strip_tags($this->satuan));
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));

        // Mengikat parameter
        $stmt->bind_param("sssss", $this->idBarang, $this->namaBarang, $this->keterangan, $this->satuan, $this->idPengguna);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Metode untuk mengambil semua barang
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->query($query);
        return $result;
    }

    // Metode untuk mengambil satu barang berdasarkan idBarang
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE IdBarang = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idBarang = htmlspecialchars(strip_tags($this->idBarang));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idBarang);

        // Eksekusi query
        $stmt->execute();
        $result = $stmt->get_result();

        // Mendapatkan baris hasil
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Menetapkan nilai properti
            $this->namaBarang = $row['NamaBarang'];
            $this->keterangan = $row['Keterangan'];
            $this->satuan = $row['Satuan'];
            $this->idPengguna = $row['IdPengguna'];

            return true;
        }

        return false;
    }

    // Metode untuk memperbarui data barang
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET NamaBarang = ?, Keterangan = ?, Satuan = ?, IdPengguna = ? WHERE IdBarang = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idBarang = htmlspecialchars(strip_tags($this->idBarang));
        $this->namaBarang = htmlspecialchars(strip_tags($this->namaBarang));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));
        $this->satuan = htmlspecialchars(strip_tags($this->satuan));
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));

        // Mengikat parameter
        $stmt->bind_param("sssss", $this->namaBarang, $this->keterangan, $this->satuan, $this->idPengguna, $this->idBarang);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Metode untuk menghapus barang berdasarkan idBarang
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE IdBarang = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idBarang = htmlspecialchars(strip_tags($this->idBarang));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idBarang);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
