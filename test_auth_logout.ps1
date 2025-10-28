# Test Logout API Endpoint

$uri = "http://localhost:8000/api/auth/logout"
$token = "fl4DmzhmX45Sq6nyhTc5qRH35Jjab6yBKpzcwP6d2XO2t2CukLnGSgQGkg3l"
$headers = @{
    "Content-Type" = "application/json"
    "Authorization" = "Bearer $token"
}

Write-Host "Testing Logout API..." -ForegroundColor Cyan
Write-Host "URL: $uri" -ForegroundColor Gray
Write-Host "Token: $token" -ForegroundColor Gray
Write-Host ""

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -ErrorAction Stop
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

