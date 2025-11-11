# Quick Test - JWT Authentication
# Save as: test_jwt_quick.ps1

$baseUrl = "http://localhost/viyon_backend"

Write-Host "`n=== Quick JWT Test ===" -ForegroundColor Cyan

# Test 1: Login
Write-Host "`n1. Login Test..." -ForegroundColor Yellow
$loginBody = @{
    email = "test@viyon.com"
    password = "test123"
    area = "01"
    divisi = "01"
}

try {
    $response = Invoke-WebRequest -Uri "$baseUrl/auth/login" -Method Post -Body $loginBody -UseBasicParsing
    $json = $response.Content | ConvertFrom-Json
    
    if ($json.success -eq "success") {
        Write-Host "✓ Login Success!" -ForegroundColor Green
        Write-Host "  Access Token: $($json.access_token.Substring(0,50))..." -ForegroundColor Gray
        Write-Host "  Token Type: $($json.token_type)" -ForegroundColor Gray
        Write-Host "  Expires In: $($json.expires_in) seconds" -ForegroundColor Gray
        
        $token = $json.access_token
        
        # Test 2: Validate Token
        Write-Host "`n2. Validate Token Test..." -ForegroundColor Yellow
        $headers = @{
            "Authorization" = "Bearer $token"
        }
        
        $validateResponse = Invoke-WebRequest -Uri "$baseUrl/auth/validate_token" -Method Post -Headers $headers -UseBasicParsing
        $validateJson = $validateResponse.Content | ConvertFrom-Json
        
        if ($validateJson.valid -eq $true) {
            Write-Host "✓ Token Valid!" -ForegroundColor Green
            Write-Host "  User: $($validateJson.user.fv_username)" -ForegroundColor Gray
            Write-Host "  Expires: $($validateJson.expires_at)" -ForegroundColor Gray
        }
        
        # Test 3: Get User
        Write-Host "`n3. Get Current User Test..." -ForegroundColor Yellow
        $meResponse = Invoke-WebRequest -Uri "$baseUrl/auth/me" -Method Post -Headers $headers -UseBasicParsing
        $meJson = $meResponse.Content | ConvertFrom-Json
        
        if ($meJson.success -eq "success") {
            Write-Host "✓ User Data Retrieved!" -ForegroundColor Green
            Write-Host "  Name: $($meJson.user.fv_nama)" -ForegroundColor Gray
        }
        
    } else {
        Write-Host "✗ Login Failed: $($json.message)" -ForegroundColor Red
        Write-Host "  Note: Update credentials in test_jwt_quick.ps1" -ForegroundColor Yellow
    }
} catch {
    Write-Host "✗ Error: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.Exception.Response) {
        $reader = New-Object System.IO.StreamReader($_.Exception.Response.GetResponseStream())
        $responseBody = $reader.ReadToEnd()
        Write-Host "Response: $responseBody" -ForegroundColor Gray
    }
}

Write-Host "`n=== Test Complete ===`n" -ForegroundColor Cyan
