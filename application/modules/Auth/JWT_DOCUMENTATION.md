# JWT Authentication Documentation

## Overview

JWT (JSON Web Token) authentication has been added to the Viyon Backend application. This provides a secure, stateless authentication mechanism for both web and mobile applications.

## Installation

JWT library (Firebase PHP-JWT) has been installed via Composer:
```bash
composer require firebase/php-jwt
```

## Configuration

Configuration file: `application/config/jwt.php`

Key settings:
- `jwt_secret_key`: Secret key for encoding/decoding tokens (CHANGE THIS IN PRODUCTION!)
- `jwt_algorithm`: Algorithm used for JWT (default: HS256)
- `jwt_token_expiration`: Access token expiration (default: 3600 seconds / 1 hour)
- `jwt_refresh_token_expiration`: Refresh token expiration (default: 604800 seconds / 7 days)

## API Endpoints

### 1. Login (Web)

**Endpoint:** `POST /auth/login`

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123",
  "area": "01",
  "divisi": "DIV01"
}
```

**Response (Success):**
```json
{
  "success": "success",
  "data": {
    "fv_userid": "USR001",
    "fv_username": "user@example.com",
    "fv_nama": "John Doe",
    "f_deptid": "01"
  },
  "area": "01",
  "divisi": "DIV01",
  "nama_area": "Jakarta",
  "nama_divisi": "IT Division",
  "mainmenu": [...],
  "submenu": [...],
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

**Response (Failed):**
```json
{
  "success": "failed",
  "message": "Invalid credentials"
}
```

---

### 2. Login Android

**Endpoint:** `POST /auth/login_android`

**Request Body:**
```json
{
  "username": "user@example.com",
  "password": "password123",
  "area": "01",
  "divisi": "DIV01"
}
```

**Response (Success):**
```json
{
  "success": "success",
  "data": {
    "fv_userid": "USR001",
    "fv_username": "user@example.com",
    "fv_nama": "John Doe",
    "f_deptid": "01"
  },
  "area": "01",
  "divisi": "DIV01",
  "submenu": [...],
  "posisi": {...},
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

---

### 3. Refresh Token

**Endpoint:** `POST /auth/refresh_token`

**Request Body:**
```json
{
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

**Response (Success):**
```json
{
  "success": "success",
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

**Response (Failed):**
```json
{
  "success": "failed",
  "message": "Invalid or expired refresh token"
}
```

---

### 4. Validate Token

**Endpoint:** `POST /auth/validate_token`

**Headers:**
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

**Response (Success):**
```json
{
  "success": "success",
  "valid": true,
  "user": {
    "fv_userid": "USR001",
    "fv_username": "user@example.com",
    "fv_nama": "John Doe",
    "f_deptid": "01",
    "fc_kdarea": "01",
    "fc_kddivisi": "DIV01"
  },
  "expires_at": "2025-11-11 18:30:45"
}
```

**Response (Failed):**
```json
{
  "success": "failed",
  "valid": false,
  "message": "Invalid or expired token"
}
```

---

### 5. Get Current User

**Endpoint:** `POST /auth/me`

**Headers:**
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

**Response (Success):**
```json
{
  "success": "success",
  "user": {
    "fv_userid": "USR001",
    "fv_username": "user@example.com",
    "fv_nama": "John Doe",
    "f_deptid": "01",
    "fc_kdarea": "01",
    "fc_kddivisi": "DIV01",
    "fv_nmarea": "Jakarta",
    "fv_nmdivisi": "IT Division"
  }
}
```

**Response (Failed - 401):**
```json
{
  "success": "failed",
  "message": "Unauthorized - Invalid or expired token"
}
```

---

## Using JWT Tokens

### 1. Frontend (Web/Mobile)

#### Store Tokens
After successful login, store both tokens:
- `access_token`: Use for API requests (expires in 1 hour)
- `refresh_token`: Use to get new access token (expires in 7 days)

```javascript
// JavaScript example
localStorage.setItem('access_token', response.access_token);
localStorage.setItem('refresh_token', response.refresh_token);
```

#### Make Authenticated Requests
Include access token in Authorization header:

```javascript
// JavaScript example
fetch('http://localhost/viyon_backend/menu/akses/mainmenu', {
  headers: {
    'Authorization': 'Bearer ' + localStorage.getItem('access_token')
  }
});
```

```java
// Android (Java) example
HttpURLConnection connection = (HttpURLConnection) url.openConnection();
connection.setRequestProperty("Authorization", "Bearer " + accessToken);
```

#### Handle Token Expiration
When access token expires, use refresh token to get new one:

```javascript
// JavaScript example
async function refreshAccessToken() {
  const response = await fetch('http://localhost/viyon_backend/auth/refresh_token', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      refresh_token: localStorage.getItem('refresh_token')
    })
  });
  
  const data = await response.json();
  if (data.success === 'success') {
    localStorage.setItem('access_token', data.access_token);
    return data.access_token;
  } else {
    // Redirect to login
    window.location.href = '/login';
  }
}
```

### 2. Backend (PHP)

#### Protect Endpoints
Use JWT_Auth library to validate tokens in your controllers:

```php
// In your controller
public function protected_endpoint() {
    $decoded = $this->jwt_auth->validate_token();
    
    if (!$decoded) {
        http_response_code(401);
        die(json_encode([
            'success' => 'failed',
            'message' => 'Unauthorized'
        ]));
    }
    
    $user_data = $this->jwt_auth->get_user_data($decoded);
    
    // Your protected logic here
    // ...
}
```

#### Create JWT Middleware (Optional)
Create a base controller with JWT validation:

```php
// application/core/MY_Protected_Controller.php
class MY_Protected_Controller extends MX_Controller {
    protected $current_user;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('JWT_Auth');
        
        $decoded = $this->jwt_auth->validate_token();
        
        if (!$decoded) {
            http_response_code(401);
            die(json_encode([
                'success' => 'failed',
                'message' => 'Unauthorized'
            ]));
        }
        
        $this->current_user = $this->jwt_auth->get_user_data($decoded);
    }
}
```

Then extend it in your protected controllers:
```php
class Protected_Controller extends MY_Protected_Controller {
    public function some_method() {
        // Access current user via $this->current_user
        $user_id = $this->current_user['fv_userid'];
        // ...
    }
}
```

---

## Security Best Practices

### 1. Change Secret Key in Production
Edit `application/config/jwt.php` and change `jwt_secret_key` to a strong, random string:
```php
$config['jwt_secret_key'] = bin2hex(random_bytes(32)); // Generate a strong key
```

### 2. Use HTTPS
Always use HTTPS in production to prevent token interception.

### 3. Token Storage
- **Web:** Use `localStorage` or `sessionStorage` (be aware of XSS risks)
- **Mobile:** Use secure storage (Keychain for iOS, KeyStore for Android)
- **Never** store tokens in cookies without proper security flags

### 4. Token Expiration
- Access tokens: Short-lived (1 hour recommended)
- Refresh tokens: Longer-lived (7 days recommended)
- Implement token rotation for refresh tokens in high-security scenarios

### 5. Logout
On logout, remove tokens from client storage. Consider implementing token blacklist on server side for enterprise applications.

---

## Testing with cURL

### Login
```bash
curl -X POST http://localhost/viyon_backend/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password123",
    "area": "01",
    "divisi": "DIV01"
  }'
```

### Validate Token
```bash
curl -X POST http://localhost/viyon_backend/auth/validate_token \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN_HERE"
```

### Get Current User
```bash
curl -X POST http://localhost/viyon_backend/auth/me \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN_HERE"
```

### Refresh Token
```bash
curl -X POST http://localhost/viyon_backend/auth/refresh_token \
  -H "Content-Type: application/json" \
  -d '{
    "refresh_token": "YOUR_REFRESH_TOKEN_HERE"
  }'
```

---

## Troubleshooting

### Token Decode Error
**Error:** "JWT Decode Error: Signature verification failed"
**Solution:** Ensure the same secret key is used for encoding and decoding. Check `application/config/jwt.php`.

### Token Expired
**Error:** "Invalid or expired token"
**Solution:** Use refresh token to get a new access token, or login again.

### Missing Authorization Header
**Error:** Token not found
**Solution:** Ensure Authorization header is sent with format: `Bearer <token>`

### CORS Issues
If frontend can't send Authorization header:
1. Add CORS headers in `application/config/rest.php`
2. Or add to `.htaccess`:
```apache
Header set Access-Control-Allow-Headers "Authorization, Content-Type"
Header set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"
```

---

## Migration from Session-Based to JWT

If you're migrating from session-based authentication:

1. **Both systems work simultaneously** - Session and JWT authentication can coexist
2. **Gradual migration** - Update frontend/mobile apps gradually to use JWT
3. **Backward compatibility** - Old endpoints still use sessions, new endpoints use JWT
4. **Authentication check** - Update protected endpoints to accept both session and JWT

Example dual authentication:
```php
public function protected_endpoint() {
    // Check JWT first
    $jwt_decoded = $this->jwt_auth->validate_token();
    
    if ($jwt_decoded) {
        // JWT authenticated
        $user_data = $this->jwt_auth->get_user_data($jwt_decoded);
    } else if ($this->session->userdata('fv_userid')) {
        // Session authenticated
        $user_data = [
            'fv_userid' => $this->session->userdata('fv_userid')
        ];
    } else {
        // Not authenticated
        http_response_code(401);
        die(json_encode(['success' => 'failed', 'message' => 'Unauthorized']));
    }
    
    // Continue with logic...
}
```

---

## Summary

✅ JWT authentication has been successfully added to:
- Web login (`/auth/login`)
- Android login (`/auth/login_android`)
- Token refresh (`/auth/refresh_token`)
- Token validation (`/auth/validate_token`)
- Get current user (`/auth/me`)

✅ Features:
- Stateless authentication
- Access & refresh tokens
- Token expiration handling
- Secure token generation
- Easy integration with frontend/mobile apps

✅ Files created/modified:
- `application/libraries/JWT_Auth.php` - JWT library
- `application/config/jwt.php` - JWT configuration
- `application/modules/Auth/controllers/Auth.php` - Updated with JWT support
- `composer.json` - Added firebase/php-jwt dependency
