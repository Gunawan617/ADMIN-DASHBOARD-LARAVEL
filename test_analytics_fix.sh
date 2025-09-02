#!/bin/bash

echo "🧪 Testing Analytics API Fix..."
echo "================================"

# Test 1: Basic POST request
echo "📝 Test 1: Basic POST request"
curl -X POST http://localhost:8000/api/analytics/track \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-Requested-With: XMLHttpRequest" \
  -d '{
    "url": "https://example.com/test",
    "referrer": "https://google.com",
    "user_agent": "Mozilla/5.0 (Test Browser)"
  }' \
  -w "\nHTTP Status: %{http_code}\n" \
  -s

echo ""
echo "================================"

# Test 2: OPTIONS preflight request
echo "📝 Test 2: OPTIONS preflight request"
curl -X OPTIONS http://localhost:8000/api/analytics/track \
  -H "Origin: http://localhost:3000" \
  -H "Access-Control-Request-Method: POST" \
  -H "Access-Control-Request-Headers: Content-Type" \
  -w "\nHTTP Status: %{http_code}\n" \
  -s

echo ""
echo "================================"

# Test 3: Test dengan credentials: omit
echo "📝 Test 3: Test dengan credentials: omit"
curl -X POST http://localhost:8000/api/analytics/track \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-Requested-With: XMLHttpRequest" \
  -H "Origin: http://localhost:3000" \
  -d '{
    "url": "https://example.com/test2",
    "referrer": "https://bing.com",
    "user_agent": "Mozilla/5.0 (Test Browser 2)"
  }' \
  -w "\nHTTP Status: %{http_code}\n" \
  -s

echo ""
echo "✅ Test completed!"
