-- Database: `u170538644_unsur` --
-- Table `tbl_hak_akses` --
CREATE TABLE `tbl_hak_akses` (
  `level_pegawai` enum('Pegawai','Admin','Wali Kelas') NOT NULL,
  `hak_akses` enum('0','1') NOT NULL,
  `jurusan` enum('0','1') NOT NULL,
  `kelas` enum('0','1') NOT NULL,
  `pengguna` enum('0','1') NOT NULL,
  `siswa` enum('0','1') NOT NULL,
  `laporan_jenis_pembayaran` enum('0','1') NOT NULL,
  `laporan_pembayaran` enum('0','1') NOT NULL,
  `laporan_siswa` enum('0','1') NOT NULL,
  `laporan_jurusan` enum('0','1') NOT NULL,
  `laporan_kelas` enum('0','1') NOT NULL,
  `laporan_pengguna` enum('0','1') NOT NULL,
  `backup` enum('0','1') NOT NULL,
  `pembayaran` enum('0','1') NOT NULL,
  `transaksi` enum('0','1') NOT NULL,
  PRIMARY KEY (`level_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_hak_akses` (`level_pegawai`, `hak_akses`, `jurusan`, `kelas`, `pengguna`, `siswa`, `laporan_jenis_pembayaran`, `laporan_pembayaran`, `laporan_siswa`, `laporan_jurusan`, `laporan_kelas`, `laporan_pengguna`, `backup`, `pembayaran`, `transaksi`) VALUES
('Pegawai', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
('Admin', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1'),
('Wali Kelas', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0');

-- Table `tbl_history` --
CREATE TABLE `tbl_history` (
  `id_history` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `waktu_history` datetime NOT NULL,
  `keterangan_history` varchar(100) NOT NULL,
  PRIMARY KEY (`id_history`),
  KEY `id_user` (`id_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_history` (`id_history`, `id_pegawai`, `waktu_history`, `keterangan_history`) VALUES
(8, 1, '2018-04-09 02:33:24', 'Telah Login'),
(9, 1, '2018-04-09 09:42:50', 'Telah Login'),
(10, 1, '2018-04-09 10:07:32', 'Telah Logout'),
(11, 1, '2018-04-09 10:07:37', 'Telah Login'),
(12, 1, '2018-04-09 10:08:16', 'Telah Logout'),
(13, 1, '2018-04-09 10:08:45', 'Telah Login'),
(14, 1, '2018-04-09 11:11:04', 'Telah Login');

-- Table `tbl_jurusan` --
CREATE TABLE `tbl_jurusan` (
  `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jurusan` varchar(100) NOT NULL,
  `diskripsi_jurusan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jurusan` (`id_jurusan`, `nama_jurusan`, `diskripsi_jurusan`) VALUES
(1, 'Rekayasa Perangkat Lunak', 'RPL'),
(2, 'Multimedia', 'MM'),
(3, 'Bengkel2', 'B');

-- Table `tbl_kelas` --
CREATE TABLE `tbl_kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurusan` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `id_jurusan` (`id_jurusan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_kelas` (`id_kelas`, `id_jurusan`, `nama_kelas`) VALUES
(1, 1, 'X RPL 1'),
(2, 2, 'X MM 1'),
(3, 3, 'X B 1');

-- Table `tbl_pegawai` --
CREATE TABLE `tbl_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nip` char(15) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `alamat_pegawai` varchar(200) NOT NULL,
  `telp_pegawai` varchar(15) NOT NULL,
  `foto_pegawai` text NOT NULL,
  `email_pegawai` varchar(100) NOT NULL,
  `password_pegawai` varchar(100) NOT NULL,
  `level_pegawai` enum('Admin','Pegawai','Wali Kelas') NOT NULL,
  `aktif_pegawai` enum('0','1') NOT NULL,
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pegawai` (`id_pegawai`, `nip`, `nama_pegawai`, `alamat_pegawai`, `telp_pegawai`, `foto_pegawai`, `email_pegawai`, `password_pegawai`, `level_pegawai`, `aktif_pegawai`) VALUES
(1, '2110175022', 'Fastforit', 'Jalan Slamet Riyadi 92, Kota Pasuruan', '085655580445', '1523171296-3.png', 'fastforit@gmail.com', '7b2e9f54cdff413fcde01f330af6896c3cd7e6cd', 'Admin', '1');

-- Table `tbl_pembayaran` --
CREATE TABLE `tbl_pembayaran` (
  `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pembayaran` varchar(100) NOT NULL,
  `nominal_pembayaran` int(11) NOT NULL,
  `jumlah_cicilan` int(11) NOT NULL,
  `aktif_pembayaran` enum('0','1') NOT NULL,
  PRIMARY KEY (`id_pembayaran`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pembayaran` (`id_pembayaran`, `nama_pembayaran`, `nominal_pembayaran`, `jumlah_cicilan`, `aktif_pembayaran`) VALUES
(2, 'SPP', 3000000, 8, '1'),
(4, 'Iuran', 100000, 100, '0'),
(7, 'Wisuda 2018', 300000, 1, '1');

-- Table `tbl_siswa` --
CREATE TABLE `tbl_siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nis` char(15) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `jekel_siswa` enum('Laki-Laki','Perempuan') NOT NULL,
  `alamat_siswa` text NOT NULL,
  `email_siswa` varchar(100) NOT NULL,
  `foto_siswa` text NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `aktif_siswa` enum('0','1') NOT NULL,
  `angkatan_siswa` varchar(30) NOT NULL,
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY `nis` (`nis`),
  KEY `id_kelas` (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_siswa` (`id_siswa`, `nis`, `nama_siswa`, `jekel_siswa`, `alamat_siswa`, `email_siswa`, `foto_siswa`, `id_kelas`, `aktif_siswa`, `angkatan_siswa`) VALUES
(4, '143140914111009', 'Bagus Prasetya', 'Laki-Laki', 'Jalan Slamet Riyadi 92', 'bagusprasetya96@gmail.com', 'default.jpg', 1, '1', '2018');

-- Table `tbl_transaksi` --
CREATE TABLE `tbl_transaksi` (
  `id_transaksi` char(15) NOT NULL,
  `waktu_transaksi` datetime NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `nominal_transaksi` double NOT NULL,
  `pembayaran_melalui` enum('TUNAI','TRANSFER') NOT NULL,
  `file_foto` varchar(30) NOT NULL,
  `cicilan_transaksi` int(11) NOT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_siswa` (`id_siswa`),
  KEY `id_pegawai` (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_transaksi` (`id_transaksi`, `waktu_transaksi`, `id_siswa`, `id_pegawai`, `id_pembayaran`, `nominal_transaksi`, `pembayaran_melalui`, `file_foto`, `cicilan_transaksi`) VALUES
('TR-000000000001', '2018-04-07 09:45:24', 4, 1, 7, '50000', 'TUNAI', '0', 1),
('TR-000000000002', '2018-04-07 13:03:31', 4, 1, 7, '100000', 'TUNAI', '0', 2),
('TR-000000000003', '2018-04-08 05:05:37', 4, 1, 7, '5000', 'TRANSFER', '1523156737-Bukti Transfer.jpg', 3),
('TR-000000000004', '2018-04-09 00:51:38', 4, 1, 2, '1000000', 'TUNAI', '0', 1),
('TR-000000000005', '2018-04-09 01:08:09', 4, 1, 7, '145000', 'TUNAI', '0', 4);

