# JWT Authentication Testing Guide

## Prerequisites
- Backend server running (http://localhost/viyon_backend)
- Valid user credentials in database
- cURL or Postman installed

## Test Scenarios

### 1. Test Login with JWT

#### Using cURL:
```bash
curl -X POST http://localhost/viyon_backend/auth/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=your_email@example.com&password=your_password&area=01&divisi=01"
```

#### Using PowerShell:
```powershell
$body = @{
    email = "your_email@example.com"
    password = "your_password"
    area = "01"
    divisi = "01"
}

$response = Invoke-RestMethod -Uri "http://localhost/viyon_backend/auth/login" -Method Post -Body $body
$response | ConvertTo-Json -Depth 5
```

#### Expected Response:
```json
{
  "success": "success",
  "data": {
    "fv_userid": "USR001",
    "fv_username": "user@example.com",
    "fv_nama": "John Doe"
  },
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

**Save the tokens for next tests!**

---

### 2. Test Validate Token

#### Using cURL:
```bash
# Replace YOUR_TOKEN with actual access_token from login response
curl -X POST http://localhost/viyon_backend/auth/validate_token \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Using PowerShell:
```powershell
$token = "YOUR_ACCESS_TOKEN_HERE"
$headers = @{
    "Authorization" = "Bearer $token"
}

$response = Invoke-RestMethod -Uri "http://localhost/viyon_backend/auth/validate_token" -Method Post -Headers $headers
$response | ConvertTo-Json
```

#### Expected Response:
```json
{
  "success": "success",
  "valid": true,
  "user": {
    "fv_userid": "USR001",
    "fv_username": "user@example.com",
    "fv_nama": "John Doe",
    "f_deptid": "01"
  },
  "expires_at": "2025-11-11 18:30:45"
}
```

---

### 3. Test Get Current User

#### Using cURL:
```bash
curl -X POST http://localhost/viyon_backend/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Using PowerShell:
```powershell
$token = "YOUR_ACCESS_TOKEN_HERE"
$headers = @{
    "Authorization" = "Bearer $token"
}

$response = Invoke-RestMethod -Uri "http://localhost/viyon_backend/auth/me" -Method Post -Headers $headers
$response | ConvertTo-Json
```

#### Expected Response:
```json
{
  "success": "success",
  "user": {
    "fv_userid": "USR001",
    "fv_username": "user@example.com",
    "fv_nama": "John Doe",
    "f_deptid": "01"
  }
}
```

---

### 4. Test Refresh Token

#### Using cURL:
```bash
# Replace YOUR_REFRESH_TOKEN with actual refresh_token from login response
curl -X POST http://localhost/viyon_backend/auth/refresh_token \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "refresh_token=YOUR_REFRESH_TOKEN"
```

#### Using PowerShell:
```powershell
$body = @{
    refresh_token = "YOUR_REFRESH_TOKEN_HERE"
}

$response = Invoke-RestMethod -Uri "http://localhost/viyon_backend/auth/refresh_token" -Method Post -Body $body
$response | ConvertTo-Json
```

#### Expected Response:
```json
{
  "success": "success",
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

---

### 5. Test Android Login

#### Using cURL:
```bash
curl -X POST http://localhost/viyon_backend/auth/login_android \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "username=your_username&password=your_password&area=01&divisi=01"
```

#### Using PowerShell:
```powershell
$body = @{
    username = "your_username"
    password = "your_password"
    area = "01"
    divisi = "01"
}

$response = Invoke-RestMethod -Uri "http://localhost/viyon_backend/auth/login_android" -Method Post -Body $body
$response | ConvertTo-Json -Depth 5
```

---

### 6. Test Invalid Token

#### Using cURL:
```bash
curl -X POST http://localhost/viyon_backend/auth/validate_token \
  -H "Authorization: Bearer invalid_token_here"
```

#### Expected Response:
```json
{
  "success": "failed",
  "valid": false,
  "message": "Invalid or expired token"
}
```

---

### 7. Test Expired Token

Wait for token to expire (default: 1 hour) or manually set a short expiration time in `application/config/jwt.php` for testing:

```php
// In jwt.php - for testing only
$config['jwt_token_expiration'] = 60; // 60 seconds
```

Then test with an old token after 60 seconds.

---

## Complete Testing Flow (PowerShell Script)

Save this as `test_jwt.ps1`:

```powershell
# JWT Authentication Testing Script

$baseUrl = "http://localhost/viyon_backend"

Write-Host "=== JWT Authentication Testing ===" -ForegroundColor Cyan
Write-Host ""

# Step 1: Login
Write-Host "1. Testing Login..." -ForegroundColor Yellow
$loginBody = @{
    email = "admin@viyon.com"  # Change to your credentials
    password = "admin123"       # Change to your password
    area = "01"
    divisi = "01"
}

try {
    $loginResponse = Invoke-RestMethod -Uri "$baseUrl/auth/login" -Method Post -Body $loginBody
    
    if ($loginResponse.success -eq "success") {
        Write-Host "✓ Login successful!" -ForegroundColor Green
        Write-Host "User: $($loginResponse.data.fv_nama)" -ForegroundColor Gray
        
        $accessToken = $loginResponse.access_token
        $refreshToken = $loginResponse.refresh_token
        
        Write-Host "✓ Access Token received (length: $($accessToken.Length))" -ForegroundColor Green
        Write-Host "✓ Refresh Token received (length: $($refreshToken.Length))" -ForegroundColor Green
    } else {
        Write-Host "✗ Login failed: $($loginResponse.message)" -ForegroundColor Red
        exit
    }
} catch {
    Write-Host "✗ Login error: $_" -ForegroundColor Red
    exit
}

Write-Host ""

# Step 2: Validate Token
Write-Host "2. Testing Token Validation..." -ForegroundColor Yellow
$headers = @{
    "Authorization" = "Bearer $accessToken"
}

try {
    $validateResponse = Invoke-RestMethod -Uri "$baseUrl/auth/validate_token" -Method Post -Headers $headers
    
    if ($validateResponse.valid -eq $true) {
        Write-Host "✓ Token is valid!" -ForegroundColor Green
        Write-Host "Expires at: $($validateResponse.expires_at)" -ForegroundColor Gray
    } else {
        Write-Host "✗ Token validation failed" -ForegroundColor Red
    }
} catch {
    Write-Host "✗ Validation error: $_" -ForegroundColor Red
}

Write-Host ""

# Step 3: Get Current User
Write-Host "3. Testing Get Current User..." -ForegroundColor Yellow
try {
    $meResponse = Invoke-RestMethod -Uri "$baseUrl/auth/me" -Method Post -Headers $headers
    
    if ($meResponse.success -eq "success") {
        Write-Host "✓ User data retrieved!" -ForegroundColor Green
        Write-Host "User ID: $($meResponse.user.fv_userid)" -ForegroundColor Gray
        Write-Host "Username: $($meResponse.user.fv_username)" -ForegroundColor Gray
        Write-Host "Name: $($meResponse.user.fv_nama)" -ForegroundColor Gray
    } else {
        Write-Host "✗ Failed to get user data" -ForegroundColor Red
    }
} catch {
    Write-Host "✗ Get user error: $_" -ForegroundColor Red
}

Write-Host ""

# Step 4: Refresh Token
Write-Host "4. Testing Token Refresh..." -ForegroundColor Yellow
$refreshBody = @{
    refresh_token = $refreshToken
}

try {
    $refreshResponse = Invoke-RestMethod -Uri "$baseUrl/auth/refresh_token" -Method Post -Body $refreshBody
    
    if ($refreshResponse.success -eq "success") {
        Write-Host "✓ New access token generated!" -ForegroundColor Green
        Write-Host "New Token length: $($refreshResponse.access_token.Length)" -ForegroundColor Gray
        Write-Host "Expires in: $($refreshResponse.expires_in) seconds" -ForegroundColor Gray
    } else {
        Write-Host "✗ Token refresh failed" -ForegroundColor Red
    }
} catch {
    Write-Host "✗ Refresh error: $_" -ForegroundColor Red
}

Write-Host ""

# Step 5: Test Invalid Token
Write-Host "5. Testing Invalid Token..." -ForegroundColor Yellow
$invalidHeaders = @{
    "Authorization" = "Bearer invalid_token_12345"
}

try {
    $invalidResponse = Invoke-RestMethod -Uri "$baseUrl/auth/validate_token" -Method Post -Headers $invalidHeaders
    Write-Host "✗ Invalid token was accepted (unexpected!)" -ForegroundColor Red
} catch {
    Write-Host "✓ Invalid token correctly rejected!" -ForegroundColor Green
}

Write-Host ""
Write-Host "=== Testing Complete ===" -ForegroundColor Cyan
```

Run with:
```powershell
.\test_jwt.ps1
```

---

## Postman Collection

### Import this collection:

1. Open Postman
2. Click Import
3. Paste this JSON:

```json
{
  "info": {
    "name": "Viyon Backend JWT Auth",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "variable": [
    {
      "key": "base_url",
      "value": "http://localhost/viyon_backend",
      "type": "string"
    },
    {
      "key": "access_token",
      "value": "",
      "type": "string"
    },
    {
      "key": "refresh_token",
      "value": "",
      "type": "string"
    }
  ],
  "item": [
    {
      "name": "Login",
      "event": [
        {
          "listen": "test",
          "script": {
            "exec": [
              "var jsonData = pm.response.json();",
              "if (jsonData.success === 'success') {",
              "    pm.collectionVariables.set('access_token', jsonData.access_token);",
              "    pm.collectionVariables.set('refresh_token', jsonData.refresh_token);",
              "}"
            ]
          }
        }
      ],
      "request": {
        "method": "POST",
        "header": [],
        "body": {
          "mode": "urlencoded",
          "urlencoded": [
            {"key": "email", "value": "admin@viyon.com"},
            {"key": "password", "value": "admin123"},
            {"key": "area", "value": "01"},
            {"key": "divisi", "value": "01"}
          ]
        },
        "url": "{{base_url}}/auth/login"
      }
    },
    {
      "name": "Validate Token",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Authorization",
            "value": "Bearer {{access_token}}"
          }
        ],
        "url": "{{base_url}}/auth/validate_token"
      }
    },
    {
      "name": "Get Current User",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Authorization",
            "value": "Bearer {{access_token}}"
          }
        ],
        "url": "{{base_url}}/auth/me"
      }
    },
    {
      "name": "Refresh Token",
      "event": [
        {
          "listen": "test",
          "script": {
            "exec": [
              "var jsonData = pm.response.json();",
              "if (jsonData.success === 'success') {",
              "    pm.collectionVariables.set('access_token', jsonData.access_token);",
              "}"
            ]
          }
        }
      ],
      "request": {
        "method": "POST",
        "header": [],
        "body": {
          "mode": "urlencoded",
          "urlencoded": [
            {"key": "refresh_token", "value": "{{refresh_token}}"}
          ]
        },
        "url": "{{base_url}}/auth/refresh_token"
      }
    }
  ]
}
```

---

## Troubleshooting

### Error: "Class 'Firebase\JWT\JWT' not found"
**Solution:** Make sure Composer autoload is loaded in `index.php`:
```php
require_once FCPATH . 'vendor/autoload.php';
```

### Error: "Unable to load the requested class: JWT_Auth"
**Solution:** Check that `JWT_Auth.php` exists in `application/libraries/`

### Error: "jwt_secret_key configuration not found"
**Solution:** Ensure `application/config/jwt.php` exists and is properly configured

### Token always invalid
**Solution:** 
1. Check if secret key is the same in `jwt.php`
2. Verify token is sent with correct format: `Bearer <token>`
3. Check server time synchronization

---

## Summary

✅ **Endpoints Ready:**
- POST `/auth/login` - Login with JWT
- POST `/auth/login_android` - Android login with JWT
- POST `/auth/validate_token` - Validate access token
- POST `/auth/me` - Get current user
- POST `/auth/refresh_token` - Refresh access token

✅ **Features:**
- Access token (1 hour expiration)
- Refresh token (7 days expiration)
- Token validation
- User data retrieval
- Secure token generation

✅ **Next Steps:**
1. Test all endpoints with your credentials
2. Update frontend to use JWT tokens
3. Change JWT secret key in production
4. Enable HTTPS in production
