# API Documentation - Hak Akses Menu

API untuk mengatur hak akses (CRUD) pada tabel `tb_menu`, `tb_submenu`, `tab_akses_mainmenu`, dan `tab_akses_submenu`.

## Base URL
```
http://your-domain/menu/akses
```

## Response Format
Semua response menggunakan format JSON:
```json
{
  "status": true/false,
  "message": "Pesan response",
  "data": {} // optional
}
```

## Permission Flags
- `r` = Read (1 = allowed, 0 = denied)
- `c` = Create (1 = allowed, 0 = denied)
- `u` = Update (1 = allowed, 0 = denied)
- `d` = Delete (1 = allowed, 0 = denied)

---

## 1. MAIN MENU ACCESS API

### 1.1 Get All Main Menu Access
Mengambil semua data akses main menu, bisa difilter berdasarkan department.

**Endpoint:** `GET /menu/akses/mainmenu`

**Query Parameters:**
- `f_deptid` (optional) - Filter by department ID

**Request Examples:**
```bash
# Get all main menu access
GET /menu/akses/mainmenu

# Get main menu access for specific department
GET /menu/akses/mainmenu?f_deptid=1
```

**Response Success (200):**
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
      "d": 0,
      "menu_name": "Dashboard",
      "menu_icon": "fa-dashboard",
      "menu_url": "dashboard",
      "created_at": "2025-11-11 10:00:00",
      "updated_at": null
    }
  ]
}
```

---

### 1.2 Get Main Menu Access by ID
Mengambil detail akses main menu berdasarkan ID.

**Endpoint:** `GET /menu/akses/mainmenu/id/{id}`

**Request Example:**
```bash
GET /menu/akses/mainmenu/id/1
```

**Response Success (200):**
```json
{
  "status": true,
  "message": "Data akses main menu berhasil diambil",
  "data": {
    "id_akses_mainmenu": 1,
    "id_menu": 1,
    "f_deptid": 1,
    "r": 1,
    "c": 1,
    "u": 1,
    "d": 0,
    "menu_name": "Dashboard",
    "menu_icon": "fa-dashboard",
    "menu_url": "dashboard"
  }
}
```

**Response Error (404):**
```json
{
  "status": false,
  "message": "Data tidak ditemukan"
}
```

---

### 1.3 Create Main Menu Access
Membuat akses main menu baru untuk department tertentu.

**Endpoint:** `POST /menu/akses/mainmenu`

**Request Body:**
```json
{
  "id_menu": 1,
  "f_deptid": 1,
  "r": 1,
  "c": 1,
  "u": 1,
  "d": 0
}
```

**Response Success (201):**
```json
{
  "status": true,
  "message": "Akses main menu berhasil ditambahkan",
  "data": {
    "id_menu": 1,
    "f_deptid": 1,
    "r": 1,
    "c": 1,
    "u": 1,
    "d": 0,
    "created_at": "2025-11-11 10:00:00"
  }
}
```

**Response Error (400):**
```json
{
  "status": false,
  "message": "id_menu dan f_deptid harus diisi"
}
```

**Response Error (409):**
```json
{
  "status": false,
  "message": "Akses main menu untuk department ini sudah ada"
}
```

---

### 1.4 Update Main Menu Access
Mengupdate akses main menu berdasarkan ID.

**Endpoint:** `PUT /menu/akses/mainmenu/id/{id}`

**Request Body:**
```json
{
  "r": 1,
  "c": 0,
  "u": 1,
  "d": 0
}
```

**Response Success (200):**
```json
{
  "status": true,
  "message": "Akses main menu berhasil diupdate",
  "data": {
    "r": 1,
    "c": 0,
    "u": 1,
    "d": 0,
    "updated_at": "2025-11-11 10:30:00"
  }
}
```

**Response Error (404):**
```json
{
  "status": false,
  "message": "Data akses main menu tidak ditemukan"
}
```

---

### 1.5 Delete Main Menu Access
Menghapus akses main menu berdasarkan ID (akan menghapus juga akses submenu terkait).

**Endpoint:** `DELETE /menu/akses/mainmenu/id/{id}`

**Response Success (200):**
```json
{
  "status": true,
  "message": "Akses main menu dan submenu terkait berhasil dihapus"
}
```

**Response Error (404):**
```json
{
  "status": false,
  "message": "Data akses main menu tidak ditemukan"
}
```

---

### 1.6 Bulk Update Main Menu Access
Mengupdate seluruh akses main menu untuk department secara sekaligus (menghapus data lama dan insert data baru).

**Endpoint:** `POST /menu/akses/mainmenu/bulk`

**Request Body:**
```json
{
  "f_deptid": 1,
  "menu_access": [
    {
      "id_menu": 1,
      "r": 1,
      "c": 1,
      "u": 1,
      "d": 1
    },
    {
      "id_menu": 2,
      "r": 1,
      "c": 0,
      "u": 0,
      "d": 0
    },
    {
      "id_menu": 3,
      "r": 1,
      "c": 1,
      "u": 0,
      "d": 0
    }
  ]
}
```

**Response Success (200):**
```json
{
  "status": true,
  "message": "Akses main menu berhasil diupdate secara bulk",
  "data": {
    "total_updated": 3
  }
}
```

---

## 2. SUB MENU ACCESS API

### 2.1 Get All Sub Menu Access
Mengambil semua data akses sub menu, bisa difilter berdasarkan department dan/atau main menu.

**Endpoint:** `GET /menu/akses/submenu`

**Query Parameters:**
- `f_deptid` (optional) - Filter by department ID
- `id_menu` (optional) - Filter by main menu ID

**Request Examples:**
```bash
# Get all sub menu access
GET /menu/akses/submenu

# Get sub menu access for specific department
GET /menu/akses/submenu?f_deptid=1

# Get sub menu access for specific department and main menu
GET /menu/akses/submenu?f_deptid=1&id_menu=1
```

**Response Success (200):**
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
      "submenu_name": "User Management",
      "submenu_url": "user/list",
      "id_menu": 1,
      "created_at": "2025-11-11 10:00:00",
      "updated_at": null
    }
  ]
}
```

---

### 2.2 Get Sub Menu Access by ID
Mengambil detail akses sub menu berdasarkan ID.

**Endpoint:** `GET /menu/akses/submenu/id/{id}`

**Response Success (200):**
```json
{
  "status": true,
  "message": "Data akses sub menu berhasil diambil",
  "data": {
    "id_akses_submenu": 1,
    "id_sub_menu": 1,
    "f_deptid": 1,
    "r": 1,
    "c": 1,
    "u": 1,
    "d": 0,
    "submenu_name": "User Management",
    "submenu_url": "user/list",
    "id_menu": 1
  }
}
```

---

### 2.3 Create Sub Menu Access
Membuat akses sub menu baru untuk department tertentu.

**Endpoint:** `POST /menu/akses/submenu`

**Request Body:**
```json
{
  "id_sub_menu": 1,
  "f_deptid": 1,
  "r": 1,
  "c": 1,
  "u": 1,
  "d": 0
}
```

**Response Success (201):**
```json
{
  "status": true,
  "message": "Akses sub menu berhasil ditambahkan",
  "data": {
    "id_sub_menu": 1,
    "f_deptid": 1,
    "r": 1,
    "c": 1,
    "u": 1,
    "d": 0,
    "created_at": "2025-11-11 10:00:00"
  }
}
```

---

### 2.4 Update Sub Menu Access
Mengupdate akses sub menu berdasarkan ID.

**Endpoint:** `PUT /menu/akses/submenu/id/{id}`

**Request Body:**
```json
{
  "r": 1,
  "c": 0,
  "u": 1,
  "d": 0
}
```

**Response Success (200):**
```json
{
  "status": true,
  "message": "Akses sub menu berhasil diupdate",
  "data": {
    "r": 1,
    "c": 0,
    "u": 1,
    "d": 0,
    "updated_at": "2025-11-11 10:30:00"
  }
}
```

---

### 2.5 Delete Sub Menu Access
Menghapus akses sub menu berdasarkan ID.

**Endpoint:** `DELETE /menu/akses/submenu/id/{id}`

**Response Success (200):**
```json
{
  "status": true,
  "message": "Akses sub menu berhasil dihapus"
}
```

---

### 2.6 Bulk Update Sub Menu Access
Mengupdate seluruh akses sub menu untuk department secara sekaligus.

**Endpoint:** `POST /menu/akses/submenu/bulk`

**Request Body:**
```json
{
  "f_deptid": 1,
  "submenu_access": [
    {
      "id_sub_menu": 1,
      "r": 1,
      "c": 1,
      "u": 1,
      "d": 1
    },
    {
      "id_sub_menu": 2,
      "r": 1,
      "c": 0,
      "u": 0,
      "d": 0
    }
  ]
}
```

**Response Success (200):**
```json
{
  "status": true,
  "message": "Akses sub menu berhasil diupdate secara bulk",
  "data": {
    "total_updated": 2
  }
}
```

---

## 3. HELPER ENDPOINTS

### 3.1 Get All Available Menus
Mengambil semua menu dan submenu yang tersedia (untuk referensi saat set akses).

**Endpoint:** `GET /menu/akses/menus`

**Response Success (200):**
```json
{
  "status": true,
  "message": "Data menu berhasil diambil",
  "data": [
    {
      "id_menu": 1,
      "menu_name": "Dashboard",
      "menu_icon": "fa-dashboard",
      "menu_url": "dashboard",
      "menu_order": 1,
      "submenus": [
        {
          "id_submenu": 1,
          "id_menu": 1,
          "submenu_name": "Analytics",
          "submenu_url": "dashboard/analytics",
          "submenu_order": 1
        }
      ]
    }
  ]
}
```

---

### 3.2 Get Complete Access for Department
Mengambil semua konfigurasi akses (main menu dan sub menu) untuk department tertentu.

**Endpoint:** `GET /menu/akses/department/{f_deptid}`

**Request Example:**
```bash
GET /menu/akses/department/1
```

**Response Success (200):**
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
        "d": 0,
        "menu_name": "Dashboard"
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
        "submenu_name": "Analytics"
      }
    ]
  }
}
```

---

## Testing dengan cURL

### Create Main Menu Access
```bash
curl -X POST http://your-domain/menu/akses/mainmenu \
  -H "Content-Type: application/json" \
  -d '{
    "id_menu": 1,
    "f_deptid": 1,
    "r": 1,
    "c": 1,
    "u": 1,
    "d": 0
  }'
```

### Update Main Menu Access
```bash
curl -X PUT http://your-domain/menu/akses/mainmenu/id/1 \
  -H "Content-Type: application/json" \
  -d '{
    "r": 1,
    "c": 0,
    "u": 1,
    "d": 0
  }'
```

### Delete Main Menu Access
```bash
curl -X DELETE http://your-domain/menu/akses/mainmenu/id/1
```

### Bulk Update Main Menu Access
```bash
curl -X POST http://your-domain/menu/akses/mainmenu/bulk \
  -H "Content-Type: application/json" \
  -d '{
    "f_deptid": 1,
    "menu_access": [
      {"id_menu": 1, "r": 1, "c": 1, "u": 1, "d": 1},
      {"id_menu": 2, "r": 1, "c": 0, "u": 0, "d": 0}
    ]
  }'
```

---

## Testing dengan Postman

1. **Import** collection dengan endpoints di atas
2. Set **Base URL**: `http://your-domain/menu/akses`
3. Set **Headers**: 
   - `Content-Type: application/json`
   - `Authorization: Bearer YOUR_TOKEN` (jika menggunakan auth)

---

## Database Schema Reference

### Table: tab_akses_mainmenu
```sql
- id_akses_mainmenu (PK)
- id_menu (FK ke tb_menu)
- f_deptid (department/user ID)
- r (read permission: 0/1)
- c (create permission: 0/1)
- u (update permission: 0/1)
- d (delete permission: 0/1)
- created_at
- updated_at
```

### Table: tab_akses_submenu
```sql
- id_akses_submenu (PK)
- id_sub_menu (FK ke tb_submenu)
- f_deptid (department/user ID)
- r (read permission: 0/1)
- c (create permission: 0/1)
- u (update permission: 0/1)
- d (delete permission: 0/1)
- created_at
- updated_at
```

---

## Error Codes

- **200**: Success
- **201**: Created
- **400**: Bad Request (parameter tidak lengkap)
- **404**: Not Found (data tidak ditemukan)
- **409**: Conflict (data sudah ada)
- **500**: Internal Server Error

---

## Notes

1. Saat menghapus akses main menu, semua akses submenu terkait juga akan dihapus otomatis
2. Bulk update akan menghapus semua data lama untuk department tersebut dan menggantinya dengan data baru
3. Field `created_at` dan `updated_at` diset otomatis oleh system
4. CORS sudah diaktifkan untuk semua endpoint
