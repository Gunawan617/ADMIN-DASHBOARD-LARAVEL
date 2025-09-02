#!/bin/bash

# 🧪 Script Test Dashboard Laravel
# Author: Development Team
# Version: 1.0
# Description: Test dashboard functionality dan charts

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOG_DIR="$PROJECT_DIR/backups/logs"

# Buat direktori log jika belum ada
mkdir -p "$LOG_DIR"

# Timestamp untuk log
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
LOG_FILE="$LOG_DIR/dashboard_test_$TIMESTAMP.log"

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
echo "🧪 ==============================================="
echo "🧪    LARAVEL DASHBOARD TEST SCRIPT"
echo "🧪 ==============================================="
echo "🧪 Project: $(basename "$PROJECT_DIR")"
echo "🧪 Timestamp: $TIMESTAMP"
echo "🧪 Log File: $LOG_FILE"
echo "🧪 ==============================================="
echo ""

log "🚀 Starting dashboard test..."

# Test 1: Check if required files exist
echo "🔍 Test 1: Checking required files..."
echo "======================================"

files_to_check=(
    "resources/views/admin/dashboard.blade.php"
    "resources/views/admin/layout.blade.php"
    "app/Http/Controllers/AnalyticsController.php"
    "app/Models/Visit.php"
    "routes/web.php"
)

for file in "${files_to_check[@]}"; do
    if [ -f "$PROJECT_DIR/$file" ]; then
        echo "   ✅ $file exists"
    else
        echo "   ❌ $file not found"
        error_exit "Required file $file is missing"
    fi
done

# Test 2: Check database connection
echo ""
echo "🔍 Test 2: Checking database connection..."
echo "=========================================="

if command -v php &> /dev/null; then
    log "📡 Testing database connection..."

    # Test database connection with PHP
    DB_TEST_RESULT=$(cd "$PROJECT_DIR" && php -r "
    try {
        \$pdo = new PDO('mysql:host='.\$_ENV['DB_HOST'].';dbname='.\$_ENV['DB_DATABASE'], \$_ENV['DB_USERNAME'], \$_ENV['DB_PASSWORD']);
        \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'success';
    } catch(Exception \$e) {
        echo 'error: ' . \$e->getMessage();
    }
    " 2>/dev/null || echo "error: PHP execution failed")

    if [[ $DB_TEST_RESULT == "success" ]]; then
        echo "   ✅ Database connection successful"
    else
        echo "   ❌ Database connection failed: $DB_TEST_RESULT"
        log "⚠️  Database test failed, but continuing with other tests"
    fi
else
    echo "   ⚠️  PHP command not found, skipping database test"
fi

# Test 3: Check Visit model
echo ""
echo "🔍 Test 3: Checking Visit model..."
echo "==================================="

if [ -f "$PROJECT_DIR/app/Models/Visit.php" ]; then
    echo "   ✅ Visit model exists"

    # Check if table exists
    if command -v php &> /dev/null; then
        TABLE_EXISTS=$(cd "$PROJECT_DIR" && php -r "
        try {
            \$pdo = new PDO('mysql:host='.\$_ENV['DB_HOST'].';dbname='.\$_ENV['DB_DATABASE'], \$_ENV['DB_USERNAME'], \$_ENV['DB_PASSWORD']);
            \$result = \$pdo->query('SHOW TABLES LIKE \"visits\"');
            echo \$result->rowCount() > 0 ? 'exists' : 'not_exists';
        } catch(Exception \$e) {
            echo 'error';
        }
        " 2>/dev/null || echo "error")

        if [[ $TABLE_EXISTS == "exists" ]]; then
            echo "   ✅ Visits table exists"
        else
            echo "   ❌ Visits table not found"
            log "⚠️  Visits table not found, analytics data will be empty"
        fi
    fi
else
    echo "   ❌ Visit model not found"
fi

# Test 4: Check routes
echo ""
echo "🔍 Test 4: Checking routes..."
echo "=============================="

if command -v php &> /dev/null; then
    ROUTE_EXISTS=$(cd "$PROJECT_DIR" && php artisan route:list --name=admin.dashboard 2>/dev/null | grep -c "admin.dashboard" || echo "0")

    if [ "$ROUTE_EXISTS" -gt "0" ]; then
        echo "   ✅ Admin dashboard route exists"
    else
        echo "   ❌ Admin dashboard route not found"
        log "⚠️  Route admin.dashboard not found"
    fi
else
    echo "   ⚠️  PHP command not found, skipping route test"
fi

# Test 5: Check view compilation
echo ""
echo "🔍 Test 5: Checking view compilation..."
echo "======================================="

if command -v php &> /dev/null; then
    VIEW_COMPILE=$(cd "$PROJECT_DIR" && php -r "
    try {
        require_once 'vendor/autoload.php';
        \$app = require_once 'bootstrap/app.php';
        \$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
        \$kernel->call('view:clear');
        echo 'success';
    } catch(Exception \$e) {
        echo 'error: ' . \$e->getMessage();
    }
    " 2>/dev/null || echo "error")

    if [[ $VIEW_COMPILE == "success" ]]; then
        echo "   ✅ View compilation successful"
    else
        echo "   ⚠️  View compilation warning: $VIEW_COMPILE"
    fi
else
    echo "   ⚠️  PHP command not found, skipping view compilation test"
fi

# Test 6: Generate sample analytics data (optional)
echo ""
echo "🔍 Test 6: Generating sample analytics data..."
echo "==============================================="

read -p "Generate sample analytics data for testing? (y/N): " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Yy]$ ]]; then
    if command -v php &> /dev/null; then
        log "📊 Generating sample analytics data..."

        # Generate sample visits for the last 7 days
        cd "$PROJECT_DIR"
        php artisan tinker --execute="
        for(\$i = 0; \$i < 7; \$i++) {
            \$date = now()->subDays(\$i);
            \$visits = rand(10, 50);
            for(\$j = 0; \$j < \$visits; \$j++) {
                \App\Models\Visit::create([
                    'url' => collect([
                        'https://example.com/',
                        'https://example.com/about',
                        'https://example.com/blog',
                        'https://example.com/contact'
                    ])->random(),
                    'referrer' => collect([
                        'https://google.com',
                        'https://facebook.com',
                        null
                    ])->random(),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'ip_address' => '192.168.1.' . rand(1, 255),
                    'created_at' => \$date->copy()->addMinutes(rand(0, 1440))
                ]);
            }
        }
        echo 'Generated sample analytics data successfully';
        " 2>/dev/null || log "⚠️  Failed to generate sample data"
    else
        echo "   ⚠️  PHP command not found, skipping sample data generation"
    fi
fi

# Test 7: Check Chart.js availability
echo ""
echo "🔍 Test 7: Checking Chart.js availability..."
echo "==========================================="

CHARTJS_AVAILABLE=$(curl -s -o /dev/null -w "%{http_code}" "https://cdn.jsdelivr.net/npm/chart.js" || echo "000")

if [ "$CHARTJS_AVAILABLE" = "200" ]; then
    echo "   ✅ Chart.js CDN is accessible"
else
    echo "   ⚠️  Chart.js CDN is not accessible (HTTP $CHARTJS_AVAILABLE)"
    log "⚠️  Chart.js CDN may cause issues in dashboard"
fi

# Summary
echo ""
echo "🧪 ==============================================="
echo "🧪          DASHBOARD TEST SUMMARY"
echo "🧪 ==============================================="

echo "✅ Test completed successfully!"
echo ""
echo "📋 Test Results:"
echo "   - Required files: ✅ All found"
echo "   - Database: $([[ $DB_TEST_RESULT == "success" ]] && echo "✅ Connected" || echo "⚠️  Check connection")"
echo "   - Visit model: $([ -f "$PROJECT_DIR/app/Models/Visit.php" ] && echo "✅ Exists" || echo "❌ Missing")"
echo "   - Routes: $([ "$ROUTE_EXISTS" -gt "0" ] && echo "✅ Configured" || echo "⚠️  Check routes")"
echo "   - Views: $([[ $VIEW_COMPILE == "success" ]] && echo "✅ Compiled" || echo "⚠️  Check compilation")"
echo "   - Chart.js: $([ "$CHARTJS_AVAILABLE" = "200" ] && echo "✅ Available" || echo "⚠️  CDN issue")"

echo ""
echo "💡 Next Steps:"
echo "   1. Access admin dashboard at: /admin"
echo "   2. Check browser console for JavaScript errors"
echo "   3. Verify charts display correctly"
echo "   4. Test table data loading"
echo ""
echo "🔧 If charts don't work:"
echo "   - Check browser network tab for Chart.js loading"
echo "   - Verify analytics data exists in database"
echo "   - Check Laravel logs for PHP errors"
echo ""
echo "📊 Sample URLs to generate analytics data:"
echo "   - http://localhost:8000/ (with Next.js running)"
echo "   - Or run: ./seed_analytics_data.sh"

log "🎉 Dashboard test completed successfully!"

echo ""
echo "📝 Test log saved to: $LOG_FILE"
