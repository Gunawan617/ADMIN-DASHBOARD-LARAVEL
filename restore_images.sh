#!/bin/bash

# 🔄 Script Restore Gambar Laravel
# Author: Development Team
# Version: 1.0
# Description: Restore gambar dari backup Laravel

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_DIR="$PROJECT_DIR/backups/images"
LOG_DIR="$PROJECT_DIR/backups/logs"
STORAGE_DIR="$PROJECT_DIR/storage/app/public"
PUBLIC_STORAGE_DIR="$PROJECT_DIR/public/storage"

# Buat direktori log jika belum ada
mkdir -p "$LOG_DIR"

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

# Fungsi help
show_help() {
    echo "🔄 Laravel Images Restore Script"
    echo ""
    echo "Usage: $0 [BACKUP_FILE] [OPTIONS]"
    echo ""
    echo "Arguments:"
    echo "  BACKUP_FILE    Path to backup file (tar.gz)"
    echo ""
    echo "Options:"
    echo "  -h, --help     Show this help message"
    echo "  -l, --list     List available backups"
    echo "  -f, --force    Force restore without confirmation"
    echo "  -d, --dry-run  Show what would be restored without actually doing it"
    echo ""
    echo "Examples:"
    echo "  $0 backup_images_2024-01-15_10-30-00.tar.gz"
    echo "  $0 --list"
    echo "  $0 --force backup_images_2024-01-15_10-30-00.tar.gz"
    echo ""
}

# Parse arguments
BACKUP_FILE=""
FORCE_RESTORE=false
DRY_RUN=false
LIST_BACKUPS=false

while [[ $# -gt 0 ]]; do
    case $1 in
        -h|--help)
            show_help
            exit 0
            ;;
        -l|--list)
            LIST_BACKUPS=true
            shift
            ;;
        -f|--force)
            FORCE_RESTORE=true
            shift
            ;;
        -d|--dry-run)
            DRY_RUN=true
            shift
            ;;
        -*)
            echo "Unknown option $1"
            show_help
            exit 1
            ;;
        *)
            BACKUP_FILE="$1"
            shift
            ;;
    esac
done

# Timestamp untuk log
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
LOG_FILE="$LOG_DIR/restore_$(date +%Y-%m-%d).log"

# List available backups
if [ "$LIST_BACKUPS" = true ]; then
    echo "📋 Available Backups:"
    echo "===================="
    if [ -d "$BACKUP_DIR" ]; then
        ls -lh "$BACKUP_DIR"/*.tar.gz 2>/dev/null | awk '{print "   " $9 " (" $5 ", " $6 " " $7 " " $8 ")"}' || echo "   No backups found"
    else
        echo "   Backup directory not found: $BACKUP_DIR"
    fi
    exit 0
fi

# Cek apakah backup file diberikan
if [ -z "$BACKUP_FILE" ]; then
    echo "❌ Error: Backup file not specified"
    echo ""
    show_help
    exit 1
fi

# Cek apakah file backup ada
if [ ! -f "$BACKUP_FILE" ]; then
    # Coba cari di direktori backup
    if [ -f "$BACKUP_DIR/$BACKUP_FILE" ]; then
        BACKUP_FILE="$BACKUP_DIR/$BACKUP_FILE"
    else
        error_exit "Backup file not found: $BACKUP_FILE"
    fi
fi

# Header
echo "🔄 ==============================================="
echo "🔄    LARAVEL IMAGES RESTORE SCRIPT"
echo "🔄 ==============================================="
echo "🔄 Project: $(basename "$PROJECT_DIR")"
echo "🔄 Timestamp: $TIMESTAMP"
echo "🔄 Backup File: $BACKUP_FILE"
echo "🔄 Log File: $LOG_FILE"
echo "🔄 Mode: $([ "$DRY_RUN" = true ] && echo "DRY RUN" || echo "RESTORE")"
echo "🔄 ==============================================="
echo ""

log "🚀 Starting restore process..."

# Validasi backup file
log "🔍 Validating backup file..."
if ! tar -tzf "$BACKUP_FILE" > /dev/null 2>&1; then
    error_exit "Backup file is corrupted or invalid: $BACKUP_FILE"
fi

# Cek isi backup
log "📋 Analyzing backup contents..."
BACKUP_CONTENTS=$(tar -tzf "$BACKUP_FILE" | head -20)
log "Backup contains: $(echo "$BACKUP_CONTENTS" | wc -l) files/directories"

# Cek apakah ada storage di backup
if ! tar -tzf "$BACKUP_FILE" | grep -q "storage/app/public"; then
    error_exit "Backup does not contain storage/app/public directory"
fi

# Backup current storage (jika ada)
if [ -d "$STORAGE_DIR" ] && [ "$(ls -A "$STORAGE_DIR" 2>/dev/null)" ]; then
    CURRENT_BACKUP="$BACKUP_DIR/current_backup_before_restore_$TIMESTAMP.tar.gz"
    log "💾 Creating backup of current storage..."
    
    if [ "$DRY_RUN" = false ]; then
        tar -czf "$CURRENT_BACKUP" -C "$PROJECT_DIR" storage/app/public/ 2>/dev/null || log "⚠️  Failed to backup current storage"
        log "✅ Current storage backed up to: $CURRENT_BACKUP"
    else
        log "🔍 [DRY RUN] Would backup current storage to: $CURRENT_BACKUP"
    fi
fi

# Konfirmasi restore (kecuali force)
if [ "$FORCE_RESTORE" = false ] && [ "$DRY_RUN" = false ]; then
    echo ""
    echo "⚠️  WARNING: This will replace all current images in storage!"
    echo "   Current storage will be backed up before restore."
    echo "   Backup file: $BACKUP_FILE"
    echo ""
    read -p "Are you sure you want to continue? (y/N): " -n 1 -r
    echo ""
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        log "❌ Restore cancelled by user"
        exit 0
    fi
fi

# Proses restore
if [ "$DRY_RUN" = true ]; then
    log "🔍 [DRY RUN] Would restore from: $BACKUP_FILE"
    log "🔍 [DRY RUN] Would extract to: $PROJECT_DIR"
    echo ""
    echo "📋 Files that would be restored:"
    tar -tzf "$BACKUP_FILE" | grep -E "\.(jpg|jpeg|png|gif|webp|svg)$" | head -10
    echo "   ... and more"
    echo ""
    log "🔍 [DRY RUN] Restore simulation completed"
else
    log "📦 Extracting backup..."
    
    # Extract backup
    tar -xzf "$BACKUP_FILE" -C "$PROJECT_DIR" 2>/dev/null || error_exit "Failed to extract backup"
    
    log "✅ Backup extracted successfully"
    
    # Recreate symlinks
    log "🔗 Recreating storage symlinks..."
    
    # Hapus symlink lama jika ada
    if [ -L "$PUBLIC_STORAGE_DIR" ]; then
        rm "$PUBLIC_STORAGE_DIR"
    fi
    
    # Buat symlink baru
    if command -v php &> /dev/null; then
        cd "$PROJECT_DIR"
        php artisan storage:link 2>/dev/null || log "⚠️  Failed to create symlinks with artisan"
    fi
    
    # Manual symlink jika artisan gagal
    if [ ! -L "$PUBLIC_STORAGE_DIR" ]; then
        ln -sf "../storage/app/public" "$PUBLIC_STORAGE_DIR" 2>/dev/null || log "⚠️  Failed to create manual symlink"
    fi
    
    # Fix permissions
    log "🔧 Fixing permissions..."
    chmod -R 755 "$STORAGE_DIR" 2>/dev/null || log "⚠️  Failed to fix permissions"
    
    # Cek hasil restore
    RESTORED_COUNT=$(find "$STORAGE_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" -o -iname "*.gif" -o -iname "*.webp" -o -iname "*.svg" \) | wc -l)
    log "📊 Restored $RESTORED_COUNT images"
    
    # Validasi symlinks
    if [ -L "$PUBLIC_STORAGE_DIR" ]; then
        log "✅ Storage symlinks created successfully"
    else
        log "⚠️  Warning: Storage symlinks not created properly"
    fi
fi

# Summary
echo ""
echo "🔄 ==============================================="
echo "🔄           RESTORE COMPLETED SUCCESSFULLY"
echo "🔄 ==============================================="
echo "🔄 Backup File: $BACKUP_FILE"
echo "🔄 Mode: $([ "$DRY_RUN" = true ] && echo "DRY RUN" || echo "RESTORE")"
if [ "$DRY_RUN" = false ]; then
    echo "🔄 Images Restored: $RESTORED_COUNT"
    echo "🔄 Current Backup: $CURRENT_BACKUP"
fi
echo "🔄 Log File: $LOG_FILE"
echo "🔄 ==============================================="

log "🎉 Restore process completed successfully!"

echo ""
echo "💡 Next Steps:"
if [ "$DRY_RUN" = false ]; then
    echo "   - Test your application to ensure images load correctly"
    echo "   - Check admin dashboard for image display"
    echo "   - Verify public storage symlinks: ls -la public/storage"
else
    echo "   - Run without --dry-run to perform actual restore"
    echo "   - Use --force to skip confirmation prompt"
fi
echo "   - Check log for details: tail -f $LOG_FILE"
echo ""
