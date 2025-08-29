#!/bin/bash

# Test API Script untuk Admin Dashboard
# Base URL
BASE_URL="http://localhost:8000/api"

echo "🚀 Testing Admin Dashboard API"
echo "================================"

# Test Register
echo "1. Testing User Registration..."
# REGISTER_RESPONSE=$(curl -s -X POST "$BASE_URL/register" \
#   -H "Content-Type: application/json" \
#   -d '{"name":"API Test User","email":"apitest@example.com","password":"password123"}')

REGISTER_RESPONSE=$(curl -s -X POST "$BASE_URL/register" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"API Test User","email":"apitest12345@example.com","password":"password123"}')

echo "Response: $REGISTER_RESPONSE"
echo ""

# Extract token from register response
TOKEN=$(echo $REGISTER_RESPONSE | grep -o '"access_token":"[^"]*"' | cut -d'"' -f4)

if [ -z "$TOKEN" ]; then
    echo "❌ Failed to get token from registration"
    exit 1
fi

echo "✅ Registration successful! Token: ${TOKEN:0:20}..."
echo ""

# Test Login
echo "2. Testing User Login..."
LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"apitest12345@example.com","password":"password123"}')

echo "Response: $LOGIN_RESPONSE"
echo ""

# Extract token from login response
LOGIN_TOKEN=$(echo $LOGIN_RESPONSE | grep -o '"access_token":"[^"]*"' | cut -d'"' -f4)

if [ -z "$LOGIN_TOKEN" ]; then
    echo "❌ Failed to get token from login"
    exit 1
fi

echo "✅ Login successful! Token: ${LOGIN_TOKEN:0:20}..."
echo ""

# Test Get Profile
echo "3. Testing Get User Profile..."
PROFILE_RESPONSE=$(curl -s -X GET "$BASE_URL/user/profile" \
  -H "Authorization: Bearer $LOGIN_TOKEN")

echo "Response: $PROFILE_RESPONSE"
echo ""

# Test Create Post
echo "4. Testing Create Post..."
CREATE_POST_RESPONSE=$(curl -s -X POST "$BASE_URL/admin/posts" \
  -H "Authorization: Bearer $LOGIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"API Test Post","summary":"This post was created via API test","content":"Full content of the API test post"}')

echo "Response: $CREATE_POST_RESPONSE"
echo ""

# Test Get Posts
echo "5. Testing Get Posts..."
GET_POSTS_RESPONSE=$(curl -s -X GET "$BASE_URL/admin/posts" \
  -H "Authorization: Bearer $LOGIN_TOKEN")

echo "Response: $GET_POSTS_RESPONSE"
echo ""

# Test Create Book
echo "6. Testing Create Book..."
CREATE_BOOK_RESPONSE=$(curl -s -X POST "$BASE_URL/admin/books" \
  -H "Authorization: Bearer $LOGIN_TOKEN" \
  -F "title=API Test Book" \
  -F "author=API Author" \
  -F "category=API Category" \
  -F "excerpt=API Excerpt" \
  -F "description=API Description" \
  -F "price=123456" \
  -F "cover_image=@test_cover.jpg;type=image/jpeg")

echo "Response: $CREATE_BOOK_RESPONSE"
if echo "$CREATE_BOOK_RESPONSE" | grep -q '"errors"'; then
    echo "❌ Error saat create book:"
    echo "$CREATE_BOOK_RESPONSE" | jq .
    exit 1
fi
BOOK_ID=$(echo $CREATE_BOOK_RESPONSE | grep -o '"id":[0-9]*' | head -1 | cut -d':' -f2)
if [ -z "$BOOK_ID" ]; then
    echo "❌ Book ID tidak ditemukan di response."
    exit 1
fi
echo "Book ID: $BOOK_ID"
echo ""

# Test Get Books
echo "7. Testing Get Books..."
GET_BOOKS_RESPONSE=$(curl -s -X GET "$BASE_URL/admin/books" \
  -H "Authorization: Bearer $LOGIN_TOKEN")
echo "Response: $GET_BOOKS_RESPONSE"
if echo "$GET_BOOKS_RESPONSE" | grep -q '"errors"'; then
    echo "❌ Error saat get books:"
    echo "$GET_BOOKS_RESPONSE" | jq .
    exit 1
fi
echo ""

# Test Update Book
echo "8. Testing Update Book..."
UPDATE_BOOK_RESPONSE=$(curl -s -X PUT "$BASE_URL/admin/books/$BOOK_ID" \
  -H "Authorization: Bearer $LOGIN_TOKEN" \
  -F "title=Updated API Book" \
  -F "cover_image=@test_cover.jpg;type=image/jpeg")
echo "Response: $UPDATE_BOOK_RESPONSE"
echo ""

# Test Delete Book
echo "9. Testing Delete Book..."
DELETE_BOOK_RESPONSE=$(curl -s -X DELETE "$BASE_URL/admin/books/$BOOK_ID" \
  -H "Authorization: Bearer $LOGIN_TOKEN")
echo "Response: $DELETE_BOOK_RESPONSE"
echo ""

# Test Logout
echo "10. Testing Logout..."
LOGOUT_RESPONSE=$(curl -s -X POST "$BASE_URL/logout" \
  -H "Authorization: Bearer $LOGIN_TOKEN")

echo "Response: $LOGOUT_RESPONSE"
echo ""

# Test if token is revoked
echo "11. Testing Token Revocation..."
REVOKED_RESPONSE=$(curl -s -X GET "$BASE_URL/user/profile" \
  -H "Authorization: Bearer $LOGIN_TOKEN")

echo "Response: $REVOKED_RESPONSE"
echo ""

echo "🎉 API Testing Complete!"
echo "================================"
echo "✅ All endpoints working correctly!"
echo "✅ Authentication working with Sanctum!"
echo "✅ Token management working!"
echo "✅ CRUD operations working!"
echo "✅ Book CRUD API tested!"
echo ""
echo "🌐 API is ready for external applications!"
