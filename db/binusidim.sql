-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jul 2024 pada 00.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `binusidim`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `IdBarang` varchar(10) NOT NULL,
  `NamaBarang` varchar(255) NOT NULL,
  `Keterangan` text DEFAULT NULL,
  `Satuan` varchar(100) NOT NULL,
  `IdPengguna` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`IdBarang`, `NamaBarang`, `Keterangan`, `Satuan`, `IdPengguna`) VALUES
('BaasuR5', 'Asus ROG Phone 5', 'Smartphone Asus\r\n', 'Unit', 'Idpn05'),
('BagooP5', 'Google Pixel 5', 'Smartphone Google', 'Unit', 'Idpn07'),
('BahuaP40', 'Huawei P40', 'Smartphone Huawei', 'Unit', 'Idpn09'),
('Baiph12', 'iPhone 12', 'Smartphone Apple', 'Unit', 'Idpn03'),
('Baone9', 'OnePlus 9', 'Smartphone OnePlus', 'Unit', 'Idpn06'),
('BaoppX3', 'Oppo Find X3', 'Smartphone Oppo', 'Unit', 'Idpn04'),
('Basga21', 'Samsung Galaxy S21', 'Smartphone Samsung', 'Unit', 'Idpn02'),
('BasonX1', 'Sony Xperia 1', 'Smartphone Sony', 'Unit', 'Idpn08'),
('Baviv60', 'Vivo X60', 'Smartphone Vivo', 'Unit', 'Idpn05'),
('Baxia11', 'Xiaomi Mi 11', 'Smartphone Xiaomi', 'Unit', 'Idpn03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hakakses`
--

CREATE TABLE `hakakses` (
  `IdAkses` varchar(10) NOT NULL,
  `NamaAkses` varchar(50) NOT NULL,
  `Keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hakakses`
--

INSERT INTO `hakakses` (`IdAkses`, `NamaAkses`, `Keterangan`) VALUES
('AdmA1', 'Admin', 'Administrator full access'),
('GdgA1', 'Gudang', 'Akses untuk mengelola gudang'),
('HrdA1', 'HRD', 'Akses untuk HRD'),
('ITS1', 'IT Support', 'Akses untuk IT support'),
('KrwA1', 'Karyawan', 'Akses terbatas untuk karyawan'),
('KsrA1', 'Kasir', 'Akses untuk kasir'),
('MgrA1', 'Manager', 'Akses untuk manajer'),
('OptA1', 'Operator', 'Akses untuk operator'),
('SlsA1', 'Sales', 'Akses untuk sales'),
('SprA1', 'Supervisor', 'Akses untuk supervisor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `IdPelanggan` varchar(10) NOT NULL,
  `NamaPelanggan` varchar(255) NOT NULL,
  `AlamatPelanggan` varchar(255) DEFAULT NULL,
  `NoHpPelanggan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`IdPelanggan`, `NamaPelanggan`, `AlamatPelanggan`, `NoHpPelanggan`) VALUES
('PLG001', 'Rina Melati', 'Jl. Kenanga No.1, Surabaya', '081322233344'),
('PLG002', 'Siti Aminah', 'Jl. Melati No.2, Bandung', '081433344455'),
('PLG003', 'Tina Kartika', 'Jl. Kamboja No.3, Yogyakarta', '081544455566'),
('PLG004', 'Umar Zain', 'Jl. Mawar No.4, Semarang', '081655566677'),
('PLG005', 'Vina Kusuma', 'Jl. Anggrek No.5, Medan', '081766677788'),
('PLG006', 'Winda Puspita', 'Jl. Dahlia No.6, Malang', '081877788899'),
('PLG007', 'Xena Larasati', 'Jl. Teratai No.7, Denpasar', '081988899900'),
('PLG008', 'Yogi Pratama', 'Jl. Soka No.8, Palembang', '082199900011'),
('PLG009', 'Zara Dewi', 'Jl. Bougenville No.9, Makassar', '082210001122'),
('PLG010', 'Aldo Prasetyo', 'Jl. Flamboyan No.10, Padang', '082321112233'),
('PLG011', 'Bimo Susanto', 'Jl. Cemara No.11, Balikpapan', '082432223344'),
('PLG012', 'Cinta Hapsari', 'Jl. Bakung No.12, Samarinda', '082543334455'),
('PLG013', 'Dito Wicaksono', 'Jl. Melur No.13, Pekanbaru', '082654445566'),
('PLG014', 'Eka Setiawan', 'Jl. Dahlia No.14, Pontianak', '082765556677'),
('PLG015', 'Fajar Nugraha', 'Jl. Anyelir No.15, Banjarmasin', '082876667788'),
('PLG016', 'Gina Hartono', 'Jl. Tulip No.16, Mataram', '082987778899'),
('PLG017', 'Haris Pratama', 'Jl. Seruni No.17, Ambon', '083098889900'),
('PLG018', 'Indra Permana', 'Jl. Kembang No.18, Manado', '083209990011'),
('PLG019', 'Joko Purnomo', 'Jl. Teratai No.19, Jayapura', '083311001122'),
('PLG020', 'Kirana Dewi', 'Jl. Matahari No.20, Kupang', '083422112233');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `IdPembelian` varchar(10) NOT NULL,
  `JumlahPembelian` int(11) NOT NULL,
  `HargaBeli` decimal(10,2) NOT NULL,
  `IdPengguna` varchar(10) NOT NULL,
  `IdSupplier` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`IdPembelian`, `JumlahPembelian`, `HargaBeli`, `IdPengguna`, `IdSupplier`) VALUES
('PBN001', 21, 10000000.00, 'Idpn02', 'SPL020'),
('PBN002', 16, 1500000.00, 'Idpn01', 'SPL007'),
('PBN003', 24, 2000000.00, 'idpn02', 'SPL003'),
('PBN004', 20, 1200000.00, 'idpn03', 'SPL004'),
('PBN005', 23, 1300000.00, 'idpn04', 'SPL005'),
('PBN006', 18, 1700000.00, 'idpn05', 'SPL006'),
('PBN007', 10, 1600000.00, 'idpn01', 'SPL007'),
('PBN008', 15, 1000000.00, 'idpn02', 'SPL008'),
('PBN009', 20, 2000000.00, 'idpn03', 'SPL009'),
('PBN010', 12, 1500000.00, 'idpn04', 'SPL010'),
('PBN011', 18, 1100000.00, 'idpn05', 'SPL011'),
('PBN012', 22, 1200000.00, 'idpn06', 'SPL012'),
('PBN013', 17, 1300000.00, 'idpn07', 'SPL013'),
('PBN014', 25, 1400000.00, 'idpn08', 'SPL014'),
('PBN015', 19, 1100000.00, 'idpn09', 'SPL015');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `IdPengguna` varchar(10) NOT NULL,
  `NamaPengguna` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `NamaDepan` varchar(255) NOT NULL,
  `NamaBelakang` varchar(255) DEFAULT NULL,
  `NoHp` varchar(15) DEFAULT NULL,
  `Alamat` text DEFAULT NULL,
  `IdAkses` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`IdPengguna`, `NamaPengguna`, `Password`, `NamaDepan`, `NamaBelakang`, `NoHp`, `Alamat`, `IdAkses`) VALUES
('Idpn01', 'admin', 'Admin12345', 'Budi', 'Santoso', '081512345678', 'Jl. Merdeka No.1, Jakarta', 'AdmA1'),
('Idpn02', 'karyawan', 'Karyawan12345', 'Agus', 'Wibowo', '081212345679', 'Jl. Thamrin No.2, Jakarta', 'KrwA1'),
('Idpn03', 'gudang', 'Gudang12345', 'Dedi', 'Purnomo', '081312345680', 'Jl. Sudirman No.3, Jakarta', 'GdgA1'),
('Idpn04', 'kasir', 'Kasir12345', 'Eko', 'Prasetyo', '081412345681', 'Jl. Gatot Subroto No.4, Jakarta', 'KsrA1'),
('Idpn05', 'manager', 'Manager12345', 'Fajar', 'Sutrisno', '081512345682', 'Jl. Satrio No.5, Jakarta', 'MgrA1'),
('Idpn06', 'supervisor', 'Supervisor12345', 'Gilang', 'Saputra', '081612345683', 'Jl. Casablanca No.6, Jakarta', 'SprA1'),
('Idpn07', 'hrd', 'Hrd12345', 'Hadi', 'Kusuma', '081712345684', 'Jl. Rasuna Said No.7, Jakarta', 'HrdA1'),
('Idpn08', 'operator', 'Operator12345', 'Iwan', 'Wahyudi', '081812345685', 'Jl. Pramuka No.8, Jakarta', 'OptA1'),
('Idpn09', 'sales', 'Sales12345', 'Joko', 'Susanto', '081912345686', 'Jl. Daan Mogot No.9, Jakarta', 'SlsA1'),
('Idpn10', 'itsupport', 'Itsupport12345', 'Kiki', 'Hartono', '082012345687', 'Jl. Mangga Dua No.10, Jakarta', 'ITS1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `IdPenjualan` varchar(10) NOT NULL,
  `JumlahPenjualan` int(11) NOT NULL,
  `HargaJual` decimal(10,2) NOT NULL,
  `IdPengguna` varchar(10) NOT NULL,
  `IdPelanggan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`IdPenjualan`, `JumlahPenjualan`, `HargaJual`, `IdPengguna`, `IdPelanggan`) VALUES
('PJL001', 13, 11000000.00, 'Idpn05', 'PLG001'),
('PJL002', 11, 1500000.00, 'Idpn02', 'PLG002'),
('PJL003', 14, 1700000.00, 'idpn09', 'PLG003'),
('PJL004', 5, 2200000.00, 'Idpn08', 'PLG015'),
('PJL005', 4, 2150000.00, 'Idpn07', 'PLG005'),
('PJL006', 7, 2300000.00, 'Idpn04', 'PLG020'),
('PJL007', 8, 2350000.00, 'Idpn07', 'PLG017'),
('PJL008', 9, 2400000.00, 'idpn06', 'PLG008'),
('PJL009', 6, 2100000.00, 'Idpn06', 'PLG013'),
('PJL010', 7, 2150000.00, 'Idpn06', 'PLG014'),
('PJL011', 8, 2700000.00, 'Idpn08', 'PLG011'),
('PJL012', 6, 2650000.00, 'Idpn10', 'PLG016'),
('PJL013', 12, 2600000.00, 'idpn08', 'PLG013'),
('PJL014', 10, 2200000.00, 'idpn05', 'PLG014'),
('PJL015', 9, 2250000.00, 'idpn05', 'PLG015');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `IdSupplier` varchar(10) NOT NULL,
  `NamaSupplier` varchar(255) NOT NULL,
  `AlamatSupplier` varchar(255) DEFAULT NULL,
  `NoHpSupplier` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`IdSupplier`, `NamaSupplier`, `AlamatSupplier`, `NoHpSupplier`) VALUES
('SPL001', 'PT. Apple Indonesia ', 'Jl. Merdeka No.1, Jakarta', '081512345678'),
('SPL002', 'PT. Samsung Indonesia', 'Jl. Thamrin No.2, Jakarta', '081212345679'),
('SPL003', 'PT. Xiaomi Indonesia', 'Jl. Sudirman No.3, Jakarta', '081312345680'),
('SPL004', 'PT. Oppo Indonesia', 'Jl. Gatot Subroto No.4, Jakarta', '081412345681'),
('SPL005', 'PT. Vivo Indonesia', 'Jl. Satrio No.5, Jakarta', '081512345682'),
('SPL006', 'PT. OnePlus Indonesia', 'Jl. Casablanca No.6, Jakarta', '081612345683'),
('SPL007', 'PT. Google Indonesia', 'Jl. Rasuna Said No.7, Jakarta', '081712345684'),
('SPL008', 'PT. Sony Indonesia', 'Jl. Pramuka No.8, Jakarta', '081812345685'),
('SPL009', 'PT. Huawei Indonesia', 'Jl. Daan Mogot No.9, Jakarta', '081912345686'),
('SPL010', 'PT. Asus Indonesia', 'Jl. Mangga Dua No.10, Jakarta', '082012345687'),
('SPL011', 'PT. Realme Indonesia', 'Jl. Kemang No.11, Jakarta', '082112345688'),
('SPL012', 'PT. Lenovo Indonesia', 'Jl. Senayan No.12, Jakarta', '082212345689'),
('SPL013', 'PT. Nokia Indonesia', 'Jl. Cikini No.13, Jakarta', '082312345690'),
('SPL014', 'PT. Motorola Indonesia', 'Jl. Salemba No.14, Jakarta', '082412345691'),
('SPL015', 'PT. LG Indonesia', 'Jl. Blok M No.15, Jakarta', '082512345692'),
('SPL016', 'PT. Meizu Indonesia', 'Jl. Tebet No.16, Jakarta', '082612345693'),
('SPL017', 'PT. ZTE Indonesia', 'Jl. Gajah Mada No.17, Jakarta', '082712345694'),
('SPL018', 'PT. HTC Indonesia', 'Jl. Pancoran No.18, Jakarta', '082812345695'),
('SPL019', 'PT. Alcatel Indonesia', 'Jl. Pluit No.19, Jakarta', '082912345696'),
('SPL020', 'PT. Oppo Indonesia', 'Jl. Manggarai No.20, Jakarta', '083012345697');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`IdBarang`),
  ADD KEY `IdPengguna` (`IdPengguna`);

--
-- Indeks untuk tabel `hakakses`
--
ALTER TABLE `hakakses`
  ADD PRIMARY KEY (`IdAkses`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`IdPelanggan`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`IdPembelian`),
  ADD KEY `IdPengguna` (`IdPengguna`),
  ADD KEY `IdSupplier` (`IdSupplier`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`IdPengguna`),
  ADD KEY `IdAkses` (`IdAkses`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`IdPenjualan`),
  ADD KEY `IdPengguna` (`IdPengguna`),
  ADD KEY `IdPelanggan` (`IdPelanggan`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`IdSupplier`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`IdPengguna`) REFERENCES `pengguna` (`IdPengguna`);

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`IdPengguna`) REFERENCES `pengguna` (`IdPengguna`),
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`IdSupplier`) REFERENCES `supplier` (`IdSupplier`);

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`IdAkses`) REFERENCES `hakakses` (`IdAkses`);

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`IdPengguna`) REFERENCES `pengguna` (`IdPengguna`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`IdPelanggan`) REFERENCES `pelanggan` (`IdPelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
