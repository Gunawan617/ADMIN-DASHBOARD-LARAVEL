# Dokumentasi Formulir Pendaftaran

## Overview
Sistem formulir pendaftaran untuk program Bimbel dan Try Out dengan integrasi WhatsApp.

## Fitur

### 1. Halaman Pendaftaran (Frontend)
- **URL**: `/daftar`
- **Komponen**: `DaftarPage.tsx`
- Form pendaftaran dengan field:
  - Nama Lengkap (required)
  - Email (required)
  - Nomor WhatsApp (required)
  - Jenis Program: Bimbel atau Try Out (required)
  - Pesan (optional)

### 2. API Endpoint

#### Public API
- **POST** `/api/public/formulir` - Submit formulir pendaftaran
  - Request Body:
    ```json
    {
      "nama": "string",
      "email": "string",
      "whatsapp": "string",
      "jenis_program": "bimbel|tryout",
      "pesan": "string (optional)"
    }
    ```
  - Response:
    ```json
    {
      "success": true,
      "message": "Formulir pendaftaran berhasil dikirim!",
      "data": {...},
      "admin_whatsapp": "6281234567890"
    }
    ```

#### Admin API (Protected)
- **GET** `/api/admin/formulir` - List semua formulir
- **GET** `/api/admin/formulir/{id}` - Detail formulir
- **PUT** `/api/admin/formulir/{id}/status` - Update status
- **DELETE** `/api/admin/formulir/{id}` - Hapus formulir

### 3. Admin Dashboard
- **URL**: `/admin/formulir`
- Fitur:
  - List semua formulir pendaftaran
  - Filter berdasarkan status (pending, contacted, registered)
  - Detail formulir dengan tombol WhatsApp langsung
  - Update status formulir
  - Hapus formulir

### 4. Database
**Tabel**: `formulir`
- `id` - Primary key
- `nama` - Nama lengkap pendaftar
- `email` - Email pendaftar
- `whatsapp` - Nomor WhatsApp
- `jenis_program` - Enum: 'bimbel' atau 'tryout'
- `pesan` - Pesan tambahan (nullable)
- `status` - Enum: 'pending', 'contacted', 'registered' (default: pending)
- `created_at` - Timestamp
- `updated_at` - Timestamp

## Konfigurasi

### Environment Variables
Tambahkan di file `.env`:
```env
ADMIN_WHATSAPP_NUMBER=6281234567890
```

**Catatan**: Ganti nomor WhatsApp sesuai kebutuhan. Format: kode negara + nomor (tanpa +, spasi, atau tanda hubung)

## Cara Menggunakan

### Untuk User
1. Klik tombol "Daftar Sekarang" di header
2. Isi formulir pendaftaran
3. Pilih jenis program (Bimbel atau Try Out)
4. Submit formulir
5. Setelah berhasil, akan muncul tombol untuk langsung menghubungi admin via WhatsApp

### Untuk Admin
1. Login ke admin dashboard
2. Akses menu "Formulir" di sidebar
3. Lihat daftar pendaftar
4. Klik detail untuk melihat informasi lengkap
5. Update status sesuai progress (Pending → Dihubungi → Terdaftar)
6. Gunakan tombol WhatsApp untuk menghubungi pendaftar langsung

## Migration
Jalankan migration untuk membuat tabel:
```bash
php artisan migrate
```

## Testing
Test API dengan curl:
```bash
curl -X POST http://localhost:8000/api/public/formulir \
  -H "Content-Type: application/json" \
  -d '{
    "nama": "Test User",
    "email": "test@example.com",
    "whatsapp": "081234567890",
    "jenis_program": "bimbel",
    "pesan": "Saya ingin mendaftar bimbel UKOM"
  }'
```

## File yang Dibuat/Dimodifikasi

### Backend
- `app/Models/Formulir.php` - Model
- `app/Http/Controllers/FormulirController.php` - API Controller
- `app/Http/Controllers/Admin/FormulirAdminController.php` - Admin Controller
- `database/migrations/2025_11_05_090602_create_formulir_table.php` - Migration
- `routes/api.php` - API routes
- `routes/web.php` - Web routes

### Frontend
- `resources/react-website/pages/DaftarPage.tsx` - Halaman pendaftaran
- `resources/react-website/App.tsx` - Route configuration
- `resources/react-website/components/Header.tsx` - Update button "Daftar Sekarang"

### Admin Views
- `resources/views/admin/formulir/index.blade.php` - List formulir
- `resources/views/admin/formulir/show.blade.php` - Detail formulir
- `resources/views/admin/layout.blade.php` - Update sidebar menu

### Configuration
- `.env` - Tambah ADMIN_WHATSAPP_NUMBER
- `.env.example` - Tambah contoh konfigurasi

## Status Formulir
- **pending**: Formulir baru masuk, belum diproses
- **contacted**: Admin sudah menghubungi pendaftar
- **registered**: Pendaftar sudah terdaftar di program
