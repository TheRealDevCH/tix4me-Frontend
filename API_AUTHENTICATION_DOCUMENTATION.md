# API Authentication Documentation

## Overview

This document describes the secure token-based authentication system for the Tix4me API. The system uses cryptographically secure tokens stored in a dedicated `sessions` table to manage user authentication.

## Architecture

### Key Components

1. **LoginController** (`app/Http/Controllers/Auth/LoginController.php`)
   - Handles user login
   - Generates secure session tokens
   - Manages user logout

2. **RegisterController** (`app/Http/Controllers/Auth/RegisterController.php`)
   - Handles user registration
   - Creates new user accounts
   - Generates initial session tokens

3. **ValidateSessionToken Middleware** (`app/Http/Middleware/ValidateSessionToken.php`)
   - Validates session tokens from Authorization headers
   - Checks token expiration
   - Updates last activity timestamp

4. **Session Model** (`app/Models/Session.php`)
   - Represents user sessions
   - Stores token, user_id, expiration time, IP address, user agent
   - Provides validation methods

5. **User Model** (`app/Models/User.php`)
   - Extended with session management methods
   - `sessions()` - Get all sessions for user
   - `activeSession()` - Get current active session
   - `invalidateAllSessions()` - Logout from all devices

## Security Features

### Token Generation
- **Algorithm**: Cryptographically secure random string (60 characters)
- **Generation**: `Str::random(60)` - Uses PHP's `random_bytes()`
- **Storage**: Hashed in database (unique constraint)
- **Uniqueness**: Guaranteed by database unique constraint

### Session Management
- **Expiration**: 24 hours (configurable in controller)
- **Invalidation**: Automatic on logout or expiration
- **Device Tracking**: IP address and user agent stored
- **Activity Tracking**: Last activity timestamp updated on each request

### Protection Mechanisms
1. **Token Binding**: Each token is bound to a specific user_id
2. **Expiration**: Tokens automatically expire after 24 hours
3. **Single Session**: Previous sessions invalidated on new login
4. **Activity Tracking**: Last activity timestamp prevents stale sessions
5. **Device Identification**: IP and user agent stored for security audits

## API Endpoints

### 1. User Registration

**Endpoint**: `POST /api/auth/register`

**Authentication**: Not required

**Request Body**:
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!"
}
```

**Password Requirements**:
- Minimum 8 characters
- Must contain uppercase letters
- Must contain lowercase letters
- Must contain numbers
- Must contain special characters

**Success Response (201)**:
```json
{
    "message": "Registrierung erfolgreich",
    "token": "abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "expires_at": "2025-10-24T12:00:00Z"
}
```

**Error Response (422)**:
```json
{
    "message": "Validierungsfehler",
    "errors": {
        "email": ["Diese E-Mail-Adresse ist bereits registriert"],
        "password": ["Passwort muss Sonderzeichen enthalten"]
    }
}
```

### 2. User Login

**Endpoint**: `POST /api/auth/login`

**Authentication**: Not required

**Request Body**:
```json
{
    "email": "john@example.com",
    "password": "SecurePass123!"
}
```

**Success Response (200)**:
```json
{
    "message": "Login erfolgreich",
    "token": "abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "expires_at": "2025-10-24T12:00:00Z"
}
```

**Error Response (401)**:
```json
{
    "message": "E-Mail oder Passwort ist falsch"
}
```

### 3. User Logout

**Endpoint**: `POST /api/auth/logout`

**Authentication**: Required (Bearer token)

**Headers**:
```
Authorization: Bearer abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890
```

**Success Response (200)**:
```json
{
    "message": "Logout erfolgreich"
}
```

**Error Response (401)**:
```json
{
    "message": "Ungültiges oder abgelaufenes Token"
}
```

## Using the Token

### Authorization Header Format

All authenticated requests must include the token in the Authorization header:

```
Authorization: Bearer <token>
```

### Example Request

```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890" \
  -H "Content-Type: application/json"
```

## Database Schema

### Sessions Table

```sql
CREATE TABLE sessions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    user_agent TEXT,
    ip_address VARCHAR(45),
    last_activity DATETIME,
    expires_at DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## Implementation Notes for Backend Developers

### Adding Protected Routes

To add a new protected route, use the `validate.session.token` middleware:

```php
Route::middleware('validate.session.token')->group(function () {
    Route::get('/user/profile', [UserController::class, 'getProfile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
});
```

### Accessing User in Protected Routes

The middleware automatically attaches the user to the request:

```php
public function getProfile(Request $request)
{
    $user = $request->user; // User object from session
    $session = $request->session; // Session object
    
    return response()->json(['user' => $user]);
}
```

### Session Expiration

Sessions automatically expire after 24 hours. To change this:

1. Edit `LoginController.php` or `RegisterController.php`
2. Change `SESSION_EXPIRATION_HOURS` constant
3. Restart the application

### Invalidating All Sessions

To logout a user from all devices:

```php
$user->invalidateAllSessions();
```

## Testing the API

### Test Registration

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "TestPass123!",
    "password_confirmation": "TestPass123!"
  }'
```

### Test Login

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "TestPass123!"
  }'
```

### Test Logout

```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer <token_from_login>" \
  -H "Content-Type: application/json"
```

## Security Considerations

1. **HTTPS Only**: Always use HTTPS in production
2. **Token Storage**: Store tokens securely on the client (HttpOnly cookies or secure storage)
3. **Token Rotation**: Consider implementing token refresh mechanism for long-lived sessions
4. **Rate Limiting**: Implement rate limiting on login/register endpoints
5. **Audit Logging**: Log all authentication events for security audits
6. **IP Validation**: Consider validating IP address consistency for additional security

## Future Enhancements

1. **Token Refresh**: Implement refresh tokens for better security
2. **Multi-Factor Authentication**: Add 2FA support
3. **Session Management UI**: Allow users to manage active sessions
4. **Audit Logging**: Detailed logging of authentication events
5. **Rate Limiting**: Prevent brute force attacks
6. **Device Management**: Allow users to manage trusted devices

