-- SQL Script untuk tabel Hak Akses Menu
-- Database: Viyon Backend
-- Created: 2025-11-11

-- ============================================
-- Table structure for tb_menu
-- ============================================
CREATE TABLE IF NOT EXISTS `tb_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(100) NOT NULL,
  `menu_icon` varchar(50) DEFAULT NULL,
  `menu_url` varchar(200) DEFAULT NULL,
  `menu_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table structure for tb_submenu
-- ============================================
CREATE TABLE IF NOT EXISTS `tb_submenu` (
  `id_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `submenu_name` varchar(100) NOT NULL,
  `submenu_url` varchar(200) DEFAULT NULL,
  `submenu_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_submenu`),
  KEY `fk_submenu_menu` (`id_menu`),
  CONSTRAINT `fk_submenu_menu` FOREIGN KEY (`id_menu`) REFERENCES `tb_menu` (`id_menu`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table structure for tab_akses_mainmenu
-- ============================================
CREATE TABLE IF NOT EXISTS `tab_akses_mainmenu` (
  `id_akses_mainmenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `f_deptid` int(11) NOT NULL COMMENT 'Department/User ID',
  `r` tinyint(1) DEFAULT 0 COMMENT 'Read permission',
  `c` tinyint(1) DEFAULT 0 COMMENT 'Create permission',
  `u` tinyint(1) DEFAULT 0 COMMENT 'Update permission',
  `d` tinyint(1) DEFAULT 0 COMMENT 'Delete permission',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_akses_mainmenu`),
  UNIQUE KEY `uk_menu_dept` (`id_menu`,`f_deptid`),
  KEY `idx_deptid` (`f_deptid`),
  KEY `fk_akses_mainmenu` (`id_menu`),
  CONSTRAINT `fk_akses_mainmenu` FOREIGN KEY (`id_menu`) REFERENCES `tb_menu` (`id_menu`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table structure for tab_akses_submenu
-- ============================================
CREATE TABLE IF NOT EXISTS `tab_akses_submenu` (
  `id_akses_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_sub_menu` int(11) NOT NULL,
  `f_deptid` int(11) NOT NULL COMMENT 'Department/User ID',
  `r` tinyint(1) DEFAULT 0 COMMENT 'Read permission',
  `c` tinyint(1) DEFAULT 0 COMMENT 'Create permission',
  `u` tinyint(1) DEFAULT 0 COMMENT 'Update permission',
  `d` tinyint(1) DEFAULT 0 COMMENT 'Delete permission',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_akses_submenu`),
  UNIQUE KEY `uk_submenu_dept` (`id_sub_menu`,`f_deptid`),
  KEY `idx_deptid` (`f_deptid`),
  KEY `fk_akses_submenu` (`id_sub_menu`),
  CONSTRAINT `fk_akses_submenu` FOREIGN KEY (`id_sub_menu`) REFERENCES `tb_submenu` (`id_submenu`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Sample data for testing
-- ============================================

-- Insert sample main menus
INSERT INTO `tb_menu` (`menu_name`, `menu_icon`, `menu_url`, `menu_order`, `is_active`, `created_at`) VALUES
('Dashboard', 'fa-dashboard', 'dashboard', 1, 1, NOW()),
('Master Data', 'fa-database', '#', 2, 1, NOW()),
('Transaksi', 'fa-shopping-cart', '#', 3, 1, NOW()),
('Laporan', 'fa-file-text', '#', 4, 1, NOW()),
('Pengaturan', 'fa-cog', '#', 5, 1, NOW());

-- Insert sample sub menus
INSERT INTO `tb_submenu` (`id_menu`, `submenu_name`, `submenu_url`, `submenu_order`, `is_active`, `created_at`) VALUES
(2, 'Barang', 'barang/index', 1, 1, NOW()),
(2, 'Pelanggan', 'pelanggan/index', 2, 1, NOW()),
(2, 'Supplier', 'supplier/index', 3, 1, NOW()),
(3, 'Penjualan', 'penjualan/index', 1, 1, NOW()),
(3, 'Pembelian', 'pembelian/index', 2, 1, NOW()),
(4, 'Laporan Penjualan', 'laporan/penjualan', 1, 1, NOW()),
(4, 'Laporan Pembelian', 'laporan/pembelian', 2, 1, NOW()),
(5, 'User', 'user/index', 1, 1, NOW()),
(5, 'Menu', 'menu/index', 2, 1, NOW());

-- Insert sample main menu access for department 1
INSERT INTO `tab_akses_mainmenu` (`id_menu`, `f_deptid`, `r`, `c`, `u`, `d`, `created_at`) VALUES
(1, 1, 1, 1, 1, 1, NOW()),
(2, 1, 1, 1, 1, 0, NOW()),
(3, 1, 1, 1, 0, 0, NOW());

-- Insert sample sub menu access for department 1
INSERT INTO `tab_akses_submenu` (`id_sub_menu`, `f_deptid`, `r`, `c`, `u`, `d`, `created_at`) VALUES
(1, 1, 1, 1, 1, 0, NOW()),
(2, 1, 1, 1, 1, 0, NOW()),
(3, 1, 1, 0, 0, 0, NOW()),
(4, 1, 1, 1, 1, 1, NOW()),
(5, 1, 1, 1, 0, 0, NOW());

-- ============================================
-- Queries untuk testing
-- ============================================

-- View all main menu access for department 1
-- SELECT * FROM tab_akses_mainmenu WHERE f_deptid = 1;

-- View all sub menu access for department 1
-- SELECT * FROM tab_akses_submenu WHERE f_deptid = 1;

-- View complete access configuration
-- SELECT 
--     m.menu_name,
--     am.r as read_access,
--     am.c as create_access,
--     am.u as update_access,
--     am.d as delete_access
-- FROM tab_akses_mainmenu am
-- JOIN tb_menu m ON m.id_menu = am.id_menu
-- WHERE am.f_deptid = 1;
