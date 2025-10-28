# Test Invalid Token

$uri = "http://localhost:8000/api/auth/logout"
$invalidToken = "invalid_token_12345"
$headers = @{
    "Content-Type" = "application/json"
    "Authorization" = "Bearer $invalidToken"
}

Write-Host "Testing Invalid Token..." -ForegroundColor Cyan
Write-Host "URL: $uri" -ForegroundColor Gray
Write-Host "Token: $invalidToken" -ForegroundColor Gray
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

