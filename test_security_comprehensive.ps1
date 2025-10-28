# Comprehensive Security Tests for Authentication System

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "SECURITY TESTS FOR AUTHENTICATION SYSTEM" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Test 1: Missing Authorization Header
Write-Host "Test 1: Missing Authorization Header" -ForegroundColor Yellow
$uri = "http://localhost:8000/api/auth/logout"
$headers = @{
    "Content-Type" = "application/json"
}

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -ErrorAction Stop
} catch {
    $statusCode = $_.Exception.Response.StatusCode
    $responseBody = $_.Exception.Response.GetResponseStream() | ForEach-Object { (New-Object System.IO.StreamReader($_)).ReadToEnd() }
    Write-Host "Status: $statusCode" -ForegroundColor Red
    Write-Host "Response: $responseBody" -ForegroundColor Red
}
Write-Host ""

# Test 2: Empty Authorization Header
Write-Host "Test 2: Empty Authorization Header" -ForegroundColor Yellow
$headers = @{
    "Content-Type" = "application/json"
    "Authorization" = ""
}

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -ErrorAction Stop
} catch {
    $statusCode = $_.Exception.Response.StatusCode
    $responseBody = $_.Exception.Response.GetResponseStream() | ForEach-Object { (New-Object System.IO.StreamReader($_)).ReadToEnd() }
    Write-Host "Status: $statusCode" -ForegroundColor Red
    Write-Host "Response: $responseBody" -ForegroundColor Red
}
Write-Host ""

# Test 3: Invalid Token Format
Write-Host "Test 3: Invalid Token Format (no Bearer prefix)" -ForegroundColor Yellow
$headers = @{
    "Content-Type" = "application/json"
    "Authorization" = "invalid_token_without_bearer"
}

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -ErrorAction Stop
} catch {
    $statusCode = $_.Exception.Response.StatusCode
    $responseBody = $_.Exception.Response.GetResponseStream() | ForEach-Object { (New-Object System.IO.StreamReader($_)).ReadToEnd() }
    Write-Host "Status: $statusCode" -ForegroundColor Red
    Write-Host "Response: $responseBody" -ForegroundColor Red
}
Write-Host ""

# Test 4: Weak Password Validation
Write-Host "Test 4: Weak Password Validation (no special chars)" -ForegroundColor Yellow
$registerUri = "http://localhost:8000/api/auth/register"
$headers = @{
    "Content-Type" = "application/json"
}
$body = @{
    name = "Test User"
    email = "weakpass@example.com"
    password = "TestPass123"
    password_confirmation = "TestPass123"
} | ConvertTo-Json

try {
    $response = Invoke-WebRequest -Uri $registerUri -Method POST -Headers $headers -Body $body -ErrorAction Stop
} catch {
    $statusCode = $_.Exception.Response.StatusCode
    $responseBody = $_.Exception.Response.GetResponseStream() | ForEach-Object { (New-Object System.IO.StreamReader($_)).ReadToEnd() }
    Write-Host "Status: $statusCode" -ForegroundColor Red
    Write-Host "Response: $responseBody" -ForegroundColor Red
}
Write-Host ""

# Test 5: Duplicate Email Registration
Write-Host "Test 5: Duplicate Email Registration" -ForegroundColor Yellow
$body = @{
    name = "Duplicate User"
    email = "testuser@example.com"
    password = "TestPass123!"
    password_confirmation = "TestPass123!"
} | ConvertTo-Json

try {
    $response = Invoke-WebRequest -Uri $registerUri -Method POST -Headers $headers -Body $body -ErrorAction Stop
} catch {
    $statusCode = $_.Exception.Response.StatusCode
    $responseBody = $_.Exception.Response.GetResponseStream() | ForEach-Object { (New-Object System.IO.StreamReader($_)).ReadToEnd() }
    Write-Host "Status: $statusCode" -ForegroundColor Red
    Write-Host "Response: $responseBody" -ForegroundColor Red
}
Write-Host ""

# Test 6: Wrong Password
Write-Host "Test 6: Wrong Password" -ForegroundColor Yellow
$loginUri = "http://localhost:8000/api/auth/login"
$body = @{
    email = "karnathphilipp5@gmail.com"
    password = "wrongpassword"
} | ConvertTo-Json

try {
    $response = Invoke-WebRequest -Uri $loginUri -Method POST -Headers $headers -Body $body -ErrorAction Stop
} catch {
    $statusCode = $_.Exception.Response.StatusCode
    $responseBody = $_.Exception.Response.GetResponseStream() | ForEach-Object { (New-Object System.IO.StreamReader($_)).ReadToEnd() }
    Write-Host "Status: $statusCode" -ForegroundColor Red
    Write-Host "Response: $responseBody" -ForegroundColor Red
}
Write-Host ""

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "SECURITY TESTS COMPLETED" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

