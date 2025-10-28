$uri = "http://localhost:8000/api/password/email"
$headers = @{
    "Content-Type" = "application/json"
}
$body = @{
    email = "karnathphilipp5@gmail.com"
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

