#!/bin/bash

# 🎛️  Script Master Backup Manager Laravel
# Author: Development Team
# Version: 1.0
# Description: Master script untuk mengelola semua backup operations

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Fungsi untuk tampilkan header
show_header() {
    echo "🎛️  ==============================================="
    echo "🎛️      LARAVEL BACKUP MANAGER"
    echo "🎛️  ==============================================="
    echo "🎛️  Project: $(basename "$PROJECT_DIR")"
    echo "🎛️  Version: 1.0"
    echo "🎛️  ==============================================="
    echo ""
}

# Fungsi untuk tampilkan menu
show_menu() {
    echo "📋 Available Operations:"
    echo "========================"
    echo "1. 📦 Full Backup (backup_images.sh)"
    echo "2. 📦 Incremental Backup (backup_images_incremental.sh)"
    echo "3. 🔄 Restore from Backup (restore_images.sh)"
    echo "4. 📊 Check Backup Status (check_backup_status.sh)"
    echo "5. ⏰ Setup Cron Jobs (setup_backup_cron.sh)"
    echo "6. 📋 List Available Backups"
    echo "7. 🧹 Clean Old Backups"
    echo "8. 📖 Show Documentation"
    echo "9. 🧪 Test Backup System"
    echo "0. ❌ Exit"
    echo ""
}

# Fungsi untuk list backups
list_backups() {
    echo "📋 Available Backups:"
    echo "===================="
    
    BACKUP_DIR="$PROJECT_DIR/backups/images"
    INCREMENTAL_DIR="$BACKUP_DIR/incremental"
    
    if [ -d "$BACKUP_DIR" ]; then
        echo "📦 Full Backups:"
        ls -lh "$BACKUP_DIR"/*.tar.gz 2>/dev/null | awk '{print "   " $9 " (" $5 ", " $6 " " $7 " " $8 ")"}' || echo "   No full backups found"
        
        if [ -d "$INCREMENTAL_DIR" ]; then
            echo ""
            echo "📦 Incremental Backups:"
            ls -lh "$INCREMENTAL_DIR"/*.tar.gz 2>/dev/null | awk '{print "   " $9 " (" $5 ", " $6 " " $7 " " $8 ")"}' || echo "   No incremental backups found"
        fi
    else
        echo "❌ No backup directory found"
    fi
}

# Fungsi untuk clean old backups
clean_old_backups() {
    echo "🧹 Cleaning Old Backups..."
    echo "=========================="
    
    BACKUP_DIR="$PROJECT_DIR/backups/images"
    INCREMENTAL_DIR="$BACKUP_DIR/incremental"
    
    if [ ! -d "$BACKUP_DIR" ]; then
        echo "❌ No backup directory found"
        return
    fi
    
    # Tanya user untuk konfirmasi
    echo "⚠️  This will delete backups older than specified days."
    read -p "Enter days to keep (default 30): " days
    days=${days:-30}
    
    if [ "$days" -lt 1 ]; then
        echo "❌ Invalid number of days"
        return
    fi
    
    echo "🗑️  Deleting backups older than $days days..."
    
    # Delete old full backups
    OLD_FULL=$(find "$BACKUP_DIR" -name "backup_images_*.tar.gz" -mtime +$days -type f | wc -l)
    if [ "$OLD_FULL" -gt 0 ]; then
        find "$BACKUP_DIR" -name "backup_images_*.tar.gz" -mtime +$days -delete
        echo "✅ Deleted $OLD_FULL old full backups"
    else
        echo "📦 No old full backups to delete"
    fi
    
    # Delete old incremental backups
    if [ -d "$INCREMENTAL_DIR" ]; then
        OLD_INC=$(find "$INCREMENTAL_DIR" -name "incremental_*.tar.gz" -mtime +$days -type f | wc -l)
        if [ "$OLD_INC" -gt 0 ]; then
            find "$INCREMENTAL_DIR" -name "incremental_*.tar.gz" -mtime +$days -delete
            echo "✅ Deleted $OLD_INC old incremental backups"
        else
            echo "📦 No old incremental backups to delete"
        fi
    fi
    
    # Delete old info files
    OLD_INFO=$(find "$BACKUP_DIR" -name "backup_info_*.txt" -mtime +$days -type f | wc -l)
    if [ "$OLD_INFO" -gt 0 ]; then
        find "$BACKUP_DIR" -name "backup_info_*.txt" -mtime +$days -delete
        echo "✅ Deleted $OLD_INFO old info files"
    fi
    
    echo "🎉 Cleanup completed!"
}

# Fungsi untuk show documentation
show_documentation() {
    echo "📖 Documentation:"
    echo "================="
    echo ""
    echo "📚 Available Documentation:"
    echo "   📄 BACKUP_IMAGES_DOCUMENTATION.md - Complete backup guide"
    echo "   📄 API_DOCUMENTATION.md - API documentation"
    echo ""
    echo "🔧 Available Scripts:"
    echo "   📦 backup_images.sh - Full backup"
    echo "   📦 backup_images_incremental.sh - Incremental backup"
    echo "   🔄 restore_images.sh - Restore from backup"
    echo "   📊 check_backup_status.sh - Check system status"
    echo "   ⏰ setup_backup_cron.sh - Setup automatic backups"
    echo ""
    echo "💡 Quick Commands:"
    echo "   ./backup_images.sh                    # Full backup"
    echo "   ./backup_images_incremental.sh        # Incremental backup"
    echo "   ./restore_images.sh backup_file.tar.gz # Restore"
    echo "   ./check_backup_status.sh              # Check status"
    echo "   ./setup_backup_cron.sh --setup        # Setup cron"
    echo ""
    echo "📖 For detailed documentation, see: BACKUP_IMAGES_DOCUMENTATION.md"
}

# Fungsi untuk test backup system
test_backup_system() {
    echo "🧪 Testing Backup System..."
    echo "=========================="
    
    # Test 1: Check if all scripts exist
    echo "🔍 Test 1: Checking script files..."
    scripts=("backup_images.sh" "restore_images.sh" "backup_images_incremental.sh" "check_backup_status.sh" "setup_backup_cron.sh")
    
    for script in "${scripts[@]}"; do
        if [ -f "$PROJECT_DIR/$script" ]; then
            if [ -x "$PROJECT_DIR/$script" ]; then
                echo "   ✅ $script (executable)"
            else
                echo "   ⚠️  $script (not executable)"
            fi
        else
            echo "   ❌ $script (not found)"
        fi
    done
    
    # Test 2: Check storage directory
    echo ""
    echo "🔍 Test 2: Checking storage directory..."
    STORAGE_DIR="$PROJECT_DIR/storage/app/public"
    if [ -d "$STORAGE_DIR" ]; then
        echo "   ✅ Storage directory exists"
        IMAGE_COUNT=$(find "$STORAGE_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" -o -iname "*.gif" -o -iname "*.webp" -o -iname "*.svg" \) | wc -l)
        echo "   📊 Found $IMAGE_COUNT images"
    else
        echo "   ❌ Storage directory not found"
    fi
    
    # Test 3: Check symlinks
    echo ""
    echo "🔍 Test 3: Checking symlinks..."
    PUBLIC_STORAGE_DIR="$PROJECT_DIR/public/storage"
    if [ -L "$PUBLIC_STORAGE_DIR" ]; then
        if [ -e "$PUBLIC_STORAGE_DIR" ]; then
            echo "   ✅ Public storage symlink is working"
        else
            echo "   ❌ Public storage symlink is broken"
        fi
    else
        echo "   ❌ Public storage symlink not found"
    fi
    
    # Test 4: Check backup directory
    echo ""
    echo "🔍 Test 4: Checking backup directory..."
    BACKUP_DIR="$PROJECT_DIR/backups/images"
    if [ -d "$BACKUP_DIR" ]; then
        echo "   ✅ Backup directory exists"
        BACKUP_COUNT=$(find "$BACKUP_DIR" -name "*.tar.gz" -type f | wc -l)
        echo "   📊 Found $BACKUP_COUNT backup files"
    else
        echo "   ⚠️  Backup directory not found (will be created on first backup)"
    fi
    
    # Test 5: Check required commands
    echo ""
    echo "🔍 Test 5: Checking required commands..."
    commands=("tar" "gzip" "find" "ls" "chmod")
    
    for cmd in "${commands[@]}"; do
        if command -v "$cmd" &> /dev/null; then
            echo "   ✅ $cmd command available"
        else
            echo "   ❌ $cmd command not found"
        fi
    done
    
    # Test 6: Check permissions
    echo ""
    echo "🔍 Test 6: Checking permissions..."
    if [ -w "$PROJECT_DIR" ]; then
        echo "   ✅ Project directory is writable"
    else
        echo "   ❌ Project directory is not writable"
    fi
    
    echo ""
    echo "🎉 System test completed!"
    echo ""
    echo "💡 Recommendations:"
    if [ ! -d "$STORAGE_DIR" ]; then
        echo "   🔧 Create storage directory"
    fi
    if [ ! -L "$PUBLIC_STORAGE_DIR" ] || [ ! -e "$PUBLIC_STORAGE_DIR" ]; then
        echo "   🔗 Run: php artisan storage:link"
    fi
    if [ ! -d "$BACKUP_DIR" ]; then
        echo "   📦 Run first backup to create backup directory"
    fi
}

# Main menu loop
main() {
    show_header
    
    while true; do
        show_menu
        read -p "Select operation (0-9): " choice
        echo ""
        
        case $choice in
            1)
                echo "📦 Running Full Backup..."
                echo "========================="
                ./backup_images.sh
                ;;
            2)
                echo "📦 Running Incremental Backup..."
                echo "================================"
                ./backup_images_incremental.sh
                ;;
            3)
                echo "🔄 Restore from Backup..."
                echo "========================"
                list_backups
                echo ""
                read -p "Enter backup file name: " backup_file
                if [ -n "$backup_file" ]; then
                    ./restore_images.sh "$backup_file"
                else
                    echo "❌ No backup file specified"
                fi
                ;;
            4)
                echo "📊 Checking Backup Status..."
                echo "============================"
                ./check_backup_status.sh
                ;;
            5)
                echo "⏰ Setting up Cron Jobs..."
                echo "=========================="
                ./setup_backup_cron.sh --setup
                ;;
            6)
                list_backups
                ;;
            7)
                clean_old_backups
                ;;
            8)
                show_documentation
                ;;
            9)
                test_backup_system
                ;;
            0)
                echo "👋 Goodbye!"
                exit 0
                ;;
            *)
                echo "❌ Invalid choice. Please select 0-9."
                ;;
        esac
        
        echo ""
        read -p "Press Enter to continue..." -r
        echo ""
        show_header
    done
}

# Check if running in interactive mode
if [ -t 0 ]; then
    # Interactive mode
    main
else
    # Non-interactive mode, show help
    show_header
    show_documentation
fi
