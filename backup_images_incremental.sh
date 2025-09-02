#!/bin/bash

# 📸 Script Backup Incremental Gambar Laravel
# Author: Development Team
# Version: 1.0
# Description: Backup incremental gambar dari storage Laravel menggunakan rsync

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_DIR="$PROJECT_DIR/backups/images"
INCREMENTAL_DIR="$BACKUP_DIR/incremental"
LOG_DIR="$PROJECT_DIR/backups/logs"
STORAGE_DIR="$PROJECT_DIR/storage/app/public"

# Buat direktori backup jika belum ada
mkdir -p "$BACKUP_DIR"
mkdir -p "$INCREMENTAL_DIR"
mkdir -p "$LOG_DIR"

# Timestamp untuk nama file backup
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
LOG_FILE="$LOG_DIR/incremental_backup_$(date +%Y-%m-%d).log"

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
echo "📸    LARAVEL INCREMENTAL IMAGES BACKUP"
echo "📸 ==============================================="
echo "📸 Project: $(basename "$PROJECT_DIR")"
echo "📸 Timestamp: $TIMESTAMP"
echo "📸 Log File: $LOG_FILE"
echo "📸 ==============================================="
echo ""

log "🚀 Starting incremental backup process..."

# Cek apakah direktori storage ada
if [ ! -d "$STORAGE_DIR" ]; then
    error_exit "Storage directory not found: $STORAGE_DIR"
fi

# Cek apakah rsync tersedia
if ! command -v rsync &> /dev/null; then
    error_exit "rsync command not found. Please install rsync."
fi

# Cek apakah ada backup sebelumnya
LATEST_BACKUP=$(find "$BACKUP_DIR" -name "backup_images_*.tar.gz" -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -d' ' -f2-)

if [ -z "$LATEST_BACKUP" ]; then
    log "⚠️  No previous backup found. Running full backup instead..."
    log "💡 Run ./backup_images.sh first for initial backup"
    
    # Tanya user apakah mau jalankan full backup
    read -p "Do you want to run full backup now? (y/N): " -n 1 -r
    echo ""
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        exec "$PROJECT_DIR/backup_images.sh"
    else
        log "❌ Incremental backup cancelled"
        exit 0
    fi
fi

log "📋 Latest backup found: $(basename "$LATEST_BACKUP")"

# Cek perubahan file
log "🔍 Checking for changes since last backup..."

# Buat direktori temporary untuk extract backup terakhir
TEMP_DIR="/tmp/laravel_backup_$TIMESTAMP"
mkdir -p "$TEMP_DIR"

# Extract backup terakhir ke temporary directory
tar -xzf "$LATEST_BACKUP" -C "$TEMP_DIR" storage/app/public/ 2>/dev/null || error_exit "Failed to extract latest backup"

# Cek perubahan menggunakan rsync
CHANGES_FILE="$INCREMENTAL_DIR/changes_$TIMESTAMP.txt"
rsync -avun --delete "$STORAGE_DIR/" "$TEMP_DIR/storage/app/public/" > "$CHANGES_FILE" 2>/dev/null || true

# Hitung jumlah perubahan
CHANGED_FILES=$(grep -c "^[^d]" "$CHANGES_FILE" 2>/dev/null || echo "0")
DELETED_FILES=$(grep -c "^deleting" "$CHANGES_FILE" 2>/dev/null || echo "0")
NEW_FILES=$((CHANGED_FILES - DELETED_FILES))

log "📊 Changes detected: $NEW_FILES new/modified, $DELETED_FILES deleted"

# Jika tidak ada perubahan
if [ "$CHANGED_FILES" -eq 0 ]; then
    log "✅ No changes detected. Incremental backup not needed."
    rm -rf "$TEMP_DIR"
    rm -f "$CHANGES_FILE"
    echo ""
    echo "📸 ==============================================="
    echo "📸        NO CHANGES - BACKUP SKIPPED"
    echo "📸 ==============================================="
    echo "📸 No changes detected since last backup"
    echo "📸 Last backup: $(basename "$LATEST_BACKUP")"
    echo "📸 ==============================================="
    exit 0
fi

# Tampilkan preview perubahan
echo ""
echo "📋 Changes Preview:"
echo "==================="
head -20 "$CHANGES_FILE" | while read line; do
    if [[ $line == deleting* ]]; then
        echo "   🗑️  $line"
    elif [[ $line == */* ]]; then
        echo "   📝 $line"
    fi
done

if [ "$CHANGED_FILES" -gt 20 ]; then
    echo "   ... and $((CHANGED_FILES - 20)) more changes"
fi

echo ""

# Konfirmasi backup
read -p "Do you want to create incremental backup? (Y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Nn]$ ]]; then
    log "❌ Incremental backup cancelled by user"
    rm -rf "$TEMP_DIR"
    rm -f "$CHANGES_FILE"
    exit 0
fi

# Buat incremental backup
INCREMENTAL_BACKUP="$INCREMENTAL_DIR/incremental_$TIMESTAMP.tar.gz"
log "📦 Creating incremental backup..."

# Buat file info incremental
INFO_FILE="$INCREMENTAL_DIR/incremental_info_$TIMESTAMP.txt"
cat > "$INFO_FILE" << EOF
Laravel Incremental Images Backup Information
============================================
Project: $(basename "$PROJECT_DIR")
Backup Date: $(date)
Backup File: incremental_$TIMESTAMP.tar.gz
Base Backup: $(basename "$LATEST_BACKUP")
Changes: $NEW_FILES new/modified, $DELETED_FILES deleted

Changes Details:
$(cat "$CHANGES_FILE")

System Information:
- OS: $(uname -a)
- Disk Usage: $(df -h "$PROJECT_DIR" | tail -1)
EOF

# Buat incremental backup dengan hanya file yang berubah
cd "$PROJECT_DIR"

# Buat list file yang berubah
CHANGED_FILES_LIST="$INCREMENTAL_DIR/changed_files_$TIMESTAMP.txt"
grep "^[^d]" "$CHANGES_FILE" | sed 's|^|storage/app/public/|' > "$CHANGED_FILES_LIST" 2>/dev/null || true

# Backup file yang berubah
if [ -s "$CHANGED_FILES_LIST" ]; then
    tar -czf "$INCREMENTAL_BACKUP" \
        -T "$CHANGED_FILES_LIST" \
        "$INFO_FILE" \
        "$CHANGES_FILE" \
        2>/dev/null || error_exit "Failed to create incremental backup"
else
    error_exit "No changed files to backup"
fi

# Cek ukuran backup
BACKUP_SIZE=$(du -h "$INCREMENTAL_BACKUP" | cut -f1)
log "✅ Incremental backup created: incremental_$TIMESTAMP.tar.gz ($BACKUP_SIZE)"

# Validasi backup
log "🔍 Validating incremental backup..."
if tar -tzf "$INCREMENTAL_BACKUP" > /dev/null 2>&1; then
    log "✅ Incremental backup validation successful"
else
    error_exit "Incremental backup validation failed - archive is corrupted"
fi

# Cleanup temporary files
rm -rf "$TEMP_DIR"
rm -f "$CHANGES_FILE"
rm -f "$CHANGED_FILES_LIST"

# Hapus incremental backup lama (lebih dari 7 hari)
log "🧹 Cleaning old incremental backups..."
find "$INCREMENTAL_DIR" -name "incremental_*.tar.gz" -mtime +7 -delete 2>/dev/null || true
find "$INCREMENTAL_DIR" -name "incremental_info_*.txt" -mtime +7 -delete 2>/dev/null || true

# Summary
echo ""
echo "📸 ==============================================="
echo "📸      INCREMENTAL BACKUP COMPLETED"
echo "📸 ==============================================="
echo "📸 Backup File: incremental_$TIMESTAMP.tar.gz"
echo "📸 Size: $BACKUP_SIZE"
echo "📸 Changes: $NEW_FILES new/modified, $DELETED_FILES deleted"
echo "📸 Base Backup: $(basename "$LATEST_BACKUP")"
echo "📸 Log File: $LOG_FILE"
echo "📸 ==============================================="

log "🎉 Incremental backup process completed successfully!"

# Tampilkan daftar incremental backup
echo ""
echo "📋 Available Incremental Backups:"
ls -lh "$INCREMENTAL_DIR"/*.tar.gz 2>/dev/null | awk '{print "   " $9 " (" $5 ", " $6 " " $7 " " $8 ")"}' || echo "   No incremental backups found"

echo ""
echo "💡 Tips:"
echo "   - Incremental backups are smaller and faster"
echo "   - Use full backup for complete restore"
echo "   - Incremental backups depend on base backup"
echo "   - Setup cron for automatic incremental backups"
echo ""
