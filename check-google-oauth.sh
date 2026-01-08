#!/bin/bash
# atau bisa dijalankan via php artisan tinker

# Check Google OAuth Configuration
echo "Checking Google OAuth Configuration..."
echo ""

# Check if credentials exist
if [ -z "$GOOGLE_CLIENT_ID" ]; then
    echo "❌ GOOGLE_CLIENT_ID not set in .env"
else
    echo "✅ GOOGLE_CLIENT_ID is set"
fi

if [ -z "$GOOGLE_CLIENT_SECRET" ]; then
    echo "❌ GOOGLE_CLIENT_SECRET not set in .env"
else
    echo "✅ GOOGLE_CLIENT_SECRET is set"
fi

if [ -z "$GOOGLE_REDIRECT_URI" ]; then
    echo "❌ GOOGLE_REDIRECT_URI not set in .env"
else
    echo "✅ GOOGLE_REDIRECT_URI is set to: $GOOGLE_REDIRECT_URI"
fi

echo ""
echo "Fix: Add these to your .env file:"
echo "GOOGLE_CLIENT_ID=your_id_here"
echo "GOOGLE_CLIENT_SECRET=your_secret_here"
echo "GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback"
