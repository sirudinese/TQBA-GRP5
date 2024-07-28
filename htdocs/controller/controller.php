<?php
require_once '../database.php';
require_once '../barang.php';
require_once '../dashboard.php';
require_once '../hakakses.php';
require_once '../pelanggan.php';
require_once '../pembelian.php';
require_once '../pengguna.php';
require_once '../penjualan.php';
require_once '../supplier.php';

// Membuat instance dari koneksi database
$database = new Database();
$db = $database->getConnection();

// Menentukan jenis request dan aksi yang diminta
$requestMethod = $_SERVER["REQUEST_METHOD"];
$entity = $_GET['entity'];
$action = $_GET['action'];

// Memproses request berdasarkan entitas dan aksi
switch ($entity) {
    case 'barang':
        $barang = new Barang($db);
        switch ($action) {
            case 'create':
                $barang->idBarang = $_POST['idBarang'];
                $barang->namaBarang = $_POST['namaBarang'];
                $barang->keterangan = $_POST['keterangan'];
                $barang->satuan = $_POST['satuan'];
                $barang->idPengguna = $_POST['idPengguna'];
                if($barang->create()) {
                    echo json_encode(["message" => "Barang berhasil ditambahkan."]);
                } else {
                    echo json_encode(["message" => "Barang gagal ditambahkan."]);
                }
                break;
            case 'read':
                $result = $barang->read();
                $barangList = [];
                while ($row = $result->fetch_assoc()) {
                    $barangList[] = $row;
                }
                echo json_encode($barangList);
                break;
            case 'readOne':
                $barang->idBarang = $_GET['idBarang'];
                if($barang->readOne()) {
                    echo json_encode($barang);
                } else {
                    echo json_encode(["message" => "Barang tidak ditemukan."]);
                }
                break;
            case 'update':
                $barang->idBarang = $_POST['idBarang'];
                $barang->namaBarang = $_POST['namaBarang'];
                $barang->keterangan = $_POST['keterangan'];
                $barang->satuan = $_POST['satuan'];
                $barang->idPengguna = $_POST['idPengguna'];
                if($barang->update()) {
                    echo json_encode(["message" => "Barang berhasil diperbarui."]);
                } else {
                    echo json_encode(["message" => "Barang gagal diperbarui."]);
                }
                break;
            case 'delete':
                $barang->idBarang = $_GET['idBarang'];
                if($barang->delete()) {
                    echo json_encode(["message" => "Barang berhasil dihapus."]);
                } else {
                    echo json_encode(["message" => "Barang gagal dihapus."]);
                }
                break;
        }
        break;
    
    case 'dashboard':
        $dashboard = new Dashboard($db);
        switch ($action) {
            case 'getNamaAkses':
                echo json_encode($dashboard->getNamaAkses($_GET['idAkses']));
                break;
            case 'getTotalPesanan':
                echo json_encode($dashboard->getTotalPesanan());
                break;
            case 'getTotalPemasukan':
                echo json_encode($dashboard->getTotalPemasukan());
                break;
            case 'getTotalPelanggan':
                echo json_encode($dashboard->getTotalPelanggan());
                break;
            case 'getPenjualan':
                echo json_encode($dashboard->getPenjualan());
                break;
            case 'getPembelian':
                echo json_encode($dashboard->getPembelian());
                break;
            case 'getLabaRugi':
                echo json_encode($dashboard->getLabaRugi());
                break;
        }
        break;

    case 'hakakses':
        $hakAkses = new HakAkses($db);
        switch ($action) {
            case 'create':
                $hakAkses->idAkses = $_POST['idAkses'];
                $hakAkses->namaAkses = $_POST['namaAkses'];
                $hakAkses->keterangan = $_POST['keterangan'];
                if($hakAkses->create()) {
                    echo json_encode(["message" => "Hak akses berhasil ditambahkan."]);
                } else {
                    echo json_encode(["message" => "Hak akses gagal ditambahkan."]);
                }
                break;
            case 'read':
                $result = $hakAkses->read();
                $hakAksesList = [];
                while ($row = $result->fetch_assoc()) {
                    $hakAksesList[] = $row;
                }
                echo json_encode($hakAksesList);
                break;
            case 'readOne':
                $hakAkses->idAkses = $_GET['idAkses'];
                if($hakAkses->readOne()) {
                    echo json_encode($hakAkses);
                } else {
                    echo json_encode(["message" => "Hak akses tidak ditemukan."]);
                }
                break;
            case 'update':
                $hakAkses->idAkses = $_POST['idAkses'];
                $hakAkses->namaAkses = $_POST['namaAkses'];
                $hakAkses->keterangan = $_POST['keterangan'];
                if($hakAkses->update()) {
                    echo json_encode(["message" => "Hak akses berhasil diperbarui."]);
                } else {
                    echo json_encode(["message" => "Hak akses gagal diperbarui."]);
                }
                break;
            case 'delete':
                $hakAkses->idAkses = $_GET['idAkses'];
                if($hakAkses->delete()) {
                    echo json_encode(["message" => "Hak akses berhasil dihapus."]);
                } else {
                    echo json_encode(["message" => "Hak akses gagal dihapus."]);
                }
                break;
        }
        break;

    case 'pelanggan':
        $pelanggan = new Pelanggan($db);
        switch ($action) {
            case 'create':
                $pelanggan->idPelanggan = $_POST['idPelanggan'];
                $pelanggan->namaPelanggan = $_POST['namaPelanggan'];
                $pelanggan->alamatPelanggan = $_POST['alamatPelanggan'];
                $pelanggan->noHpPelanggan = $_POST['noHpPelanggan'];
                if($pelanggan->create()) {
                    echo json_encode(["message" => "Pelanggan berhasil ditambahkan."]);
                } else {
                    echo json_encode(["message" => "Pelanggan gagal ditambahkan."]);
                }
                break;
            case 'read':
                $result = $pelanggan->read();
                $pelangganList = [];
                while ($row = $result->fetch_assoc()) {
                    $pelangganList[] = $row;
                }
                echo json_encode($pelangganList);
                break;
            case 'readOne':
                $pelanggan->idPelanggan = $_GET['idPelanggan'];
                if($pelanggan->readOne()) {
                    echo json_encode($pelanggan);
                } else {
                    echo json_encode(["message" => "Pelanggan tidak ditemukan."]);
                }
                break;
            case 'update':
                $pelanggan->idPelanggan = $_POST['idPelanggan'];
                $pelanggan->namaPelanggan = $_POST['namaPelanggan'];
                $pelanggan->alamatPelanggan = $_POST['alamatPelanggan'];
                $pelanggan->noHpPelanggan = $_POST['noHpPelanggan'];
                if($pelanggan->update()) {
                    echo json_encode(["message" => "Pelanggan berhasil diperbarui."]);
                } else {
                    echo json_encode(["message" => "Pelanggan gagal diperbarui."]);
                }
                break;
            case 'delete':
                $pelanggan->idPelanggan = $_GET['idPelanggan'];
                if($pelanggan->delete()) {
                    echo json_encode(["message" => "Pelanggan berhasil dihapus."]);
                } else {
                    echo json_encode(["message" => "Pelanggan gagal dihapus."]);
                }
                break;
        }
        break;

    case 'pembelian':
        $pembelian = new Pembelian($db);
        switch ($action) {
            case 'create':
                $pembelian->idPembelian = $_POST['idPembelian'];
                $pembelian->jumlahPembelian = $_POST['jumlahPembelian'];
                $pembelian->hargaBeli = $_POST['hargaBeli'];
                $pembelian->idPengguna = $_POST['idPengguna'];
                $pembelian->idSupplier = $_POST['idSupplier'];
                if($pembelian->create()) {
                    echo json_encode(["message" => "Pembelian berhasil ditambahkan."]);
                } else {
                    echo json_encode(["message" => "Pembelian gagal ditambahkan."]);
                }
                break;
            case 'read':
                $result = $pembelian->read();
                $pembelianList = [];
                while ($row = $result->fetch_assoc()) {
                    $pembelianList[] = $row;
                }
                echo json_encode($pembelianList);
                break;
            case 'readOne':
                $pembelian->idPembelian = $_GET['idPembelian'];
                if($pembelian->readOne()) {
                    echo json_encode($pembelian);
                } else {
                    echo json_encode(["message" => "Pembelian tidak ditemukan."]);
                }
                break;
            case 'update':
                $pembelian->idPembelian = $_POST['idPembelian'];
                $pembelian->jumlahPembelian = $_POST['jumlahPembelian'];
                $pembelian->hargaBeli = $_POST['hargaBeli'];
                $pembelian->idPengguna = $_POST['idPengguna'];
                $pembelian->idSupplier = $_POST['idSupplier'];
                if($pembelian->update()) {
                    echo json_encode(["message" => "Pembelian berhasil diperbarui."]);
                } else {
                    echo json_encode(["message" => "Pembelian gagal diperbarui."]);
                }
                break;
            case 'delete':
                $pembelian->idPembelian = $_GET['idPembelian'];
                if($pembelian->delete()) {
                    echo json_encode(["message" => "Pembelian berhasil dihapus."]);
                } else {
                    echo json_encode(["message" => "Pembelian gagal dihapus."]);
                }
                break;
        }
        break;

    case 'pengguna':
        $pengguna = new Pengguna($db);
        switch ($action) {
            case 'create':
                $pengguna->idPengguna = $_POST['idPengguna'];
                $pengguna->namaPengguna = $_POST['namaPengguna'];
                $pengguna->password = $_POST['password'];
                $pengguna->namaDepan = $_POST['namaDepan'];
                $pengguna->namaBelakang = $_POST['namaBelakang'];
                $pengguna->noHp = $_POST['noHp'];
                $pengguna->alamat = $_POST['alamat'];
                $pengguna->idAkses = $_POST['idAkses'];
                if($pengguna->create()) {
                    echo json_encode(["message" => "Pengguna berhasil ditambahkan."]);
                } else {
                    echo json_encode(["message" => "Pengguna gagal ditambahkan."]);
                }
                break;
            case 'read':
                $result = $pengguna->read();
                $penggunaList = [];
                while ($row = $result->fetch_assoc()) {
                    $penggunaList[] = $row;
                }
                echo json_encode($penggunaList);
                break;
            case 'readOne':
                $pengguna->idPengguna = $_GET['idPengguna'];
                if($pengguna->readOne()) {
                    echo json_encode($pengguna);
                } else {
                    echo json_encode(["message" => "Pengguna tidak ditemukan."]);
                }
                break;
            case 'update':
                $pengguna->idPengguna = $_POST['idPengguna'];
                $pengguna->namaPengguna = $_POST['namaPengguna'];
                $pengguna->password = $_POST['password'];
                $pengguna->namaDepan = $_POST['namaDepan'];
                $pengguna->namaBelakang = $_POST['namaBelakang'];
                $pengguna->noHp = $_POST['noHp'];
                $pengguna->alamat = $_POST['alamat'];
                $pengguna->idAkses = $_POST['idAkses'];
                if($pengguna->update()) {
                    echo json_encode(["message" => "Pengguna berhasil diperbarui."]);
                } else {
                    echo json_encode(["message" => "Pengguna gagal diperbarui."]);
                }
                break;
            case 'delete':
                $pengguna->idPengguna = $_GET['idPengguna'];
                if($pengguna->delete()) {
                    echo json_encode(["message" => "Pengguna berhasil dihapus."]);
                } else {
                    echo json_encode(["message" => "Pengguna gagal dihapus."]);
                }
                break;
        }
        break;

    case 'penjualan':
        $penjualan = new Penjualan($db);
        switch ($action) {
            case 'create':
                $penjualan->idPenjualan = $_POST['idPenjualan'];
                $penjualan->jumlahPenjualan = $_POST['jumlahPenjualan'];
                $penjualan->hargaJual = $_POST['hargaJual'];
                $penjualan->idPengguna = $_POST['idPengguna'];
                $penjualan->idPelanggan = $_POST['idPelanggan'];
                if($penjualan->create()) {
                    echo json_encode(["message" => "Penjualan berhasil ditambahkan."]);
                } else {
                    echo json_encode(["message" => "Penjualan gagal ditambahkan."]);
                }
                break;
            case 'read':
                $result = $penjualan->read();
                $penjualanList = [];
                while ($row = $result->fetch_assoc()) {
                    $penjualanList[] = $row;
                }
                echo json_encode($penjualanList);
                break;
            case 'readOne':
                $penjualan->idPenjualan = $_GET['idPenjualan'];
                if($penjualan->readOne()) {
                    echo json_encode($penjualan);
                } else {
                    echo json_encode(["message" => "Penjualan tidak ditemukan."]);
                }
                break;
            case 'update':
                $penjualan->idPenjualan = $_POST['idPenjualan'];
                $penjualan->jumlahPenjualan = $_POST['jumlahPenjualan'];
                $penjualan->hargaJual = $_POST['hargaJual'];
                $penjualan->idPengguna = $_POST['idPengguna'];
                $penjualan->idPelanggan = $_POST['idPelanggan'];
                if($penjualan->update()) {
                    echo json_encode(["message" => "Penjualan berhasil diperbarui."]);
                } else {
                    echo json_encode(["message" => "Penjualan gagal diperbarui."]);
                }
                break;
            case 'delete':
                $penjualan->idPenjualan = $_GET['idPenjualan'];
                if($penjualan->delete()) {
                    echo json_encode(["message" => "Penjualan berhasil dihapus."]);
                } else {
                    echo json_encode(["message" => "Penjualan gagal dihapus."]);
                }
                break;
        }
        break;

    case 'supplier':
        $supplier = new Supplier($db);
        switch ($action) {
            case 'create':
                $supplier->idSupplier = $_POST['idSupplier'];
                $supplier->namaSupplier = $_POST['namaSupplier'];
                $supplier->alamatSupplier = $_POST['alamatSupplier'];
                $supplier->noHpSupplier = $_POST['noHpSupplier'];
                if($supplier->create()) {
                    echo json_encode(["message" => "Supplier berhasil ditambahkan."]);
                } else {
                    echo json_encode(["message" => "Supplier gagal ditambahkan."]);
                }
                break;
            case 'read':
                $result = $supplier->read();
                $supplierList = [];
                while ($row = $result->fetch_assoc()) {
                    $supplierList[] = $row;
                }
                echo json_encode($supplierList);
                break;
            case 'readOne':
                $supplier->idSupplier = $_GET['idSupplier'];
                if($supplier->readOne()) {
                    echo json_encode($supplier);
                } else {
                    echo json_encode(["message" => "Supplier tidak ditemukan."]);
                }
                break;
            case 'update':
                $supplier->idSupplier = $_POST['idSupplier'];
                $supplier->namaSupplier = $_POST['namaSupplier'];
                $supplier->alamatSupplier = $_POST['alamatSupplier'];
                $supplier->noHpSupplier = $_POST['noHpSupplier'];
                if($supplier->update()) {
                    echo json_encode(["message" => "Supplier berhasil diperbarui."]);
                } else {
                    echo json_encode(["message" => "Supplier gagal diperbarui."]);
                }
                break;
            case 'delete':
                $supplier->idSupplier = $_GET['idSupplier'];
                if($supplier->delete()) {
                    echo json_encode(["message" => "Supplier berhasil dihapus."]);
                } else {
                    echo json_encode(["message" => "Supplier gagal dihapus."]);
                }
                break;
        }
        break;
}
?>
