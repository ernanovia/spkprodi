-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2019 at 08:53 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spkprodi2`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama_prodi` varchar(225) NOT NULL,
  `akreditasi` varchar(10) NOT NULL,
  `fakultas` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_prodi`, `akreditasi`, `fakultas`) VALUES
(1, 'Bahasa dan Sastra Arab ', 'A', 'ADAB DAN ILMU BUDAYA'),
(2, 'Sejarah dan Kebudayaan Islam ', 'A', 'ADAB DAN ILMU BUDAYA'),
(3, 'Ilmu Perpustakaan,  D3', 'A', 'ADAB DAN ILMU BUDAYA'),
(4, 'Ilmu Perpustakaan,  S1  ', 'A', 'ADAB DAN ILMU BUDAYA'),
(5, 'Sastra Inggris ', 'B', 'ADAB DAN ILMU BUDAYA'),
(6, 'Komunikasi dan Penyiaran Islam', 'A', 'DAKWAH DAN KOMUNIKASI'),
(7, 'Bimbingan dan Konseling Islam', 'A', 'DAKWAH DAN KOMUNIKASI'),
(8, 'Pengembangan Masyarakat Islam', 'A', 'DAKWAH DAN KOMUNIKASI'),
(9, 'Manajemen Dakwah ', 'A', 'DAKWAH DAN KOMUNIKASI'),
(10, 'Ilmu Kesejahteraan Sosial ', 'B', 'DAKWAH DAN KOMUNIKASI'),
(11, 'Al-Ahwal Asy-Syakhsiyah ', 'A', 'SYARIAH DAN HUKUM'),
(12, 'Perbandingan Mazhab', 'A', 'SYARIAH DAN HUKUM'),
(13, 'Siyasah/Hukum Tata Negara', 'A', 'SYARIAH DAN HUKUM'),
(14, 'Muamalat /Hukum Keuangan Syari\'ah', 'A', 'SYARIAH DAN HUKUM'),
(15, 'Ilmu Hukum ', 'A', 'SYARIAH DAN HUKUM'),
(16, 'Pendidikan Agama Islam', 'A', 'ILMU TARBIYAH DAN KEGURUAN'),
(17, 'Pendidikan Bahasa Arab', 'A', 'ILMU TARBIYAH DAN KEGURUAN'),
(18, 'Kependidikan Islam / Manajemen Pendidikan Islam', 'A', 'ILMU TARBIYAH DAN KEGURUAN'),
(19, 'Pend Guru Madrasah Ibtidaiyah', 'A', 'ILMU TARBIYAH DAN KEGURUAN'),
(20, 'Pend Guru Raudhatul Athfal', 'C', 'ILMU TARBIYAH DAN KEGURUAN'),
(21, 'Filsafat Agama', 'A', 'USHULUDDIN DAN PEMIKIRAN ISLAM'),
(22, 'Perbandingan Agama ', 'A', 'USHULUDDIN DAN PEMIKIRAN ISLAM'),
(23, 'Ilmu Al-Qur\'an dan Tafsir', 'A', 'USHULUDDIN DAN PEMIKIRAN ISLAM'),
(24, 'Sosiologi Agama ', 'B', 'USHULUDDIN DAN PEMIKIRAN ISLAM'),
(25, 'Ilmu Hadis', 'B', 'USHULUDDIN DAN PEMIKIRAN ISLAM'),
(26, 'Matematika ', 'B', 'SAINS DAN TEKNOLOGI'),
(27, 'Fisika  ', 'B', 'SAINS DAN TEKNOLOGI'),
(28, 'Kimia ', 'B', 'SAINS DAN TEKNOLOGI'),
(29, 'Biologi ', 'B', 'SAINS DAN TEKNOLOGI'),
(30, 'Teknik Industri ', 'B', 'SAINS DAN TEKNOLOGI'),
(31, 'Teknik Informatika ', 'B', 'SAINS DAN TEKNOLOGI'),
(32, 'Pendidikan Matematika ', 'B', 'SAINS DAN TEKNOLOGI'),
(33, 'Pendidikan Fisika ', 'B', 'SAINS DAN TEKNOLOGI'),
(34, 'Pendidikan Kimia ', 'A', 'SAINS DAN TEKNOLOGI'),
(35, 'Pendidikan Biologi ', 'B', 'SAINS DAN TEKNOLOGI'),
(36, 'Ilmu Komunikasi', 'B', 'SAINS DAN TEKNOLOGI'),
(37, 'Psikologi ', 'B', 'ILMU SOSIAL DAN HUMANIORA'),
(38, 'Sosiologi ', 'B', 'ILMU SOSIAL DAN HUMANIORA'),
(39, 'Ekonomi Syari\'ah', 'B', 'EKONOMI DAN BISNIS ISLAM'),
(40, 'Perbankan Syari\'ah', 'B', 'EKONOMI DAN BISNIS ISLAM'),
(41, 'Keuangan Syari\'ah', 'B', 'EKONOMI DAN BISNIS ISLAM'),
(42, 'Akuntansi Syari\'ah', 'C', 'EKONOMI DAN BISNIS ISLAM');

-- --------------------------------------------------------

--
-- Table structure for table `analisis_sensitifitas`
--

CREATE TABLE `analisis_sensitifitas` (
  `id` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `saw` int(11) DEFAULT NULL,
  `saw_sen` int(11) DEFAULT NULL,
  `topsis` int(11) DEFAULT NULL,
  `topsis_sen` int(11) DEFAULT NULL,
  `saw_topsis` int(11) DEFAULT NULL,
  `saw_topsis_sen` int(11) DEFAULT NULL,
  `nilai_saw` double DEFAULT NULL,
  `nilai_saw_sen` double DEFAULT NULL,
  `nilai_topsis` double DEFAULT NULL,
  `nilai_topsis_sen` double DEFAULT NULL,
  `nilai_saw_topsis` double DEFAULT NULL,
  `nilai_saw_topsis_sen` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `analisis_sensitifitas`
--

INSERT INTO `analisis_sensitifitas` (`id`, `id_alternatif`, `saw`, `saw_sen`, `topsis`, `topsis_sen`, `saw_topsis`, `saw_topsis_sen`, `nilai_saw`, `nilai_saw_sen`, `nilai_topsis`, `nilai_topsis_sen`, `nilai_saw_topsis`, `nilai_saw_topsis_sen`) VALUES
(4, 1, 10, 10, 10, 10, 10, 10, 0.56, 0.78, 0.32196809651231, 0.38076075868695, 0.51787997811553, 0.37733896738654),
(5, 2, 18, 13, 18, 18, 13, 13, 0.52, 0.76, 0.30020425615716, 0.35242525366672, 0.4939015319192, 0.35508711933988),
(6, 3, 26, 21, 25, 26, 23, 21, 0.44, 0.72, 0.27393248712235, 0.3070437402166, 0.44948974278318, 0.32156448889298),
(7, 4, 20, 20, 23, 23, 20, 20, 0.48, 0.74, 0.28340362468279, 0.32588558716903, 0.47013189239861, 0.33530507603353),
(8, 5, 36, 36, 41, 41, 36, 41, 0.36, 0.48, 0.17140021403248, 0.18619206527478, 0.29705041592171, 0.14903375323213),
(9, 6, 11, 11, 11, 11, 11, 11, 0.56, 0.78, 0.32196809651231, 0.38076075868695, 0.51787997811553, 0.37733896738654),
(10, 7, 14, 14, 19, 19, 14, 14, 0.52, 0.76, 0.30020425615716, 0.35242525366672, 0.4939015319192, 0.35508711933988),
(11, 8, 21, 18, 24, 24, 18, 18, 0.48, 0.74, 0.28340362468279, 0.32588558716903, 0.47013189239861, 0.33530507603353),
(12, 9, 23, 19, 22, 22, 19, 19, 0.48, 0.74, 0.28340362468279, 0.32588558716903, 0.47013189239861, 0.33530507603353),
(13, 10, 40, 40, 37, 37, 40, 37, 0.36, 0.48, 0.17140021403248, 0.18619206527478, 0.29705041592171, 0.14903375323213),
(14, 11, 15, 15, 20, 15, 15, 15, 0.52, 0.76, 0.30020425615716, 0.35242525366672, 0.4939015319192, 0.35508711933988),
(15, 12, 16, 16, 16, 16, 16, 16, 0.52, 0.76, 0.30020425615716, 0.35242525366672, 0.4939015319192, 0.35508711933988),
(16, 13, 17, 17, 17, 17, 17, 17, 0.52, 0.76, 0.30020425615716, 0.35242525366672, 0.4939015319192, 0.35508711933988),
(17, 14, 9, 9, 9, 9, 9, 9, 0.56, 0.78, 0.32196809651231, 0.38076075868695, 0.51787997811553, 0.37733896738654),
(18, 15, 1, 1, 1, 1, 1, 1, 0.96, 0.98, 0.86354223167998, 0.57978842805737, 0.9031700110106, 0.48147548011818),
(19, 16, 5, 5, 8, 8, 6, 5, 0.6, 0.8, 0.34598072328409, 0.40691518786902, 0.53912703272959, 0.39915721461751),
(20, 17, 12, 12, 12, 12, 12, 12, 0.56, 0.78, 0.32196809651231, 0.38076075868695, 0.51787997811553, 0.37733896738654),
(21, 18, 7, 7, 13, 13, 7, 7, 0.56, 0.78, 0.32196809651231, 0.38076075868695, 0.51787997811553, 0.37733896738654),
(22, 19, 8, 8, 14, 14, 8, 8, 0.56, 0.78, 0.32196809651231, 0.38076075868695, 0.51787997811553, 0.37733896738654),
(23, 20, 41, 41, 34, 27, 41, 26, 0.32, 0.26, 0.19411615150229, 0.24753740913699, 0.25728427444747, 0.20998078424976),
(24, 21, 4, 4, 6, 4, 4, 4, 0.66, 0.83, 0.4161882853171, 0.47844264435719, 0.59268475398619, 0.40123394131228),
(25, 22, 6, 6, 7, 5, 5, 6, 0.58, 0.79, 0.4097476531406, 0.47107663035505, 0.55303769162223, 0.3823330480035),
(26, 23, 3, 3, 3, 3, 3, 3, 0.78, 0.89, 0.57788398841942, 0.54738811527662, 0.71462117803913, 0.45110125528063),
(27, 24, 13, 22, 5, 7, 21, 23, 0.55, 0.575, 0.42027008966367, 0.42247878100693, 0.46497644566588, 0.27207860934554),
(28, 25, 25, 26, 26, 25, 26, 27, 0.44, 0.52, 0.27361580599979, 0.32523465957037, 0.35190560474626, 0.19947874986536),
(29, 26, 34, 34, 35, 35, 34, 35, 0.36, 0.48, 0.17140021403248, 0.18619206527478, 0.29705041592171, 0.14903375323213),
(30, 27, 35, 35, 36, 36, 35, 36, 0.36, 0.48, 0.17140021403248, 0.18619206527478, 0.29705041592171, 0.14903375323213),
(31, 28, 32, 32, 32, 33, 32, 33, 0.4, 0.5, 0.20363757801813, 0.2329690784993, 0.33549437839914, 0.19478327914876),
(32, 29, 28, 28, 28, 29, 28, 29, 0.4, 0.5, 0.20363757801813, 0.2329690784993, 0.33549437839914, 0.19478327914876),
(33, 30, 30, 30, 30, 31, 30, 31, 0.4, 0.5, 0.20363757801813, 0.2329690784993, 0.33549437839914, 0.19478327914876),
(34, 31, 24, 25, 21, 20, 24, 25, 0.48, 0.54, 0.29941929170614, 0.34565803873771, 0.39285714285714, 0.2315427193727),
(35, 32, 27, 27, 27, 28, 27, 28, 0.4, 0.5, 0.20363757801813, 0.2329690784993, 0.33549437839914, 0.19478327914876),
(36, 33, 37, 37, 38, 38, 37, 38, 0.36, 0.48, 0.17140021403248, 0.18619206527478, 0.29705041592171, 0.14903375323213),
(37, 34, 2, 2, 2, 2, 2, 2, 0.85, 0.925, 0.71243237180157, 0.57333267061582, 0.78650461458574, 0.45385579244943),
(38, 35, 29, 29, 29, 30, 29, 30, 0.4, 0.5, 0.20363757801813, 0.2329690784993, 0.33549437839914, 0.19478327914876),
(39, 36, 22, 24, 15, 21, 25, 24, 0.48, 0.54, 0.3082741469435, 0.34539559370802, 0.37555293500684, 0.23338064487774),
(40, 37, 31, 31, 31, 32, 31, 32, 0.4, 0.5, 0.20363757801813, 0.2329690784993, 0.33549437839914, 0.19478327914876),
(41, 38, 19, 23, 4, 6, 22, 22, 0.51, 0.555, 0.44420929841042, 0.44005915254735, 0.46225858682058, 0.28647232580651),
(42, 39, 38, 38, 39, 39, 38, 39, 0.36, 0.48, 0.17140021403248, 0.18619206527478, 0.29705041592171, 0.14903375323213),
(43, 40, 39, 39, 40, 40, 39, 40, 0.36, 0.48, 0.17140021403248, 0.18619206527478, 0.29705041592171, 0.14903375323213),
(44, 41, 33, 33, 33, 34, 33, 34, 0.4, 0.5, 0.20363757801813, 0.2329690784993, 0.33549437839914, 0.19478327914876),
(45, 42, 42, 42, 42, 42, 42, 42, 0.24, 0.22, 0.072612192162367, 0.16955708685109, 0.09890772657493, 0.13992289236082);

-- --------------------------------------------------------

--
-- Table structure for table `bobot_alternatif`
--

CREATE TABLE `bobot_alternatif` (
  `id_bobot_alter` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `bobot_alternatif` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bobot_alternatif`
--

INSERT INTO `bobot_alternatif` (`id_bobot_alter`, `id_alternatif`, `id_kriteria`, `bobot_alternatif`) VALUES
(1, 1, 1, 0.4),
(2, 1, 2, 0.5),
(3, 1, 3, 0.1),
(4, 1, 4, 0.1),
(5, 1, 5, 0.1),
(6, 2, 1, 0.3),
(7, 2, 2, 0.5),
(8, 2, 3, 0.1),
(9, 2, 4, 0.1),
(10, 2, 5, 0.1),
(11, 3, 1, 0.1),
(12, 3, 2, 0.5),
(13, 3, 3, 0.1),
(14, 3, 4, 0.1),
(15, 3, 5, 0.1),
(16, 4, 1, 0.2),
(17, 4, 2, 0.5),
(18, 4, 3, 0.1),
(19, 4, 4, 0.1),
(20, 4, 5, 0.1),
(21, 5, 1, 0.2),
(22, 5, 2, 0.3),
(23, 5, 3, 0.1),
(24, 5, 4, 0.1),
(25, 5, 5, 0.1),
(26, 6, 1, 0.4),
(27, 6, 2, 0.5),
(28, 6, 3, 0.1),
(29, 6, 4, 0.1),
(30, 6, 5, 0.1),
(31, 7, 1, 0.3),
(32, 7, 2, 0.5),
(33, 7, 3, 0.1),
(34, 7, 4, 0.1),
(35, 7, 5, 0.1),
(36, 8, 1, 0.2),
(37, 8, 2, 0.5),
(38, 8, 3, 0.1),
(39, 8, 4, 0.1),
(40, 8, 5, 0.1),
(41, 9, 1, 0.2),
(42, 9, 2, 0.5),
(43, 9, 3, 0.1),
(44, 9, 4, 0.1),
(45, 9, 5, 0.1),
(46, 10, 1, 0.2),
(47, 10, 2, 0.3),
(48, 10, 3, 0.1),
(49, 10, 4, 0.1),
(50, 10, 5, 0.1),
(51, 11, 1, 0.3),
(52, 11, 2, 0.5),
(53, 11, 3, 0.1),
(54, 11, 4, 0.1),
(55, 11, 5, 0.1),
(56, 12, 1, 0.3),
(57, 12, 2, 0.5),
(58, 12, 3, 0.1),
(59, 12, 4, 0.1),
(60, 12, 5, 0.1),
(61, 13, 1, 0.3),
(62, 13, 2, 0.5),
(63, 13, 3, 0.1),
(64, 13, 4, 0.1),
(65, 13, 5, 0.1),
(66, 14, 1, 0.4),
(67, 14, 2, 0.5),
(68, 14, 3, 0.1),
(69, 14, 4, 0.1),
(70, 14, 5, 0.1),
(71, 15, 1, 0.5),
(72, 15, 2, 0.5),
(73, 15, 3, 0.3),
(74, 15, 4, 0.5),
(75, 15, 5, 0.5),
(76, 16, 1, 0.5),
(77, 16, 2, 0.5),
(78, 16, 3, 0.1),
(79, 16, 4, 0.1),
(80, 16, 5, 0.1),
(81, 17, 1, 0.4),
(82, 17, 2, 0.5),
(83, 17, 3, 0.1),
(84, 17, 4, 0.1),
(85, 17, 5, 0.1),
(86, 18, 1, 0.4),
(87, 18, 2, 0.5),
(88, 18, 3, 0.1),
(89, 18, 4, 0.1),
(90, 18, 5, 0.1),
(91, 19, 1, 0.4),
(92, 19, 2, 0.5),
(93, 19, 3, 0.1),
(94, 19, 4, 0.1),
(95, 19, 5, 0.1),
(96, 20, 1, 0.4),
(97, 20, 2, 0.1),
(98, 20, 3, 0.1),
(99, 20, 4, 0.1),
(100, 20, 5, 0.1),
(101, 21, 1, 0.4),
(102, 21, 2, 0.5),
(103, 21, 3, 0.2),
(104, 21, 4, 0.2),
(105, 21, 5, 0.2),
(106, 22, 1, 0.2),
(107, 22, 2, 0.5),
(108, 22, 3, 0.1),
(109, 22, 4, 0.1),
(110, 22, 5, 0.3),
(111, 23, 1, 0.5),
(112, 23, 2, 0.5),
(113, 23, 3, 0.1),
(114, 23, 4, 0.2),
(115, 23, 5, 0.4),
(116, 24, 1, 0.3),
(117, 24, 2, 0.3),
(118, 24, 3, 0.2),
(119, 24, 4, 0.2),
(120, 24, 5, 0.3),
(121, 25, 1, 0.2),
(122, 25, 2, 0.3),
(123, 25, 3, 0.1),
(124, 25, 4, 0.2),
(125, 25, 5, 0.2),
(126, 26, 1, 0.2),
(127, 26, 2, 0.3),
(128, 26, 3, 0.1),
(129, 26, 4, 0.1),
(130, 26, 5, 0.1),
(131, 27, 1, 0.2),
(132, 27, 2, 0.3),
(133, 27, 3, 0.1),
(134, 27, 4, 0.1),
(135, 27, 5, 0.1),
(136, 28, 1, 0.3),
(137, 28, 2, 0.3),
(138, 28, 3, 0.1),
(139, 28, 4, 0.1),
(140, 28, 5, 0.1),
(141, 29, 1, 0.3),
(142, 29, 2, 0.3),
(143, 29, 3, 0.1),
(144, 29, 4, 0.1),
(145, 29, 5, 0.1),
(146, 30, 1, 0.3),
(147, 30, 2, 0.3),
(148, 30, 3, 0.1),
(149, 30, 4, 0.1),
(150, 30, 5, 0.1),
(151, 31, 1, 0.3),
(152, 31, 2, 0.3),
(153, 31, 3, 0.1),
(154, 31, 4, 0.2),
(155, 31, 5, 0.2),
(156, 32, 1, 0.3),
(157, 32, 2, 0.3),
(158, 32, 3, 0.1),
(159, 32, 4, 0.1),
(160, 32, 5, 0.1),
(161, 33, 1, 0.2),
(162, 33, 2, 0.3),
(163, 33, 3, 0.1),
(164, 33, 4, 0.1),
(165, 33, 5, 0.1),
(166, 34, 1, 0.4),
(167, 34, 2, 0.5),
(168, 34, 3, 0.5),
(169, 34, 4, 0.3),
(170, 34, 5, 0.4),
(171, 35, 1, 0.3),
(172, 35, 2, 0.3),
(173, 35, 3, 0.1),
(174, 35, 4, 0.1),
(175, 35, 5, 0.1),
(176, 36, 1, 0.3),
(177, 36, 2, 0.3),
(178, 36, 3, 0.5),
(179, 36, 4, 0.1),
(180, 36, 5, 0.1),
(181, 37, 1, 0.3),
(182, 37, 2, 0.3),
(183, 37, 3, 0.1),
(184, 37, 4, 0.1),
(185, 37, 5, 0.1),
(186, 38, 1, 0.2),
(187, 38, 2, 0.3),
(188, 38, 3, 0.1),
(189, 38, 4, 0.1),
(190, 38, 5, 0.4),
(191, 39, 1, 0.2),
(192, 39, 2, 0.3),
(193, 39, 3, 0.1),
(194, 39, 4, 0.1),
(195, 39, 5, 0.1),
(196, 40, 1, 0.2),
(197, 40, 2, 0.3),
(198, 40, 3, 0.1),
(199, 40, 4, 0.1),
(200, 40, 5, 0.1),
(201, 41, 1, 0.3),
(202, 41, 2, 0.3),
(203, 41, 3, 0.1),
(204, 41, 4, 0.1),
(205, 41, 5, 0.1),
(206, 42, 1, 0.2),
(207, 42, 2, 0.1),
(208, 42, 3, 0.1),
(209, 42, 4, 0.1),
(210, 42, 5, 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_sensitifitas`
--

CREATE TABLE `hasil_sensitifitas` (
  `id` int(11) NOT NULL,
  `perubahan` varchar(100) NOT NULL,
  `saw` int(11) NOT NULL,
  `topsis` int(11) NOT NULL,
  `saw_topsis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_sensitifitas`
--

INSERT INTO `hasil_sensitifitas` (`id`, `perubahan`, `saw`, `topsis`, `saw_topsis`) VALUES
(1, 'akreditasi ditambah 1', 9, 17, 22);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `tipe_kriteria` varchar(10) NOT NULL,
  `bobot_kriteria` double NOT NULL,
  `bobot_stvitas` double NOT NULL,
  `status` enum('ya','tidak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `tipe_kriteria`, `bobot_kriteria`, `bobot_stvitas`, `status`) VALUES
(1, 'dukungan', 'benefit', 0.2, 0.2, 'ya'),
(2, 'akreditasi', 'benefit', 0.3, 1.3, 'ya'),
(3, 'kerjasama nasional', 'benefit', 0.1, 0.1, 'ya'),
(4, 'kerjasama internasional', 'benefit', 0.15, 0.15, 'ya'),
(5, 'penghargaan', 'benefit', 0.25, 0.25, 'ya');

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id_subkrit` int(11) NOT NULL,
  `nama_subkrit` varchar(50) NOT NULL,
  `interval_subkrit` varchar(50) NOT NULL,
  `nilai_subkrit` double NOT NULL,
  `id_kriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`id_subkrit`, `nama_subkrit`, `interval_subkrit`, `nilai_subkrit`, `id_kriteria`) VALUES
(1, 'Sangat baik', '355-343', 0.5, 1),
(2, 'baik', '342-330', 0.4, 1),
(3, 'cukup baik', '329-317', 0.3, 1),
(4, 'kurang baik', '316-304', 0.2, 1),
(5, 'sangat kurang baik', '303-0', 0.1, 1),
(6, 'A', '500', 0.5, 2),
(7, 'B', '300', 0.3, 2),
(8, 'C', '100', 0.1, 2),
(9, 'Sangat baik', '9900-7920', 0.5, 3),
(10, 'baik', '7919-5939', 0.4, 3),
(11, 'cukup baik', '5938-3958', 0.3, 3),
(12, 'kurang baik', '3957-1977', 0.2, 3),
(13, 'sangat kurang baik', '1976-0', 0.1, 3),
(14, 'Sangat baik', '6800-5440', 0.5, 4),
(15, 'baik', '5439-4079', 0.4, 4),
(16, 'cukup baik', '4078-2718', 0.3, 4),
(17, 'kurang baik', '2717-1357', 0.2, 4),
(18, 'sangat kurang baik', '1356-0', 0.1, 4),
(19, 'Sangat baik', '14350-11480', 0.5, 5),
(20, 'baik', '11479-8609', 0.4, 5),
(21, 'cukup baik', '8608-5738', 0.3, 5),
(22, 'kurang baik', '5737-2867', 0.2, 5),
(23, 'sangat kurang baik', '2866-0', 0.1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `analisis_sensitifitas`
--
ALTER TABLE `analisis_sensitifitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bobot_alternatif`
--
ALTER TABLE `bobot_alternatif`
  ADD PRIMARY KEY (`id_bobot_alter`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `hasil_sensitifitas`
--
ALTER TABLE `hasil_sensitifitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id_subkrit`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `analisis_sensitifitas`
--
ALTER TABLE `analisis_sensitifitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `bobot_alternatif`
--
ALTER TABLE `bobot_alternatif`
  MODIFY `id_bobot_alter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT for table `hasil_sensitifitas`
--
ALTER TABLE `hasil_sensitifitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id_subkrit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
