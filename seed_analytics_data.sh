#!/bin/bash

# 📊 Script Seed Analytics Data Laravel
# Author: Development Team
# Version: 1.0
# Description: Generate sample analytics data untuk testing dashboard

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOG_DIR="$PROJECT_DIR/backups/logs"

# Buat direktori log jika belum ada
mkdir -p "$LOG_DIR"

# Timestamp untuk log
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
LOG_FILE="$LOG_DIR/seed_analytics_$TIMESTAMP.log"

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
echo "📊 ==============================================="
echo "📊    LARAVEL ANALYTICS DATA SEEDER"
echo "📊 ==============================================="
echo "📊 Project: $(basename "$PROJECT_DIR")"
echo "📊 Timestamp: $TIMESTAMP"
echo "📊 Log File: $LOG_FILE"
echo "📊 ==============================================="
echo ""

log "🚀 Starting analytics data seeding..."

# Check if PHP is available
if ! command -v php &> /dev/null; then
    error_exit "PHP command not found. Please ensure PHP is installed."
fi

# Check if Visit model exists
if [ ! -f "$PROJECT_DIR/app/Models/Visit.php" ]; then
    error_exit "Visit model not found. Please run: php artisan make:model Visit"
fi

# Check database connection
echo "🔍 Checking database connection..."
DB_TEST=$(cd "$PROJECT_DIR" && php -r "
try {
    require_once 'vendor/autoload.php';
    \$app = require_once 'bootstrap/app.php';
    \$app->make('db')->connection()->getPdo();
    echo 'success';
} catch(Exception \$e) {
    echo 'error: ' . \$e->getMessage();
}
" 2>/dev/null || echo "error")

if [[ $DB_TEST != "success" ]]; then
    error_exit "Database connection failed: $DB_TEST"
fi

echo "✅ Database connection successful"

# Ask for confirmation
echo ""
echo "⚠️  WARNING: This will generate sample analytics data"
echo "   - Adds $((7 * 30)) sample visits (7 days × ~30 visits/day)"
echo "   - Uses realistic URLs and user agents"
echo "   - Existing data will NOT be deleted"
echo ""
read -p "Continue with seeding? (y/N): " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    log "❌ Seeding cancelled by user"
    exit 0
fi

# Generate sample data
echo "📊 Generating sample analytics data..."
echo "======================================"

cd "$PROJECT_DIR"

# Generate visits for the last 7 days
log "📅 Generating visits for the last 7 days..."

VISIT_COUNT=0

for i in {0..6}; do
    DATE=$(date -d "$i days ago" +%Y-%m-%d)
    DAILY_VISITS=$((RANDOM % 40 + 10))  # 10-50 visits per day

    echo "   📆 $DATE: Generating $DAILY_VISITS visits..."

    for j in $(seq 1 $DAILY_VISITS); do
        # Random URL
        URLS=("https://example.com/" "https://example.com/about" "https://example.com/blog" "https://example.com/contact" "https://example.com/services")
        RANDOM_URL=${URLS[$RANDOM % ${#URLS[@]}]}

        # Random referrer
        REFERRERS=("https://google.com" "https://facebook.com" "https://twitter.com" "https://linkedin.com" "" "")
        RANDOM_REFERRER=${REFERRERS[$RANDOM % ${#REFERRERS[@]}]}

        # Random user agent
        USER_AGENTS=(
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36"
            "Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1"
            "Mozilla/5.0 (Linux; Android 11; SM-G998B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36"
        )
        RANDOM_UA=${USER_AGENTS[$RANDOM % ${#USER_AGENTS[@]}]}

        # Random IP
        RANDOM_IP="192.168.1.$((RANDOM % 254 + 1))"

        # Random time within the day
        RANDOM_HOUR=$((RANDOM % 24))
        RANDOM_MINUTE=$((RANDOM % 60))
        DATETIME="$DATE $RANDOM_HOUR:$RANDOM_MINUTE:00"

        # Insert visit using Laravel
        php artisan tinker --execute="
        \App\Models\Visit::create([
            'url' => '$RANDOM_URL',
            'referrer' => '$RANDOM_REFERRER',
            'user_agent' => '$RANDOM_UA',
            'ip_address' => '$RANDOM_IP',
            'created_at' => '$DATETIME',
            'updated_at' => '$DATETIME'
        ]);
        " >/dev/null 2>&1

        VISIT_COUNT=$((VISIT_COUNT + 1))
    done
done

# Verify data was created
echo ""
echo "🔍 Verifying generated data..."
TOTAL_VISITS=$(cd "$PROJECT_DIR" && php artisan tinker --execute="echo \App\Models\Visit::count();" 2>/dev/null | grep -o '[0-9]*' || echo "0")

if [ "$TOTAL_VISITS" -gt "0" ]; then
    echo "✅ Successfully generated $TOTAL_VISITS visits"

    # Show summary
    echo ""
    echo "📊 Analytics Data Summary:"
    echo "=========================="

    # Most visited pages
    echo "🏆 Top 5 Most Visited Pages:"
    cd "$PROJECT_DIR" && php artisan tinker --execute="
    \App\Models\Visit::select('url')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('url')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(5)
        ->get()
        ->each(function(\$item) {
            echo '   ' . \$item->count . ' visits: ' . \$item->url . PHP_EOL;
        });
    " 2>/dev/null

    # Daily visits summary
    echo ""
    echo "📅 Daily Visits Summary:"
    cd "$PROJECT_DIR" && php artisan tinker --execute="
    \App\Models\Visit::selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get()
        ->each(function(\$item) {
            echo '   ' . \$item->date . ': ' . \$item->total . ' visits' . PHP_EOL;
        });
    " 2>/dev/null

    echo ""
    echo "🎉 Sample analytics data generated successfully!"
    echo ""
    echo "💡 Next Steps:"
    echo "   1. Access admin dashboard at: /admin"
    echo "   2. Check the charts and tables"
    echo "   3. Verify data is displayed correctly"
    echo "   4. Test different time periods"

else
    error_exit "Failed to generate analytics data"
fi

log "🎉 Analytics data seeding completed successfully! Generated $TOTAL_VISITS visits."

echo ""
echo "📝 Seed log saved to: $LOG_FILE"
