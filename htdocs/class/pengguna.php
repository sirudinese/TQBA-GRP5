<?php
class Pengguna {
    private $conn;
    private $table_name = "Pengguna";

    // Properti pengguna
    public $idPengguna;
    public $namaPengguna;
    public $password;
    public $namaDepan;
    public $namaBelakang;
    public $noHp;
    public $alamat;
    public $idAkses;

    // Konstruktor dengan $db sebagai koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua pengguna
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY IdPengguna ASC";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    // Buat pengguna baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET IdPengguna=?, NamaPengguna=?, Password=?, NamaDepan=?, NamaBelakang=?, NoHp=?, Alamat=?, IdAkses=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));
        $this->namaPengguna = htmlspecialchars(strip_tags($this->namaPengguna));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->namaDepan = htmlspecialchars(strip_tags($this->namaDepan));
        $this->namaBelakang = htmlspecialchars(strip_tags($this->namaBelakang));
        $this->noHp = htmlspecialchars(strip_tags($this->noHp));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->idAkses = htmlspecialchars(strip_tags($this->idAkses));

        // Mengikat parameter
        $stmt->bind_param("ssssssss", $this->idPengguna, $this->namaPengguna, $this->password, $this->namaDepan, $this->namaBelakang, $this->noHp, $this->alamat, $this->idAkses);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update pengguna yang ada
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET NamaPengguna=?, Password=?, NamaDepan=?, NamaBelakang=?, NoHp=?, Alamat=?, IdAkses=? WHERE IdPengguna=?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));
        $this->namaPengguna = htmlspecialchars(strip_tags($this->namaPengguna));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->namaDepan = htmlspecialchars(strip_tags($this->namaDepan));
        $this->namaBelakang = htmlspecialchars(strip_tags($this->namaBelakang));
        $this->noHp = htmlspecialchars(strip_tags($this->noHp));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->idAkses = htmlspecialchars(strip_tags($this->idAkses));

        // Mengikat parameter
        $stmt->bind_param("ssssssss", $this->namaPengguna, $this->password, $this->namaDepan, $this->namaBelakang, $this->noHp, $this->alamat, $this->idAkses, $this->idPengguna);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Hapus pengguna
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE IdPengguna = ?";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPengguna);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ambil satu pengguna berdasarkan IdPengguna
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE IdPengguna = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data
        $this->idPengguna = htmlspecialchars(strip_tags($this->idPengguna));

        // Mengikat parameter
        $stmt->bind_param("s", $this->idPengguna);

        // Eksekusi query
        $stmt->execute();

        // Mendapatkan hasil
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mengatur nilai properti
            $this->idPengguna = $row['IdPengguna'];
            $this->namaPengguna = $row['NamaPengguna'];
            $this->password = $row['Password'];
            $this->namaDepan = $row['NamaDepan'];
            $this->namaBelakang = $row['NamaBelakang'];
            $this->noHp = $row['NoHp'];
            $this->alamat = $row['Alamat'];
            $this->idAkses = $row['IdAkses'];

            return true;
        }

        return false;
    }
}
?>
