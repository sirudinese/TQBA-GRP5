-- Membuat tabel HakAkses
CREATE TABLE HakAkses (
    IdAkses VARCHAR(10) NOT NULL PRIMARY KEY,
    NamaAkses VARCHAR(50) NOT NULL,
    Keterangan TEXT
);

-- Membuat tabel Pengguna
CREATE TABLE Pengguna (
    IdPengguna VARCHAR(10) NOT NULL PRIMARY KEY,
    NamaPengguna VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    NamaDepan VARCHAR(255) NOT NULL,
    NamaBelakang VARCHAR(255),
    NoHp VARCHAR(15),
    Alamat TEXT,
    IdAkses VARCHAR(10) NOT NULL,
    FOREIGN KEY (IdAkses) REFERENCES HakAkses(IdAkses)
);

-- Membuat tabel Barang
CREATE TABLE Barang (
    IdBarang VARCHAR(10) NOT NULL PRIMARY KEY,
    NamaBarang VARCHAR(255) NOT NULL,
    Keterangan TEXT,
    Satuan VARCHAR(100) NOT NULL,
    IdPengguna VARCHAR(10) NOT NULL,
    FOREIGN KEY (IdPengguna) REFERENCES Pengguna(IdPengguna)
);

-- Membuat tabel Supplier
CREATE TABLE Supplier (
    IdSupplier VARCHAR(10) NOT NULL PRIMARY KEY,
    NamaSupplier VARCHAR(255) NOT NULL,
    AlamatSupplier VARCHAR(255),
    NoHpSupplier VARCHAR(20)
);

-- Membuat tabel Pelanggan
CREATE TABLE Pelanggan (
    IdPelanggan VARCHAR(10) NOT NULL PRIMARY KEY,
    NamaPelanggan VARCHAR(255) NOT NULL,
    AlamatPelanggan VARCHAR(255),
    NoHpPelanggan VARCHAR(20)
);

-- Membuat tabel Pembelian
CREATE TABLE Pembelian (
    IdPembelian VARCHAR(10) NOT NULL PRIMARY KEY,
    JumlahPembelian INT NOT NULL,
    HargaBeli DECIMAL(10, 2) NOT NULL,
    IdPengguna VARCHAR(10) NOT NULL,
    IdSupplier VARCHAR(10) NOT NULL,
    FOREIGN KEY (IdPengguna) REFERENCES Pengguna(IdPengguna),
    FOREIGN KEY (IdSupplier) REFERENCES Supplier(IdSupplier)
);

-- Membuat tabel Penjualan
CREATE TABLE Penjualan (
    IdPenjualan VARCHAR(10) NOT NULL PRIMARY KEY,
    JumlahPenjualan INT NOT NULL,
    HargaJual DECIMAL(10, 2) NOT NULL,
    IdPengguna VARCHAR(10) NOT NULL,
    IdPelanggan VARCHAR(10) NOT NULL,
    FOREIGN KEY (IdPengguna) REFERENCES Pengguna(IdPengguna),
    FOREIGN KEY (IdPelanggan) REFERENCES Pelanggan(IdPelanggan)
);

-- Menambahkan Data ke Tabel HakAkses
INSERT INTO HakAkses (IdAkses, NamaAkses, Keterangan) VALUES 
('AdmA1', 'Admin', 'Administrator full access'),
('KrwA1', 'Karyawan', 'Akses terbatas untuk karyawan'),
('GdgA1', 'Gudang', 'Akses untuk mengelola gudang'),
('KsrA1', 'Kasir', 'Akses untuk kasir'),
('MgrA1', 'Manager', 'Akses untuk manajer'),
('SprA1', 'Supervisor', 'Akses untuk supervisor'),
('HrdA1', 'HRD', 'Akses untuk HRD'),
('OptA1', 'Operator', 'Akses untuk operator'),
('SlsA1', 'Sales', 'Akses untuk sales'),
('ITS1', 'IT Support', 'Akses untuk IT support');

-- Menambahkan Data ke Tabel Pengguna
INSERT INTO Pengguna (IdPengguna, NamaPengguna, Password, NamaDepan, NamaBelakang, NoHp, Alamat, IdAkses) VALUES 
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

-- Menambahkan Data ke Tabel Barang
INSERT INTO Barang (IdBarang, NamaBarang, Keterangan, Satuan, IdPengguna) VALUES 
('Baiph12', 'iPhone 12', 'Smartphone Apple', 'Unit', 'Idpn01'),
('Basga21', 'Samsung Galaxy S21', 'Smartphone Samsung', 'Unit', 'Idpn02'),
('Baxia11', 'Xiaomi Mi 11', 'Smartphone Xiaomi', 'Unit', 'Idpn03'),
('BaoppX3', 'Oppo Find X3', 'Smartphone Oppo', 'Unit', 'Idpn04'),
('Baviv60', 'Vivo X60', 'Smartphone Vivo', 'Unit', 'Idpn05'),
('Baone9', 'OnePlus 9', 'Smartphone OnePlus', 'Unit', 'Idpn06'),
('BagooP5', 'Google Pixel 5', 'Smartphone Google', 'Unit', 'Idpn07'),
('BasonX1', 'Sony Xperia 1', 'Smartphone Sony', 'Unit', 'Idpn08'),
('BahuaP40', 'Huawei P40', 'Smartphone Huawei', 'Unit', 'Idpn09'),
('BaasuR5', 'Asus ROG Phone 5', 'Smartphone Asus', 'Unit', 'Idpn10');

-- Menambahkan Data ke Tabel Supplier
INSERT INTO Supplier (IdSupplier, NamaSupplier, AlamatSupplier, NoHpSupplier) VALUES 
('SPLiph12', 'PT. Apple Indonesia', 'Jl. Merdeka No.1, Jakarta', '081512345678'),
('SPLsg21', 'PT. Samsung Indonesia', 'Jl. Thamrin No.2, Jakarta', '081212345679'),
('SPLxia11', 'PT. Xiaomi Indonesia', 'Jl. Sudirman No.3, Jakarta', '081312345680'),
('SPLoppX3', 'PT. Oppo Indonesia', 'Jl. Gatot Subroto No.4, Jakarta', '081412345681'),
('SPLviv60', 'PT. Vivo Indonesia', 'Jl. Satrio No.5, Jakarta', '081512345682'),
('SPLone9', 'PT. OnePlus Indonesia', 'Jl. Casablanca No.6, Jakarta', '081612345683'),
('SPLgooP5', 'PT. Google Indonesia', 'Jl. Rasuna Said No.7, Jakarta', '081712345684'),
('SPLsonX1', 'PT. Sony Indonesia', 'Jl. Pramuka No.8, Jakarta', '081812345685'),
('SPLhuaP40', 'PT. Huawei Indonesia', 'Jl. Daan Mogot No.9, Jakarta', '081912345686'),
('SPLasuR5', 'PT. Asus Indonesia', 'Jl. Mangga Dua No.10, Jakarta', '082012345687');

-- Menambahkan Data ke Tabel Pelanggan
INSERT INTO Pelanggan (IdPelanggan, NamaPelanggan, AlamatPelanggan, NoHpPelanggan) VALUES 
('PLG001', 'Rina Melati', 'Jl. Kenanga No.1, Surabaya', '081322233344'),
('PLG002', 'Siti Aminah', 'Jl. Melati No.2, Bandung', '081433344455'),
('PLG003', 'Tina Kartika', 'Jl. Kamboja No.3, Yogyakarta', '081544455566'),
('PLG004', 'Umar Zain', 'Jl. Mawar No.4, Semarang', '081655566677'),
('PLG005', 'Vina Kusuma', 'Jl. Anggrek No.5, Medan', '081766677788'),
('PLG006', 'Winda Puspita', 'Jl. Dahlia No.6, Malang', '081877788899'),
('PLG007', 'Xena Larasati', 'Jl. Teratai No.7, Denpasar', '081988899900'),
('PLG008', 'Yogi Pratama', 'Jl. Soka No.8, Palembang', '082199900011'),
('PLG009', 'Zara Dewi', 'Jl. Bougenville No.9, Makassar', '082210001122'),
('PLG010', 'Aldo Prasetyo', 'Jl. Flamboyan No.10, Padang', '082321112233');

-- Menambahkan Data ke Tabel Pembelian
INSERT INTO Pembelian (IdPembelian, JumlahPembelian, HargaBeli, IdPengguna, IdSupplier) VALUES 
('PBN001', 21, 10000000.00, 'Idpn01', 'SPLiph12'),
('PBN002', 16, 1500000.00, 'Idpn02', 'SPLsg21'),
('PBN003', 24, 2000000.00, 'Idpn03', 'SPLxia11'),
('PBN004', 20, 1200000.00, 'Idpn04', 'SPLoppX3'),
('PBN005', 23, 1300000.00, 'Idpn05', 'SPLviv60'),
('PBN006', 18, 1700000.00, 'Idpn06', 'SPLone9'),
('PBN007', 10, 1600000.00, 'Idpn07', 'SPLgooP5'),
('PBN008', 15, 1000000.00, 'Idpn08', 'SPLsonX1'),
('PBN009', 20, 2000000.00, 'Idpn09', 'SPLhuaP40'),
('PBN010', 12, 1500000.00, 'Idpn10', 'SPLasuR5');

-- Menambahkan Data ke Tabel Penjualan
INSERT INTO Penjualan (IdPenjualan, JumlahPenjualan, HargaJual, IdPengguna, IdPelanggan) VALUES 
('PJL001', 13, 11000000.00, 'Idpn01', 'PLG001'),
('PJL002', 11, 1500000.00, 'Idpn02', 'PLG002'),
('PJL003', 14, 1700000.00, 'Idpn03', 'PLG003'),
('PJL004', 5, 2200000.00, 'Idpn04', 'PLG004'),
('PJL005', 4, 2150000.00, 'Idpn05', 'PLG005'),
('PJL006', 7, 2300000.00, 'Idpn06', 'PLG006'),
('PJL007', 8, 2350000.00, 'Idpn07', 'PLG007'),
('PJL008', 9, 2400000.00, 'Idpn08', 'PLG008'),
('PJL009', 6, 2100000.00, 'Idpn09', 'PLG009'),
('PJL010', 7, 2150000.00, 'Idpn10', 'PLG010');

