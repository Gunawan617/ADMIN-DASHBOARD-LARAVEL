#!/bin/bash

echo "🔒 Testing Security - Memastikan fitur lain tetap aman..."
echo "=================================================="

# Test 1: Login API (harus tetap berfungsi)
echo "📝 Test 1: Login API (harus tetap berfungsi)"
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "wrongpassword"
  }' \
  -w "\nHTTP Status: %{http_code}\n" \
  -s

echo ""
echo "================================"

# Test 2: Protected route tanpa token (harus 401)
echo "📝 Test 2: Protected route tanpa token (harus 401)"
curl -X GET http://localhost:8000/api/user/profile \
  -H "Content-Type: application/json" \
  -w "\nHTTP Status: %{http_code}\n" \
  -s

echo ""
echo "================================"

# Test 3: Admin route tanpa token (harus 401)
echo "📝 Test 3: Admin route tanpa token (harus 401)"
curl -X GET http://localhost:8000/api/admin/books \
  -H "Content-Type: application/json" \
  -w "\nHTTP Status: %{http_code}\n" \
  -s

echo ""
echo "================================"

# Test 4: Public route (harus tetap bisa diakses)
echo "📝 Test 4: Public route (harus tetap bisa diakses)"
curl -X GET http://localhost:8000/api/public/books \
  -H "Content-Type: application/json" \
  -w "\nHTTP Status: %{http_code}\n" \
  -s

echo ""
echo "✅ Security test completed!"
echo "Jika semua test menunjukkan status yang benar, maka keamanan tetap terjaga."
