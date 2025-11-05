$uri = "http://localhost:8000/api/password/reset"
$headers = @{
    "Content-Type" = "application/json"
}
$body = @{
    email = "test@example.com"
    password = "newpassword123"
    password_confirmation = "newpassword123"
    token = "32d52f152e4769b1fce364256be326ced2aab0d24090aa71b36f49cc648227a2"
} | ConvertTo-Json

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -Body $body -ErrorAction Stop
    Write-Host "Status: $($response.StatusCode)"
    Write-Host "Response: $($response.Content)"
} catch {
    Write-Host "Error Status: $($_.Exception.Response.StatusCode)"
    Write-Host "Error Message: $($_.Exception.Message)"
    $stream = $_.Exception.Response.GetResponseStream()
    $reader = New-Object System.IO.StreamReader($stream)
    $responseBody = $reader.ReadToEnd()
    Write-Host "Response Body: $responseBody"
}

