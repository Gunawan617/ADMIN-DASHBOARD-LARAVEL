# 📸 Dokumentasi Backup Gambar - Admin Dashboard Laravel

## 📋 Overview
Dokumentasi ini menjelaskan cara melakukan backup dan restore gambar yang tersimpan di Laravel storage untuk aplikasi Admin Dashboard.

## 📁 Struktur Direktori Gambar

### Storage Laravel (`storage/app/public/`)
```
storage/app/public/
├── books/                 # Gambar cover buku
├── team_members/          # Foto anggota tim
├── posts/                 # Gambar artikel/posts
├── bimbel_programs/       # Gambar program bimbel
├── tryout_programs/       # Gambar program tryout
└── uploads/               # Upload umum
```

### Public Storage (`public/storage/`)
```
public/storage/
├── books/                 # Symlink ke storage/app/public/books
├── team_members/          # Symlink ke storage/app/public/team_members
├── posts/                 # Symlink ke storage/app/public/posts
├── bimbel_programs/       # Symlink ke storage/app/public/bimbel_programs
├── tryout_programs/       # Symlink ke storage/app/public/tryout_programs
└── uploads/               # Symlink ke storage/app/public/uploads
```

## 🔧 Script Backup yang Tersedia

### 1. `backup_images.sh` - Backup Lengkap
- Backup semua gambar dari storage
- Kompres dengan tar.gz
- Include metadata dan timestamp
- Backup database untuk referensi

### 2. `backup_images_incremental.sh` - Backup Incremental
- Backup hanya file yang berubah
- Lebih cepat untuk backup rutin
- Menggunakan rsync untuk efisiensi

### 3. `restore_images.sh` - Restore Backup
- Restore gambar dari backup
- Recreate symlinks
- Validasi integritas file

## 📊 Informasi Backup

### Ukuran Estimasi
- **Books**: ~50-200MB (tergantung jumlah buku)
- **Team Members**: ~10-50MB (foto profil)
- **Posts**: ~100-500MB (gambar artikel)
- **Programs**: ~50-200MB (gambar program)
- **Total**: ~200MB - 1GB (tergantung konten)

### Format Backup
- **File**: `backup_images_YYYY-MM-DD_HH-MM-SS.tar.gz`
- **Lokasi**: `./backups/images/`
- **Kompresi**: gzip (tingkat 6)

## 🚀 Cara Penggunaan

### Backup Manual
```bash
# Backup lengkap
./backup_images.sh

# Backup incremental
./backup_images_incremental.sh

# Restore dari backup
./restore_images.sh backup_images_2024-01-15_10-30-00.tar.gz
```

### Backup Otomatis (Cron)
```bash
# Edit crontab
crontab -e

# Backup harian jam 2 pagi
0 2 * * * /path/to/your/project/backup_images.sh

# Backup incremental setiap 6 jam
0 */6 * * * /path/to/your/project/backup_images_incremental.sh
```

## 🔍 Monitoring dan Log

### Log Files
- `./backups/logs/backup_YYYY-MM-DD.log` - Log backup
- `./backups/logs/restore_YYYY-MM-DD.log` - Log restore
- `./backups/logs/error_YYYY-MM-DD.log` - Log error

### Monitoring
```bash
# Cek status backup terakhir
./check_backup_status.sh

# Cek ukuran backup
ls -lh ./backups/images/

# Cek log error
tail -f ./backups/logs/error_$(date +%Y-%m-%d).log
```

## ⚠️ Penting untuk Diingat

### Sebelum Backup
1. Pastikan ada ruang disk yang cukup
2. Cek permission direktori storage
3. Pastikan symlink public/storage sudah benar

### Setelah Backup
1. Test restore di environment development
2. Verifikasi integritas file
3. Simpan backup di lokasi aman (cloud storage)

### Troubleshooting
1. **Permission denied**: Cek ownership file storage
2. **Symlink broken**: Jalankan `php artisan storage:link`
3. **Disk full**: Hapus backup lama atau pindah ke storage lain

## 🔐 Keamanan

### Enkripsi Backup (Opsional)
```bash
# Backup dengan enkripsi
./backup_images_encrypted.sh

# Restore dengan dekripsi
./restore_images_encrypted.sh backup_encrypted.tar.gz.enc
```

### Backup ke Cloud Storage
- **AWS S3**: `./backup_to_s3.sh`
- **Google Drive**: `./backup_to_gdrive.sh`
- **Dropbox**: `./backup_to_dropbox.sh`

## 📈 Best Practices

1. **Backup Rutin**: Setiap hari untuk production
2. **Multiple Locations**: Simpan di 3 lokasi berbeda
3. **Test Restore**: Test restore secara berkala
4. **Monitor Space**: Pantau penggunaan disk
5. **Documentation**: Update dokumentasi setelah perubahan

## 🆘 Emergency Recovery

### Jika Storage Corrupt
```bash
# 1. Stop aplikasi
sudo systemctl stop nginx
sudo systemctl stop php8.1-fpm

# 2. Restore dari backup terbaru
./restore_images.sh backup_images_2024-01-15_10-30-00.tar.gz

# 3. Recreate symlinks
php artisan storage:link

# 4. Fix permissions
sudo chown -R www-data:www-data storage/
sudo chmod -R 755 storage/

# 5. Restart aplikasi
sudo systemctl start php8.1-fpm
sudo systemctl start nginx
```

### Jika Backup Corrupt
```bash
# Cek integritas backup
tar -tzf backup_images_2024-01-15_10-30-00.tar.gz > /dev/null

# Jika corrupt, gunakan backup sebelumnya
./restore_images.sh backup_images_2024-01-14_10-30-00.tar.gz
```

## 📞 Kontak Support

Jika mengalami masalah dengan backup/restore:
1. Cek log error di `./backups/logs/`
2. Dokumentasikan error yang terjadi
3. Hubungi tim development dengan informasi:
   - Error message
   - Log file
   - Langkah yang sudah dicoba

---
**Last Updated**: $(date)
**Version**: 1.0
**Author**: Development Team
