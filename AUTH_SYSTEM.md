# Sistem Autentikasi Klinik UKOM

## Overview
Sistem autentikasi lengkap dengan registrasi dan login untuk alumni, terintegrasi dengan sistem testimoni.

## Fitur

### 1. Halaman Register (`/register`)
- Form registrasi lengkap untuk alumni
- Field yang tersedia:
  - Nama Lengkap (required)
  - Email (required, unique)
  - Password (required, min 8 karakter)
  - Konfirmasi Password (required)
  - Angkatan (optional)
  - Jurusan: Perawat/Bidan (optional)
  - Nomor Telepon (optional)
- Validasi password confirmation
- Auto-login setelah registrasi berhasil
- Token disimpan di localStorage
- Redirect ke homepage setelah sukses

### 2. Halaman Login (`/login`)
- Form login sederhana
- Field: Email & Password
- Token-based authentication (Laravel Sanctum)
- Error handling yang jelas
- Link ke halaman register
- Redirect ke homepage setelah login

### 3. Header dengan Auth State
- Tampilan berbeda untuk user yang sudah login vs belum login
- **Belum Login:**
  - Tombol "Masuk" → ke `/login`
  - Tombol "Daftar Sekarang" → ke `/register`
- **Sudah Login:**
  - Avatar dengan initial nama
  - Dropdown menu dengan:
    - Nama & email user
    - Link "Kirim Testimoni"
    - Tombol "Logout"
- Responsive untuk mobile & desktop

### 4. Protected Routes
- Halaman submit testimoni memerlukan login
- Auto-redirect ke login jika belum authenticated
- Form testimoni auto-fill dengan data user (nama, angkatan, jurusan)

## Database Schema

### Updated `users` table
```sql
- id (bigint, primary key)
- name (string)
- email (string, unique)
- password (string, hashed)
- role (string, nullable)
- batch (string, nullable) - Angkatan
- major (string, nullable) - Jurusan (Perawat/Bidan)
- phone (string, nullable) - Nomor telepon
- photo (string, nullable) - Foto profil
- email_verified_at (timestamp, nullable)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## API Endpoints

### Authentication Endpoints
```
POST /api/register
- Registrasi user baru
- Body: name, email, password, batch, major, phone
- Response: access_token, user data
- Auto-generate Sanctum token

POST /api/login
- Login user
- Body: email, password
- Response: access_token, user data

GET /api/user/profile (Requires Authentication)
- Get current user profile
- Headers: Authorization: Bearer {token}
- Response: user data

POST /api/logout (Requires Authentication)
- Logout user
- Revoke current token
```

## Authentication Flow

### Registration Flow
1. User mengisi form registrasi di `/register`
2. Submit data ke `/api/register`
3. Backend validasi data
4. Create user baru dengan password hashed
5. Generate Sanctum token
6. Return token & user data
7. Frontend simpan token di localStorage
8. Redirect ke homepage
9. Header otomatis update menampilkan user menu

### Login Flow
1. User mengisi form login di `/login`
2. Submit credentials ke `/api/login`
3. Backend validasi email & password
4. Generate Sanctum token
5. Return token & user data
6. Frontend simpan token di localStorage
7. Redirect ke homepage
8. Header otomatis update

### Logout Flow
1. User klik tombol "Logout" di header
2. Remove token dari localStorage
3. Remove user data dari localStorage
4. Update UI state (header kembali ke guest mode)
5. Redirect ke homepage

### Protected Page Access
1. User akses halaman protected (e.g., `/submit-testimonial`)
2. Check token di localStorage
3. Jika tidak ada token → tampilkan login prompt
4. Jika ada token → verify dengan API
5. Jika valid → tampilkan halaman
6. Jika invalid → remove token & tampilkan login prompt

## Token Management

### Storage
- Token disimpan di `localStorage` dengan key: `auth_token`
- User data disimpan di `localStorage` dengan key: `user`

### Usage
```javascript
// Get token
const token = localStorage.getItem('auth_token');

// Use in API calls
fetch('/api/endpoint', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json'
  }
});
```

### Security
- Token menggunakan Laravel Sanctum
- Token hanya valid untuk API requests
- Token dapat di-revoke saat logout
- Password di-hash menggunakan bcrypt

## Integration dengan Testimoni

### Auto-fill Form
Saat user yang sudah login mengakses form testimoni:
1. System fetch user profile dari API
2. Auto-fill field:
   - Nama → dari `user.name`
   - Angkatan → dari `user.batch`
   - Jurusan → dari `user.major`
3. User bisa edit jika perlu
4. Submit testimoni dengan user_id otomatis

### User Identification
- Setiap testimoni terhubung dengan user via `user_id`
- Admin bisa lihat siapa yang submit testimoni
- User hanya bisa edit/delete testimoni sendiri yang masih pending

## UI/UX Features

### Responsive Design
- Form responsive untuk mobile & desktop
- Header menu adaptive
- Mobile: hamburger menu dengan user info
- Desktop: dropdown menu di pojok kanan

### Error Handling
- Validasi client-side (HTML5 validation)
- Error messages yang jelas dari server
- Loading states saat submit
- Success messages dengan auto-redirect

### User Feedback
- Loading spinner saat processing
- Success notification setelah register/login
- Error alerts dengan icon
- Smooth transitions

## File Structure

```
app/
├── Models/
│   └── User.php (updated with new fields)
├── Http/Controllers/Auth/
│   ├── RegisteredUserController.php (updated)
│   └── AuthenticatedSessionController.php

resources/
├── react-website/
│   ├── pages/
│   │   ├── LoginPage.tsx
│   │   ├── RegisterPage.tsx
│   │   └── SubmitTestimonialPage.tsx (updated)
│   └── components/
│       └── Header.tsx (updated with auth state)

database/
└── migrations/
    └── 2025_11_03_093613_add_profile_fields_to_users_table.php

routes/
└── api.php (auth routes)
```

## Usage Examples

### Register New User
```javascript
const response = await fetch('/api/register', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    name: 'John Doe',
    email: 'john@example.com',
    password: 'password123',
    batch: '2023',
    major: 'Perawat',
    phone: '081234567890'
  })
});

const data = await response.json();
// Save token
localStorage.setItem('auth_token', data.access_token);
localStorage.setItem('user', JSON.stringify(data.user));
```

### Login User
```javascript
const response = await fetch('/api/login', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    email: 'john@example.com',
    password: 'password123'
  })
});

const data = await response.json();
localStorage.setItem('auth_token', data.access_token);
localStorage.setItem('user', JSON.stringify(data.user));
```

### Check Authentication
```javascript
const checkAuth = () => {
  const token = localStorage.getItem('auth_token');
  const user = localStorage.getItem('user');
  return token && user;
};
```

## Security Best Practices

1. **Password Hashing**: Menggunakan bcrypt via Laravel Hash
2. **Token-based Auth**: Laravel Sanctum untuk API authentication
3. **HTTPS**: Pastikan production menggunakan HTTPS
4. **Input Validation**: Server-side validation untuk semua input
5. **XSS Protection**: React otomatis escape output
6. **CSRF Protection**: Sanctum handle CSRF untuk SPA

## Future Improvements

- Email verification
- Password reset functionality
- Remember me option
- Social login (Google, Facebook)
- Two-factor authentication
- Profile edit page
- Change password feature
- Session management (view active sessions)
