-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 15, 2025 lúc 04:22 AM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanly_banhang_2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chung_tu_ban`
--

CREATE TABLE `chung_tu_ban` (
  `ID_CTBAN` int NOT NULL,
  `MASOCT` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NGAYDATHANG` date DEFAULT NULL,
  `ID_KHACHHANG` int DEFAULT NULL,
  `TONGTIENHANG` decimal(18,2) DEFAULT NULL,
  `THUE` decimal(18,2) DEFAULT NULL,
  `TIENTHUE` decimal(18,2) GENERATED ALWAYS AS (((`TONGTIENHANG` * `THUE`) / 100)) STORED,
  `TONGCONG` decimal(18,2) GENERATED ALWAYS AS ((`TONGTIENHANG` + ((`TONGTIENHANG` * `THUE`) / 100))) STORED,
  `TRANGTHAI` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GHICHU` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chung_tu_ban`
--

INSERT INTO `chung_tu_ban` (`ID_CTBAN`, `MASOCT`, `NGAYDATHANG`, `ID_KHACHHANG`, `TONGTIENHANG`, `THUE`, `TRANGTHAI`, `GHICHU`) VALUES
(1, 'BAN00041', '2025-04-02', 42, 1429366.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 41'),
(2, 'BAN00031', '2025-02-04', 32, 4906950.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 31'),
(3, 'BAN00021', '2025-05-24', 22, 6567758.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 21'),
(4, 'BAN00011', '2025-06-18', 12, 6824867.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 11'),
(5, 'BAN00001', '2025-02-04', 2, 4762646.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 1'),
(6, 'BAN00042', '2025-06-27', 43, 3266488.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 42'),
(7, 'BAN00032', '2025-03-31', 33, 1399459.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 32'),
(8, 'BAN00022', '2025-02-19', 23, 3391343.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 22'),
(9, 'BAN00012', '2025-03-21', 13, 2040383.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 12'),
(10, 'BAN00002', '2025-10-23', 3, 6445195.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 2'),
(11, 'BAN00043', '2025-04-14', 44, 6295269.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 43'),
(12, 'BAN00033', '2024-12-16', 34, 3803361.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 33'),
(13, 'BAN00023', '2025-06-30', 24, 5806437.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 23'),
(14, 'BAN00013', '2025-08-19', 14, 2292066.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 13'),
(15, 'BAN00003', '2025-06-01', 4, 5491328.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 3'),
(16, 'BAN00044', '2025-01-24', 45, 1906652.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 44'),
(17, 'BAN00034', '2025-05-10', 35, 1004437.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 34'),
(18, 'BAN00024', '2025-01-17', 25, 8124438.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 24'),
(19, 'BAN00014', '2025-07-12', 15, 7524404.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 14'),
(20, 'BAN00004', '2025-06-17', 5, 4043736.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 4'),
(21, 'BAN00045', '2025-11-02', 46, 7311350.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 45'),
(23, 'BAN00025', '2025-10-26', 26, 6116619.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 25'),
(24, 'BAN00015', '2025-06-20', 16, 7917398.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 15'),
(25, 'BAN00005', '2025-05-23', 6, 5581000.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 5'),
(26, 'BAN00046', '2025-01-30', 47, 982428.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 46'),
(28, 'BAN00026', '2024-12-10', 27, 3463869.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 26'),
(30, 'BAN00006', '2025-10-18', 7, 330734.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 6'),
(31, 'BAN00047', '2025-02-24', 48, 5970803.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 47'),
(32, 'BAN00037', '2025-07-24', 38, 4668663.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 37'),
(33, 'BAN00027', '2025-02-22', 28, 1167367.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 27'),
(34, 'BAN00017', '2025-07-30', 18, 2362022.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 17'),
(35, 'BAN00007', '2025-07-14', 8, 572117.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 7'),
(37, 'BAN00038', '2025-01-01', 39, 1479493.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 38'),
(38, 'BAN00028', '2025-10-24', 29, 8002113.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 28'),
(39, 'BAN00018', '2025-04-20', 19, 924719.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 18'),
(40, 'BAN00008', '2025-04-06', 9, 7750650.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 8'),
(41, 'BAN00049', '2025-02-11', 50, 1139894.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 49'),
(42, 'BAN00039', '2025-09-08', 40, 6102143.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 39'),
(43, 'BAN00029', '2025-11-14', 30, 7881677.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 29'),
(44, 'BAN00019', '2025-03-17', 20, 5032574.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 19'),
(45, 'BAN00009', '2024-12-22', 10, 6883817.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 9'),
(46, 'BAN00050', '2025-07-08', 1, 3699367.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 50'),
(48, 'BAN00030', '2025-01-03', 31, 1044621.00, 0.00, 'Đã Giao Hàng', 'Ghi chú cho chứng từ bán 30'),
(49, 'BAN00020', '2025-01-24', 21, 7245167.00, 10.00, 'Đã Hủy', 'Ghi chú cho chứng từ bán 20'),
(50, 'BAN00010', '2025-01-08', 11, 6456589.00, 8.00, 'Đang Xử Lý', 'Ghi chú cho chứng từ bán 10'),
(52, 'CTB-1764908939', '2025-12-05', 2, 12950661.00, 10.00, 'Đang xử lý', NULL),
(53, 'CTB-1765688885', '2025-12-14', 2, 7551795.00, 10.00, 'Đang xử lý', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chung_tu_ban_ct`
--

CREATE TABLE `chung_tu_ban_ct` (
  `ID_CT` int NOT NULL,
  `ID_HANGHOA` int DEFAULT NULL,
  `GIABAN` decimal(18,2) DEFAULT NULL,
  `SOLUONG` int DEFAULT NULL,
  `THANHTIEN` decimal(18,2) GENERATED ALWAYS AS ((`GIABAN` * `SOLUONG`)) STORED,
  `ID_CTBAN` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chung_tu_ban_ct`
--

INSERT INTO `chung_tu_ban_ct` (`ID_CT`, `ID_HANGHOA`, `GIABAN`, `SOLUONG`, `ID_CTBAN`) VALUES
(1, 42, 1479808.00, 5, 41),
(3, 22, 4186595.00, 5, 21),
(4, 12, 443014.00, 3, 11),
(5, 2, 3937919.00, 1, 1),
(7, 33, 4392146.00, 4, 32),
(9, 13, 334758.00, 1, 12),
(11, 44, 1858203.00, 4, 43),
(12, 34, 872222.00, 4, 33),
(13, 24, 3048394.00, 3, 23),
(14, 14, 3269497.00, 4, 13),
(15, 4, 2884903.00, 4, 3),
(16, 45, 3587684.00, 3, 44),
(17, 35, 401877.00, 5, 34),
(19, 15, 1966790.00, 2, 14),
(20, 5, 3650425.00, 3, 4),
(21, 46, 4856981.00, 3, 45),
(22, 36, 2628821.00, 1, 35),
(23, 26, 4434781.00, 1, 25),
(24, 16, 3801454.00, 3, 15),
(25, 6, 514605.00, 5, 5),
(26, 47, 3764419.00, 4, 46),
(28, 27, 1078080.00, 5, 26),
(29, 17, 2850861.00, 2, 16),
(30, 7, 2663645.00, 5, 6),
(32, 38, 4106053.00, 2, 37),
(34, 18, 420931.00, 4, 17),
(35, 8, 535659.00, 3, 7),
(36, 49, 4589155.00, 1, 48),
(37, 39, 573019.00, 5, 38),
(38, 29, 2784962.00, 4, 28),
(39, 19, 957126.00, 3, 18),
(40, 9, 1320735.00, 3, 8),
(41, 50, 4679841.00, 5, 49),
(42, 40, 230360.00, 2, 39),
(44, 20, 4834075.00, 4, 19),
(45, 10, 922924.00, 2, 9),
(46, 1, 2228891.00, 5, 50),
(47, 41, 2242617.00, 2, 40),
(48, 31, 749714.00, 4, 30),
(50, 11, 4411947.00, 4, 10),
(51, 48, 4316887.00, 3, 52),
(52, 47, 2517265.00, 3, 53);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chung_tu_mua`
--

CREATE TABLE `chung_tu_mua` (
  `ID_CTMUA` int NOT NULL,
  `MASOCT` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NGAYPHATSINH` date DEFAULT NULL,
  `ID_KHACHHANG` int DEFAULT NULL,
  `TONGTIENHANG` decimal(18,2) DEFAULT NULL,
  `THUE` decimal(18,2) DEFAULT NULL,
  `TIENTHUE` decimal(18,2) GENERATED ALWAYS AS (((`TONGTIENHANG` * `THUE`) / 100)) STORED,
  `TONGCONG` decimal(18,2) GENERATED ALWAYS AS ((`TONGTIENHANG` + ((`TONGTIENHANG` * `THUE`) / 100))) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chung_tu_mua`
--

INSERT INTO `chung_tu_mua` (`ID_CTMUA`, `MASOCT`, `NGAYPHATSINH`, `ID_KHACHHANG`, `TONGTIENHANG`, `THUE`) VALUES
(1, 'MUA00041', '2025-05-29', 44, 3949344.00, 10.00),
(2, 'MUA00031', '2025-06-23', 34, 10006425.00, 5.00),
(3, 'MUA00021', '2025-03-28', 24, 3677987.00, 0.00),
(4, 'MUA00011', '2025-02-11', 14, 8923938.00, 10.00),
(5, 'MUA00001', '2025-11-12', 4, 5552947.00, 5.00),
(6, 'MUA00042', '2025-04-17', 45, 4290559.00, 0.00),
(7, 'MUA00032', '2025-08-23', 35, 644114.00, 10.00),
(8, 'MUA00022', '2025-06-02', 25, 2723129.00, 5.00),
(9, 'MUA00012', '2025-01-18', 15, 5042429.00, 0.00),
(10, 'MUA00002', '2025-01-01', 5, 397998.00, 10.00),
(11, 'MUA00043', '2025-06-18', 46, 1280115.00, 5.00),
(12, 'MUA00033', '2025-08-22', 36, 9840207.00, 0.00),
(14, 'MUA00013', '2025-11-26', 16, 6853415.00, 5.00),
(15, 'MUA00003', '2025-07-14', 6, 8428715.00, 0.00),
(16, 'MUA00044', '2025-11-09', 47, 7564853.00, 10.00),
(17, 'MUA00034', '2025-04-27', 37, 6973783.00, 5.00),
(18, 'MUA00024', '2025-03-23', 27, 3518208.00, 0.00),
(19, 'MUA00014', '2025-03-28', 17, 3181919.00, 10.00),
(20, 'MUA00004', '2025-05-13', 7, 7892597.00, 5.00),
(21, 'MUA00045', '2025-08-18', 48, 422086.00, 0.00),
(22, 'MUA00035', '2025-07-26', 38, 6086260.00, 10.00),
(23, 'MUA00025', '2024-12-05', 28, 940173.00, 5.00),
(24, 'MUA00015', '2025-05-31', 18, 2186950.00, 0.00),
(25, 'MUA00005', '2025-05-04', 8, 2190507.00, 10.00),
(26, 'MUA00046', '2025-07-24', 49, 1037090.00, 5.00),
(27, 'MUA00036', '2025-06-20', 39, 9090152.00, 0.00),
(28, 'MUA00026', '2025-09-19', 29, 2479080.00, 10.00),
(29, 'MUA00016', '2025-04-11', 19, 4391156.00, 5.00),
(30, 'MUA00006', '2025-08-24', 9, 220256.00, 0.00),
(31, 'MUA00047', '2025-08-16', 50, 3764459.00, 10.00),
(32, 'MUA00037', '2024-11-30', 40, 8642424.00, 5.00),
(33, 'MUA00027', '2025-08-09', 30, 9425928.00, 0.00),
(34, 'MUA00017', '2025-02-20', 20, 410827.00, 10.00),
(35, 'MUA00007', '2025-01-17', 10, 2072361.00, 5.00),
(36, 'MUA00048', '2025-06-29', 3, 4777425.00, 0.00),
(37, 'MUA00038', '2025-10-20', 41, 1219828.00, 10.00),
(38, 'MUA00028', '2025-08-27', 31, 9279920.00, 5.00),
(39, 'MUA00018', '2025-01-25', 21, 4440029.00, 0.00),
(40, 'MUA00008', '2025-04-01', 11, 9941272.00, 10.00),
(41, 'MUA00049', '2024-12-15', 4, 8023914.00, 5.00),
(42, 'MUA00039', '2025-10-15', 42, 2082919.00, 0.00),
(43, 'MUA00029', '2025-04-05', 32, 6460252.00, 10.00),
(44, 'MUA00019', '2025-08-30', 22, 3098529.00, 5.00),
(45, 'MUA00009', '2025-02-17', 12, 9829794.00, 0.00),
(46, 'MUA00050', '2025-05-13', 5, 7979326.00, 10.00),
(47, 'MUA00040', '2025-08-03', 43, 2239054.00, 5.00),
(48, 'MUA00030', '2025-10-13', 33, 9828100.00, 0.00),
(49, 'MUA00020', '2025-05-30', 23, 5682425.00, 10.00),
(50, 'MUA00010', '2025-08-07', 13, 8613185.00, 5.00),
(51, 'CTM-1764258448', '2025-11-27', 1, 10450698.00, 10.00),
(52, 'CTM-1764908916', '2025-12-05', 1, 12950661.00, 10.00),
(53, 'CTM-1764909343', '2025-12-05', 1, 10450698.00, 10.00),
(54, 'CTM-1764909896', '2025-12-05', 1, 10473333.00, 10.00),
(55, 'CTM-1765178617', '2025-12-08', 1, 3491111.00, 10.00),
(56, 'CTM-1765688907', '2025-12-14', 1, 6967132.00, 10.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chung_tu_mua_ct`
--

CREATE TABLE `chung_tu_mua_ct` (
  `ID_CT` int NOT NULL,
  `ID_HANGHOA` int DEFAULT NULL,
  `GIAMUA` decimal(18,2) DEFAULT NULL,
  `SOLUONG` int DEFAULT NULL,
  `THANHTIEN` decimal(18,2) GENERATED ALWAYS AS ((`GIAMUA` * `SOLUONG`)) STORED,
  `ID_CTMUA` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chung_tu_mua_ct`
--

INSERT INTO `chung_tu_mua_ct` (`ID_CT`, `ID_HANGHOA`, `GIAMUA`, `SOLUONG`, `ID_CTMUA`) VALUES
(1, 42, 1463859.00, 2, 41),
(3, 22, 3415464.00, 6, 21),
(4, 12, 761633.00, 3, 11),
(5, 2, 2831860.00, 8, 1),
(7, 33, 575580.00, 7, 32),
(8, 23, 3580193.00, 5, 22),
(9, 13, 1943450.00, 1, 12),
(11, 44, 1881676.00, 9, 43),
(12, 34, 617400.00, 10, 33),
(13, 24, 1895513.00, 4, 23),
(15, 4, 3645484.00, 1, 3),
(16, 45, 2340725.00, 7, 44),
(17, 35, 2764429.00, 4, 34),
(19, 15, 2815023.00, 1, 14),
(20, 5, 1566825.00, 6, 4),
(21, 46, 3534476.00, 6, 45),
(22, 36, 153625.00, 6, 35),
(23, 26, 2208603.00, 1, 25),
(24, 16, 3680833.00, 2, 15),
(25, 6, 1158403.00, 8, 5),
(26, 47, 3982170.00, 6, 46),
(27, 37, 335606.00, 6, 36),
(28, 27, 1636993.00, 4, 26),
(29, 17, 3182423.00, 7, 16),
(30, 7, 833110.00, 9, 6),
(31, 48, 2287287.00, 3, 47),
(32, 38, 3060471.00, 9, 37),
(33, 28, 663365.00, 1, 27),
(34, 18, 159703.00, 9, 17),
(35, 8, 164076.00, 7, 7),
(36, 49, 780122.00, 10, 48),
(37, 39, 445632.00, 7, 38),
(38, 29, 545914.00, 6, 28),
(39, 19, 1461686.00, 1, 18),
(40, 9, 1958817.00, 1, 8),
(41, 50, 3162349.00, 8, 49),
(42, 40, 1555294.00, 7, 39),
(43, 30, 189453.00, 3, 29),
(44, 20, 701964.00, 1, 19),
(45, 10, 2732247.00, 3, 9),
(46, 1, 695019.00, 1, 50),
(47, 41, 3715153.00, 4, 40),
(48, 31, 3432732.00, 3, 30),
(50, 11, 3030585.00, 4, 10),
(51, 49, 3483566.00, 3, 51),
(52, 48, 4316887.00, 3, 52),
(53, 49, 3483566.00, 3, 53),
(54, 50, 3491111.00, 3, 54),
(55, 50, 3491111.00, 1, 55),
(56, 49, 3483566.00, 2, 56);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_gia_ban`
--

CREATE TABLE `don_gia_ban` (
  `ID_DONGIA` int NOT NULL,
  `GIATRI` decimal(18,2) NOT NULL,
  `NGAYBATDAU` date NOT NULL,
  `APDUNG` tinyint DEFAULT '1',
  `ID_HANGHOA` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `don_gia_ban`
--

INSERT INTO `don_gia_ban` (`ID_DONGIA`, `GIATRI`, `NGAYBATDAU`, `APDUNG`, `ID_HANGHOA`) VALUES
(1, 4837719.00, '2025-01-29', 1, 41),
(2, 3104706.00, '2025-10-10', 1, 31),
(4, 606684.00, '2024-12-21', 1, 11),
(5, 3477462.00, '2025-09-21', 1, 1),
(6, 1111624.00, '2025-11-02', 1, 42),
(8, 1645631.00, '2025-08-19', 1, 22),
(9, 3853724.00, '2025-05-14', 1, 12),
(10, 3910074.00, '2025-02-10', 1, 2),
(12, 2359473.00, '2025-09-23', 1, 33),
(13, 4358873.00, '2025-07-30', 1, 23),
(14, 2083334.00, '2025-04-20', 1, 13),
(16, 2966537.00, '2025-01-23', 1, 44),
(17, 4182694.00, '2025-10-02', 1, 34),
(18, 3272363.00, '2025-08-04', 1, 24),
(19, 5030660.00, '2025-04-26', 1, 14),
(20, 1631278.00, '2025-07-16', 1, 4),
(21, 1218342.00, '2025-04-12', 1, 45),
(22, 3967012.00, '2025-04-24', 1, 35),
(24, 3051791.00, '2025-03-31', 1, 15),
(25, 4310658.00, '2025-01-26', 1, 5),
(26, 4936394.00, '2024-12-21', 1, 46),
(27, 5495564.00, '2025-09-15', 1, 36),
(28, 5488179.00, '2025-07-07', 1, 26),
(29, 5315329.00, '2025-04-06', 1, 16),
(30, 2097643.00, '2025-03-26', 1, 6),
(31, 2517265.00, '2025-11-26', 1, 47),
(32, 4449256.00, '2024-12-15', 1, 37),
(33, 2380475.00, '2025-11-14', 1, 27),
(34, 685733.00, '2025-10-26', 1, 17),
(35, 2104657.00, '2025-07-23', 1, 7),
(36, 4316887.00, '2025-02-14', 1, 48),
(37, 3578942.00, '2025-03-03', 1, 38),
(38, 4647932.00, '2024-12-18', 1, 28),
(39, 1600227.00, '2025-08-18', 1, 18),
(40, 4072926.00, '2025-02-26', 1, 8),
(41, 3483566.00, '2025-03-02', 1, 49),
(42, 5031416.00, '2025-08-04', 1, 39),
(43, 4744824.00, '2025-08-07', 1, 29),
(44, 5368909.00, '2024-12-12', 1, 19),
(45, 4805857.00, '2025-06-20', 1, 9),
(46, 3491111.00, '2025-03-23', 1, 50),
(47, 3578406.00, '2025-11-15', 1, 40),
(48, 2069722.00, '2025-06-07', 1, 30),
(49, 2619077.00, '2025-03-16', 1, 20),
(50, 1634964.00, '2025-11-13', 1, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hang_hoa`
--

CREATE TABLE `hang_hoa` (
  `ID_HANGHOA` int NOT NULL,
  `TENHANGHOA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MOTA` text COLLATE utf8mb4_unicode_ci,
  `DONVITINH` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HINHANH` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ID_PHANLOAI` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hang_hoa`
--

INSERT INTO `hang_hoa` (`ID_HANGHOA`, `TENHANGHOA`, `MOTA`, `DONVITINH`, `HINHANH`, `ID_PHANLOAI`) VALUES
(1, 'iPad Air 5 M1', 'Mô tả chi tiết sản phẩm 41.', 'Bộ', NULL, 2),
(2, 'CPU Intel Core i9-14900K', 'Mô tả chi tiết sản phẩm 31.', 'Hộp', NULL, 8),
(4, 'Tai Nghe Sony WH-1000XM5', 'Mô tả chi tiết sản phẩm 11.', 'Hộp', NULL, 4),
(5, 'Samsung Galaxy Tab S9', 'Mô tả chi tiết sản phẩm 1.', 'Bộ', NULL, 2),
(6, 'MacBook Air M2 (2024)', 'Mô tả chi tiết sản phẩm 42.', 'Cái', NULL, 3),
(7, 'Samsung Galaxy S23', 'Mô tả chi tiết sản phẩm 32.', 'Chiếc', NULL, 1),
(8, 'Robot Hút Bụi Ecovacs Deebot T20', 'Mô tả chi tiết sản phẩm 22.', 'Cái', NULL, 7),
(9, 'Router Wi-Fi 6 TP-Link AX73', 'Mô tả chi tiết sản phẩm 12.', 'Chiếc', NULL, 5),
(10, 'Dell XPS 13 Plus', 'Mô tả chi tiết sản phẩm 2.', 'Cái', NULL, 3),
(11, 'Sạc Nhanh Anker 65W', 'Mô tả chi tiết sản phẩm 43.', 'Hộp', NULL, 4),
(12, 'Xiaomi Pad 6', 'Mô tả chi tiết sản phẩm 33.', 'Bộ', NULL, 2),
(13, 'RAM Corsair Vengeance 32GB (2x16GB)', 'Mô tả chi tiết sản phẩm 23.', 'Hộp', NULL, 8),
(14, 'Sản Phẩm 13', 'Mô tả chi tiết sản phẩm 13.', 'Bộ', NULL, 6),
(15, 'Ốp Lưng MagSafe iPhone', 'Mô tả chi tiết sản phẩm 3.', 'Hộp', NULL, 4),
(16, 'Bộ Phát Wi-Fi Mesh Mercusys', 'Mô tả chi tiết sản phẩm 44.', 'Chiếc', NULL, 5),
(17, 'HP Pavilion Gaming 15', 'Mô tả chi tiết sản phẩm 34.', 'Cái', NULL, 3),
(18, 'iPhone 15 Pro Max', 'Mô tả chi tiết sản phẩm 24.', 'Chiếc', NULL, 1),
(19, 'Nồi Cơm Điện Cao Tần Zojirushi', 'Mô tả chi tiết sản phẩm 14.', 'Cái', NULL, 7),
(20, 'Switch Mạng Gigabit', 'Mô tả chi tiết sản phẩm 4.', 'Chiếc', NULL, 5),
(22, 'Chuột Không Dây Logitech MX Master 3S', 'Mô tả chi tiết sản phẩm 35.', 'Hộp', NULL, 4),
(23, 'Lenovo Tab P11 Gen 2', 'Mô tả chi tiết sản phẩm 25.', 'Bộ', NULL, 2),
(24, 'Card Đồ Họa NVIDIA RTX 4080', 'Mô tả chi tiết sản phẩm 15.', 'Hộp', NULL, 8),
(26, 'Máy Lọc Không Khí Sharp FP-J80EV', 'Mô tả chi tiết sản phẩm 46.', 'Cái', NULL, 7),
(27, 'Modem DrayTek Vigor 2927', 'Mô tả chi tiết sản phẩm 36.', 'Chiếc', NULL, 5),
(28, 'Asus ZenBook Duo', 'Mô tả chi tiết sản phẩm 26.', 'Cái', NULL, 3),
(29, 'Xiaomi Redmi Note 13', 'Mô tả chi tiết sản phẩm 16.', 'Chiếc', NULL, 1),
(30, 'Bếp Từ Đôi Bosch PID675DC1E', 'Mô tả chi tiết sản phẩm 6.', 'Cái', NULL, 7),
(31, 'SSD Samsung 990 Pro 1TB', 'Mô tả chi tiết sản phẩm 47.', 'Hộp', NULL, 8),
(33, 'Bàn Phím Cơ AKKO 3098', 'Mô tả chi tiết sản phẩm 27.', 'Hộp', NULL, 4),
(34, 'Kindle Paperwhite', 'Mô tả chi tiết sản phẩm 17.', 'Bộ', NULL, 2),
(35, 'Mainboard Asus ROG Strix Z790-E', 'Mô tả chi tiết sản phẩm 7.', 'Hộp', NULL, 8),
(36, 'Oppo Find N3 Flip', 'Mô tả chi tiết sản phẩm 48.', 'Chiếc', NULL, 1),
(37, 'Máy Hút Bụi Cầm Tay Dyson V15', 'Mô tả chi tiết sản phẩm 38.', 'Cái', NULL, 7),
(38, 'Repeater Xiaomi Pro', 'Mô tả chi tiết sản phẩm 28.', 'Chiếc', NULL, 5),
(39, 'Lenovo Legion 5', 'Mô tả chi tiết sản phẩm 18.', 'Cái', NULL, 3),
(40, 'Realme C55', 'Mô tả chi tiết sản phẩm 8.', 'Chiếc', NULL, 1),
(41, 'Microsoft Surface Go 3', 'Mô tả chi tiết sản phẩm 49.', 'Bộ', '1764175008994_5650372_surface_go_3_under_embargo_until_22.webp', 2),
(42, 'Tản Nhiệt Nước Cooler Master MasterLiquid', 'Mô tả chi tiết sản phẩm 39.', 'Hộp', '1764174985990_images.jpg', 8),
(44, 'Ổ Cứng Di Động Samsung T7', 'Mô tả chi tiết sản phẩm 19.', 'Hộp', '1764174725771_samsung_t7_portable_ssd_thumb_4f35411519.png', 4),
(45, 'Acer Iconia Tab M10', 'Mô tả chi tiết sản phẩm 9.', 'Bộ', '1764174699099_acer-iconia-tab-m10_2_.webp', 2),
(46, 'Acer Nitro V', 'Mô tả chi tiết sản phẩm 50.', 'Cái', '1764174508609_text_ng_n_11__4_19.webp', 3),
(47, 'Nokia C21 Plus', 'Mô tả chi tiết sản phẩm 40.', 'Chiếc', '1764174407510_nokia-c21-plus-600x600.jpg', 1),
(48, 'Quạt Điều Hòa Daikiosan', 'Mô tả chi tiết sản phẩm 30.', 'Cái', '1764174390829_quat-dieu-hoa-daikiosan-dka-04000c-01.jpg', 7),
(49, 'Cáp Mạng Cat6 UTP', 'Mô tả chi tiết sản phẩm 20.', 'Chiếc', '1764174333626_5570_lention_l6_2m_bl.jpg', 5),
(50, 'MSI Thin GF63', 'Mô tả chi tiết sản phẩm 10.', 'Cái', '1764174258347_gf63.1.jpg', 3),
(52, 'Phím cơ RGB', '', 'Cái', NULL, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `ID_KHACH_HANG` int NOT NULL,
  `TEN_KH` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DIACHI` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SODIENTHOAI` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HINHANH` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SOB` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PASSWORD` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`ID_KHACH_HANG`, `TEN_KH`, `DIACHI`, `SODIENTHOAI`, `HINHANH`, `SOB`, `PASSWORD`) VALUES
(1, 'admin', 'Hà Nội, Việt Nam', '0901000000', '1764174172746_admin.png', 'ADMIN001', '123456'),
(2, 'user', 'TP Hồ Chí Minh, Việt Nam', '0902000000', '1764174198520_user.png', 'USER001', '123456'),
(3, 'Khách Hàng 41', 'Địa Chỉ 41', '0930820396', NULL, 'KH043', '123456'),
(4, 'Khách Hàng 31', 'Địa Chỉ 31', '0959151222', NULL, 'KH033', '123456'),
(5, 'Khách Hàng 21', 'Địa Chỉ 21', '0993294927', NULL, 'KH023', '123456'),
(6, 'Khách Hàng 11', 'Địa Chỉ 11', '0979020977', NULL, 'KH013', '123456'),
(7, 'Khách Hàng 1', 'Địa Chỉ 1', '0910522010', NULL, 'KH003', '123456'),
(8, 'Khách Hàng 42', 'Địa Chỉ 42', '0979037600', NULL, 'KH044', '123456'),
(9, 'Khách Hàng 32', 'Địa Chỉ 32', '0969527687', NULL, 'KH034', '123456'),
(10, 'Khách Hàng 22', 'Địa Chỉ 22', '0910052564', NULL, 'KH024', '123456'),
(11, 'Khách Hàng 12', 'Địa Chỉ 12', '0984045152', NULL, 'KH014', '123456'),
(12, 'Khách Hàng 2', 'Địa Chỉ 2', '0910864883', NULL, 'KH004', '123456'),
(13, 'Khách Hàng 43', 'Địa Chỉ 43', '0981108741', NULL, 'KH045', '123456'),
(14, 'Khách Hàng 33', 'Địa Chỉ 33', '0969597193', NULL, 'KH035', '123456'),
(15, 'Khách Hàng 23', 'Địa Chỉ 23', '0994659746', NULL, 'KH025', '123456'),
(16, 'Khách Hàng 13', 'Địa Chỉ 13', '0954507156', NULL, 'KH015', '123456'),
(17, 'Khách Hàng 3', 'Địa Chỉ 3', '0978556547', NULL, 'KH005', '123456'),
(18, 'Khách Hàng 44', 'Địa Chỉ 44', '0919261271', NULL, 'KH046', '123456'),
(19, 'Khách Hàng 34', 'Địa Chỉ 34', '0950636714', NULL, 'KH036', '123456'),
(20, 'Khách Hàng 24', 'Địa Chỉ 24', '0985399764', NULL, 'KH026', '123456'),
(21, 'Khách Hàng 14', 'Địa Chỉ 14', '0965088684', NULL, 'KH016', '123456'),
(22, 'Khách Hàng 4', 'Địa Chỉ 4', '0959244129', NULL, 'KH006', '123456'),
(23, 'Khách Hàng 45', 'Địa Chỉ 45', '0990954596', NULL, 'KH047', '123456'),
(24, 'Khách Hàng 35', 'Địa Chỉ 35', '0967040600', NULL, 'KH037', '123456'),
(25, 'Khách Hàng 25', 'Địa Chỉ 25', '0952339216', NULL, 'KH027', '123456'),
(26, 'Khách Hàng 15', 'Địa Chỉ 15', '0950574285', NULL, 'KH017', '123456'),
(27, 'Khách Hàng 5', 'Địa Chỉ 5', '0985853777', NULL, 'KH007', '123456'),
(28, 'Khách Hàng 46', 'Địa Chỉ 46', '0967546038', NULL, 'KH048', '123456'),
(29, 'Khách Hàng 36', 'Địa Chỉ 36', '0970168863', NULL, 'KH038', '123456'),
(30, 'Khách Hàng 26', 'Địa Chỉ 26', '0938206204', NULL, 'KH028', '123456'),
(31, 'Khách Hàng 16', 'Địa Chỉ 16', '0970524434', NULL, 'KH018', '123456'),
(32, 'Khách Hàng 6', 'Địa Chỉ 6', '0928003564', NULL, 'KH008', '123456'),
(33, 'Khách Hàng 47', 'Địa Chỉ 47', '0918444519', NULL, 'KH049', '123456'),
(34, 'Khách Hàng 37', 'Địa Chỉ 37', '0998211908', NULL, 'KH039', '123456'),
(35, 'Khách Hàng 27', 'Địa Chỉ 27', '0925725989', NULL, 'KH029', '123456'),
(36, 'Khách Hàng 17', 'Địa Chỉ 17', '0923994224', NULL, 'KH019', '123456'),
(37, 'Khách Hàng 7', 'Địa Chỉ 7', '0932793155', NULL, 'KH009', '123456'),
(38, 'Khách Hàng 48', 'Địa Chỉ 48', '0981983106', NULL, 'KH050', '123456'),
(39, 'Khách Hàng 38', 'Địa Chỉ 38', '0910153607', NULL, 'KH040', '123456'),
(40, 'Khách Hàng 28', 'Địa Chỉ 28', '0951731045', NULL, 'KH030', '123456'),
(41, 'Khách Hàng 18', 'Địa Chỉ 18', '0944047013', NULL, 'KH020', '123456'),
(42, 'Khách Hàng 8', 'Địa Chỉ 8', '0955041934', NULL, 'KH010', '123456'),
(43, 'Khách Hàng 39', 'Địa Chỉ 39', '0933068634', NULL, 'KH041', '123456'),
(44, 'Khách Hàng 29', 'Địa Chỉ 29', '0990217369', NULL, 'KH031', '123456'),
(45, 'Khách Hàng 19', 'Địa Chỉ 19', '0941880953', NULL, 'KH021', '123456'),
(46, 'Khách Hàng 9', 'Địa Chỉ 9', '0928752660', NULL, 'KH011', '123456'),
(47, 'Khách Hàng 40', 'Địa Chỉ 40', '0910812044', NULL, 'KH042', '123456'),
(48, 'Khách Hàng 30', 'Địa Chỉ 30', '0944344249', NULL, 'KH032', '123456'),
(49, 'Khách Hàng 20', 'Địa Chỉ 20', '0987359913', NULL, 'KH022', '123456'),
(50, 'Khách Hàng 10', 'Địa Chỉ 10', '0993766824', NULL, 'KH012', '123456'),
(53, 'admin12345', 'cần thơ', '0123456789', '1765179674528_pxfuel (12).jpg', 'SOB001', NULL),
(54, 'user123', '', '', NULL, 'user', '123456');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phan_loai`
--

CREATE TABLE `phan_loai` (
  `ID_PHANLOAI` int NOT NULL,
  `TENPHANLOAI` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MOTA` text COLLATE utf8mb4_unicode_ci,
  `HINHANH` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phan_loai`
--

INSERT INTO `phan_loai` (`ID_PHANLOAI`, `TENPHANLOAI`, `MOTA`, `HINHANH`) VALUES
(1, 'Điện Thoại', 'Các loại điện thoại thông minh, điện thoại phổ thông.', NULL),
(2, 'Máy Tính Bảng', 'Các loại máy tính bảng Android, iOS.', NULL),
(3, 'Laptop', 'Máy tính xách tay phục vụ học tập, làm việc, gaming.', NULL),
(4, 'Phụ Kiện', 'Tai nghe, sạc, ốp lưng, chuột, bàn phím.', NULL),
(5, 'Thiết Bị Mạng', 'Router, modem, cáp mạng, thiết bị phát wifi.', NULL),
(6, 'Máy Ảnh', 'Máy ảnh DSLR, Mirrorless và các phụ kiện liên quan.', NULL),
(7, 'Đồ Gia Dụng', 'Thiết bị điện tử phục vụ gia đình: nồi cơm điện, máy hút bụi.', NULL),
(8, 'Linh Kiện PC', 'CPU, RAM, Mainboard, VGA, SSD.', NULL),
(10, 'Bàn Phím', '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuoc_tinh`
--

CREATE TABLE `thuoc_tinh` (
  `ID_THUOCTINH` int NOT NULL,
  `TEN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GIATRI` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HINHANH` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ID_HANGHOA` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thuoc_tinh`
--

INSERT INTO `thuoc_tinh` (`ID_THUOCTINH`, `TEN`, `GIATRI`, `HINHANH`, `ID_HANGHOA`) VALUES
(1, 'Dung Lượng', 'Giá Trị 41', NULL, 41),
(2, 'Dung Lượng', 'Giá Trị 31', NULL, 31),
(4, 'Dung Lượng', 'Giá Trị 11', NULL, 11),
(5, 'Dung Lượng', 'Giá Trị 1', NULL, 1),
(6, 'Kích Thước', 'Giá Trị 42', NULL, 42),
(8, 'Kích Thước', 'Giá Trị 22', NULL, 22),
(9, 'Kích Thước', 'Giá Trị 12', NULL, 12),
(10, 'Kích Thước', 'Giá Trị 2', NULL, 2),
(12, 'Chất Liệu', 'Giá Trị 33', NULL, 33),
(13, 'Chất Liệu', 'Giá Trị 23', NULL, 23),
(14, 'Chất Liệu', 'Giá Trị 13', NULL, 13),
(16, 'Hệ Điều Hành', 'Giá Trị 44', NULL, 44),
(17, 'Hệ Điều Hành', 'Giá Trị 34', NULL, 34),
(18, 'Hệ Điều Hành', 'Giá Trị 24', NULL, 24),
(19, 'Hệ Điều Hành', 'Giá Trị 14', NULL, 14),
(20, 'Hệ Điều Hành', 'Giá Trị 4', NULL, 4),
(21, 'Màu Sắc', 'Giá Trị 45', NULL, 45),
(22, 'Màu Sắc', 'Giá Trị 35', NULL, 35),
(24, 'Màu Sắc', 'Giá Trị 15', NULL, 15),
(25, 'Màu Sắc', 'Giá Trị 5', NULL, 5),
(26, 'Dung Lượng', 'Giá Trị 46', NULL, 46),
(27, 'Dung Lượng', 'Giá Trị 36', NULL, 36),
(28, 'Dung Lượng', 'Giá Trị 26', NULL, 26),
(29, 'Dung Lượng', 'Giá Trị 16', NULL, 16),
(30, 'Dung Lượng', 'Giá Trị 6', NULL, 6),
(31, 'Kích Thước', 'Giá Trị 47', NULL, 47),
(32, 'Kích Thước', 'Giá Trị 37', NULL, 37),
(33, 'Kích Thước', 'Giá Trị 27', NULL, 27),
(34, 'Kích Thước', 'Giá Trị 17', NULL, 17),
(35, 'Kích Thước', 'Giá Trị 7', NULL, 7),
(36, 'Chất Liệu', 'Giá Trị 48', NULL, 48),
(37, 'Chất Liệu', 'Giá Trị 38', NULL, 38),
(38, 'Chất Liệu', 'Giá Trị 28', NULL, 28),
(39, 'Chất Liệu', 'Giá Trị 18', NULL, 18),
(40, 'Chất Liệu', 'Giá Trị 8', NULL, 8),
(41, 'Hệ Điều Hành', 'Giá Trị 49', NULL, 49),
(42, 'Hệ Điều Hành', 'Giá Trị 39', NULL, 39),
(43, 'Hệ Điều Hành', 'Giá Trị 29', NULL, 29),
(44, 'Hệ Điều Hành', 'Giá Trị 19', NULL, 19),
(45, 'Hệ Điều Hành', 'Giá Trị 9', NULL, 9),
(46, 'Màu Sắc', 'Giá Trị 50', NULL, 50),
(47, 'Màu Sắc', 'Giá Trị 40', NULL, 40),
(48, 'Màu Sắc', 'Giá Trị 30', NULL, 30),
(49, 'Màu Sắc', 'Giá Trị 20', NULL, 20),
(50, 'Màu Sắc', 'Giá Trị 10', NULL, 10),
(52, 'Màu Sắc', '100', NULL, 52);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chung_tu_ban`
--
ALTER TABLE `chung_tu_ban`
  ADD PRIMARY KEY (`ID_CTBAN`),
  ADD KEY `ID_KHACHHANG` (`ID_KHACHHANG`);

--
-- Chỉ mục cho bảng `chung_tu_ban_ct`
--
ALTER TABLE `chung_tu_ban_ct`
  ADD PRIMARY KEY (`ID_CT`),
  ADD KEY `ID_HANGHOA` (`ID_HANGHOA`),
  ADD KEY `ID_CTBAN` (`ID_CTBAN`);

--
-- Chỉ mục cho bảng `chung_tu_mua`
--
ALTER TABLE `chung_tu_mua`
  ADD PRIMARY KEY (`ID_CTMUA`),
  ADD KEY `ID_KHACHHANG` (`ID_KHACHHANG`);

--
-- Chỉ mục cho bảng `chung_tu_mua_ct`
--
ALTER TABLE `chung_tu_mua_ct`
  ADD PRIMARY KEY (`ID_CT`),
  ADD KEY `ID_HANGHOA` (`ID_HANGHOA`),
  ADD KEY `ID_CTMUA` (`ID_CTMUA`);

--
-- Chỉ mục cho bảng `don_gia_ban`
--
ALTER TABLE `don_gia_ban`
  ADD PRIMARY KEY (`ID_DONGIA`),
  ADD KEY `ID_HANGHOA` (`ID_HANGHOA`);

--
-- Chỉ mục cho bảng `hang_hoa`
--
ALTER TABLE `hang_hoa`
  ADD PRIMARY KEY (`ID_HANGHOA`),
  ADD KEY `ID_PHANLOAI` (`ID_PHANLOAI`);

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`ID_KHACH_HANG`);

--
-- Chỉ mục cho bảng `phan_loai`
--
ALTER TABLE `phan_loai`
  ADD PRIMARY KEY (`ID_PHANLOAI`);

--
-- Chỉ mục cho bảng `thuoc_tinh`
--
ALTER TABLE `thuoc_tinh`
  ADD PRIMARY KEY (`ID_THUOCTINH`),
  ADD KEY `ID_HANGHOA` (`ID_HANGHOA`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chung_tu_ban`
--
ALTER TABLE `chung_tu_ban`
  MODIFY `ID_CTBAN` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `chung_tu_ban_ct`
--
ALTER TABLE `chung_tu_ban_ct`
  MODIFY `ID_CT` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `chung_tu_mua`
--
ALTER TABLE `chung_tu_mua`
  MODIFY `ID_CTMUA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `chung_tu_mua_ct`
--
ALTER TABLE `chung_tu_mua_ct`
  MODIFY `ID_CT` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `don_gia_ban`
--
ALTER TABLE `don_gia_ban`
  MODIFY `ID_DONGIA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `hang_hoa`
--
ALTER TABLE `hang_hoa`
  MODIFY `ID_HANGHOA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `ID_KHACH_HANG` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `phan_loai`
--
ALTER TABLE `phan_loai`
  MODIFY `ID_PHANLOAI` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `thuoc_tinh`
--
ALTER TABLE `thuoc_tinh`
  MODIFY `ID_THUOCTINH` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `chung_tu_ban`
--
ALTER TABLE `chung_tu_ban`
  ADD CONSTRAINT `chung_tu_ban_ibfk_1` FOREIGN KEY (`ID_KHACHHANG`) REFERENCES `khach_hang` (`ID_KHACH_HANG`);

--
-- Ràng buộc cho bảng `chung_tu_ban_ct`
--
ALTER TABLE `chung_tu_ban_ct`
  ADD CONSTRAINT `chung_tu_ban_ct_ibfk_1` FOREIGN KEY (`ID_HANGHOA`) REFERENCES `hang_hoa` (`ID_HANGHOA`),
  ADD CONSTRAINT `chung_tu_ban_ct_ibfk_2` FOREIGN KEY (`ID_CTBAN`) REFERENCES `chung_tu_ban` (`ID_CTBAN`);

--
-- Ràng buộc cho bảng `chung_tu_mua`
--
ALTER TABLE `chung_tu_mua`
  ADD CONSTRAINT `chung_tu_mua_ibfk_1` FOREIGN KEY (`ID_KHACHHANG`) REFERENCES `khach_hang` (`ID_KHACH_HANG`);

--
-- Ràng buộc cho bảng `chung_tu_mua_ct`
--
ALTER TABLE `chung_tu_mua_ct`
  ADD CONSTRAINT `chung_tu_mua_ct_ibfk_1` FOREIGN KEY (`ID_HANGHOA`) REFERENCES `hang_hoa` (`ID_HANGHOA`),
  ADD CONSTRAINT `chung_tu_mua_ct_ibfk_2` FOREIGN KEY (`ID_CTMUA`) REFERENCES `chung_tu_mua` (`ID_CTMUA`);

--
-- Ràng buộc cho bảng `don_gia_ban`
--
ALTER TABLE `don_gia_ban`
  ADD CONSTRAINT `don_gia_ban_ibfk_1` FOREIGN KEY (`ID_HANGHOA`) REFERENCES `hang_hoa` (`ID_HANGHOA`);

--
-- Ràng buộc cho bảng `hang_hoa`
--
ALTER TABLE `hang_hoa`
  ADD CONSTRAINT `hang_hoa_ibfk_1` FOREIGN KEY (`ID_PHANLOAI`) REFERENCES `phan_loai` (`ID_PHANLOAI`);

--
-- Ràng buộc cho bảng `thuoc_tinh`
--
ALTER TABLE `thuoc_tinh`
  ADD CONSTRAINT `thuoc_tinh_ibfk_1` FOREIGN KEY (`ID_HANGHOA`) REFERENCES `hang_hoa` (`ID_HANGHOA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
