/*
Navicat MySQL Data Transfer

Source Server         : viyon_db
Source Server Version : 50733
Source Host           : robertlawoffice.com:3306
Source Database       : k4991560_db_backend

Target Server Type    : MYSQL
Target Server Version : 50733
File Encoding         : 65001

Date: 2021-02-26 16:39:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_customer
-- ----------------------------
DROP TABLE IF EXISTS `t_customer`;
CREATE TABLE `t_customer` (
  `fc_kdcust` char(8) NOT NULL,
  `fv_nama` varchar(40) DEFAULT NULL,
  `fv_alamat` varchar(75) DEFAULT NULL,
  `fv_email` varchar(50) DEFAULT NULL,
  `fv_noktp` varchar(100) DEFAULT NULL,
  `fc_jenis` char(1) DEFAULT NULL,
  `fc_hold` char(1) DEFAULT NULL,
  `fc_kota` char(50) DEFAULT NULL,
  `fc_kdtop` char(2) DEFAULT NULL,
  `fc_kdprofesi` char(3) DEFAULT NULL,
  `fc_statusangsur` char(1) DEFAULT NULL,
  `fc_notelp` char(15) DEFAULT NULL,
  PRIMARY KEY (`fc_kdcust`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_customer
-- ----------------------------
INSERT INTO `t_customer` VALUES ('00000001', 'Yordan', 'Sawojajar', 'laksono@mail.com', '1223334555', null, 'N', 'Malang', '01', '001', '', null);
INSERT INTO `t_customer` VALUES ('00000002', 'ahmda', 'malang', 'ahmda@gmail.com', '18989667', null, 'Y', 'malang', '01', '001', 'Y', '084675354123');

-- ----------------------------
-- Table structure for t_departement
-- ----------------------------
DROP TABLE IF EXISTS `t_departement`;
CREATE TABLE `t_departement` (
  `fn_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_deptid` char(2) DEFAULT NULL,
  `f_deptname` char(30) DEFAULT NULL,
  `f_status` char(1) DEFAULT NULL,
  PRIMARY KEY (`fn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_departement
-- ----------------------------
INSERT INTO `t_departement` VALUES ('1', '01', 'ADMIN', 'Y');
INSERT INTO `t_departement` VALUES ('2', '02', 'SALES', 'Y');

-- ----------------------------
-- Table structure for t_diskonperiode
-- ----------------------------
DROP TABLE IF EXISTS `t_diskonperiode`;
CREATE TABLE `t_diskonperiode` (
  `fc_kddiskon` char(40) NOT NULL,
  `fv_nmdiskon` varchar(100) DEFAULT NULL,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fm_diskon_rupiah` double DEFAULT NULL,
  `ff_diskon_persen` char(30) DEFAULT NULL,
  `fd_tanggal_mulai` date DEFAULT NULL,
  `fd_tanggal_selesai` date DEFAULT NULL,
  `fc_sts` char(1) DEFAULT NULL,
  PRIMARY KEY (`fc_kddiskon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_diskonperiode
-- ----------------------------

-- ----------------------------
-- Table structure for t_nomor
-- ----------------------------
DROP TABLE IF EXISTS `t_nomor`;
CREATE TABLE `t_nomor` (
  `kode` char(10) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `awalan` char(15) COLLATE latin1_general_ci DEFAULT NULL,
  `akhiran` char(15) COLLATE latin1_general_ci DEFAULT NULL,
  `panjang` int(4) unsigned DEFAULT '0',
  `nomor` double(4,0) unsigned DEFAULT '0',
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of t_nomor
-- ----------------------------
INSERT INTO `t_nomor` VALUES ('POST', 'PST/', null, '6', '76');

-- ----------------------------
-- Table structure for t_sales
-- ----------------------------
DROP TABLE IF EXISTS `t_sales`;
CREATE TABLE `t_sales` (
  `fc_salesid` char(5) NOT NULL,
  `fv_nama` varchar(50) DEFAULT NULL,
  `fc_email` varchar(100) DEFAULT NULL,
  `fc_hp` varchar(30) DEFAULT NULL,
  `fc_aktif` enum('N','Y') DEFAULT 'Y',
  `fd_tglaktif` date DEFAULT NULL,
  `fd_tgllahir` date DEFAULT NULL,
  `f_deptid` char(2) DEFAULT NULL,
  PRIMARY KEY (`fc_salesid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_sales
-- ----------------------------
INSERT INTO `t_sales` VALUES ('00001', 'cicih', 'edwinea', '087987967089', 'Y', '2021-01-01', '2021-01-07', '02');
INSERT INTO `t_sales` VALUES ('00003', 'saleh', 'saleh@mail.com', '086987576354', 'Y', '2021-01-01', '2021-01-13', '02');
INSERT INTO `t_sales` VALUES ('00004', 'abdulah', 'abdul@mail.com', '089798576354', 'Y', '2021-01-01', '2021-01-08', '02');

-- ----------------------------
-- Table structure for t_setup
-- ----------------------------
DROP TABLE IF EXISTS `t_setup`;
CREATE TABLE `t_setup` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fc_param` char(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fc_kode` char(3) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fc_isi` char(200) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of t_setup
-- ----------------------------
INSERT INTO `t_setup` VALUES ('1', 'BANNER', 'A', 'C:\\MUKA\\temp\\banner.jpg');
INSERT INTO `t_setup` VALUES ('6', 'LVLUSER', 'A', 'ADMINISTRATOR');
INSERT INTO `t_setup` VALUES ('7', 'LVLUSER', 'B', 'OPERATOR');
INSERT INTO `t_setup` VALUES ('9', 'LVLUSER', 'D', 'SUPERVISOR');
INSERT INTO `t_setup` VALUES ('10', 'LVLUSER', 'E', 'MANAJER');
INSERT INTO `t_setup` VALUES ('11', 'MASAKAS', 'A', '201201');
INSERT INTO `t_setup` VALUES ('17', 'PJGKODE', 'A', '6');
INSERT INTO `t_setup` VALUES ('104', 'RESTOMAX', '', '500');
INSERT INTO `t_setup` VALUES ('32', 'WARNAISI', 'A', 'clInfobk');
INSERT INTO `t_setup` VALUES ('33', 'WARNAGRID', 'A', 'clMoneyGreen');
INSERT INTO `t_setup` VALUES ('34', 'FONTISI', 'A', '8');
INSERT INTO `t_setup` VALUES ('35', 'FONTSTYLEISI', '', 'Arial');
INSERT INTO `t_setup` VALUES ('36', 'FONTLABEL', '', '9');
INSERT INTO `t_setup` VALUES ('37', 'FONTSTYLELABEL', '', 'Arial Rounded MT');
INSERT INTO `t_setup` VALUES ('38', 'FONTBOLDLABEL', '', 'Y');
INSERT INTO `t_setup` VALUES ('39', 'DIRDUMP', '', 'D:\\xampp\\mysql\\bin\\mysqldump');
INSERT INTO `t_setup` VALUES ('40', 'DIRTARGET', '', 'D:\\Data');
INSERT INTO `t_setup` VALUES ('102', 'PSW_OPNAME', '', '12345');
INSERT INTO `t_setup` VALUES ('101', 'PRINTPAYMODEL', '', 'C');
INSERT INTO `t_setup` VALUES ('115', 'FULLBARCODE', '', 'Y');
INSERT INTO `t_setup` VALUES ('97', 'KOTA', '', 'KEDIRI');
INSERT INTO `t_setup` VALUES ('47', 'VERSI', '', '1.0');
INSERT INTO `t_setup` VALUES ('48', 'PATHSHARE', '', 'Z:\\Install MUKA.exe');
INSERT INTO `t_setup` VALUES ('49', 'CEKVERSI', '', 'N');
INSERT INTO `t_setup` VALUES ('96', 'NPWP', '', '');
INSERT INTO `t_setup` VALUES ('51', 'DIRPHOTO', '', 'C:\\MUKA\\Photo\\');
INSERT INTO `t_setup` VALUES ('52', 'PHOTO_TINGGI', '', '185');
INSERT INTO `t_setup` VALUES ('53', 'PHOTO_LEBAR', '', '103');
INSERT INTO `t_setup` VALUES ('54', 'DIRTTD', '', 'C:\\MUKA\\Photo\\');
INSERT INTO `t_setup` VALUES ('98', 'PERIODE_SO', '', '20161026');
INSERT INTO `t_setup` VALUES ('56', 'DIRPHOTO2', '', 'Z:\\');
INSERT INTO `t_setup` VALUES ('57', 'DIRTEMP', '', 'C:\\MUKA\\Temp\\');
INSERT INTO `t_setup` VALUES ('95', 'EMAIL', '', 'info@muka.com');
INSERT INTO `t_setup` VALUES ('94', 'HP', '', '');
INSERT INTO `t_setup` VALUES ('93', 'TELP', '', '031-');
INSERT INTO `t_setup` VALUES ('92', 'ALAMAT', '', 'Jl. Kawi Perum Mojorot Regency A-1');
INSERT INTO `t_setup` VALUES ('91', 'NAMA', '', 'PT MUKA');
INSERT INTO `t_setup` VALUES ('90', 'BATASCLOSING', '', '20');
INSERT INTO `t_setup` VALUES ('89', 'PERSENFEE', '', '15');
INSERT INTO `t_setup` VALUES ('88', 'POTONGFEE', '', '2');
INSERT INTO `t_setup` VALUES ('87', 'PSW_VOID', '', '1');
INSERT INTO `t_setup` VALUES ('81', 'WARNAISI', 'A', 'clInfobk');
INSERT INTO `t_setup` VALUES ('82', 'WARNAGRID', 'A', 'clMoneyGreen');
INSERT INTO `t_setup` VALUES ('83', 'FONTISI', 'A', '8');
INSERT INTO `t_setup` VALUES ('84', 'FONTSTYLEISI', 'A', 'Arial');
INSERT INTO `t_setup` VALUES ('85', 'FONTLABEL', 'A', '9');
INSERT INTO `t_setup` VALUES ('86', 'FONTBOLDLABEL', 'A', 'Y');
INSERT INTO `t_setup` VALUES ('105', 'PERSENJUAL', '', '10');
INSERT INTO `t_setup` VALUES ('106', 'REQ_MINDISC', '', '100000000');
INSERT INTO `t_setup` VALUES ('107', 'COST_PACKING', '', '5000');
INSERT INTO `t_setup` VALUES ('108', 'REPRINT_LIMIT', '', '2');
INSERT INTO `t_setup` VALUES ('109', 'JNSCETAK', '', '1');
INSERT INTO `t_setup` VALUES ('110', 'FILESTRUK', '', 'C:\\STRUK.TXT');
INSERT INTO `t_setup` VALUES ('111', 'PERIODEKAS', '', '201508');
INSERT INTO `t_setup` VALUES ('112', 'SALT', '', 'MUKA');
INSERT INTO `t_setup` VALUES ('113', 'SMSFOOT', '', 'Terima Kasih');
INSERT INTO `t_setup` VALUES ('116', 'BK', '', '2');
INSERT INTO `t_setup` VALUES ('117', 'PPN', '', '10');
INSERT INTO `t_setup` VALUES ('126', 'MINBONUS', '1', '20000000');
INSERT INTO `t_setup` VALUES ('127', 'PRESENTASEBONUS', '1', '0,1');
INSERT INTO `t_setup` VALUES ('122', 'BONUS', '1', '1000');
INSERT INTO `t_setup` VALUES ('123', 'BATASBOLOS', '1', '3');
INSERT INTO `t_setup` VALUES ('124', 'DENDABOLOS', '1', '50000');
INSERT INTO `t_setup` VALUES ('125', 'UANGMAKAN', '1', '30000');
INSERT INTO `t_setup` VALUES ('128', 'IPLOGIN', '1', '36.82.100.206');
INSERT INTO `t_setup` VALUES ('129', 'DISPENSASI', '1', '15');
INSERT INTO `t_setup` VALUES ('130', 'JAMMASUK', '1', '07:00:00');
INSERT INTO `t_setup` VALUES ('131', 'JAMKELUAR', '1', '23:00:00');
INSERT INTO `t_setup` VALUES ('132', 'NAMATOKO', '1', 'LARIS 32 KONFEKSI');
INSERT INTO `t_setup` VALUES ('133', 'ALAMATTOKO', '1', 'Jl. Sersan Harun 16 Malang');
INSERT INTO `t_setup` VALUES ('134', 'TELPTOKO', '1', 'Telp. 0341-364762');
INSERT INTO `t_setup` VALUES ('135', 'HOST', '1', 'DESKTOP-OAUQLQF');
INSERT INTO `t_setup` VALUES ('136', 'INTEGRATION', '1', 'WebServiceIntegration');
INSERT INTO `t_setup` VALUES ('137', 'PORT', '1', '96');
INSERT INTO `t_setup` VALUES ('138', 'PRINTERNAME', '1', 'POSTEK C168/200s');

-- ----------------------------
-- Table structure for t_setup_
-- ----------------------------
DROP TABLE IF EXISTS `t_setup_`;
CREATE TABLE `t_setup_` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fc_param` char(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fc_kode` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fc_isi` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of t_setup_
-- ----------------------------
INSERT INTO `t_setup_` VALUES ('1', 'LOGO1', '1', 'fotosetup_1597643035.png');
INSERT INTO `t_setup_` VALUES ('35', 'TELP', '1', '(+6231) 600033878');
INSERT INTO `t_setup_` VALUES ('36', 'EMAIL', '1', 'supporthere@mail.com');
INSERT INTO `t_setup_` VALUES ('37', 'ALAMAT', '1', 'Jl. Jenderal Sudirman Blok J No 3 Bintaro Jaya 15229');
INSERT INTO `t_setup_` VALUES ('39', 'TENTANG', '1', 'ISS didirikan di Kopenhagen pada tahun 1901 dan telah berkembang menjadi salah satu perusahaan jasa layanan terkemuka di dunia dengan pendapatan sebesar DKK 79.9 miliar pada tahun 2017. Rahasia kesuksesan kami terletak pada bagaimana kami menyesuaikan solusi layanan kami dengan kebutuhan klien, bagaimana kami mengelola risiko, dan bagaimana tim yang melibatkan 480.000 karyawan memberikan sentuhan \'the power with the human touch\' dalam segala hal yang kita lakukan.');
INSERT INTO `t_setup_` VALUES ('42', 'KONTAK', '1', 'ISS didirikan di Kopenhagen pada tahun 1901 dan telah berkembang menjadi salah satu perusahaan jasa layanan terkemuka di dunia dengan pendapatan sebesar DKK 79.9 miliar pada tahun 2017. Rahasia kesuksesan kami terletak pada bagaimana kami menyesuaikan solusi layanan kami dengan kebutuhan klien, bagaimana kami mengelola risiko, dan bagaimana tim yang melibatkan 480.000 karyawan memberikan sentuhan \'the power with the human touch\' dalam segala hal yang kita lakukan.');

-- ----------------------------
-- Table structure for t_status
-- ----------------------------
DROP TABLE IF EXISTS `t_status`;
CREATE TABLE `t_status` (
  `fc_param` char(10) COLLATE latin1_general_ci NOT NULL,
  `fc_kode` char(2) COLLATE latin1_general_ci NOT NULL,
  `fv_value` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `fc_link` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `fv_img` text COLLATE latin1_general_ci,
  `fv_ket` text COLLATE latin1_general_ci,
  PRIMARY KEY (`fc_param`,`fc_kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of t_status
-- ----------------------------
INSERT INTO `t_status` VALUES ('STATUS', 'Y', 'Y', null, null, null);
INSERT INTO `t_status` VALUES ('STATUS', 'N', 'N', null, null, null);
INSERT INTO `t_status` VALUES ('JENISKEL', 'L', 'LAKI-LAKI', null, null, null);
INSERT INTO `t_status` VALUES ('JENISKEL', 'P', 'PEREMPUAN', null, null, null);
INSERT INTO `t_status` VALUES ('LEVEL_USER', 'A', 'ADMIN', null, null, null);
INSERT INTO `t_status` VALUES ('LEVEL_USER', 'B', 'SUB ADMIN', null, null, null);
INSERT INTO `t_status` VALUES ('LEVEL_USER', 'C', 'KASIR', null, null, null);
INSERT INTO `t_status` VALUES ('GROUP_LINK', 'A', 'ADMINISTRASI ONLINE', null, null, null);
INSERT INTO `t_status` VALUES ('GROUP_LINK', 'B', 'LEMBAGA ORGANISASI & ORGANISASI DESA', null, null, null);
INSERT INTO `t_status` VALUES ('GROUP_LINK', 'C', 'PENDIDIKAN', null, null, null);
INSERT INTO `t_status` VALUES ('BRANCH', 'A', 'TENTANG WS', '', null, null);
INSERT INTO `t_status` VALUES ('BRANCH', 'B', 'Our Service', 'C_service', null, null);
INSERT INTO `t_status` VALUES ('BRANCH', 'C', 'Certificate Validation', 'C_certificate', null, null);
INSERT INTO `t_status` VALUES ('BRANCH', 'D', 'SQA Procedure', 'C_procedure', null, null);
INSERT INTO `t_status` VALUES ('BRANCH', 'E', 'Customer Information', 'C_customer', null, null);
INSERT INTO `t_status` VALUES ('BRANCH', 'F', 'Contact', 'C_contact', null, null);

-- ----------------------------
-- Table structure for tab_akses_mainmenu
-- ----------------------------
DROP TABLE IF EXISTS `tab_akses_mainmenu`;
CREATE TABLE `tab_akses_mainmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) DEFAULT NULL,
  `f_deptid` char(2) DEFAULT NULL,
  `c` int(11) DEFAULT '0',
  `r` int(11) DEFAULT '0',
  `u` int(11) DEFAULT '0',
  `d` int(11) DEFAULT '0',
  `entry_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entry_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_akses_mainmenu
-- ----------------------------
INSERT INTO `tab_akses_mainmenu` VALUES ('1', '1', '01', '0', '1', '0', '0', '2020-12-26 15:09:42', null);
INSERT INTO `tab_akses_mainmenu` VALUES ('2', '23', '01', '0', '1', '0', '0', '2020-12-26 15:09:43', null);
INSERT INTO `tab_akses_mainmenu` VALUES ('3', '24', '01', '0', '1', '0', '0', '2020-12-26 15:09:43', null);
INSERT INTO `tab_akses_mainmenu` VALUES ('4', '25', '01', '0', '1', '0', '0', '2021-01-07 11:24:32', null);
INSERT INTO `tab_akses_mainmenu` VALUES ('5', '26', '01', '0', '1', '0', '0', '2021-01-07 11:24:38', null);

-- ----------------------------
-- Table structure for tab_akses_submenu
-- ----------------------------
DROP TABLE IF EXISTS `tab_akses_submenu`;
CREATE TABLE `tab_akses_submenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sub_menu` int(11) DEFAULT NULL,
  `f_deptid` char(2) DEFAULT NULL,
  `c` int(11) DEFAULT '0',
  `r` int(11) DEFAULT '0',
  `u` int(11) DEFAULT '0',
  `d` int(11) DEFAULT '0',
  `entry_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entry_user` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_akses_submenu
-- ----------------------------
INSERT INTO `tab_akses_submenu` VALUES ('1', '1', '01', '1', '1', '1', '1', '2021-01-01 13:18:10', null);
INSERT INTO `tab_akses_submenu` VALUES ('2', '2', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('3', '23', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('4', '24', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('5', '25', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('6', '26', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('7', '27', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('8', '28', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('9', '29', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('10', '30', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('11', '31', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('12', '32', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('13', '33', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('14', '34', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('15', '35', '01', '1', '1', '1', '1', '2021-01-01 13:18:11', null);
INSERT INTO `tab_akses_submenu` VALUES ('16', '36', '01', '1', '1', '1', '1', '2021-01-07 09:36:19', null);
INSERT INTO `tab_akses_submenu` VALUES ('17', '37', '01', '1', '1', '1', '1', '2021-01-07 09:36:27', null);
INSERT INTO `tab_akses_submenu` VALUES ('18', '38', '01', '1', '1', '1', '1', '2021-01-07 13:02:32', null);
INSERT INTO `tab_akses_submenu` VALUES ('19', '39', '01', '1', '1', '1', '1', '2021-01-07 13:02:39', null);
INSERT INTO `tab_akses_submenu` VALUES ('20', '40', '01', '1', '1', '1', '1', '2021-01-07 13:04:25', null);
INSERT INTO `tab_akses_submenu` VALUES ('21', '41', '01', '1', '1', '1', '1', '2021-01-07 13:15:33', null);
INSERT INTO `tab_akses_submenu` VALUES ('22', '42', '01', '1', '1', '1', '1', '2021-01-07 13:20:04', null);
INSERT INTO `tab_akses_submenu` VALUES ('23', '43', '01', '1', '1', '1', '1', '2021-01-07 13:20:10', null);
INSERT INTO `tab_akses_submenu` VALUES ('24', '44', '01', '1', '1', '1', '1', '2021-01-26 12:49:12', null);
INSERT INTO `tab_akses_submenu` VALUES ('25', '45', '01', '1', '1', '1', '1', '2021-01-26 12:49:18', null);
INSERT INTO `tab_akses_submenu` VALUES ('26', '46', '01', '1', '1', '1', '1', '2021-01-26 12:49:35', null);
INSERT INTO `tab_akses_submenu` VALUES ('27', '47', '01', '1', '1', '1', '1', '2021-01-26 12:49:43', null);
INSERT INTO `tab_akses_submenu` VALUES ('28', '48', '01', '1', '1', '1', '1', '2021-02-07 14:06:53', null);
INSERT INTO `tab_akses_submenu` VALUES ('29', '49', '01', '1', '1', '1', '1', '2021-02-26 11:35:00', null);

-- ----------------------------
-- Table structure for tb_menu
-- ----------------------------
DROP TABLE IF EXISTS `tb_menu`;
CREATE TABLE `tb_menu` (
  `id_menu` int(5) NOT NULL AUTO_INCREMENT,
  `urutan` int(5) DEFAULT NULL,
  `nm_menu` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `link` varchar(90) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `title` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `class1` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `class2` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sts_menu` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_menu
-- ----------------------------
INSERT INTO `tb_menu` VALUES ('1', '1', 'Dashboard', '/pages/dashboard', '', 'alert-triangle-outline', null, 'Y', 'W');
INSERT INTO `tb_menu` VALUES ('23', '2', 'Master', '/pages/master', null, 'browser-outline', null, 'Y', 'W');
INSERT INTO `tb_menu` VALUES ('24', '3', 'Inventory', '/pages/inventory', null, 'folder-add-outline', null, 'Y', 'W');
INSERT INTO `tb_menu` VALUES ('25', '4', 'Laporan', '/pages/laporan', null, 'file-text-outline', null, 'Y', 'W');
INSERT INTO `tb_menu` VALUES ('26', '5', 'Finance', '/pages/finance', null, 'npm-outline', null, 'Y', 'W');
INSERT INTO `tb_menu` VALUES ('27', '6', 'Android', null, null, null, null, 'Y', 'A');

-- ----------------------------
-- Table structure for tb_submenu
-- ----------------------------
DROP TABLE IF EXISTS `tb_submenu`;
CREATE TABLE `tb_submenu` (
  `id_submenu` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_menu` int(5) NOT NULL,
  `urutan` int(5) DEFAULT NULL,
  `nm_submenu` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `link` varchar(90) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `title` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `class1` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `class2` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sts_menu` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_submenu`,`id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_submenu
-- ----------------------------
INSERT INTO `tb_submenu` VALUES ('1', '23', '1', 'Master Barang', '/pages/barang', 'Master Barang', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('2', '23', '2', 'Master Customer', '/pages/customer', 'Master Customer', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('23', '23', '3', 'Master Sales', '/pages/sales', 'Master Sales', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('24', '23', '4', 'Master Area', '/pages/area', 'Master Area', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('25', '23', '5', 'Master Bank', '/pages/bank', 'Master Bank', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('26', '23', '6', 'Master Brand', '/pages/brand', 'Master Brand', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('27', '23', '7', 'Master Divisi', '/pages/divisi', 'Master Divisi', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('28', '23', '8', 'Master Group', '/pages/group', 'Master Group', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('29', '23', '9', 'Master Karyawan', '/pages/karyawan', 'Master Karyawan', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('30', '23', '10', 'Master Profesi', '/pages/profesi', 'Master Profesi', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('31', '23', '11', 'Master Satuan', '/pages/satuan', 'Master Satuan', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('32', '23', '12', 'Master Supplier', '/pages/supplier', 'Master Supplier', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('33', '23', '13', 'Master Tipe', '/pages/tipe', 'Master Tipe', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('34', '23', '14', 'Master Top', '/pages/top', 'Master Top', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('35', '23', '15', 'Master Wilayah', '/pages/wilayah', 'Master Wilayah', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('36', '23', '16', 'Master Akun', '/pages/akun', 'Master Akun', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('37', '23', '17', 'Master Departement', '/pages/department', 'Master Departemen', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('38', '24', '18', 'Stock Barang', '/pages/stock', 'Stock Barang', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('39', '24', '19', 'Kartu Stock', '/pages/kartu-stock', 'Kartu Stock', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('40', '24', '20', 'Koreksi Stock', '/pages/koreksi-stock', 'Koreksi Stock', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('41', '26', '21', 'Billing', '/pages/billing', 'Billing', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('42', '26', '22', 'Transaksi', '/pages/transaksi', 'Transaksi', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('43', '26', '23', 'Laporan Transaksi', '/pages/laporan_transaksi', 'Laporan Transaksi', null, null, 'Y', 'W');
INSERT INTO `tb_submenu` VALUES ('44', '27', '24', 'Home', 'home', 'Home', null, null, 'Y', 'A');
INSERT INTO `tb_submenu` VALUES ('45', '27', '25', 'Penjualan', 'penjualan', 'Penjualan', null, null, 'Y', 'A');
INSERT INTO `tb_submenu` VALUES ('46', '27', '26', 'Return', 'return', 'Return', null, null, 'Y', 'A');
INSERT INTO `tb_submenu` VALUES ('47', '27', '27', 'Transaksi', 'transaksi', 'Transaksi', null, null, 'Y', 'A');
INSERT INTO `tb_submenu` VALUES ('48', '27', '28', 'Nota', 'nota', 'Nota', null, null, 'Y', 'A');
INSERT INTO `tb_submenu` VALUES ('49', '24', '29', 'Transfer Stock', '/pages/transfer-stock', 'Transfer Stock', null, null, 'Y', 'W');

-- ----------------------------
-- Table structure for td_invoice
-- ----------------------------
DROP TABLE IF EXISTS `td_invoice`;
CREATE TABLE `td_invoice` (
  `fn_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_nofaktur` char(40) DEFAULT NULL,
  `fn_idpenjualan` int(11) DEFAULT NULL,
  `fn_nomor` smallint(6) DEFAULT NULL,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fc_barcode` char(14) DEFAULT NULL,
  `fc_kdtipe` varchar(4) DEFAULT NULL,
  `fc_kdbrand` char(6) DEFAULT NULL,
  `fc_kdgroup` char(3) DEFAULT NULL,
  `fc_kdsatuan` char(2) DEFAULT NULL,
  `fc_sts` char(1) DEFAULT NULL,
  `fn_qty` int(11) DEFAULT NULL,
  `fm_price` double DEFAULT NULL,
  `ff_disc` float(4,2) DEFAULT NULL,
  `fm_disc` double DEFAULT NULL,
  `fm_subtot` double DEFAULT NULL,
  `fc_jns` char(1) DEFAULT NULL,
  `fc_kdarea` char(3) DEFAULT NULL,
  `fc_kddivisi` char(4) DEFAULT NULL,
  `fv_ket` text,
  `fc_kdkaryawan` char(15) DEFAULT NULL,
  PRIMARY KEY (`fn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_invoice
-- ----------------------------
INSERT INTO `td_invoice` VALUES ('1', 'K0001/30/1/21-UM01/001', '1', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('2', 'K0001/30/1/21-UM01/001', '1', null, 'PST04-0007', '5997527131', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('3', 'K0001/30/1/21-UM01/002', '2', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('4', 'K0001/30/1/21-UM01/003', '3', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('5', 'K0001/30/1/21-UM01/004', '4', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('6', 'K0001/30/1/21-UM01/004', '4', null, 'PST04-0007', '5997527131', '01', 'KS', '001', '02', 'I', '2', '180000', null, '0', '360000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('7', 'K0001/30/1/21-UM01/005', '5', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('8', 'K0001/30/1/21-UM01/006', '6', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('9', 'K0001/30/1/21-UM01/007', '7', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('10', 'K0001/30/1/21-UM01/008', '8', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('11', 'K0001/30/1/21-UM01/009', '9', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '180000', null, '0', '180000', null, '001', '001', null, null);
INSERT INTO `td_invoice` VALUES ('12', 'K0001/30/1/21-UM01/010', '10', null, 'PST04-0006', '5997527030', '01', 'KS', '001', '02', 'I', '1', '190000', null, '0', '190000', null, '001', '001', 'Penjualan K0001/30/1/21-UM01/010', null);
INSERT INTO `td_invoice` VALUES ('13', 'K0001/04/2/21-UM01/001', '0', null, 'PST04-0007', '5997527131', '01', 'KS', '001', '02', 'I', '2', '180000', null, '0', '360000', null, '001', '001', 'Penjualan K0001/04/2/21-UM01/001', 'K0001');

-- ----------------------------
-- Table structure for td_kartu_stok
-- ----------------------------
DROP TABLE IF EXISTS `td_kartu_stok`;
CREATE TABLE `td_kartu_stok` (
  `fn_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_kdarea` char(3) DEFAULT NULL,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fd_tgl` date DEFAULT NULL,
  `fc_userinput` char(15) DEFAULT NULL,
  `fn_qty_awal` int(11) DEFAULT NULL,
  `fn_qty_in` int(11) DEFAULT NULL,
  `fn_qty_out` int(11) DEFAULT NULL,
  `fn_qty_sisa` int(11) DEFAULT NULL,
  `fv_ket` text,
  `fc_kddivisi` char(4) DEFAULT NULL,
  PRIMARY KEY (`fn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_kartu_stok
-- ----------------------------
INSERT INTO `td_kartu_stok` VALUES ('1', '001', 'PST04-0006', '2021-01-30', 'K0001', '100', '0', '1', '99', 'Penjualan K0001/30/1/21-UM01/010', '001');
INSERT INTO `td_kartu_stok` VALUES ('2', '001', 'PST04-0006', '2021-02-04', 'K0001', '101', '0', '0', '0', 'Return Penjualan K0001/30/1/21-UM01/005', '001');
INSERT INTO `td_kartu_stok` VALUES ('3', '001', 'PST04-0006', '2021-02-04', 'K0001', '102', '0', '0', '0', 'Return Penjualan K0001/30/1/21-UM01/005', '001');
INSERT INTO `td_kartu_stok` VALUES ('4', '001', 'PST04-0006', '2021-02-04', 'K0001', '103', '0', '0', '0', 'Return Penjualan K0001/30/1/21-UM01/008', '001');
INSERT INTO `td_kartu_stok` VALUES ('5', '001', 'PST04-0007', '2021-02-04', 'K0001', '200', '0', '2', '198', 'Penjualan K0001/04/2/21-UM01/001', '001');
INSERT INTO `td_kartu_stok` VALUES ('6', '001', 'PST04-0006', '2021-02-26', 'K0001', '103', '80', '0', '80', 'Koreksi Stock000001', '001');
INSERT INTO `td_kartu_stok` VALUES ('7', '001', 'PST04-0007', '2021-02-26', 'K0001', '198', '90', '0', '90', 'Koreksi Stock000001', '001');

-- ----------------------------
-- Table structure for td_koreksi_stok
-- ----------------------------
DROP TABLE IF EXISTS `td_koreksi_stok`;
CREATE TABLE `td_koreksi_stok` (
  `fn_iddetail` int(11) NOT NULL AUTO_INCREMENT,
  `fc_notrans` char(15) DEFAULT NULL,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fc_kdtipe` varchar(4) DEFAULT NULL,
  `fc_kdbrand` char(6) DEFAULT NULL,
  `fc_kdgroup` char(3) DEFAULT NULL,
  `fc_kdsatuan` char(2) DEFAULT NULL,
  `fn_qty_sistem` int(11) DEFAULT NULL,
  `fn_qty_aktual` int(11) DEFAULT NULL,
  `fn_qty_selisih` int(11) DEFAULT NULL,
  `fv_ket` text,
  PRIMARY KEY (`fn_iddetail`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_koreksi_stok
-- ----------------------------
INSERT INTO `td_koreksi_stok` VALUES ('1', '000001', 'PST04-0006', '01', 'KS', '001', '02', '103', '80', '-23', '');
INSERT INTO `td_koreksi_stok` VALUES ('2', '000001', 'PST04-0007', '01', 'KS', '001', '02', '198', '90', '-108', '');

-- ----------------------------
-- Table structure for td_returninv
-- ----------------------------
DROP TABLE IF EXISTS `td_returninv`;
CREATE TABLE `td_returninv` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_noretur` char(15) DEFAULT NULL,
  `fn_nomor` mediumint(9) DEFAULT NULL,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fc_kdtipe` char(4) DEFAULT NULL,
  `fc_kdbrand` char(6) DEFAULT NULL,
  `fc_kdgroup` char(3) DEFAULT NULL,
  `fc_kdsatuan` char(2) DEFAULT NULL,
  `fm_price` double DEFAULT NULL,
  `fn_qtyinv` mediumint(7) DEFAULT NULL,
  `fn_qtyretur` mediumint(7) DEFAULT NULL,
  `fn_qtykirim` mediumint(7) DEFAULT NULL,
  `fc_sts` char(1) DEFAULT NULL,
  `fm_subtot` double DEFAULT NULL,
  `fc_kdarea` char(3) DEFAULT NULL,
  `fc_kddivisi` char(4) DEFAULT NULL,
  `fc_kdkaryawan` char(15) DEFAULT NULL,
  `fv_ket` text,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_returninv
-- ----------------------------
INSERT INTO `td_returninv` VALUES ('1', 'RJ21-1', null, 'PST04-0006', '01', 'KS', '001', '02', '180000', null, '1', null, 'I', '180000', '001', '001', 'K0001', 'Return Penjualan K0001/30/1/21-UM01/008');

-- ----------------------------
-- Table structure for td_salesarea
-- ----------------------------
DROP TABLE IF EXISTS `td_salesarea`;
CREATE TABLE `td_salesarea` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_salesid` char(5) DEFAULT NULL,
  `fc_kdarea` char(4) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_salesarea
-- ----------------------------

-- ----------------------------
-- Table structure for td_stock
-- ----------------------------
DROP TABLE IF EXISTS `td_stock`;
CREATE TABLE `td_stock` (
  `fn_detail_stok` int(11) NOT NULL AUTO_INCREMENT,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fc_kdarea` char(3) DEFAULT NULL,
  `fn_qty` smallint(8) DEFAULT NULL,
  `fc_userinput` char(15) DEFAULT NULL,
  `fd_input` date DEFAULT NULL,
  `fc_kddivisi` char(4) DEFAULT NULL,
  PRIMARY KEY (`fn_detail_stok`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_stock
-- ----------------------------
INSERT INTO `td_stock` VALUES ('1', 'PST04-0006', '001', '80', null, null, '001');
INSERT INTO `td_stock` VALUES ('2', 'PST04-0007', '001', '90', null, null, '001');

-- ----------------------------
-- Table structure for td_stok
-- ----------------------------
DROP TABLE IF EXISTS `td_stok`;
CREATE TABLE `td_stok` (
  `fn_detail_stok` int(11) NOT NULL AUTO_INCREMENT,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fc_kdarea` char(3) DEFAULT NULL,
  `fc_kddivisi` char(4) DEFAULT NULL,
  `fn_qty` smallint(8) DEFAULT NULL,
  `fc_userinput` char(15) DEFAULT NULL,
  `fd_input` date DEFAULT NULL,
  `fd_edit` date DEFAULT NULL,
  PRIMARY KEY (`fn_detail_stok`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_stok
-- ----------------------------

-- ----------------------------
-- Table structure for tm_area
-- ----------------------------
DROP TABLE IF EXISTS `tm_area`;
CREATE TABLE `tm_area` (
  `fc_kdarea` char(3) NOT NULL,
  `fc_kdwilayah` char(3) DEFAULT NULL,
  `fv_nmarea` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fc_kdarea`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_area
-- ----------------------------
INSERT INTO `tm_area` VALUES ('001', '01', 'Probolinggo');
INSERT INTO `tm_area` VALUES ('002', '01', 'Pasuruan');

-- ----------------------------
-- Table structure for tm_bank
-- ----------------------------
DROP TABLE IF EXISTS `tm_bank`;
CREATE TABLE `tm_bank` (
  `fc_kdbank` char(2) NOT NULL,
  `fv_bank` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`fc_kdbank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_bank
-- ----------------------------
INSERT INTO `tm_bank` VALUES ('01', 'BCA');

-- ----------------------------
-- Table structure for tm_brand
-- ----------------------------
DROP TABLE IF EXISTS `tm_brand`;
CREATE TABLE `tm_brand` (
  `fc_kdbrand` char(2) NOT NULL,
  `fv_nmbrand` varchar(50) DEFAULT NULL,
  `fc_hold` char(1) DEFAULT NULL,
  PRIMARY KEY (`fc_kdbrand`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_brand
-- ----------------------------
INSERT INTO `tm_brand` VALUES ('KS', 'KST', 'N');

-- ----------------------------
-- Table structure for tm_divisi
-- ----------------------------
DROP TABLE IF EXISTS `tm_divisi`;
CREATE TABLE `tm_divisi` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_kddivisi` char(4) DEFAULT NULL,
  `fv_nmdivisi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_divisi
-- ----------------------------
INSERT INTO `tm_divisi` VALUES ('1', '001', 'Divisi Toko');

-- ----------------------------
-- Table structure for tm_group
-- ----------------------------
DROP TABLE IF EXISTS `tm_group`;
CREATE TABLE `tm_group` (
  `fc_kdgroup` char(4) DEFAULT NULL,
  `fc_kdbrand` char(2) DEFAULT NULL,
  `fv_nmgroup` varchar(50) DEFAULT NULL,
  `fc_hold` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_group
-- ----------------------------
INSERT INTO `tm_group` VALUES ('001', 'KS', 'Baju', 'N');

-- ----------------------------
-- Table structure for tm_invoice
-- ----------------------------
DROP TABLE IF EXISTS `tm_invoice`;
CREATE TABLE `tm_invoice` (
  `fn_idpenjualan` int(11) NOT NULL,
  `fc_nofaktur` char(40) NOT NULL,
  `fc_kdcust` char(8) DEFAULT NULL,
  `fd_tglinput` date DEFAULT NULL,
  `fc_kdkaryawan` char(15) DEFAULT NULL,
  `fc_contacperson` varchar(50) DEFAULT NULL,
  `fv_alamatkirim` varchar(220) DEFAULT NULL,
  `fc_sts` char(1) DEFAULT NULL,
  `fc_ppn` enum('I','E') DEFAULT 'E',
  `ff_ppn` float(4,2) DEFAULT NULL,
  `fm_ppn` double DEFAULT NULL,
  `fn_totqty` int(11) DEFAULT NULL,
  `fm_dpp` double DEFAULT NULL,
  `ff_disc` float(4,2) DEFAULT NULL,
  `fm_disc` double DEFAULT NULL,
  `fm_total` double DEFAULT NULL,
  `fn_print` smallint(6) DEFAULT NULL,
  `fc_userapprove` char(15) DEFAULT NULL,
  `fv_memo` mediumtext,
  `fc_returninv` char(15) DEFAULT NULL,
  `fc_nocn` char(15) DEFAULT NULL,
  `fm_selisih` double DEFAULT NULL,
  `fd_tgljatuh_tempo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_invoice
-- ----------------------------
INSERT INTO `tm_invoice` VALUES ('1', 'K0001/30/1/21-UM01/001', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '380000', null, null, '360000', null, null, '', null, null, '-20000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('2', 'K0001/30/1/21-UM01/002', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '190000', null, null, '180000', null, null, '', null, null, '-10000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('3', 'K0001/30/1/21-UM01/003', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '180000', null, null, '180000', null, null, '', null, null, '0', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('4', 'K0001/30/1/21-UM01/004', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '550000', null, null, '540000', null, null, '', null, null, '10000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('5', 'K0001/30/1/21-UM01/005', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '180000', null, null, '180000', null, null, '', null, null, '0', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('6', 'K0001/30/1/21-UM01/006', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '200000', null, null, '180000', null, null, '', null, null, '20000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('7', 'K0001/30/1/21-UM01/007', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '200000', null, null, '180000', null, null, '', null, null, '20000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('8', 'K0001/30/1/21-UM01/008', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '200000', null, null, '180000', null, null, '', null, null, '20000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('9', 'K0001/30/1/21-UM01/009', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '200000', null, null, '180000', null, null, '', null, null, '20000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('10', 'K0001/30/1/21-UM01/010', 'UMUM', '2021-01-30', 'K0001', '0', '', 'I', 'E', null, null, null, '200000', null, null, '190000', null, null, '', null, null, '10000', '2021-01-30');
INSERT INTO `tm_invoice` VALUES ('0', 'K0001/04/2/21-UM01/001', 'UMUM', '2021-02-04', 'K0001', '0', '', 'I', 'E', null, null, null, '370000', null, null, '360000', null, null, '', null, null, '10000', '2021-02-04');

-- ----------------------------
-- Table structure for tm_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `tm_karyawan`;
CREATE TABLE `tm_karyawan` (
  `fc_kdkaryawan` char(40) NOT NULL,
  `fv_noktp` varchar(40) DEFAULT NULL,
  `fv_username` varchar(40) DEFAULT NULL,
  `fv_password` varchar(40) DEFAULT NULL,
  `fv_view_password` text,
  `fv_nama` varchar(100) DEFAULT NULL,
  `fv_alamat` text,
  `fc_kota` char(40) DEFAULT NULL,
  `fv_notelp` varchar(20) DEFAULT NULL,
  `f_deptid` char(2) DEFAULT NULL,
  `fc_sts` enum('N','Y') DEFAULT NULL,
  `fc_kdarea` char(3) DEFAULT NULL,
  `fc_kddivisi` char(4) DEFAULT NULL,
  PRIMARY KEY (`fc_kdkaryawan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_karyawan
-- ----------------------------
INSERT INTO `tm_karyawan` VALUES ('K0001', '99888999', 'superadmin', 'ac497cfaba23c4184cb03b97e8c51e0a', 'superadmin123', 'edwin', 'malang', 'malang', '087897654867', '01', 'Y', '001', '001');

-- ----------------------------
-- Table structure for tm_koreksi_stok
-- ----------------------------
DROP TABLE IF EXISTS `tm_koreksi_stok`;
CREATE TABLE `tm_koreksi_stok` (
  `fn_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_notrans` char(15) DEFAULT NULL,
  `fd_date` date DEFAULT NULL,
  `fc_kdkaryawan` char(40) DEFAULT NULL,
  `fc_sts` char(1) DEFAULT NULL,
  `fc_kdarea` char(15) DEFAULT NULL,
  `fc_kddivisi` char(15) DEFAULT NULL,
  `fc_periode` char(10) DEFAULT NULL,
  PRIMARY KEY (`fn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_koreksi_stok
-- ----------------------------
INSERT INTO `tm_koreksi_stok` VALUES ('1', '000001', '2021-02-26', 'K0001', '1', '001', '001', '2021');

-- ----------------------------
-- Table structure for tm_profesi
-- ----------------------------
DROP TABLE IF EXISTS `tm_profesi`;
CREATE TABLE `tm_profesi` (
  `fc_kdprofesi` char(3) NOT NULL,
  `fv_nmprofesi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fc_kdprofesi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_profesi
-- ----------------------------
INSERT INTO `tm_profesi` VALUES ('001', 'Pegawai Negeri');

-- ----------------------------
-- Table structure for tm_returninv
-- ----------------------------
DROP TABLE IF EXISTS `tm_returninv`;
CREATE TABLE `tm_returninv` (
  `fc_noretur` char(15) NOT NULL,
  `fc_nofaktur` char(40) DEFAULT NULL,
  `fc_kdcust` char(15) DEFAULT NULL,
  `fd_tglinput` date DEFAULT NULL,
  `fc_sts` char(1) DEFAULT NULL,
  `fm_ppn` double DEFAULT NULL,
  `fm_total` double DEFAULT NULL,
  `fv_note` varchar(250) DEFAULT NULL,
  `fn_print` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`fc_noretur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_returninv
-- ----------------------------
INSERT INTO `tm_returninv` VALUES ('RJ21-1', 'K0001/30/1/21-UM01/008', 'UMUM', '2021-02-04', 'I', null, '180000', 'rusak', null);

-- ----------------------------
-- Table structure for tm_satuan
-- ----------------------------
DROP TABLE IF EXISTS `tm_satuan`;
CREATE TABLE `tm_satuan` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `fc_kdsatuan` char(2) DEFAULT NULL,
  `fv_satuan` varchar(20) DEFAULT NULL,
  `fc_sts` char(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_satuan
-- ----------------------------
INSERT INTO `tm_satuan` VALUES ('3', '02', 'PCS', 'Y');

-- ----------------------------
-- Table structure for tm_stock
-- ----------------------------
DROP TABLE IF EXISTS `tm_stock`;
CREATE TABLE `tm_stock` (
  `fn_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_kdstock` char(15) DEFAULT NULL,
  `fc_barcode` char(13) DEFAULT NULL,
  `fv_namastock` varchar(255) DEFAULT NULL,
  `fc_kdtipe` varchar(4) DEFAULT NULL,
  `fc_kdbrand` char(6) DEFAULT NULL,
  `fc_kdgroup` char(3) DEFAULT NULL,
  `fm_hargajual` double DEFAULT NULL,
  `fm_hargabeli` double DEFAULT NULL,
  `fn_qtymin` smallint(4) DEFAULT NULL,
  `fn_qtymax` smallint(4) DEFAULT NULL,
  `fn_qtyPOmax` smallint(6) DEFAULT NULL,
  `fn_qtyPOmin` smallint(6) DEFAULT NULL,
  `fc_status` char(1) DEFAULT NULL,
  `fd_update` datetime DEFAULT NULL,
  `fd_tglinput` datetime DEFAULT NULL,
  `fc_userinput` char(15) DEFAULT NULL,
  `fv_ket` varchar(50) DEFAULT NULL,
  `ff_disc_persen` char(20) DEFAULT NULL,
  `ff_disc_rupiah` char(20) DEFAULT NULL,
  `fm_ongkir` double DEFAULT NULL,
  `f_foto` text,
  `fc_kdsatuan` char(2) DEFAULT NULL,
  PRIMARY KEY (`fn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_stock
-- ----------------------------
INSERT INTO `tm_stock` VALUES ('1', 'PST04-0006', '5997527030', 'Celana', '01', 'KS', '001', '190000', '90000', '10', '50', '10', '5', 'Y', null, null, null, '<p>Baju</p>\n', '0', '10000', '1000', 'fotobarang_1610110297.jpg', '02');
INSERT INTO `tm_stock` VALUES ('2', 'PST04-0007', '5997527131', 'Baju', '01', 'KS', '001', '190000', '90000', '10', '50', '10', '5', 'Y', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '<p>Baju</p>\n', '0', '10000', '1000', 'fotobarang_1610110297.jpg', '02');

-- ----------------------------
-- Table structure for tm_supplier
-- ----------------------------
DROP TABLE IF EXISTS `tm_supplier`;
CREATE TABLE `tm_supplier` (
  `fc_kdsupp` char(5) NOT NULL,
  `fv_nama` varchar(150) DEFAULT NULL,
  `fv_alamat` varchar(225) DEFAULT NULL,
  `fc_kota` char(20) DEFAULT NULL,
  `fc_telp` char(20) DEFAULT NULL,
  `fc_telp2` char(20) DEFAULT NULL,
  `fc_fax` char(20) DEFAULT NULL,
  `fv_email` varchar(50) DEFAULT NULL,
  `fd_tglinput` date DEFAULT NULL,
  `fc_userinput` char(15) DEFAULT NULL,
  `fc_stssup` char(2) DEFAULT NULL,
  `fc_bank` char(10) DEFAULT NULL,
  `fv_norek` varchar(25) DEFAULT NULL,
  `fc_jenis` char(1) DEFAULT NULL,
  `fm_tottagihan` double DEFAULT NULL,
  `fd_lastpayment` date DEFAULT NULL,
  `fc_kdtop` char(3) DEFAULT NULL,
  PRIMARY KEY (`fc_kdsupp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_supplier
-- ----------------------------

-- ----------------------------
-- Table structure for tm_tipe
-- ----------------------------
DROP TABLE IF EXISTS `tm_tipe`;
CREATE TABLE `tm_tipe` (
  `fc_kdtipe` char(2) DEFAULT NULL,
  `fc_kdgroup` char(3) DEFAULT NULL,
  `fc_kdbrand` char(2) DEFAULT NULL,
  `fv_nmtipe` varchar(50) DEFAULT NULL,
  `fc_hold` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_tipe
-- ----------------------------
INSERT INTO `tm_tipe` VALUES ('01', '001', 'KS', 'S', 'N');

-- ----------------------------
-- Table structure for tm_top
-- ----------------------------
DROP TABLE IF EXISTS `tm_top`;
CREATE TABLE `tm_top` (
  `fn_top` smallint(6) NOT NULL AUTO_INCREMENT,
  `fc_kdtop` char(3) DEFAULT NULL,
  `fv_nmtop` varchar(20) DEFAULT NULL,
  `fn_jumlah` int(20) DEFAULT NULL,
  PRIMARY KEY (`fn_top`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_top
-- ----------------------------
INSERT INTO `tm_top` VALUES ('1', '01', '10 Hari', '10');
INSERT INTO `tm_top` VALUES ('2', '02', '30 Hari', '30');

-- ----------------------------
-- Table structure for tm_wilayah
-- ----------------------------
DROP TABLE IF EXISTS `tm_wilayah`;
CREATE TABLE `tm_wilayah` (
  `fc_kdwilayah` char(3) NOT NULL,
  `fv_nmwilayah` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fc_kdwilayah`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_wilayah
-- ----------------------------
INSERT INTO `tm_wilayah` VALUES ('01', 'Jawa Timur');

-- ----------------------------
-- Table structure for transaksi_akun
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_akun`;
CREATE TABLE `transaksi_akun` (
  `id_transaksi_akun` int(11) NOT NULL AUTO_INCREMENT,
  `nama_transaksi_akun` varchar(75) NOT NULL,
  `debit_transaksi_akun` double NOT NULL,
  `kredit_transaksi_akun` double NOT NULL,
  `saldo_akun` double NOT NULL,
  `status_debit_kredit` int(1) NOT NULL,
  `kelompok_hitungan` int(1) NOT NULL,
  `debit_nutup_harian` double NOT NULL,
  `kredit_nutup_harian` double NOT NULL,
  `saldo_nutup_harian` double NOT NULL,
  `sts` enum('N','Y') DEFAULT 'Y',
  PRIMARY KEY (`id_transaksi_akun`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of transaksi_akun
-- ----------------------------
INSERT INTO `transaksi_akun` VALUES ('1', 'Pembelian', '0', '0', '0', '2', '1', '0', '-21423000', '-21423000', 'Y');
INSERT INTO `transaksi_akun` VALUES ('2', 'Penjualan', '0', '0', '0', '1', '1', '10865844', '0', '-10557156', 'Y');
INSERT INTO `transaksi_akun` VALUES ('3', 'Pendapatan', '0', '0', '0', '1', '1', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('4', 'Return Pembelian', '0', '0', '0', '0', '1', '63000', '0', '-10494156', 'Y');
INSERT INTO `transaksi_akun` VALUES ('5', 'Return Penjualan', '0', '0', '0', '2', '1', '0', '-24000', '-10518156', 'Y');
INSERT INTO `transaksi_akun` VALUES ('6', 'Bad Debt', '0', '0', '0', '0', '1', '0', '0', '-10518156', 'Y');
INSERT INTO `transaksi_akun` VALUES ('7', 'Penggajian Karyawan', '0', '0', '0', '0', '1', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('8', 'Penggajian ', '0', '0', '0', '0', '1', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('9', 'Utang Usaha', '0', '0', '0', '0', '1', '0', '0', '-10518156', 'Y');
INSERT INTO `transaksi_akun` VALUES ('10', 'Piutang Usaha', '0', '0', '0', '0', '1', '0', '0', '-10518156', 'Y');
INSERT INTO `transaksi_akun` VALUES ('11', 'BG SUPPLIER', '0', '0', '0', '1', '1', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('12', 'Penggajian', '0', '0', '0', '0', '1', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('13', 'Toko', '0', '0', '0', '0', '1', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('14', 'Return Toko', '0', '0', '0', '0', '1', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('21', 'BARANG MASUK', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('22', 'LEMBURAN', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('23', 'KOMISI', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('24', 'THR (TUNJANGAN HARI RAYA )', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('25', 'SUMBANGAN', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('26', 'PEMELIHARAAN KENDARAAN XPANDER', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('27', 'ATK', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('28', 'BENSIN', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('29', 'BIAYA LAIN-LAIN', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('30', 'SANGU LUAR KOTA', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('31', 'SALDO AWAL', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('32', 'PERPINDAHAN UANG -', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('33', 'PERPINDAHAN UANG +', '0', '0', '0', '2', '0', '0', '200000', '200000', 'Y');
INSERT INTO `transaksi_akun` VALUES ('35', 'PERPINDAHAN UANG CASH TO BANK +', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('36', 'PERPINDAHAN UANG CASH TO BANK -', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('37', 'KEMBALIAN SANGU', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('38', 'BUNGA', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('39', 'PEMBAYARAN PENJUALAN', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('40', 'BARANG MASUK (PENERIMAAN)', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('41', 'BENSIN', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('42', 'TUNJANGAN HARI RAYA', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('43', 'BMBM BM', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('44', 'PEMELIHARAAN KENDARAAN MIRAGE', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('45', 'RUMAH JAGALAN', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('46', 'TAGIHAN AIR', '0', '0', '0', '1', '0', '-500000', '0', '-500000', 'Y');
INSERT INTO `transaksi_akun` VALUES ('47', 'BONUS ', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('48', 'PIUTANG KAS BON', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('49', 'BAYAR KAS BON', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('50', 'PEMBELIAN AIR MINUM', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('51', 'PEMBELIAN BENSIN GENSET', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('52', 'PEMBELIAN ATK ', '0', '0', '0', '1', '0', '0', '0', '0', 'Y');
INSERT INTO `transaksi_akun` VALUES ('53', '.', '200000', '0', '0', '0', '0', '0', '0', '0', 'N');
INSERT INTO `transaksi_akun` VALUES ('54', 'Beli Bensin', '0', '0', '0', '2', '0', '0', '0', '0', 'Y');

-- ----------------------------
-- Table structure for transaksi_komisi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_komisi`;
CREATE TABLE `transaksi_komisi` (
  `kode_transaksi_komisi` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL,
  `tgl_transaksi_komisi` datetime NOT NULL,
  `debit_transaksi_komisi` double NOT NULL,
  `kredit_transaksi_komisi` double NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  PRIMARY KEY (`kode_transaksi_komisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of transaksi_komisi
-- ----------------------------

-- ----------------------------
-- Table structure for transaksi_master
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_master`;
CREATE TABLE `transaksi_master` (
  `kode_transaksi_master` int(11) NOT NULL AUTO_INCREMENT,
  `faktur_bp` varchar(15) NOT NULL,
  `seri_bg` varchar(100) NOT NULL,
  `no_faktur` varchar(100) NOT NULL,
  `tgl_transaksi_master` datetime NOT NULL,
  `debit_transaksi_master` double NOT NULL,
  `kredit_transaksi_master` double NOT NULL,
  `status_transaksi_master` int(1) NOT NULL,
  `kebijakan_transaksi_master` int(1) NOT NULL,
  `keterangan_transaksi_master` text,
  `kode_nama_keuangan` int(11) NOT NULL,
  `kode_pegawai` int(11) NOT NULL,
  `kode_salesman` int(11) NOT NULL,
  `lampiran` text,
  `tgl_tutup_buku` datetime NOT NULL,
  `tgl_filter_tutup_buku` date NOT NULL,
  `status_beban` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`kode_transaksi_master`),
  FULLTEXT KEY `keterangan_transaksi_master` (`keterangan_transaksi_master`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of transaksi_master
-- ----------------------------
INSERT INTO `transaksi_master` VALUES ('1', 'BJ20-1', '', 'US16/16/6/20-UM40/01', '2020-06-16 04:33:11', '27000', '0', '3', '0', 'pembayaran dengan cash', '7', '15', '0', null, '2020-07-02 13:52:07', '2020-07-02', null);
INSERT INTO `transaksi_master` VALUES ('2', 'BRJ20-1', '', 'RJ20-1', '2020-06-16 04:35:40', '0', '30000', '5', '0', null, '1', '15', '0', null, '0000-00-00 00:00:00', '0000-00-00', null);
INSERT INTO `transaksi_master` VALUES ('3', 'BHP20-1', '', 'FAK024', '2020-06-17 04:13:45', '0', '68000', '1', '0', '', '4', '15', '0', null, '0000-00-00 00:00:00', '0000-00-00', null);
INSERT INTO `transaksi_master` VALUES ('4', 'BJ20-2', '', 'US16/17/6/20-ML16/01', '2020-06-17 10:47:44', '27000', '0', '3', '0', 'pembayaran dengan cash', '7', '15', '0', null, '0000-00-00 00:00:00', '0000-00-00', null);
INSERT INTO `transaksi_master` VALUES ('5', '', '', '41', '2020-06-17 10:53:44', '0', '10000', '7', '0', 'undefined', '7', '15', '0', null, '0000-00-00 00:00:00', '0000-00-00', 'Y');
INSERT INTO `transaksi_master` VALUES ('6', 'BJ20-3', '', 'US16/20/6/20-ML29/01', '2020-06-22 07:39:56', '27000', '0', '3', '0', 'pembayaran dengan cash', '7', '15', '0', null, '0000-00-00 00:00:00', '0000-00-00', null);
INSERT INTO `transaksi_master` VALUES ('7', 'BRJ21-2', '', 'RJ21-3', '2021-02-04 06:23:30', '0', '180000', '5', '0', null, '7', '7', '0', null, '0000-00-00 00:00:00', '0000-00-00', null);
INSERT INTO `transaksi_master` VALUES ('8', 'BRJ21-3', '', 'RJ21-1', '2021-02-04 06:25:35', '0', '180000', '5', '0', null, '7', '7', '0', null, '0000-00-00 00:00:00', '0000-00-00', null);
INSERT INTO `transaksi_master` VALUES ('9', 'BJ21-4', '', 'K0001/04/2/21-UM01/001', '2021-02-04 06:47:22', '370000', '0', '3', '0', 'pembayaran dengan cash', '7', '0', '0', null, '0000-00-00 00:00:00', '0000-00-00', null);

-- ----------------------------
-- Table structure for transaksi_nama_keuangan
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_nama_keuangan`;
CREATE TABLE `transaksi_nama_keuangan` (
  `kode_nama_keuangan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_keuangan` varchar(75) DEFAULT NULL,
  `nomor_keuangan` varchar(50) DEFAULT NULL,
  `atas_nama` varchar(75) DEFAULT NULL,
  `saldo_keuangan` double DEFAULT NULL,
  `alasan_dirubah` text,
  PRIMARY KEY (`kode_nama_keuangan`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of transaksi_nama_keuangan
-- ----------------------------
INSERT INTO `transaksi_nama_keuangan` VALUES ('1', 'BCA REK BARU', '0620500208', 'Saleh Salim Mauladawilah', '1100000', 'rubah');
INSERT INTO `transaksi_nama_keuangan` VALUES ('4', 'BCA REK LAMA', '0620586889', 'SALEH SALIM DAWILAH', '1100000', null);
INSERT INTO `transaksi_nama_keuangan` VALUES ('5', 'BCA SYARIAH ', '0533335550', 'MUHAMMAD ANIS SALEH M', '1100000', null);
INSERT INTO `transaksi_nama_keuangan` VALUES ('6', 'TABUNGAN', '', 'TABUNGAN KASIR', '1100000', null);
INSERT INTO `transaksi_nama_keuangan` VALUES ('7', 'KASIR', '', 'KASIR', '1334000', null);

-- ----------------------------
-- Procedure structure for kartu_approve_pembelian
-- ----------------------------
DROP PROCEDURE IF EXISTS `kartu_approve_pembelian`;
DELIMITER ;;
CREATE DEFINER=`k4991560_backend`@`%` PROCEDURE `kartu_approve_pembelian`(IN p_kode_area VARCHAR (100),
	IN p_kode_stock VARCHAR (100),
	IN p_tgl VARCHAR (100),
	IN p_userid VARCHAR (100),
	IN p_qty_awal VARCHAR (100),
	IN p_qty_in VARCHAR (100),
	IN p_qty_out VARCHAR (100),
	IN p_qty_sisa VARCHAR (100),
	IN p_keterangan VARCHAR (100),
	IN p_kode_divisi VARCHAR (100))
BEGIN
	INSERT INTO td_kartu_stok (
		fc_kdarea,
		fc_kdstock,
		fd_tgl,
		fc_userinput,
		fn_qty_awal,
		fn_qty_in,
		fn_qty_out,
		fn_qty_sisa,
		fv_ket,
		fc_kddivisi
	)
VALUES
	(
		p_kode_area,
		p_kode_stock,
		p_tgl,
		p_userid,
		p_qty_awal,
		p_qty_in,
		p_qty_out,
		p_qty_sisa,
		p_keterangan,
		p_kode_divisi
	);


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `AfterInsertGudangToKS`;
DELIMITER ;;
CREATE TRIGGER `AfterInsertGudangToKS` BEFORE INSERT ON `td_invoice` FOR EACH ROW BEGIN
    DECLARE i INT;
    DECLARE s INT;
		SET i = (SELECT fn_qty FROM td_stock WHERE fc_kdstock = NEW.fc_kdstock AND fc_kdarea = NEW.fc_kdarea AND fc_kddivisi=NEW.fc_kddivisi);
    
	INSERT INTO `td_kartu_stok` SET
    `fc_kdarea`=NEW.fc_kdarea,
    `fc_kddivisi`=NEW.fc_kddivisi,
    `fc_kdstock`=NEW.`fc_kdstock`, 
    `fd_tgl`=now(),
    `fc_userinput`=NEW.fc_kdkaryawan,
    `fn_qty_awal`=i,
    `fn_qty_in`=0,
    `fn_qty_out`=NEW.fn_qty,
    `fn_qty_sisa`=i-NEW.fn_qty,
    `fv_ket`=NEW.fv_ket;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `AfterInsertGoedang`;
DELIMITER ;;
CREATE TRIGGER `AfterInsertGoedang` AFTER INSERT ON `td_invoice` FOR EACH ROW BEGIN
DECLARE i INT;
SET i = (SELECT fn_qty FROM td_stock WHERE fc_kdstock = NEW.fc_kdstock AND fc_kdarea = NEW.fc_kdarea AND fc_kddivisi=NEW.fc_kddivisi);

UPDATE td_stock
SET fn_qty = i - NEW.fn_qty
WHERE fc_kdstock = NEW.fc_kdstock
AND fc_kdarea = NEW.fc_kdarea
AND fc_kddivisi = NEW.fc_kddivisi;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `AfterInsertReturnKS`;
DELIMITER ;;
CREATE TRIGGER `AfterInsertReturnKS` BEFORE INSERT ON `td_returninv` FOR EACH ROW BEGIN
    DECLARE i INT;
    DECLARE s INT;
    SET i = (SELECT fn_qty FROM td_stock WHERE fc_kdstock = NEW.fc_kdstock AND fc_kdarea = NEW.fc_kdarea AND fc_kddivisi=NEW.fc_kddivisi);
    
	INSERT INTO `td_kartu_stok` SET
    `fc_kdarea`=NEW.fc_kdarea,
    `fc_kddivisi`=NEW.fc_kddivisi,
    `fc_kdstock`=NEW.`fc_kdstock`, 
    `fd_tgl`=now(),
    `fc_userinput`=NEW.fc_kdkaryawan,
    `fn_qty_awal`=i,
    `fn_qty_in`=NEW.fn_qtyretur,
    `fn_qty_out`=0,
    `fn_qty_sisa`=i+NEW.fn_qtyretur,
    `fv_ket`=NEW.fv_ket;
END
;;
DELIMITER ;
