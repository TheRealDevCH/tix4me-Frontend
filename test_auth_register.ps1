# Test Register API Endpoint

$uri = "http://localhost:8000/api/auth/register"
$headers = @{
    "Content-Type" = "application/json"
}
$body = @{
    name = "Test User"
    email = "testuser@example.com"
    password = "TestPass123!"
    password_confirmation = "TestPass123!"
} | ConvertTo-Json

Write-Host "Testing Register API..." -ForegroundColor Cyan
Write-Host "URL: $uri" -ForegroundColor Gray
Write-Host "Body: $body" -ForegroundColor Gray
Write-Host ""

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -Body $body -ErrorAction Stop
    Write-Host "Status: $($response.StatusCode)" -ForegroundColor Green
    Write-Host "Response:" -ForegroundColor Green
    $response.Content | ConvertFrom-Json | ConvertTo-Json | Write-Host
    
} catch {
    Write-Host "Error Status: $($_.Exception.Response.StatusCode)" -ForegroundColor Red
    Write-Host "Error Message: $($_.Exception.Message)" -ForegroundColor Red
    $stream = $_.Exception.Response.GetResponseStream()
    $reader = New-Object System.IO.StreamReader($stream)
    $responseBody = $reader.ReadToEnd()
    Write-Host "Response Body: $responseBody" -ForegroundColor Red
}

