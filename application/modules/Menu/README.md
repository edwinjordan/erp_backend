# Quick Start - API Hak Akses Menu

## 📋 Prerequisites

1. **Database Setup**
   - Import file `database_schema.sql` ke database Anda
   - Pastikan tabel sudah terisi dengan sample data

2. **File yang Sudah Dibuat:**
   - ✅ `controllers/Akses.php` - REST API Controller
   - ✅ `models/M_akses.php` - Data Model
   - ✅ `language/english/rest_controller_lang.php` - Language file
   - ✅ `config/rest.php` - REST configuration

## 🚀 Testing API

### 1. Test Connection
```bash
GET http://localhost/viyon_backend/menu/akses/test
```

Response:
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

### 2. Get All Menus (Reference)
```bash
GET http://localhost/viyon_backend/menu/akses/menus
```

### 3. Create Main Menu Access
```bash
POST http://localhost/viyon_backend/menu/akses/mainmenu
Content-Type: application/json

{
  "id_menu": 1,
  "f_deptid": 1,
  "r": 1,
  "c": 1,
  "u": 1,
  "d": 0
}
```

### 4. Get Department Access
```bash
GET http://localhost/viyon_backend/menu/akses/department/1
```

## 📚 Complete Documentation

Lihat file `API_DOCUMENTATION.md` untuk dokumentasi lengkap semua endpoint.

## 🔑 Permission Flags

- `r` = Read (1 = allowed, 0 = denied)
- `c` = Create (1 = allowed, 0 = denied)
- `u` = Update (1 = allowed, 0 = denied)
- `d` = Delete (1 = allowed, 0 = denied)

## 🛠️ Troubleshooting

### Error: "Unable to load language file"
✅ **FIXED** - File `rest_controller_lang.php` sudah dibuat

### Error: "Class 'REST_Controller' not found"
- Pastikan file `application/libraries/REST_Controller.php` ada
- Pastikan file `application/libraries/Format.php` ada

### Error: "Table doesn't exist"
- Import file `database_schema.sql` ke database Anda

## 📞 Support

Jika ada error atau pertanyaan, silakan hubungi developer.
