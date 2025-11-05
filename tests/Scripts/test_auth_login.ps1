# Test Login API Endpoint

$uri = "http://localhost:8000/api/auth/login"
$headers = @{
    "Content-Type" = "application/json"
}
$body = @{
    email = "karnathphilipp5@gmail.com"
    password = "password123"
} | ConvertTo-Json

Write-Host "Testing Login API..." -ForegroundColor Cyan
Write-Host "URL: $uri" -ForegroundColor Gray
Write-Host "Body: $body" -ForegroundColor Gray
Write-Host ""

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -Body $body -ErrorAction Stop
    Write-Host "Status: $($response.StatusCode)" -ForegroundColor Green
    Write-Host "Response:" -ForegroundColor Green
    $responseJson = $response.Content | ConvertFrom-Json
    $responseJson | ConvertTo-Json | Write-Host
    
    # Save token for later use
    $token = $responseJson.token
    Write-Host ""
    Write-Host "Token saved: $token" -ForegroundColor Yellow
    
} catch {
    Write-Host "Error Status: $($_.Exception.Response.StatusCode)" -ForegroundColor Red
    Write-Host "Error Message: $($_.Exception.Message)" -ForegroundColor Red
    $stream = $_.Exception.Response.GetResponseStream()
    $reader = New-Object System.IO.StreamReader($stream)
    $responseBody = $reader.ReadToEnd()
    Write-Host "Response Body: $responseBody" -ForegroundColor Red
}

