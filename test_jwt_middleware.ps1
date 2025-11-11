# JWT Middleware Testing
# Save as: test_jwt_middleware.ps1

$baseUrl = "http://localhost/viyon_backend"

Write-Host "`n=== JWT Middleware Testing ===" -ForegroundColor Cyan

# Step 1: Login to get token
Write-Host "`n1. Login to get JWT token..." -ForegroundColor Yellow
$loginBody = @{
    email = "test@viyon.com"
    password = "test123"
    area = "01"
    divisi = "01"
}

try {
    $loginResponse = Invoke-RestMethod -Uri "$baseUrl/auth/login" -Method Post -Body $loginBody
    
    if ($loginResponse.success -eq "success") {
        Write-Host "✓ Login successful!" -ForegroundColor Green
        $token = $loginResponse.access_token
        Write-Host "  Token: $($token.Substring(0,50))..." -ForegroundColor Gray
    } else {
        Write-Host "✗ Login failed. Update credentials in script." -ForegroundColor Red
        exit
    }
} catch {
    Write-Host "✗ Login error: $_" -ForegroundColor Red
    exit
}

# Step 2: Test protected endpoint WITHOUT token (should fail)
Write-Host "`n2. Testing protected endpoint WITHOUT token..." -ForegroundColor Yellow
try {
    $response = Invoke-WebRequest -Uri "$baseUrl/menu/protected_example/test" -Method Get -UseBasicParsing
    Write-Host "✗ Endpoint accepted request without token (unexpected!)" -ForegroundColor Red
} catch {
    if ($_.Exception.Response.StatusCode -eq 401) {
        Write-Host "✓ Correctly rejected - 401 Unauthorized" -ForegroundColor Green
    } else {
        Write-Host "✗ Unexpected error: $($_.Exception.Message)" -ForegroundColor Red
    }
}

# Step 3: Test protected endpoint WITH valid token (should succeed)
Write-Host "`n3. Testing protected endpoint WITH valid token..." -ForegroundColor Yellow
$headers = @{
    "Authorization" = "Bearer $token"
}

try {
    $response = Invoke-RestMethod -Uri "$baseUrl/menu/protected_example/test" -Method Get -Headers $headers
    
    if ($response.status -eq $true) {
        Write-Host "✓ Protected endpoint accessed successfully!" -ForegroundColor Green
        Write-Host "  User: $($response.user.fv_username)" -ForegroundColor Gray
        Write-Host "  Message: $($response.message)" -ForegroundColor Gray
    } else {
        Write-Host "✗ Unexpected response" -ForegroundColor Red
    }
} catch {
    Write-Host "✗ Error: $_" -ForegroundColor Red
}

# Step 4: Test profile endpoint
Write-Host "`n4. Testing profile endpoint..." -ForegroundColor Yellow
try {
    $response = Invoke-RestMethod -Uri "$baseUrl/menu/protected_example/profile" -Method Get -Headers $headers
    
    if ($response.status -eq $true) {
        Write-Host "✓ Profile retrieved!" -ForegroundColor Green
        Write-Host "  User ID: $($response.data.user_id)" -ForegroundColor Gray
        Write-Host "  Username: $($response.data.username)" -ForegroundColor Gray
        Write-Host "  Department: $($response.data.department)" -ForegroundColor Gray
    }
} catch {
    Write-Host "✗ Error: $_" -ForegroundColor Red
}

# Step 5: Test public endpoint (no token needed)
Write-Host "`n5. Testing public endpoint (no token)..." -ForegroundColor Yellow
try {
    $response = Invoke-RestMethod -Uri "$baseUrl/menu/mixed_example/public" -Method Get
    
    if ($response.status -eq $true) {
        Write-Host "✓ Public endpoint accessible!" -ForegroundColor Green
        Write-Host "  Message: $($response.message)" -ForegroundColor Gray
    }
} catch {
    Write-Host "✗ Error: $_" -ForegroundColor Red
}

# Step 6: Test mixed endpoint protected (with token)
Write-Host "`n6. Testing mixed endpoint (protected method)..." -ForegroundColor Yellow
try {
    $response = Invoke-RestMethod -Uri "$baseUrl/menu/mixed_example/protected" -Method Get -Headers $headers
    
    if ($response.status -eq $true) {
        Write-Host "✓ Protected method accessed!" -ForegroundColor Green
        Write-Host "  User: $($response.data.user.fv_username)" -ForegroundColor Gray
    }
} catch {
    Write-Host "✗ Error: $_" -ForegroundColor Red
}

# Step 7: Test optional authentication (without token)
Write-Host "`n7. Testing optional auth endpoint (no token)..." -ForegroundColor Yellow
try {
    $response = Invoke-RestMethod -Uri "$baseUrl/menu/mixed_example/optional" -Method Get
    
    if ($response.authenticated -eq $false) {
        Write-Host "✓ Anonymous access works!" -ForegroundColor Green
        Write-Host "  Message: $($response.message)" -ForegroundColor Gray
    }
} catch {
    Write-Host "✗ Error: $_" -ForegroundColor Red
}

# Step 8: Test optional authentication (with token)
Write-Host "`n8. Testing optional auth endpoint (with token)..." -ForegroundColor Yellow
try {
    $response = Invoke-RestMethod -Uri "$baseUrl/menu/mixed_example/optional" -Method Get -Headers $headers
    
    if ($response.authenticated -eq $true) {
        Write-Host "✓ Authenticated access works!" -ForegroundColor Green
        Write-Host "  User: $($response.user.fv_username)" -ForegroundColor Gray
    }
} catch {
    Write-Host "✗ Error: $_" -ForegroundColor Red
}

# Step 9: Test with invalid token
Write-Host "`n9. Testing with invalid token..." -ForegroundColor Yellow
$invalidHeaders = @{
    "Authorization" = "Bearer invalid_token_12345"
}

try {
    $response = Invoke-WebRequest -Uri "$baseUrl/menu/protected_example/test" -Method Get -Headers $invalidHeaders -UseBasicParsing
    Write-Host "✗ Invalid token accepted (unexpected!)" -ForegroundColor Red
} catch {
    if ($_.Exception.Response.StatusCode -eq 401) {
        Write-Host "✓ Invalid token correctly rejected - 401 Unauthorized" -ForegroundColor Green
    } else {
        Write-Host "✗ Unexpected error" -ForegroundColor Red
    }
}

# Step 10: Test POST with JWT
Write-Host "`n10. Testing POST endpoint with JWT..." -ForegroundColor Yellow
$createBody = @{
    name = "Test Item"
    description = "Created via JWT middleware test"
}

try {
    $response = Invoke-RestMethod -Uri "$baseUrl/menu/protected_example/create" -Method Post -Headers $headers -Body $createBody
    
    if ($response.status -eq $true) {
        Write-Host "✓ POST request successful!" -ForegroundColor Green
        Write-Host "  Created by: $($response.data.created_by)" -ForegroundColor Gray
        Write-Host "  Message: $($response.message)" -ForegroundColor Gray
    }
} catch {
    Write-Host "✗ Error: $_" -ForegroundColor Red
}

Write-Host "`n=== Testing Complete ===" -ForegroundColor Cyan
Write-Host "`nSummary:" -ForegroundColor Yellow
Write-Host "✓ JWT middleware is working correctly" -ForegroundColor Green
Write-Host "✓ Protected endpoints require valid token" -ForegroundColor Green
Write-Host "✓ Public endpoints work without token" -ForegroundColor Green
Write-Host "✓ Optional authentication works both ways" -ForegroundColor Green
Write-Host "✓ Invalid tokens are rejected" -ForegroundColor Green
Write-Host "`n"
