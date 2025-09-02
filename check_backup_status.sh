#!/bin/bash

# 📊 Script Check Status Backup Laravel
# Author: Development Team
# Version: 1.0
# Description: Monitor status backup dan kesehatan sistem

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_DIR="$PROJECT_DIR/backups/images"
INCREMENTAL_DIR="$BACKUP_DIR/incremental"
LOG_DIR="$PROJECT_DIR/backups/logs"
STORAGE_DIR="$PROJECT_DIR/storage/app/public"

# Fungsi untuk format ukuran
format_size() {
    local size=$1
    if [ "$size" -gt 1073741824 ]; then
        echo "$(( size / 1073741824 ))GB"
    elif [ "$size" -gt 1048576 ]; then
        echo "$(( size / 1048576 ))MB"
    elif [ "$size" -gt 1024 ]; then
        echo "$(( size / 1024 ))KB"
    else
        echo "${size}B"
    fi
}

# Fungsi untuk format waktu
format_time() {
    local timestamp=$1
    if [ -n "$timestamp" ]; then
        date -d "@$timestamp" "+%Y-%m-%d %H:%M:%S" 2>/dev/null || echo "Unknown"
    else
        echo "Never"
    fi
}

# Header
echo "📊 ==============================================="
echo "📊    LARAVEL BACKUP STATUS MONITOR"
echo "📊 ==============================================="
echo "📊 Project: $(basename "$PROJECT_DIR")"
echo "📊 Check Time: $(date)"
echo "📊 ==============================================="
echo ""

# Cek direktori backup
echo "📁 Backup Directory Status:"
echo "=========================="
if [ -d "$BACKUP_DIR" ]; then
    echo "✅ Backup directory exists: $BACKUP_DIR"
    BACKUP_COUNT=$(find "$BACKUP_DIR" -name "*.tar.gz" -type f | wc -l)
    echo "📊 Total backup files: $BACKUP_COUNT"
    
    if [ -d "$INCREMENTAL_DIR" ]; then
        INCREMENTAL_COUNT=$(find "$INCREMENTAL_DIR" -name "*.tar.gz" -type f | wc -l)
        echo "📊 Incremental backups: $INCREMENTAL_COUNT"
    else
        echo "⚠️  Incremental directory not found"
    fi
else
    echo "❌ Backup directory not found: $BACKUP_DIR"
    echo "💡 Run ./backup_images.sh to create first backup"
fi

echo ""

# Cek storage directory
echo "💾 Storage Directory Status:"
echo "==========================="
if [ -d "$STORAGE_DIR" ]; then
    echo "✅ Storage directory exists: $STORAGE_DIR"
    
    # Hitung file gambar
    IMAGE_COUNT=$(find "$STORAGE_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" -o -iname "*.gif" -o -iname "*.webp" -o -iname "*.svg" \) | wc -l)
    echo "📊 Total images: $IMAGE_COUNT"
    
    # Ukuran storage
    STORAGE_SIZE=$(du -sb "$STORAGE_DIR" 2>/dev/null | cut -f1)
    echo "📊 Storage size: $(format_size "$STORAGE_SIZE")"
    
    # Cek subdirectories
    echo "📁 Subdirectories:"
    find "$STORAGE_DIR" -maxdepth 1 -type d | while read dir; do
        if [ "$dir" != "$STORAGE_DIR" ]; then
            dir_name=$(basename "$dir")
            dir_count=$(find "$dir" -type f | wc -l)
            dir_size=$(du -sb "$dir" 2>/dev/null | cut -f1)
            echo "   📂 $dir_name: $dir_count files ($(format_size "$dir_size"))"
        fi
    done
else
    echo "❌ Storage directory not found: $STORAGE_DIR"
fi

echo ""

# Cek symlinks
echo "🔗 Storage Symlinks Status:"
echo "==========================="
PUBLIC_STORAGE_DIR="$PROJECT_DIR/public/storage"
if [ -L "$PUBLIC_STORAGE_DIR" ]; then
    echo "✅ Public storage symlink exists"
    TARGET=$(readlink "$PUBLIC_STORAGE_DIR")
    echo "📊 Target: $TARGET"
    
    if [ -e "$PUBLIC_STORAGE_DIR" ]; then
        echo "✅ Symlink is working correctly"
    else
        echo "❌ Symlink is broken"
    fi
else
    echo "❌ Public storage symlink not found"
    echo "💡 Run: php artisan storage:link"
fi

echo ""

# Cek backup terbaru
echo "📋 Latest Backups:"
echo "=================="
if [ -d "$BACKUP_DIR" ]; then
    # Full backups
    LATEST_FULL=$(find "$BACKUP_DIR" -name "backup_images_*.tar.gz" -type f -printf '%T@ %p\n' | sort -n | tail -1)
    if [ -n "$LATEST_FULL" ]; then
        LATEST_FULL_TIME=$(echo "$LATEST_FULL" | cut -d' ' -f1)
        LATEST_FULL_FILE=$(echo "$LATEST_FULL" | cut -d' ' -f2-)
        LATEST_FULL_SIZE=$(stat -c%s "$LATEST_FULL_FILE" 2>/dev/null || echo "0")
        echo "📦 Latest Full Backup:"
        echo "   File: $(basename "$LATEST_FULL_FILE")"
        echo "   Date: $(format_time "$LATEST_FULL_TIME")"
        echo "   Size: $(format_size "$LATEST_FULL_SIZE")"
        
        # Cek umur backup
        BACKUP_AGE=$(( $(date +%s) - ${LATEST_FULL_TIME%.*} ))
        if [ "$BACKUP_AGE" -gt 86400 ]; then
            echo "   ⚠️  Warning: Backup is older than 1 day"
        fi
    else
        echo "❌ No full backups found"
    fi
    
    # Incremental backups
    if [ -d "$INCREMENTAL_DIR" ]; then
        LATEST_INC=$(find "$INCREMENTAL_DIR" -name "incremental_*.tar.gz" -type f -printf '%T@ %p\n' | sort -n | tail -1)
        if [ -n "$LATEST_INC" ]; then
            LATEST_INC_TIME=$(echo "$LATEST_INC" | cut -d' ' -f1)
            LATEST_INC_FILE=$(echo "$LATEST_INC" | cut -d' ' -f2-)
            LATEST_INC_SIZE=$(stat -c%s "$LATEST_INC_FILE" 2>/dev/null || echo "0")
            echo "📦 Latest Incremental Backup:"
            echo "   File: $(basename "$LATEST_INC_FILE")"
            echo "   Date: $(format_time "$LATEST_INC_TIME")"
            echo "   Size: $(format_size "$LATEST_INC_SIZE")"
        else
            echo "📦 No incremental backups found"
        fi
    fi
else
    echo "❌ No backups found"
fi

echo ""

# Cek log files
echo "📝 Log Files Status:"
echo "==================="
if [ -d "$LOG_DIR" ]; then
    LOG_COUNT=$(find "$LOG_DIR" -name "*.log" -type f | wc -l)
    echo "📊 Total log files: $LOG_COUNT"
    
    # Cek log terbaru
    LATEST_LOG=$(find "$LOG_DIR" -name "*.log" -type f -printf '%T@ %p\n' | sort -n | tail -1)
    if [ -n "$LATEST_LOG" ]; then
        LATEST_LOG_TIME=$(echo "$LATEST_LOG" | cut -d' ' -f1)
        LATEST_LOG_FILE=$(echo "$LATEST_LOG" | cut -d' ' -f2-)
        echo "📄 Latest log: $(basename "$LATEST_LOG_FILE") ($(format_time "$LATEST_LOG_TIME"))"
        
        # Cek error log
        ERROR_LOG="$LOG_DIR/error_$(date +%Y-%m-%d).log"
        if [ -f "$ERROR_LOG" ]; then
            ERROR_COUNT=$(wc -l < "$ERROR_LOG" 2>/dev/null || echo "0")
            echo "❌ Today's errors: $ERROR_COUNT"
        else
            echo "✅ No errors today"
        fi
    fi
else
    echo "❌ Log directory not found: $LOG_DIR"
fi

echo ""

# Cek disk space
echo "💽 Disk Space Status:"
echo "===================="
if command -v df &> /dev/null; then
    df -h "$PROJECT_DIR" | tail -1 | awk '{
        print "📊 Project directory:"
        print "   Total: " $2
        print "   Used: " $3 " (" $5 ")"
        print "   Available: " $4
    }'
    
    if [ -d "$BACKUP_DIR" ]; then
        BACKUP_SIZE=$(du -sb "$BACKUP_DIR" 2>/dev/null | cut -f1)
        echo "📊 Backup directory size: $(format_size "$BACKUP_SIZE")"
    fi
else
    echo "❌ df command not available"
fi

echo ""

# Cek cron jobs
echo "⏰ Cron Jobs Status:"
echo "==================="
if command -v crontab &> /dev/null; then
    CRON_JOBS=$(crontab -l 2>/dev/null | grep -c "backup_images" || echo "0")
    if [ "$CRON_JOBS" -gt 0 ]; then
        echo "✅ Backup cron jobs found: $CRON_JOBS"
        crontab -l 2>/dev/null | grep "backup_images" | while read line; do
            echo "   ⏰ $line"
        done
    else
        echo "⚠️  No backup cron jobs found"
        echo "💡 Setup cron for automatic backups"
    fi
else
    echo "❌ crontab command not available"
fi

echo ""

# Summary dan rekomendasi
echo "📊 ==============================================="
echo "📊              STATUS SUMMARY"
echo "📊 ==============================================="

# Cek kesehatan umum
HEALTH_SCORE=0
TOTAL_CHECKS=5

# Check 1: Storage directory
if [ -d "$STORAGE_DIR" ]; then
    HEALTH_SCORE=$((HEALTH_SCORE + 1))
fi

# Check 2: Symlinks
if [ -L "$PUBLIC_STORAGE_DIR" ] && [ -e "$PUBLIC_STORAGE_DIR" ]; then
    HEALTH_SCORE=$((HEALTH_SCORE + 1))
fi

# Check 3: Recent backup
if [ -n "$LATEST_FULL" ]; then
    BACKUP_AGE=$(( $(date +%s) - ${LATEST_FULL_TIME%.*} ))
    if [ "$BACKUP_AGE" -lt 86400 ]; then  # Less than 1 day
        HEALTH_SCORE=$((HEALTH_SCORE + 1))
    fi
fi

# Check 4: Log directory
if [ -d "$LOG_DIR" ]; then
    HEALTH_SCORE=$((HEALTH_SCORE + 1))
fi

# Check 5: No errors today
if [ ! -f "$LOG_DIR/error_$(date +%Y-%m-%d).log" ]; then
    HEALTH_SCORE=$((HEALTH_SCORE + 1))
fi

# Tampilkan health score
HEALTH_PERCENT=$((HEALTH_SCORE * 100 / TOTAL_CHECKS))
echo "🏥 System Health: $HEALTH_SCORE/$TOTAL_CHECKS ($HEALTH_PERCENT%)"

if [ "$HEALTH_PERCENT" -ge 80 ]; then
    echo "✅ System is healthy"
elif [ "$HEALTH_PERCENT" -ge 60 ]; then
    echo "⚠️  System needs attention"
else
    echo "❌ System needs immediate attention"
fi

echo ""

# Rekomendasi
echo "💡 Recommendations:"
echo "==================="
if [ ! -d "$STORAGE_DIR" ]; then
    echo "   🔧 Create storage directory"
fi

if [ ! -L "$PUBLIC_STORAGE_DIR" ] || [ ! -e "$PUBLIC_STORAGE_DIR" ]; then
    echo "   🔗 Run: php artisan storage:link"
fi

if [ -z "$LATEST_FULL" ]; then
    echo "   📦 Run: ./backup_images.sh (first backup)"
elif [ "$BACKUP_AGE" -gt 86400 ]; then
    echo "   📦 Run: ./backup_images.sh (backup is old)"
fi

if [ "$CRON_JOBS" -eq 0 ]; then
    echo "   ⏰ Setup cron jobs for automatic backups"
fi

if [ -f "$LOG_DIR/error_$(date +%Y-%m-%d).log" ]; then
    echo "   🔍 Check error logs for issues"
fi

echo ""
echo "📊 ==============================================="
echo "📊        Status check completed"
echo "📊 ==============================================="
