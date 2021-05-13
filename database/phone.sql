-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th5 13, 2021 lúc 08:57 AM
-- Phiên bản máy phục vụ: 8.0.21
-- Phiên bản PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `phone`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

DROP TABLE IF EXISTS `binhluan`;
CREATE TABLE IF NOT EXISTS `binhluan` (
  `maBL` int NOT NULL AUTO_INCREMENT,
  `maKH` int NOT NULL,
  `maSP` int NOT NULL,
  `ND` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ThoiGianBL` datetime NOT NULL,
  PRIMARY KEY (`maBL`),
  KEY `maSP` (`maSP`),
  KEY `maKH` (`maKH`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`maBL`, `maKH`, `maSP`, `ND`, `ThoiGianBL`) VALUES
(1, 1, 166, 'hello world', '2021-05-13 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `maDH` int NOT NULL,
  `maSP` int NOT NULL,
  `SL` int NOT NULL,
  `TongTien` int NOT NULL,
  `Tinhtrang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`maDH`,`maSP`),
  KEY `maSp` (`maSP`),
  KEY `maDH` (`maDH`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`maDH`, `maSP`, `SL`, `TongTien`, `Tinhtrang`) VALUES
(1, 815, 1, 2590000, 'Đã hủy'),
(2, 166, 0, 0, 'Đã hủy'),
(3, 166, 1, 3800000, 'Đã xác nhận'),
(3, 188, 2, 15380000, 'Đã xác nhận'),
(4, 815, 1, 2590000, 'Đã xác nhận'),
(5, 238, 1, 47500000, 'Đã xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietpn`
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

--
-- Đang đổ dữ liệu cho bảng `chitietpn`
--

INSERT INTO `chitietpn` (`maPN`, `maSP`, `SL`, `DonGia`) VALUES
(1, 238, 20, 47500000),
(2, 685, 10, 19490000),
(3, 174, 10, 4990000),
(4, 622, 20, 32000000),
(5, 987, 212, 123);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietsp`
--

DROP TABLE IF EXISTS `chitietsp`;
CREATE TABLE IF NOT EXISTS `chitietsp` (
  `maCT` int NOT NULL AUTO_INCREMENT,
  `maSP` int NOT NULL,
  `maDM` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Size` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Weight` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BoNhoTrong` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BoNho` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `HDH` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CamTruoc` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CamSau` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Pin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BaoHanh` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TinhTrang` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Ngày nhập hàng` datetime NOT NULL,
  `HinhAnh` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`maCT`),
  KEY `maSP` (`maSP`),
  KEY `maDM` (`maDM`)
) ENGINE=InnoDB AUTO_INCREMENT=988 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietsp`
--

INSERT INTO `chitietsp` (`maCT`, `maSP`, `maDM`, `Size`, `Weight`, `Color`, `BoNhoTrong`, `BoNho`, `HDH`, `CamTruoc`, `CamSau`, `Pin`, `BaoHanh`, `TinhTrang`, `Ngày nhập hàng`, `HinhAnh`) VALUES
(166, 166, 'XM', '162.3 x 77.1', '198 g', 'Trắng, Xám, Xanh Lá,', '128 GB', '4 GB', 'Android 10', '13 MP', '48 MP, f/1.8, 26mm (wide), 1/2.0\", 0.8µm', '5020 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-06 01:58:06', 'image/XM/166.png'),
(174, 174, 'RM', '162.1 x 74', '191 g', 'Trắng, Xanh', '128 GB', '4 GB', 'Android v1', '16 MP', '64 MP, 8 MP, 2 MP', '4300 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-03 01:57:02', 'image/RM/174.png'),
(188, 188, 'RM', '160.9 x 74.3', '182 g', 'Bạc, Xanh', '128 GB', '8 GB', 'realme UI ', 'Sony 32MP ', '64MP + f/1.8 Sony IMX682', '4500 mAh, Sạc nhanh 30W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:07', 'image/RM/188.png'),
(189, 189, 'VM', '165.1 x 72', '180 g', 'Xanh dương', '64 GB', '6 GB', 'Android 10', '13 MP, f/2.3', '16MP f1.8, 8MP f2.2 ', 'Li-Po 5000 mAh battery Sạc nhanh 18W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:44', 'image/VM/189.png'),
(238, 238, 'SS', '175 x 70', '282 g', 'Vàng Đồng, Đen', '256 GB', '12 GB', 'Android 10', '20 MP f/2.2', '12 MP, f/1.8, 26mm (wide), 1/1.76\", 1.8µm', 'Li-Po 4500 mAh Sạc nhanh 25W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:28', 'image/SS/238.png'),
(347, 347, 'SS', '158 x 60', '169 g', 'Xanh', '64 GB', '4 GB', 'Android v9', '32 MP', '48MP, 8MP, 5MP', 'Pin chuẩn Li-Po 4000 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:13', 'image/SS/347.png'),
(371, 371, 'OP', '159.1 x 73.1', '171 g', 'Bạc, Đen', '128 GB', '8 GB', 'ColorOS 11', '44 MP, f/22', '64 MP, 8 MP', '4310mAh ', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-02 01:56:37', 'image/OP/371.png'),
(402, 402, 'RM', '164.4 x 75.5', '196 g', 'Xanh, Đen', '32 GB ', '2 GB', 'Android 10', '5 MP, f/2.0', '13 MP, (wide), f/2.2, PDAF 2 MP, f/2.4, (depth)', '5000 mAh Li-Po', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-03 01:56:58', 'image/RM/402.png'),
(472, 472, 'RM', '164.5 x 75.5', '209 g', 'Xanh, Bạc', '64 GB', '4 GB', 'Android 10', '8 MP, f/2.1', '13 MP, 8MP & 2 MP', '6000 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:10', 'image/RM/472.png'),
(557, 557, 'XM', '165.3 x 76', '215 g', 'Xám, Xanh', '128 GB', '6 GB', 'Android 10', '20 MP, f/2.3', '64 MP, f/1.9, (wide), 1/1.73\", 0.8µm, PDAF', 'Li-Po 5160 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:54', 'image/XM/557.png'),
(601, 601, 'XM', '165.1 x 76.3', '208 g', 'Bạc, Xanh, Đen', '256 GB', '8 GB', 'Android 10', '20 MP, f/2.2', '108 MP, f/1.7, 26mm (wide), 1/1.33\", 0.8µm, PDAF', 'Li-Po 5000 mAh ', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:57', 'image/XM/601.png'),
(622, 622, 'IP', '158 x 77', '226 g', 'Đen, Vàng Đồng', '256 GB', '4 GB', 'iOS 13', '12 MP f/2.3', '12MP: f/2.0, f/1.8, f/2.4', '3969 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-01 01:56:04', 'image/IP/iphone11promax1.png'),
(645, 645, 'VM', '162.3 x 77.5', '171 g', 'Tím, Xanh Dương', '64 GB', '4 GB', 'VOS 2.5', '16MP', '48 MP, 8 MP, 2 MP', '4020 mAh', '18 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:34', 'image/VM/645.png'),
(653, 653, 'RM', '164.1 x 75.5', '188 g', 'Xanh Dương, Xanh Lá', '128 GB', '8 GB', 'Android 11', '16 MP, f/2.3', '	64 MP, f/1.8, 26mm (wide), 1/1.73\", 0.8µm, PDAF', 'Li-Po 5000 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-03 01:56:52', 'image/RM/653.png'),
(680, 680, 'VM', '175 x 78', '210 g', 'Xanh Lá, Đen', '128 GB', '8 GB', 'Android 10', '20MP', '64MP, 8 MP, 2 MP', '4,000mAh, Sạc nhanh 18 W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:41', 'image/VM/680.png'),
(685, 685, 'SS', '166.9 x 76 ', '222 g', 'Trắng Thiên Vân, Đen', '128 GB', '12 GB', 'Android 10', '108 MP, f/1.8, 26mm ', '108 MP, f/1.8, 26mm (wide), PDAF, OIS', 'Li-Po 5000 mAh, Sạc nhanh 45W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:20', 'image/SS/685.png'),
(712, 712, 'IP', '146.7 x 71', '189 g', 'Vàng, Xám,', '128 GB', '6 GB', 'iOS 14.1 ', '12 MP, f/2.2', '12 MP, f/1.6, 26mm (wide), 1.4µm, dual pixel PDAF', 'Li-Ion, sạc nhanh 20W, sạc không dây 15W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-01 01:56:17', 'image/IP/iphone11pro1.png'),
(722, 722, 'SS', '161.6 x 75', '192 g', 'Váng Đồng, Xám, Xanh', '256 GB', '8 GB', 'Android 10', '10 MP, f/2.2', '12 MP, f/1.8, 26mm (wide) 1.8µm, Dual Pixel PDAF', 'Li-Ion 4300 mAh Sạc nhanh 25 W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:23', 'image/SS/722.png'),
(748, 748, 'SS', '157.8 x 74.5', '171 g', 'Bạc, Đen', '64 GB', '4 GB', 'Android 10', '13 MP', '64 MP, 12 MP', '4500 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:25', 'image/SS/748.png'),
(799, 799, 'XM', '164.3 x 74.5', '196 g', 'Xám, Xanh', '256 GB', '8 GB', 'Android 11', '20 MP, f/2.3', '108 MP, f/1.9, 26mm 1/1.33\", 0.8µm, PDAF, OIS', 'Li-Po 4600 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:47', 'image/XM/799.png'),
(800, 800, 'XM', '165.75 x 78', '209 g', 'Trắng, Xám, Xanh Lá', '64 GB', '4 GB', 'Android 10', '16 MP, f/2.2', '48 MP, f/1.8, 26mm (wide), 1/2.0\", 0.8µm, PDAF', 'Li-Po 5020 mAh battery Sạc nhanh 18 W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:51', 'image/XM/800.png'),
(815, 815, 'NO', '161 x 76', '180 g', 'Tím. Xanh. Đen', '64 GB', '4 GB', 'Android 10', '8 MP', '13 MP, (wide), PDAF', 'Li-Po 4000 Sạc nhanh 10 W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-02 01:56:27', 'image/NO/815.png'),
(875, 875, 'XM', '157.8 x 74.5', '208 g', 'Trắng, Xanh', '128 GB', '8 GB', 'Android 10', '16 MP, f/2.3', '64 MP, f/1.9, 26mm (wide), 1/1.72\", 0.8µm, PDAF', 'Li-Po 5260 mAh', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-06 01:58:03', 'image/XM/875.png'),
(923, 923, 'VM', '170 x 75', '190 g', 'Xanh Lá, Đen', '128 GB', '8 GB', 'Android 10', '16 MP, f/2.3', '64MP, 8MP, 2 MP', '4,000 mAh Sạc nhanh 18 W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-05 01:57:38', 'image/VM/923.png'),
(930, 930, 'SS', '166.9 x 76', '220 g', 'Bạc, Đen', '128 GB', '12 GB', 'Android 11', '40 MP, f/2.2', '108MP, f/1.8, 12MP, f/2.2', '5,000mAh, Sạc nhanh 25 W', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-04 01:57:17', 'image/SS/930.png'),
(946, 946, 'OP', '7.48mm x 73', '164 g', 'Trắng, Đen', '128 GB', '8 GB', '	Android 1', '16 MP, f/2', '48 MP, f/1', '4000mAh Sạc', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-03 01:56:42', 'image/OP/946.png'),
(951, 951, 'NO', '171.9 x 78.', '220 g', 'Xanh', '128 GB', '8 GB', 'Android 10', '	24 MP, f/', '	64 MP, f/', 'Li-Po 4500 ', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-02 01:56:33', 'image/NO/951.png'),
(963, 963, 'OP', '160.2 x 73.', '161 g', 'Trắng, Đen', '256 GB', '8 GB', 'ColorOS 7.', '32 MP (IMX', '48 MP (IMX', 'Li-Po 4000 ', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-03 01:56:48', 'image/OP/963.png'),
(972, 972, 'IP', '	160.8 x 78', '226 g', 'Bạc, Vàng, Xám, Xanh', '256 GB', '6 GB', 'iOS 14.1 h', '12 MP, f/2', '12 MP, f/2', 'Li-Ion, sạc', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-01 01:56:21', 'image/IP/iphonexs64gb.png'),
(986, 986, 'XM', '163.3 x 75.', '219', 'Xanh, Đen', '128 GB', '6 GB', '	Android 1', 'Motorized ', '64 MP, f/1', 'Li-Po 4700 ', '12 tháng', 'Mới, đầy đủ phụ kiện', '2021-03-06 01:58:09', 'image/XM/986.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE IF NOT EXISTS `danhmuc` (
  `maDM` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenDM` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`maDM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`maDM`, `tenDM`, `logo`) VALUES
('IP', 'Iphone', 'images/logo/logo-iphone.png'),
('NO', 'Nokia', 'images/logo/logo-nokia.png'),
('OP', 'OPPO', 'images/logo/logo-oppo.png'),
('RM', 'Realme', 'images/logo/logo-realme.png'),
('SS', 'Samsung', 'images/logo/logo-samsung.png'),
('VM', 'Vsmart', 'images/logo/logo-vsmart.png'),
('XM', 'Xiaomi', 'images/logo/logo-xiaomi.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `maDH` int NOT NULL AUTO_INCREMENT,
  `maKH` int NOT NULL,
  `maNV` int DEFAULT NULL,
  `TongTien` int NOT NULL,
  `Ngaykhoitao` datetime NOT NULL,
  PRIMARY KEY (`maDH`),
  KEY `maKH` (`maKH`),
  KEY `maNV` (`maNV`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`maDH`, `maKH`, `maNV`, `TongTien`, `Ngaykhoitao`) VALUES
(1, 1, NULL, 2590000, '2021-05-13 11:26:00'),
(2, 1, NULL, 0, '2021-05-13 15:12:50'),
(3, 1, NULL, 19180000, '2021-05-13 15:31:43'),
(4, 1, NULL, 2590000, '2021-05-13 15:32:10'),
(5, 1, NULL, 47500000, '2021-05-13 15:32:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `maKH` int NOT NULL AUTO_INCREMENT,
  `maUser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Hovaten` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Diachi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sdt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CMND` int DEFAULT NULL,
  PRIMARY KEY (`maKH`) USING BTREE,
  KEY `maUser` (`maUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`maKH`, `maUser`, `Hovaten`, `Diachi`, `Sdt`, `Email`, `CMND`) VALUES
(1, 'KH1', 'Tran Bao Long', 'SGU University', '0830343525', 'tranbaolongtbb@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `maUser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RoleID` int DEFAULT NULL,
  `TenUser` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TK` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MK` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lock/unlock` tinyint(1) NOT NULL,
  PRIMARY KEY (`maUser`),
  UNIQUE KEY `TK` (`TK`),
  KEY `RoleID` (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`maUser`, `RoleID`, `TenUser`, `TK`, `MK`, `lock/unlock`) VALUES
('0', 0, 'admin', 'admin', '$2y$10$QCa0unA45x01UzuVRl5ii.qAFWj2cGiO96FiSD2oCtyiJFo4dOGse', 1),
('1', 8, 'Trần Bảo Long', 'nhanvien1', '$2y$10$QCa0unA45x01UzuVRl5ii.qAFWj2cGiO96FiSD2oCtyiJFo4dOGse', 1),
('2', 5, 'Dương Ngọc Bảo', 'nhanvien2', '$2y$10$QCa0unA45x01UzuVRl5ii.qAFWj2cGiO96FiSD2oCtyiJFo4dOGse', 1),
('3', 6, 'Thái Bảo Long', 'nhanvien3', '$2y$10$QCa0unA45x01UzuVRl5ii.qAFWj2cGiO96FiSD2oCtyiJFo4dOGse', 1),
('KH1', NULL, 'Tran Bao Long', 'baolong123', '$2y$10$m3B05E3q6YwfDWYJJjife.xKE8wJrEu4SzPmp7GxfZhyYJw1YDxv2', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

DROP TABLE IF EXISTS `nhacungcap`;
CREATE TABLE IF NOT EXISTS `nhacungcap` (
  `maNCC` int NOT NULL AUTO_INCREMENT,
  `tenNCC` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DiaChi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SDT` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`maNCC`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`maNCC`, `tenNCC`, `DiaChi`, `SDT`, `Email`) VALUES
(1, 'Samsung Electronic', 'Việt Nam', '0758422545', 'samsung.co@samsung.com'),
(2, 'Apple', 'Việt Nam', '0751454454', 'appleco@iosco.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
CREATE TABLE IF NOT EXISTS `nhanvien` (
  `maNV` int NOT NULL AUTO_INCREMENT,
  `maUser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TenNV` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `GT` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NgaySinh` date NOT NULL,
  `Diachi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SDT` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CMND` int NOT NULL,
  `ChucVu` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NgayVaoLam` date NOT NULL,
  PRIMARY KEY (`maNV`),
  KEY `maUser` (`maUser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`maNV`, `maUser`, `TenNV`, `GT`, `NgaySinh`, `Diachi`, `SDT`, `Email`, `CMND`, `ChucVu`, `NgayVaoLam`) VALUES
(1, '1', 'Trần Bảo Long', 'Nam', '2000-03-05', 'sai gon university', '0758964581', 'nhanvien1@gmail.com', 215412450, 'Nhân viên culi', '2021-05-01'),
(2, '2', 'Dương Ngọc Bảo', 'Nam', '2000-05-05', 'sai gon university', '0885455558', 'nhanvien2@gmail.com', 215548545, 'Nhân viên cao cấp', '2018-05-04'),
(3, '3', 'Thái Bảo Long', 'Nam', '2000-03-05', 'sai gon university', '0825374264', 'nhanvien3@gmail.com', 215412450, 'Không làm mà có ăn', '2021-05-02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanquyen`
--

DROP TABLE IF EXISTS `phanquyen`;
CREATE TABLE IF NOT EXISTS `phanquyen` (
  `RoleID` int NOT NULL AUTO_INCREMENT,
  `tenQuyen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ChiTiet` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phanquyen`
--

INSERT INTO `phanquyen` (`RoleID`, `tenQuyen`, `ChiTiet`) VALUES
(0, 'Admin', 'Có đầy đủ tất cả các quyền'),
(5, 'Nhân viên cao cấp', 'qlsanpham, thongke, qldonhang, qlncc, qltaikhoan, nhaphang, qlquyen'),
(6, 'Nhân viên nhập hàng', 'qlncc, nhaphang'),
(8, 'Quản lý tài khoản và quyền', 'qltaikhoan, qlquyen');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`maPN`, `maNCC`, `maNV`, `NgayNhap`, `Tong`) VALUES
(1, 1, 2, '2021-05-13 00:00:00', 950000000),
(2, 1, 2, '2021-05-13 00:00:00', 194900000),
(3, 1, 2, '2021-05-13 00:00:00', 49900000),
(4, 2, 2, '2021-05-13 00:00:00', 640000000),
(5, 2, 2, '2021-05-13 00:00:00', 26076);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `rateID` int NOT NULL AUTO_INCREMENT,
  `maSP` int NOT NULL,
  `5star` int NOT NULL,
  `4star` int NOT NULL,
  `3star` int NOT NULL,
  `2star` int NOT NULL,
  `1star` int NOT NULL,
  `rate` float NOT NULL,
  PRIMARY KEY (`rateID`),
  KEY `maSP` (`maSP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `maSP` int NOT NULL AUTO_INCREMENT,
  `tenSp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MoTa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `GiaCa` int NOT NULL,
  `SL` int NOT NULL,
  PRIMARY KEY (`maSP`)
) ENGINE=InnoDB AUTO_INCREMENT=988 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`maSP`, `tenSp`, `MoTa`, `GiaCa`, `SL`) VALUES
(166, 'Xiaomi Redmi Note 9', '4 GB - 128 GB', 3800000, 11),
(174, 'Realme 6', '8 GB - 128 GB', 4990000, 19),
(188, 'Realme 7 Pro', '8 GB - 128 GB', 7690000, 22),
(189, 'Vsmart Joy 4', '4 GB - 64 GB', 3290000, 25),
(238, 'Samsung Galaxy Z Fold2 5G', '12 GB - 256 GB', 47500000, 26),
(347, 'Samsung Galaxy A50s', '4 GB - 64 GB', 6990000, 14),
(371, 'Oppo Reno5', '8 GB - 128 GB', 7490000, 25),
(402, 'Realme C11', '2 GB - 32 GB', 2490000, 8),
(472, 'Realme 15C', '4 GB - 64 GB', 3590000, 6),
(557, 'Xiaomi POCO X3 NFC', '6 GB - 64 GB', 5550000, 13),
(601, 'Xiaomi Mi 10T Pro 5G', '8 GB  - 128 GB', 10850000, 13),
(622, 'iPhone 11 Pro Max', '256 GB - 4 GB', 32000000, 22),
(645, 'Vsmart Active 3', '6 GB - 64 GB', 3290000, 25),
(653, 'Realme 7I', '8 GB - 128 GB', 5590000, 12),
(680, 'Vsmart Aris', '8 GB - 128 GB', 5990000, 22),
(685, 'Samsung Galaxy S20 Ultra', '12 GB - 128 GB', 19490000, 15),
(712, 'iPhone 12 Pro', '128 GB - 6 GB', 3300000, 1),
(722, 'Samsung Galaxy Note 20', '8 GB - 56 GB', 21990000, 14),
(748, 'Samsung Galaxy A71', '8 GB - 128 GB', 7700000, 30),
(799, 'Xiaomi Mi 11', '8 GB - 256 GB', 21990000, 25),
(800, 'Xiaomi Redmi Note 9s', '4 GB - 64 GB', 4450000, 15),
(815, 'Nokia 3.4', '4 GB - 64 GB', 2590000, 18),
(875, 'Xiaomi Mi Note 10 Lite', '128 GB - 8 GB', 4450000, 23),
(923, 'Vsmart Aris Pro', '8 GB - 128 GB', 7690000, 25),
(930, 'Samsung Galaxy S21 Ultra 5G', '12 GB - 128 GB', 22500000, 11),
(946, 'OPPO A93', '8 GB - 128 GB', 5790000, 25),
(951, 'Nokia 8.3 5G', '8 GB - 128 GB', 9290000, 3),
(963, 'Oppo Reno4 Pro', '8 GB - 256 GB', 9690000, 5),
(972, 'iPhone 12 Pro Max', '256 GB - 6 GB', 39000000, 2),
(986, 'POCO F2 PRO 5G', '8 GB  -256 GB', 10200000, 20),
(987, 'Iphone123', 'd - dd', 123, 212);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`),
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`);

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`maDH`) REFERENCES `donhang` (`maDH`),
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`);

--
-- Các ràng buộc cho bảng `chitietpn`
--
ALTER TABLE `chitietpn`
  ADD CONSTRAINT `chitietpn_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`),
  ADD CONSTRAINT `chitietpn_ibfk_2` FOREIGN KEY (`maPN`) REFERENCES `phieunhap` (`maPN`);

--
-- Các ràng buộc cho bảng `chitietsp`
--
ALTER TABLE `chitietsp`
  ADD CONSTRAINT `chitietsp_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`),
  ADD CONSTRAINT `chitietsp_ibfk_2` FOREIGN KEY (`maDM`) REFERENCES `danhmuc` (`maDM`);

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`),
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`maNV`) REFERENCES `nhanvien` (`maNV`);

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`maUser`) REFERENCES `nguoidung` (`maUser`);

--
-- Các ràng buộc cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `phanquyen` (`RoleID`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`maUser`) REFERENCES `nguoidung` (`maUser`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`maNV`) REFERENCES `nhanvien` (`maNV`),
  ADD CONSTRAINT `phieunhap_ibfk_2` FOREIGN KEY (`maNCC`) REFERENCES `nhacungcap` (`maNCC`);

--
-- Các ràng buộc cho bảng `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
