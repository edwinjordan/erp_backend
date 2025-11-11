# JWT Middleware Documentation

## Overview

JWT Middleware provides flexible authentication options for protecting your API endpoints. There are two approaches available:

1. **JWT_Protected_Controller** - Base controller class (for standard controllers)
2. **JWT_Authentication Trait** - Flexible trait (works with REST_Controller and any other controller)

---

## Option 1: JWT_Protected_Controller (Base Class)

### Usage

Extend `JWT_Protected_Controller` for standard MX_Controller:

```php
<?php
class Your_Controller extends JWT_Protected_Controller {
    
    public function __construct() {
        parent::__construct();
        // JWT authentication is automatic
    }
    
    public function your_method() {
        // Access current user data
        $user_id = $this->current_user['fv_userid'];
        $username = $this->current_user['fv_username'];
        
        // Use helper methods
        $dept = $this->get_current_department();
        $area = $this->get_current_area();
        
        // Your code here
    }
}
```

### Features

- ✅ Automatic JWT validation in constructor
- ✅ Access to `$this->current_user` with user data
- ✅ Helper methods for common user properties
- ✅ Built-in permission system
- ✅ Standardized JSON responses

### Available Methods

| Method | Description |
|--------|-------------|
| `$this->get_current_user_id()` | Get user ID |
| `$this->get_current_username()` | Get username |
| `$this->get_current_department()` | Get department ID |
| `$this->get_current_area()` | Get area code |
| `$this->get_current_division()` | Get division code |
| `$this->get_user_data($field)` | Get specific user field |
| `$this->is_authenticated()` | Check if authenticated |
| `$this->has_permission($perm)` | Check permission |
| `$this->require_permission($perm)` | Require permission or deny |
| `$this->success_response($data, $msg)` | Send success response |
| `$this->error_response($msg, $code)` | Send error response |

---

## Option 2: JWT_Authentication Trait (Recommended)

### Usage with REST_Controller

```php
<?php
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'traits/JWT_Authentication.php';

class Your_API extends REST_Controller {
    
    use JWT_Authentication;
    
    public function __construct() {
        parent::__construct();
        
        // Protect all endpoints
        $this->authenticate_jwt();
    }
    
    public function users_get() {
        // Access current user
        $user_id = $this->jwt_get_user_id();
        
        // Your code here
        $this->response([
            'status' => true,
            'user_id' => $user_id
        ], REST_Controller::HTTP_OK);
    }
}
```

### Selective Protection (Public + Protected Endpoints)

```php
<?php
class Mixed_API extends REST_Controller {
    
    use JWT_Authentication;
    
    public function __construct() {
        parent::__construct();
        // Don't authenticate in constructor
    }
    
    // PUBLIC - No JWT required
    public function public_info_get() {
        $this->response([
            'status' => true,
            'message' => 'This is public'
        ], REST_Controller::HTTP_OK);
    }
    
    // PROTECTED - JWT required
    public function private_data_get() {
        $this->authenticate_jwt(); // Protect this method only
        
        $this->response([
            'status' => true,
            'user' => $this->current_user
        ], REST_Controller::HTTP_OK);
    }
}
```

### Optional Authentication

```php
public function optional_get() {
    // Try to authenticate, but don't require it
    $is_authenticated = $this->authenticate_jwt(false);
    
    if ($is_authenticated) {
        // Show personalized content
        $data = $this->get_user_specific_data();
    } else {
        // Show public content
        $data = $this->get_public_data();
    }
    
    $this->response(['data' => $data], REST_Controller::HTTP_OK);
}
```

### Available Trait Methods

| Method | Description |
|--------|-------------|
| `$this->authenticate_jwt($required)` | Authenticate JWT (required=true/false) |
| `$this->jwt_get_user_id()` | Get user ID |
| `$this->jwt_get_username()` | Get username |
| `$this->jwt_get_department()` | Get department ID |
| `$this->jwt_get_area()` | Get area code |
| `$this->jwt_get_division()` | Get division code |
| `$this->jwt_get_user_data($field)` | Get specific user field |
| `$this->jwt_is_authenticated()` | Check if authenticated |
| `$this->jwt_get_current_user()` | Get all user data |
| `$this->jwt_has_permission($perm)` | Check permission (override to customize) |
| `$this->jwt_require_permission($perm)` | Require permission or deny |
| `$this->jwt_unauthorized($msg)` | Send 401 response |
| `$this->jwt_forbidden($msg)` | Send 403 response |

---

## Complete Examples

### Example 1: Fully Protected REST API

File: `application/modules/Menu/controllers/Protected_Example.php`

```php
<?php
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'traits/JWT_Authentication.php';

class Protected_Example extends REST_Controller {
    
    use JWT_Authentication;

    public function __construct() {
        parent::__construct();
        $this->authenticate_jwt(); // All methods protected
    }

    public function test_get() {
        $this->response([
            'status' => true,
            'message' => 'Protected endpoint',
            'user' => $this->current_user
        ], REST_Controller::HTTP_OK);
    }

    public function profile_get() {
        $this->response([
            'status' => true,
            'data' => [
                'user_id' => $this->jwt_get_user_id(),
                'username' => $this->jwt_get_username(),
                'department' => $this->jwt_get_department()
            ]
        ], REST_Controller::HTTP_OK);
    }
}
```

**Usage:**
```bash
# Must include Authorization header
curl -X GET http://localhost/viyon_backend/menu/protected_example/test \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Example 2: Mixed Public/Protected API

File: `application/modules/Menu/controllers/Mixed_Example.php`

```php
<?php
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'traits/JWT_Authentication.php';

class Mixed_Example extends REST_Controller {
    
    use JWT_Authentication;

    public function __construct() {
        parent::__construct();
        // Don't authenticate in constructor
    }

    // PUBLIC endpoint
    public function public_get() {
        $this->response([
            'status' => true,
            'message' => 'Public access'
        ], REST_Controller::HTTP_OK);
    }

    // PROTECTED endpoint
    public function protected_get() {
        $this->authenticate_jwt(); // Require auth for this method
        
        $this->response([
            'status' => true,
            'message' => 'Protected access',
            'user' => $this->current_user
        ], REST_Controller::HTTP_OK);
    }

    // OPTIONAL authentication
    public function optional_get() {
        $is_auth = $this->authenticate_jwt(false);
        
        $this->response([
            'status' => true,
            'authenticated' => $is_auth,
            'data' => $is_auth ? $this->current_user : 'Guest'
        ], REST_Controller::HTTP_OK);
    }
}
```

**Usage:**
```bash
# Public - No token needed
curl -X GET http://localhost/viyon_backend/menu/mixed_example/public

# Protected - Token required
curl -X GET http://localhost/viyon_backend/menu/mixed_example/protected \
  -H "Authorization: Bearer YOUR_TOKEN"

# Optional - Works with or without token
curl -X GET http://localhost/viyon_backend/menu/mixed_example/optional
curl -X GET http://localhost/viyon_backend/menu/mixed_example/optional \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Example 3: Update Existing Akses Controller

To protect the existing Menu Akses API, update `application/modules/Menu/controllers/Akses.php`:

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'traits/JWT_Authentication.php'; // Add this

class Akses extends REST_Controller {
    
    use JWT_Authentication; // Add this

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_akses');
        
        // Add JWT authentication
        $this->authenticate_jwt();
        
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        if ($this->input->method() === 'options') {
            exit();
        }
    }

    public function mainmenu_get()
    {
        // Now protected with JWT!
        // Access user data if needed
        $current_dept = $this->jwt_get_department();
        
        $f_deptid = $this->get('f_deptid') ?: $current_dept;
        $data = $this->M_akses->get_akses_mainmenu($f_deptid);
        
        $this->response([
            'status' => true,
            'message' => 'Data retrieved',
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }
    
    // ... rest of your methods
}
```

---

## Permission System

### Basic Permission Check

```php
class Your_Controller extends REST_Controller {
    use JWT_Authentication;
    
    protected function jwt_has_permission($permission) {
        // Custom permission logic
        $user_dept = $this->jwt_get_department();
        $user_area = $this->jwt_get_area();
        
        switch($permission) {
            case 'admin':
                return $user_dept === '01'; // Admin department
            case 'manager':
                return in_array($user_area, ['01', '02']);
            case 'view_reports':
                // Check database or config
                return $this->check_user_permission($permission);
            default:
                return false;
        }
    }
    
    public function admin_only_get() {
        $this->authenticate_jwt();
        $this->jwt_require_permission('admin');
        
        // Only users with admin permission can access
        $this->response(['message' => 'Admin area'], 200);
    }
}
```

---

## Error Responses

### Unauthorized (401)
When JWT token is missing, invalid, or expired:

```json
{
  "success": false,
  "status": 401,
  "message": "Invalid or expired token. Please login again.",
  "error": "Unauthorized"
}
```

### Forbidden (403)
When user doesn't have required permission:

```json
{
  "success": false,
  "status": 403,
  "message": "You don't have permission to access this resource",
  "error": "Forbidden"
}
```

---

## Testing JWT Middleware

### Test Protected Endpoint

```bash
# Without token (should fail)
curl -X GET http://localhost/viyon_backend/menu/protected_example/test

# Response: 401 Unauthorized

# With valid token (should succeed)
curl -X GET http://localhost/viyon_backend/menu/protected_example/test \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN"

# Response: 200 OK with user data
```

### PowerShell Test Script

```powershell
# Login first
$login = Invoke-RestMethod -Uri "http://localhost/viyon_backend/auth/login" `
  -Method Post -Body @{
    email = "user@example.com"
    password = "password"
    area = "01"
    divisi = "01"
  }

$token = $login.access_token

# Test protected endpoint
$headers = @{
    "Authorization" = "Bearer $token"
}

$response = Invoke-RestMethod `
  -Uri "http://localhost/viyon_backend/menu/protected_example/test" `
  -Method Get `
  -Headers $headers

$response | ConvertTo-Json
```

---

## Current User Data Structure

When authenticated, `$this->current_user` contains:

```php
[
    'fv_userid' => 'USR001',
    'fv_username' => 'user@example.com',
    'fv_nama' => 'John Doe',
    'f_deptid' => '01',
    'fc_kdarea' => '01',
    'fc_kddivisi' => 'DIV01',
    'fv_nmarea' => 'Jakarta',
    'fv_nmdivisi' => 'IT Division'
]
```

---

## Best Practices

### 1. Protect Sensitive Endpoints
Always require JWT for endpoints that:
- Modify data (POST, PUT, DELETE)
- Access user-specific information
- Perform admin operations

### 2. Use Public Endpoints Sparingly
Only make endpoints public if they truly need to be:
- Health checks
- Public documentation
- Login/registration

### 3. Log Authentication
JWT middleware logs successful authentications:
```php
log_message('debug', 'JWT Auth: User john@example.com authenticated');
```

### 4. Handle Token Expiration
Frontend should:
- Store refresh token
- Use refresh token when access token expires
- Redirect to login if refresh token expires

### 5. Use HTTPS in Production
Always use HTTPS to prevent token interception.

---

## Troubleshooting

### Error: "Authentication system error"
**Cause:** CodeIgniter instance not available  
**Solution:** Ensure trait is used in a controller that extends CI_Controller or MX_Controller

### Error: "Class 'JWT_Auth' not found"
**Cause:** JWT_Auth library not found  
**Solution:** Ensure `application/libraries/JWT_Auth.php` exists

### Error: "Trait 'JWT_Authentication' not found"
**Cause:** Trait file not loaded  
**Solution:** Add `require APPPATH . 'traits/JWT_Authentication.php';` before class definition

### Token Always Invalid
**Cause:** Secret key mismatch or token corrupted  
**Solution:** 
1. Check `application/config/jwt.php` secret key
2. Ensure token is sent correctly: `Authorization: Bearer <token>`
3. Check token hasn't expired

---

## Summary

✅ **Two Options Available:**
- JWT_Protected_Controller (base class)
- JWT_Authentication trait (flexible, works with REST_Controller)

✅ **Features:**
- Automatic token validation
- Access to current user data
- Helper methods for user properties
- Permission system
- Works with REST_Controller
- Selective protection support

✅ **Files:**
- `application/core/JWT_Protected_Controller.php` - Base controller
- `application/traits/JWT_Authentication.php` - Trait
- `application/modules/Menu/controllers/Protected_Example.php` - Example
- `application/modules/Menu/controllers/Mixed_Example.php` - Mixed example

✅ **Next Steps:**
1. Choose your approach (base class or trait)
2. Update your controllers
3. Test with valid JWT tokens
4. Implement custom permissions if needed
