#!/bin/bash

# ☁️  Script Backup ke Cloud Storage Laravel
# Author: Development Team
# Version: 1.0
# Description: Backup gambar ke cloud storage (AWS S3, Google Drive, dll)

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_DIR="$PROJECT_DIR/backups/images"
LOG_DIR="$PROJECT_DIR/backups/logs"

# Buat direktori log jika belum ada
mkdir -p "$LOG_DIR"

# Timestamp untuk log
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
LOG_FILE="$LOG_DIR/cloud_backup_$(date +%Y-%m-%d).log"

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
    echo "☁️  Laravel Cloud Backup Script"
    echo ""
    echo "Usage: $0 [OPTIONS] [BACKUP_FILE]"
    echo ""
    echo "Options:"
    echo "  -h, --help           Show this help message"
    echo "  -s, --service        Cloud service (aws, gdrive, dropbox)"
    echo "  -b, --bucket         S3 bucket name (for AWS)"
    echo "  -f, --folder         Cloud folder path"
    echo "  -l, --list           List available backups"
    echo "  -d, --download       Download from cloud"
    echo ""
    echo "Examples:"
    echo "  $0 --service aws --bucket my-bucket backup_images_2024-01-15.tar.gz"
    echo "  $0 --service gdrive --folder /backups backup_images_2024-01-15.tar.gz"
    echo "  $0 --list"
    echo ""
}

# Fungsi untuk list available backups
list_backups() {
    echo "📋 Available Local Backups:"
    echo "==========================="
    
    if [ -d "$BACKUP_DIR" ]; then
        ls -lh "$BACKUP_DIR"/*.tar.gz 2>/dev/null | awk '{print "   " $9 " (" $5 ", " $6 " " $7 " " $8 ")"}' || echo "   No backups found"
    else
        echo "   No backup directory found"
    fi
}

# Fungsi untuk upload ke AWS S3
upload_to_aws() {
    local backup_file="$1"
    local bucket="$2"
    local folder="$3"
    
    log "☁️  Uploading to AWS S3..."
    
    # Cek apakah AWS CLI terinstall
    if ! command -v aws &> /dev/null; then
        error_exit "AWS CLI not found. Please install AWS CLI first."
    fi
    
    # Cek apakah AWS configured
    if ! aws sts get-caller-identity &> /dev/null; then
        error_exit "AWS not configured. Please run 'aws configure' first."
    fi
    
    # Upload file
    local s3_key="$folder/$(basename "$backup_file")"
    log "📤 Uploading $backup_file to s3://$bucket/$s3_key"
    
    if aws s3 cp "$backup_file" "s3://$bucket/$s3_key"; then
        log "✅ Upload successful: s3://$bucket/$s3_key"
        
        # Set metadata
        aws s3api put-object-tagging \
            --bucket "$bucket" \
            --key "$s3_key" \
            --tagging 'TagSet=[{Key=backup_type,Value=laravel_images},{Key=backup_date,Value='$(date +%Y-%m-%d)'}]' 2>/dev/null || true
        
        return 0
    else
        error_exit "Failed to upload to S3"
    fi
}

# Fungsi untuk upload ke Google Drive
upload_to_gdrive() {
    local backup_file="$1"
    local folder="$2"
    
    log "☁️  Uploading to Google Drive..."
    
    # Cek apakah gdrive terinstall
    if ! command -v gdrive &> /dev/null; then
        error_exit "gdrive command not found. Please install gdrive first."
    fi
    
    # Upload file
    log "📤 Uploading $backup_file to Google Drive folder: $folder"
    
    if gdrive upload --parent "$folder" "$backup_file"; then
        log "✅ Upload successful to Google Drive"
        return 0
    else
        error_exit "Failed to upload to Google Drive"
    fi
}

# Fungsi untuk upload ke Dropbox
upload_to_dropbox() {
    local backup_file="$1"
    local folder="$2"
    
    log "☁️  Uploading to Dropbox..."
    
    # Cek apakah dropbox uploader terinstall
    if ! command -v dropbox_uploader.sh &> /dev/null; then
        error_exit "dropbox_uploader.sh not found. Please install Dropbox Uploader first."
    fi
    
    # Upload file
    local dropbox_path="$folder/$(basename "$backup_file")"
    log "📤 Uploading $backup_file to Dropbox: $dropbox_path"
    
    if dropbox_uploader.sh upload "$backup_file" "$dropbox_path"; then
        log "✅ Upload successful to Dropbox: $dropbox_path"
        return 0
    else
        error_exit "Failed to upload to Dropbox"
    fi
}

# Fungsi untuk download dari cloud
download_from_cloud() {
    local service="$1"
    local backup_file="$2"
    local bucket="$3"
    local folder="$4"
    
    log "☁️  Downloading from $service..."
    
    case $service in
        aws)
            if ! command -v aws &> /dev/null; then
                error_exit "AWS CLI not found"
            fi
            
            local s3_key="$folder/$(basename "$backup_file")"
            log "📥 Downloading from s3://$bucket/$s3_key"
            
            if aws s3 cp "s3://$bucket/$s3_key" "$BACKUP_DIR/"; then
                log "✅ Download successful"
            else
                error_exit "Failed to download from S3"
            fi
            ;;
        gdrive)
            if ! command -v gdrive &> /dev/null; then
                error_exit "gdrive command not found"
            fi
            
            log "📥 Downloading from Google Drive"
            if gdrive download "$backup_file" --path "$BACKUP_DIR/"; then
                log "✅ Download successful"
            else
                error_exit "Failed to download from Google Drive"
            fi
            ;;
        dropbox)
            if ! command -v dropbox_uploader.sh &> /dev/null; then
                error_exit "dropbox_uploader.sh not found"
            fi
            
            local dropbox_path="$folder/$(basename "$backup_file")"
            log "📥 Downloading from Dropbox: $dropbox_path"
            
            if dropbox_uploader.sh download "$dropbox_path" "$BACKUP_DIR/"; then
                log "✅ Download successful"
            else
                error_exit "Failed to download from Dropbox"
            fi
            ;;
        *)
            error_exit "Unsupported service: $service"
            ;;
    esac
}

# Parse arguments
SERVICE=""
BUCKET=""
FOLDER=""
BACKUP_FILE=""
LIST_ONLY=false
DOWNLOAD=false

while [[ $# -gt 0 ]]; do
    case $1 in
        -h|--help)
            show_help
            exit 0
            ;;
        -s|--service)
            SERVICE="$2"
            shift 2
            ;;
        -b|--bucket)
            BUCKET="$2"
            shift 2
            ;;
        -f|--folder)
            FOLDER="$2"
            shift 2
            ;;
        -l|--list)
            LIST_ONLY=true
            shift
            ;;
        -d|--download)
            DOWNLOAD=true
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

# Header
echo "☁️  ==============================================="
echo "☁️      LARAVEL CLOUD BACKUP SCRIPT"
echo "☁️  ==============================================="
echo "☁️  Project: $(basename "$PROJECT_DIR")"
echo "☁️  Timestamp: $TIMESTAMP"
echo "☁️  Log File: $LOG_FILE"
echo "☁️  ==============================================="
echo ""

log "🚀 Starting cloud backup process..."

# List backups jika diminta
if [ "$LIST_ONLY" = true ]; then
    list_backups
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

# Cek apakah service diberikan
if [ -z "$SERVICE" ]; then
    echo "❌ Error: Cloud service not specified"
    echo ""
    show_help
    exit 1
fi

# Set default folder jika tidak diberikan
if [ -z "$FOLDER" ]; then
    FOLDER="laravel-backups"
fi

# Proses upload/download
if [ "$DOWNLOAD" = true ]; then
    download_from_cloud "$SERVICE" "$BACKUP_FILE" "$BUCKET" "$FOLDER"
else
    case $SERVICE in
        aws)
            if [ -z "$BUCKET" ]; then
                error_exit "S3 bucket not specified. Use --bucket option."
            fi
            upload_to_aws "$BACKUP_FILE" "$BUCKET" "$FOLDER"
            ;;
        gdrive)
            upload_to_gdrive "$BACKUP_FILE" "$FOLDER"
            ;;
        dropbox)
            upload_to_dropbox "$BACKUP_FILE" "$FOLDER"
            ;;
        *)
            error_exit "Unsupported service: $SERVICE. Supported: aws, gdrive, dropbox"
            ;;
    esac
fi

# Summary
echo ""
echo "☁️  ==============================================="
echo "☁️           CLOUD BACKUP COMPLETED"
echo "☁️  ==============================================="
echo "☁️  Service: $SERVICE"
echo "☁️  Backup File: $(basename "$BACKUP_FILE")"
echo "☁️  Cloud Path: $FOLDER/$(basename "$BACKUP_FILE")"
echo "☁️  Log File: $LOG_FILE"
echo "☁️  ==============================================="

log "🎉 Cloud backup process completed successfully!"

echo ""
echo "💡 Tips:"
echo "   - Setup cloud credentials before running"
echo "   - Use --download to restore from cloud"
echo "   - Check cloud storage for uploaded files"
echo "   - Monitor costs for cloud storage usage"
echo ""
