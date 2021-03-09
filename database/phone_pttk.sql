-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 08, 2021 at 08:51 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone_pttk`
--

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

DROP TABLE IF EXISTS `binhluan`;
CREATE TABLE IF NOT EXISTS `binhluan` (
  `maBL` int NOT NULL AUTO_INCREMENT,
  `maKH` int NOT NULL,
  `maSP` int NOT NULL,
  `ND` varchar(100) NOT NULL,
  `ThoiGianBL` datetime NOT NULL,
  PRIMARY KEY (`maBL`),
  KEY `maSP` (`maSP`),
  KEY `maKH` (`maKH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `maDH` int NOT NULL,
  `maSp` int NOT NULL,
  `SL` int NOT NULL,
  `TongTien` int NOT NULL,
  `Tinhtrang` varchar(50) NOT NULL,
  PRIMARY KEY (`maDH`,`maSp`),
  KEY `maSp` (`maSp`),
  KEY `maDH` (`maDH`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitietpn`
--

DROP TABLE IF EXISTS `chitietpn`;
CREATE TABLE IF NOT EXISTS `chitietpn` (
  `maPN` int NOT NULL,
  `maSP` int NOT NULL,
  `SL` int NOT NULL,
  `DonGia` int NOT NULL,
  PRIMARY KEY (`maPN`,`maSP`),
  KEY `maPN` (`maPN`) USING BTREE,
  KEY `maSP` (`maSP`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitietsp`
--

DROP TABLE IF EXISTS `chitietsp`;
CREATE TABLE IF NOT EXISTS `chitietsp` (
  `maCT` int NOT NULL AUTO_INCREMENT,
  `maSP` int NOT NULL,
  `maDM` varchar(50) NOT NULL,
  `Size` int NOT NULL,
  `Weight` int NOT NULL,
  `Color` varchar(20) NOT NULL,
  `BoNhoTrong` int NOT NULL,
  `BoNho` int NOT NULL,
  `HDH` varchar(10) NOT NULL,
  `CamTruoc` varchar(10) NOT NULL,
  `CamSau` varchar(10) NOT NULL,
  `Pin` int NOT NULL,
  `BaoHanh` date NOT NULL,
  `TinhTrang` varchar(20) NOT NULL,
  `HinhAnh` varchar(20) NOT NULL,
  PRIMARY KEY (`maCT`),
  KEY `maSP` (`maSP`),
  KEY `maDM` (`maDM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE IF NOT EXISTS `danhmuc` (
  `maDM` varchar(50) NOT NULL,
  `tenDM` varchar(20) NOT NULL,
  PRIMARY KEY (`maDM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `maDH` int NOT NULL AUTO_INCREMENT,
  `maKH` int NOT NULL,
  `maNV` int NOT NULL,
  `TongTien` int NOT NULL,
  `Ngaykhoitao` datetime NOT NULL,
  PRIMARY KEY (`maDH`),
  KEY `maKH` (`maKH`),
  KEY `maNV` (`maNV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `maKH` int NOT NULL AUTO_INCREMENT,
  `maUser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Hovaten` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Diachi` varchar(50) NOT NULL,
  `Sdt` int NOT NULL,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CMND` int NOT NULL,
  PRIMARY KEY (`maKH`) USING BTREE,
  KEY `maUser` (`maUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `maUser` varchar(50) NOT NULL,
  `RoleID` int NOT NULL,
  `TenUser` varchar(20) NOT NULL,
  `TK` varchar(20) NOT NULL,
  `MK` varchar(20) NOT NULL,
  `lock/unlock` tinyint(1) NOT NULL,
  PRIMARY KEY (`maUser`),
  UNIQUE KEY `TK` (`TK`),
  KEY `RoleID` (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhacungcap`
--

DROP TABLE IF EXISTS `nhacungcap`;
CREATE TABLE IF NOT EXISTS `nhacungcap` (
  `maNCC` int NOT NULL AUTO_INCREMENT,
  `tenNCC` varchar(20) NOT NULL,
  `DiaChi` varchar(20) NOT NULL,
  `SDT` int NOT NULL,
  `Email` varchar(20) NOT NULL,
  PRIMARY KEY (`maNCC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
CREATE TABLE IF NOT EXISTS `nhanvien` (
  `maNV` int NOT NULL AUTO_INCREMENT,
  `maUser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TenNV` varchar(20) NOT NULL,
  `GT` varchar(10) NOT NULL,
  `NgaySinh` date NOT NULL,
  `SDT` int NOT NULL,
  `CMND` int NOT NULL,
  `ChucVu` varchar(20) NOT NULL,
  `NgayVaoLam` date NOT NULL,
  PRIMARY KEY (`maNV`),
  KEY `maUser` (`maUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phanquyen`
--

DROP TABLE IF EXISTS `phanquyen`;
CREATE TABLE IF NOT EXISTS `phanquyen` (
  `RoleID` int NOT NULL AUTO_INCREMENT,
  `tenQuyen` varchar(20) NOT NULL,
  `ChiTiet` varchar(50) NOT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieunhap`
--

DROP TABLE IF EXISTS `phieunhap`;
CREATE TABLE IF NOT EXISTS `phieunhap` (
  `maPN` int NOT NULL AUTO_INCREMENT,
  `maNCC` int NOT NULL,
  `maNV` int NOT NULL,
  `NgayNhap` datetime NOT NULL,
  `Tong` int NOT NULL,
  PRIMARY KEY (`maPN`),
  KEY `maNV` (`maNV`),
  KEY `maNCC` (`maNCC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `maSP` int NOT NULL AUTO_INCREMENT,
  `tenSp` varchar(50) NOT NULL,
  `MoTa` varchar(50) NOT NULL,
  `GiaCa` int NOT NULL,
  `SL` int NOT NULL,
  PRIMARY KEY (`maSP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`),
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`maDH`) REFERENCES `donhang` (`maDH`),
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`maSp`) REFERENCES `sanpham` (`maSP`);

--
-- Constraints for table `chitietpn`
--
ALTER TABLE `chitietpn`
  ADD CONSTRAINT `chitietpn_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`),
  ADD CONSTRAINT `chitietpn_ibfk_2` FOREIGN KEY (`maPN`) REFERENCES `phieunhap` (`maPN`);

--
-- Constraints for table `chitietsp`
--
ALTER TABLE `chitietsp`
  ADD CONSTRAINT `chitietsp_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`),
  ADD CONSTRAINT `chitietsp_ibfk_2` FOREIGN KEY (`maDM`) REFERENCES `danhmuc` (`maDM`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`),
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`maNV`) REFERENCES `nhanvien` (`maNV`);

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`maUser`) REFERENCES `nguoidung` (`maUser`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `phanquyen` (`RoleID`);

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`maUser`) REFERENCES `nguoidung` (`maUser`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`maNV`) REFERENCES `nhanvien` (`maNV`),
  ADD CONSTRAINT `phieunhap_ibfk_2` FOREIGN KEY (`maNCC`) REFERENCES `nhacungcap` (`maNCC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
