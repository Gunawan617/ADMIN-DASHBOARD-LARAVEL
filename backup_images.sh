#!/bin/bash

# 📸 Script Backup Gambar Laravel
# Author: Development Team
# Version: 1.0
# Description: Backup semua gambar dari storage Laravel

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_DIR="$PROJECT_DIR/backups/images"
LOG_DIR="$PROJECT_DIR/backups/logs"
STORAGE_DIR="$PROJECT_DIR/storage/app/public"
PUBLIC_STORAGE_DIR="$PROJECT_DIR/public/storage"

# Buat direktori backup jika belum ada
mkdir -p "$BACKUP_DIR"
mkdir -p "$LOG_DIR"

# Timestamp untuk nama file backup
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
BACKUP_FILE="backup_images_$TIMESTAMP.tar.gz"
LOG_FILE="$LOG_DIR/backup_$(date +%Y-%m-%d).log"

# Fungsi logging
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Fungsi error handling
error_exit() {
    log "❌ ERROR: $1"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] ERROR: $1" >> "$LOG_DIR/error_$(date +%Y-%m-%d).log"
    exit 1
}

# Header
echo "📸 ==============================================="
echo "📸    LARAVEL IMAGES BACKUP SCRIPT"
echo "📸 ==============================================="
echo "📸 Project: $(basename "$PROJECT_DIR")"
echo "📸 Timestamp: $TIMESTAMP"
echo "📸 Backup File: $BACKUP_FILE"
echo "📸 Log File: $LOG_FILE"
echo "📸 ==============================================="
echo ""

log "🚀 Starting backup process..."

# Cek apakah direktori storage ada
if [ ! -d "$STORAGE_DIR" ]; then
    error_exit "Storage directory not found: $STORAGE_DIR"
fi

# Cek apakah ada gambar di storage
IMAGE_COUNT=$(find "$STORAGE_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" -o -iname "*.gif" -o -iname "*.webp" -o -iname "*.svg" \) | wc -l)

if [ "$IMAGE_COUNT" -eq 0 ]; then
    log "⚠️  Warning: No images found in storage directory"
else
    log "📊 Found $IMAGE_COUNT images to backup"
fi

# Cek ruang disk yang tersedia
AVAILABLE_SPACE=$(df "$BACKUP_DIR" | awk 'NR==2 {print $4}')
REQUIRED_SPACE=$((IMAGE_COUNT * 1024 * 1024))  # Estimasi 1MB per gambar

if [ "$AVAILABLE_SPACE" -lt "$REQUIRED_SPACE" ]; then
    error_exit "Insufficient disk space. Available: ${AVAILABLE_SPACE}KB, Required: ${REQUIRED_SPACE}KB"
fi

log "💾 Available disk space: ${AVAILABLE_SPACE}KB"

# Buat file info backup
INFO_FILE="$BACKUP_DIR/backup_info_$TIMESTAMP.txt"
cat > "$INFO_FILE" << EOF
Laravel Images Backup Information
================================
Project: $(basename "$PROJECT_DIR")
Backup Date: $(date)
Backup File: $BACKUP_FILE
Image Count: $IMAGE_COUNT
Storage Directory: $STORAGE_DIR
Public Storage Directory: $PUBLIC_STORAGE_DIR

Directory Structure:
$(find "$STORAGE_DIR" -type d | sort)

Files to Backup:
$(find "$STORAGE_DIR" -type f | sort)

Symlinks Status:
$(ls -la "$PUBLIC_STORAGE_DIR" 2>/dev/null || echo "No public storage symlinks found")

System Information:
- OS: $(uname -a)
- Disk Usage: $(df -h "$PROJECT_DIR" | tail -1)
- Backup Size: $(du -sh "$STORAGE_DIR" 2>/dev/null || echo "0B")
EOF

log "📝 Created backup info file: $INFO_FILE"

# Backup database untuk referensi (opsional)
if [ -f "$PROJECT_DIR/.env" ]; then
    log "🗄️  Creating database backup for reference..."
    DB_BACKUP_FILE="$BACKUP_DIR/database_backup_$TIMESTAMP.sql"
    
    # Cek apakah bisa koneksi ke database
    if command -v php &> /dev/null; then
        cd "$PROJECT_DIR"
        php artisan db:dump --file="$DB_BACKUP_FILE" 2>/dev/null || log "⚠️  Database backup failed (optional)"
    fi
fi

# Proses backup
log "📦 Creating backup archive..."

cd "$PROJECT_DIR"

# Buat backup dengan tar.gz
tar -czf "$BACKUP_DIR/$BACKUP_FILE" \
    --exclude="*.log" \
    --exclude="*.tmp" \
    --exclude=".DS_Store" \
    --exclude="Thumbs.db" \
    storage/app/public/ \
    public/storage/ \
    "$INFO_FILE" \
    2>/dev/null || error_exit "Failed to create backup archive"

# Cek apakah backup berhasil dibuat
if [ ! -f "$BACKUP_DIR/$BACKUP_FILE" ]; then
    error_exit "Backup file was not created"
fi

# Cek ukuran backup
BACKUP_SIZE=$(du -h "$BACKUP_DIR/$BACKUP_FILE" | cut -f1)
log "✅ Backup created successfully: $BACKUP_FILE ($BACKUP_SIZE)"

# Validasi backup
log "🔍 Validating backup..."
if tar -tzf "$BACKUP_DIR/$BACKUP_FILE" > /dev/null 2>&1; then
    log "✅ Backup validation successful"
else
    error_exit "Backup validation failed - archive is corrupted"
fi

# Hapus backup lama (lebih dari 30 hari)
log "🧹 Cleaning old backups..."
find "$BACKUP_DIR" -name "backup_images_*.tar.gz" -mtime +30 -delete 2>/dev/null || true
find "$BACKUP_DIR" -name "backup_info_*.txt" -mtime +30 -delete 2>/dev/null || true
find "$BACKUP_DIR" -name "database_backup_*.sql" -mtime +30 -delete 2>/dev/null || true

# Summary
echo ""
echo "📸 ==============================================="
echo "📸           BACKUP COMPLETED SUCCESSFULLY"
echo "📸 ==============================================="
echo "📸 Backup File: $BACKUP_FILE"
echo "📸 Size: $BACKUP_SIZE"
echo "📸 Location: $BACKUP_DIR"
echo "📸 Images Backed Up: $IMAGE_COUNT"
echo "📸 Log File: $LOG_FILE"
echo "📸 ==============================================="

log "🎉 Backup process completed successfully!"

# Tampilkan daftar backup yang ada
echo ""
echo "📋 Available Backups:"
ls -lh "$BACKUP_DIR"/*.tar.gz 2>/dev/null | awk '{print "   " $9 " (" $5 ", " $6 " " $7 " " $8 ")"}' || echo "   No backups found"

echo ""
echo "💡 Tips:"
echo "   - Test restore dengan: ./restore_images.sh $BACKUP_FILE"
echo "   - Cek log untuk detail: tail -f $LOG_FILE"
echo "   - Setup cron untuk backup otomatis"
echo ""
