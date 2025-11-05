# Sistem Testimoni Klinik UKOM

## Overview
Sistem testimoni lengkap yang memungkinkan alumni untuk submit testimoni mereka, dan admin dapat mereview serta approve/reject testimoni tersebut sebelum ditampilkan di halaman publik.

## Fitur Utama

### 1. Halaman Publik Testimoni (`/testimonials`)
- Menampilkan semua testimoni yang sudah di-approve
- Filter berdasarkan jurusan (Perawat/Bidan)
- Tampilan card dengan foto, rating, dan detail alumni
- Statistics section (jumlah alumni, rating rata-rata, dll)
- Responsive design

### 2. Halaman Submit Testimoni (`/submit-testimonial`)
- Form untuk alumni submit testimoni
- Upload foto (opsional)
- Rating system (1-5 bintang)
- Field: nama, angkatan, jurusan, program, testimoni
- Validasi: testimoni minimal 50 karakter
- Memerlukan autentikasi (login)
- Success message setelah submit

### 3. Admin Panel Testimoni (`/admin/testimonials`)
- Dashboard dengan statistics (pending, approved, rejected)
- Tab filtering berdasarkan status
- Approve/Reject testimoni dengan notes
- Delete testimoni
- Tampilan lengkap semua detail testimoni
- Pagination

## Database Schema

### Table: `testimonials`
```sql
- id (bigint, primary key)
- user_id (foreign key to users)
- name (string)
- batch (string, nullable) - Angkatan
- major (string, nullable) - Jurusan
- program (string, nullable) - Program yang diikuti
- testimonial (text) - Isi testimoni
- photo (string, nullable) - Path foto
- rating (integer, 1-5)
- status (enum: pending, approved, rejected)
- admin_notes (text, nullable) - Catatan admin
- approved_at (timestamp, nullable)
- approved_by (foreign key to users, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## API Endpoints

### Public Endpoints
```
GET /api/public/testimonials
- Mendapatkan semua testimoni yang approved
- Response: Array of testimonials
```

### User Endpoints (Requires Authentication)
```
GET /api/user/testimonials
- Mendapatkan testimoni milik user yang login

POST /api/user/testimonials
- Submit testimoni baru
- Body: name, batch, major, program, testimonial, photo, rating
- Status otomatis: pending

PUT /api/user/testimonials/{id}
- Update testimoni (hanya jika status masih pending)

DELETE /api/user/testimonials/{id}
- Hapus testimoni (hanya jika status masih pending)
```

### Admin Endpoints (Requires Authentication)
```
GET /api/admin/testimonials
- Mendapatkan semua testimoni (all status)

POST /api/admin/testimonials/{id}/approve
- Approve testimoni
- Body: admin_notes (optional)

POST /api/admin/testimonials/{id}/reject
- Reject testimoni
- Body: admin_notes (required)

DELETE /api/admin/testimonials/{id}
- Hapus testimoni
```

## Web Routes (Admin Panel)
```
GET /admin/testimonials
- Halaman management testimoni

POST /admin/testimonials/{id}/approve
- Approve testimoni

POST /admin/testimonials/{id}/reject
- Reject testimoni dengan notes

DELETE /admin/testimonials/{id}
- Hapus testimoni
```

## Workflow

### 1. Alumni Submit Testimoni
1. Alumni login ke sistem
2. Akses halaman `/submit-testimonial`
3. Isi form testimoni (nama, angkatan, jurusan, program, rating, testimoni)
4. Upload foto (opsional)
5. Submit → Status: **pending**
6. Notifikasi sukses

### 2. Admin Review
1. Admin login ke admin panel
2. Akses `/admin/testimonials`
3. Lihat testimoni pending
4. Review isi testimoni
5. Pilihan:
   - **Approve**: Testimoni langsung tampil di halaman publik
   - **Reject**: Testimoni ditolak dengan catatan alasan
   - **Delete**: Hapus testimoni permanent

### 3. Tampil di Halaman Publik
1. Testimoni yang approved otomatis tampil di `/testimonials`
2. Visitor dapat melihat semua testimoni
3. Filter berdasarkan jurusan
4. Sorted by approved date (terbaru)

## File Structure

```
app/
├── Models/
│   └── Testimonial.php
├── Http/Controllers/
│   ├── TestimonialController.php (API)
│   └── Admin/
│       └── TestimonialAdminController.php (Web Admin)

resources/
├── react-website/
│   └── pages/
│       ├── TestimonialsPage.tsx (Public page)
│       └── SubmitTestimonialPage.tsx (Submit form)
└── views/
    └── admin/
        └── testimonials/
            └── index.blade.php (Admin panel)

database/
└── migrations/
    └── 2025_11_03_092112_create_testimonials_table.php

routes/
├── api.php (API routes)
└── web.php (Web routes)
```

## Cara Menggunakan

### Untuk Alumni
1. Login ke akun Anda
2. Klik menu "Testimoni" atau akses `/submit-testimonial`
3. Isi form dengan lengkap
4. Klik "Kirim Testimoni"
5. Tunggu approval dari admin

### Untuk Admin
1. Login ke admin panel
2. Klik menu "Testimonials" di sidebar
3. Review testimoni pending
4. Klik "Approve" untuk menyetujui
5. Atau klik "Reject" dan berikan alasan penolakan

### Untuk Visitor
1. Akses halaman `/testimonials`
2. Lihat semua testimoni alumni
3. Filter berdasarkan jurusan jika perlu

## Validasi

### Submit Testimoni
- Nama: Required
- Testimoni: Required, minimal 50 karakter
- Rating: Required, 1-5
- Foto: Optional, max 2MB, format: jpg, png, webp
- Batch, Major, Program: Optional

### Reject Testimoni
- Admin notes: Required (harus ada alasan penolakan)

## Security
- Submit testimoni memerlukan autentikasi
- User hanya bisa edit/delete testimoni sendiri yang masih pending
- Admin actions memerlukan autentikasi admin
- Photo upload dengan validasi tipe dan ukuran file

## Future Improvements
- Email notification ke alumni saat testimoni approved/rejected
- Rich text editor untuk testimoni
- Video testimonial support
- Featured testimonials
- Testimonial categories
- Export testimonials to PDF
