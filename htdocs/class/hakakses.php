<?php
class HakAkses {
    private $conn;
    private $table_name = "HakAkses";

    // Properti hak akses
    public $idAkses;
    public $namaAkses;
    public $keterangan;

    // Konstruktor dengan $db sebagai koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua hak akses
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY IdAkses ASC";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    // Buat hak akses baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET IdAkses=?, NamaAkses=?, Keterangan=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idAkses = htmlspecialchars(strip_tags($this->idAkses));
        $this->namaAkses = htmlspecialchars(strip_tags($this->namaAkses));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));

        // Mengikat parameter
        $stmt->bind_param("sss", $this->idAkses, $this->namaAkses, $this->keterangan);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update hak akses yang ada
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET NamaAkses=?, Keterangan=? WHERE IdAkses=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idAkses = htmlspecialchars(strip_tags($this->idAkses));
        $this->namaAkses = htmlspecialchars(strip_tags($this->namaAkses));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));

        // Mengikat parameter
        $stmt->bind_param("sss", $this->namaAkses, $this->keterangan, $this->idAkses);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Hapus hak akses
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE IdAkses = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idAkses = htmlspecialchars(strip_tags($this->idAkses));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idAkses);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ambil satu hak akses berdasarkan IdAkses
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE IdAkses = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idAkses = htmlspecialchars(strip_tags($this->idAkses));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idAkses);

        // Eksekusi query
        $stmt->execute();

        // Mendapatkan hasil
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mengatur nilai properti
            $this->idAkses = $row['IdAkses'];
            $this->namaAkses = $row['NamaAkses'];
            $this->keterangan = $row['Keterangan'];

            return true;
        }

        return false;
    }
}
?>
