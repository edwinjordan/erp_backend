# Testing Guide - API Hak Akses Menu

## 🚀 Pre-Testing Setup

### 1. Pastikan Tabel Sudah Ada
Jalankan query berikut untuk membuat tabel yang dibutuhkan:

```sql
-- Create tab_akses_mainmenu jika belum ada
CREATE TABLE IF NOT EXISTS `tab_akses_mainmenu` (
  `id_akses_mainmenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `f_deptid` int(11) NOT NULL,
  `r` tinyint(1) DEFAULT 0,
  `c` tinyint(1) DEFAULT 0,
  `u` tinyint(1) DEFAULT 0,
  `d` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_akses_mainmenu`),
  UNIQUE KEY `uk_menu_dept` (`id_menu`,`f_deptid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create tab_akses_submenu jika belum ada
CREATE TABLE IF NOT EXISTS `tab_akses_submenu` (
  `id_akses_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_sub_menu` int(11) NOT NULL,
  `f_deptid` int(11) NOT NULL,
  `r` tinyint(1) DEFAULT 0,
  `c` tinyint(1) DEFAULT 0,
  `u` tinyint(1) DEFAULT 0,
  `d` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_akses_submenu`),
  UNIQUE KEY `uk_submenu_dept` (`id_sub_menu`,`f_deptid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2. Insert Sample Data (Optional)
```sql
-- Sample main menu access
INSERT INTO `tab_akses_mainmenu` (`id_menu`, `f_deptid`, `r`, `c`, `u`, `d`, `created_at`) VALUES
(1, 1, 1, 1, 1, 1, NOW()),
(23, 1, 1, 1, 1, 0, NOW()),
(24, 1, 1, 0, 0, 0, NOW());

-- Sample sub menu access
INSERT INTO `tab_akses_submenu` (`id_sub_menu`, `f_deptid`, `r`, `c`, `u`, `d`, `created_at`) VALUES
(1, 1, 1, 1, 1, 0, NOW()),
(2, 1, 1, 1, 1, 0, NOW()),
(23, 1, 1, 0, 0, 0, NOW());
```

---

## 📝 Test Scenarios

### Base URL
```
http://localhost/viyon_backend/menu/akses
```

---

## ✅ TEST 1: API Connection Test

### Request
```bash
GET http://localhost/viyon_backend/menu/akses/test
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "API Akses Menu is working!",
  "data": {
    "version": "1.0",
    "php_version": "8.1.x",
    "timestamp": "2025-11-11 10:00:00"
  }
}
```

### cURL Command
```bash
curl http://localhost/viyon_backend/menu/akses/test
```

---

## ✅ TEST 2: Get All Menus (Reference Data)

### Request
```bash
GET http://localhost/viyon_backend/menu/akses/menus
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "Data menu berhasil diambil",
  "data": [
    {
      "id_menu": 1,
      "urutan": 1,
      "nm_menu": "Dashboard",
      "link": "/pages/dashboard",
      "title": "",
      "class1": "alert-triangle-outline",
      "class2": null,
      "status": "Y",
      "sts_menu": "W",
      "submenus": []
    },
    {
      "id_menu": 23,
      "urutan": 2,
      "nm_menu": "Master",
      "link": "/pages/master",
      "title": null,
      "class1": "browser-outline",
      "class2": null,
      "status": "Y",
      "sts_menu": "W",
      "submenus": [
        {
          "id_submenu": 1,
          "id_menu": 23,
          "urutan": 1,
          "nm_submenu": "Master Barang",
          "link": "/pages/barang",
          "title": "Master Barang",
          "class1": null,
          "class2": null,
          "status": "Y",
          "sts_menu": "W"
        }
      ]
    }
  ]
}
```

### cURL Command
```bash
curl http://localhost/viyon_backend/menu/akses/menus
```

---

## ✅ TEST 3: Get Main Menu Access

### Request
```bash
GET http://localhost/viyon_backend/menu/akses/mainmenu?f_deptid=1
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "Data akses main menu berhasil diambil",
  "data": [
    {
      "id_akses_mainmenu": 1,
      "id_menu": 1,
      "f_deptid": 1,
      "r": 1,
      "c": 1,
      "u": 1,
      "d": 1,
      "created_at": "2025-11-11 10:00:00",
      "updated_at": null,
      "menu_name": "Dashboard",
      "menu_icon": "alert-triangle-outline",
      "menu_url": "/pages/dashboard"
    }
  ]
}
```

### cURL Command
```bash
curl "http://localhost/viyon_backend/menu/akses/mainmenu?f_deptid=1"
```

---

## ✅ TEST 4: Create Main Menu Access

### Request
```bash
POST http://localhost/viyon_backend/menu/akses/mainmenu
Content-Type: application/json

{
  "id_menu": 24,
  "f_deptid": 1,
  "r": 1,
  "c": 1,
  "u": 1,
  "d": 0
}
```

### Expected Response (201 Created)
```json
{
  "status": true,
  "message": "Akses main menu berhasil ditambahkan",
  "data": {
    "id_menu": 24,
    "f_deptid": 1,
    "r": 1,
    "c": 1,
    "u": 1,
    "d": 0,
    "created_at": "2025-11-11 10:05:00"
  }
}
```

### cURL Command
```bash
curl -X POST http://localhost/viyon_backend/menu/akses/mainmenu \
  -H "Content-Type: application/json" \
  -d '{"id_menu":24,"f_deptid":1,"r":1,"c":1,"u":1,"d":0}'
```

### Expected Error (409 Conflict) - If Already Exists
```json
{
  "status": false,
  "message": "Akses main menu untuk department ini sudah ada"
}
```

---

## ✅ TEST 5: Update Main Menu Access

### Request
```bash
PUT http://localhost/viyon_backend/menu/akses/mainmenu/id/1
Content-Type: application/json

{
  "r": 1,
  "c": 0,
  "u": 1,
  "d": 0
}
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "Akses main menu berhasil diupdate",
  "data": {
    "r": 1,
    "c": 0,
    "u": 1,
    "d": 0,
    "updated_at": "2025-11-11 10:10:00"
  }
}
```

### cURL Command
```bash
curl -X PUT http://localhost/viyon_backend/menu/akses/mainmenu/id/1 \
  -H "Content-Type: application/json" \
  -d '{"r":1,"c":0,"u":1,"d":0}'
```

---

## ✅ TEST 6: Bulk Update Main Menu Access

### Request
```bash
POST http://localhost/viyon_backend/menu/akses/mainmenu/bulk
Content-Type: application/json

{
  "f_deptid": 2,
  "menu_access": [
    {
      "id_menu": 1,
      "r": 1,
      "c": 1,
      "u": 1,
      "d": 1
    },
    {
      "id_menu": 23,
      "r": 1,
      "c": 0,
      "u": 0,
      "d": 0
    },
    {
      "id_menu": 24,
      "r": 1,
      "c": 1,
      "u": 0,
      "d": 0
    }
  ]
}
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "Akses main menu berhasil diupdate secara bulk",
  "data": {
    "total_updated": 3
  }
}
```

### cURL Command
```bash
curl -X POST http://localhost/viyon_backend/menu/akses/mainmenu/bulk \
  -H "Content-Type: application/json" \
  -d '{"f_deptid":2,"menu_access":[{"id_menu":1,"r":1,"c":1,"u":1,"d":1},{"id_menu":23,"r":1,"c":0,"u":0,"d":0}]}'
```

---

## ✅ TEST 7: Get Sub Menu Access

### Request
```bash
GET http://localhost/viyon_backend/menu/akses/submenu?f_deptid=1&id_menu=23
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "Data akses sub menu berhasil diambil",
  "data": [
    {
      "id_akses_submenu": 1,
      "id_sub_menu": 1,
      "f_deptid": 1,
      "r": 1,
      "c": 1,
      "u": 1,
      "d": 0,
      "created_at": "2025-11-11 10:00:00",
      "updated_at": null,
      "submenu_name": "Master Barang",
      "submenu_url": "/pages/barang",
      "id_menu": 23
    }
  ]
}
```

### cURL Command
```bash
curl "http://localhost/viyon_backend/menu/akses/submenu?f_deptid=1&id_menu=23"
```

---

## ✅ TEST 8: Create Sub Menu Access

### Request
```bash
POST http://localhost/viyon_backend/menu/akses/submenu
Content-Type: application/json

{
  "id_sub_menu": 24,
  "f_deptid": 1,
  "r": 1,
  "c": 1,
  "u": 0,
  "d": 0
}
```

### Expected Response (201 Created)
```json
{
  "status": true,
  "message": "Akses sub menu berhasil ditambahkan",
  "data": {
    "id_sub_menu": 24,
    "f_deptid": 1,
    "r": 1,
    "c": 1,
    "u": 0,
    "d": 0,
    "created_at": "2025-11-11 10:15:00"
  }
}
```

### cURL Command
```bash
curl -X POST http://localhost/viyon_backend/menu/akses/submenu \
  -H "Content-Type: application/json" \
  -d '{"id_sub_menu":24,"f_deptid":1,"r":1,"c":1,"u":0,"d":0}'
```

---

## ✅ TEST 9: Get Complete Department Access

### Request
```bash
GET http://localhost/viyon_backend/menu/akses/department/1
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "Data akses department berhasil diambil",
  "data": {
    "f_deptid": 1,
    "mainmenu_access": [
      {
        "id_akses_mainmenu": 1,
        "id_menu": 1,
        "f_deptid": 1,
        "r": 1,
        "c": 1,
        "u": 1,
        "d": 1,
        "menu_name": "Dashboard",
        "menu_icon": "alert-triangle-outline",
        "menu_url": "/pages/dashboard"
      }
    ],
    "submenu_access": [
      {
        "id_akses_submenu": 1,
        "id_sub_menu": 1,
        "f_deptid": 1,
        "r": 1,
        "c": 1,
        "u": 1,
        "d": 0,
        "submenu_name": "Master Barang",
        "submenu_url": "/pages/barang",
        "id_menu": 23
      }
    ]
  }
}
```

### cURL Command
```bash
curl http://localhost/viyon_backend/menu/akses/department/1
```

---

## ✅ TEST 10: Delete Main Menu Access

### Request
```bash
DELETE http://localhost/viyon_backend/menu/akses/mainmenu/id/3
```

### Expected Response (200 OK)
```json
{
  "status": true,
  "message": "Akses main menu dan submenu terkait berhasil dihapus"
}
```

### Expected Error (404 Not Found)
```json
{
  "status": false,
  "message": "Data akses main menu tidak ditemukan"
}
```

### cURL Command
```bash
curl -X DELETE http://localhost/viyon_backend/menu/akses/mainmenu/id/3
```

---

## 🔍 Validation Tests

### TEST 11: Missing Required Fields
```bash
curl -X POST http://localhost/viyon_backend/menu/akses/mainmenu \
  -H "Content-Type: application/json" \
  -d '{"id_menu":1}'
```

**Expected Response (400 Bad Request):**
```json
{
  "status": false,
  "message": "id_menu dan f_deptid harus diisi"
}
```

### TEST 12: Invalid ID
```bash
curl http://localhost/viyon_backend/menu/akses/mainmenu/id/99999
```

**Expected Response (404 Not Found):**
```json
{
  "status": false,
  "message": "Data tidak ditemukan"
}
```

---

## 📊 Testing Checklist

- [ ] API Connection Test
- [ ] Get All Menus
- [ ] Get Main Menu Access (with filter)
- [ ] Get Main Menu Access (no filter)
- [ ] Create Main Menu Access
- [ ] Update Main Menu Access
- [ ] Delete Main Menu Access
- [ ] Bulk Update Main Menu Access
- [ ] Get Sub Menu Access (with filter)
- [ ] Get Sub Menu Access (no filter)
- [ ] Create Sub Menu Access
- [ ] Update Sub Menu Access
- [ ] Delete Sub Menu Access
- [ ] Bulk Update Sub Menu Access
- [ ] Get Complete Department Access
- [ ] Test validation errors
- [ ] Test duplicate entries
- [ ] Test cascade delete

---

## 🐛 Common Issues & Solutions

### Issue 1: "Unable to load language file"
**Solution:** File sudah dibuat di `application/language/english/rest_controller_lang.php`

### Issue 2: "Unknown column 'menu_order'"
**Solution:** Sudah diperbaiki - menggunakan kolom `urutan` yang sebenarnya

### Issue 3: "strtolower() null parameter"
**Solution:** Sudah diperbaiki di `REST_Controller.php` line 1049

### Issue 4: Empty response
**Solution:** Pastikan data sudah ada di tabel `tab_akses_mainmenu` dan `tab_akses_submenu`

---

## 📱 Postman Collection

Import collection berikut ke Postman:

1. Create new Collection: "Viyon Menu Access API"
2. Set variable `base_url`: `http://localhost/viyon_backend/menu/akses`
3. Add requests sesuai test scenarios di atas

---

## ✅ All Tests Passed!

Jika semua test di atas berhasil, API sudah siap untuk digunakan! 🎉
