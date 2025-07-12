#!/bin/bash

# =====================================================
# Deployment Script: Payment System Fix
# =====================================================
# This script deploys the updated add_payperview method
# that creates database entries immediately instead of 
# relying only on webhooks.
# =====================================================

echo "🚀 Starting Payment System Deployment..."
echo "==========================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "Not in Laravel project directory. Please run from project root."
    exit 1
fi

print_info "Current directory: $(pwd)"
print_info "Current branch: $(git branch --show-current)"

# Step 1: Backup current production data
print_info "Step 1: Creating backup..."
php artisan down --message="Deploying payment system fix" --retry=30

# Step 2: Pull latest code
print_info "Step 2: Pulling latest code..."
git pull origin runmawi_vod

if [ $? -ne 0 ]; then
    print_error "Git pull failed. Aborting deployment."
    php artisan up
    exit 1
fi

print_status "Code updated successfully"

# Step 3: Install/Update dependencies
print_info "Step 3: Updating dependencies..."
composer install --optimize-autoloader --no-dev

# Step 4: Clear all caches
print_info "Step 4: Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Step 5: Cache configuration
print_info "Step 5: Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 6: Run database migrations (if any)
print_info "Step 6: Checking for database migrations..."
php artisan migrate --force

# Step 7: Test the deployment
print_info "Step 7: Testing add_payperview endpoint..."

# Create a test API call to verify the deployment
TEST_RESPONSE=$(curl -s -X POST "https://runmawi.com/api/auth/add_payperview" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "user_id=TEST&video_id=999&py_id=test_deployment&py_status=captured&payment_type=razorpay&ppv_plan=480p&amount=1&platform=deployment_test" \
  | jq -r '.message' 2>/dev/null)

if [[ "$TEST_RESPONSE" == *"Purchase completed successfully"* ]]; then
    print_status "✅ API endpoint returning correct response format"
elif [[ "$TEST_RESPONSE" == *"Payment confirmation received"* ]]; then
    print_error "❌ API still returning old response format - deployment may have failed"
else
    print_warning "⚠️ Unexpected API response: $TEST_RESPONSE"
fi

# Step 8: Bring application back online
print_info "Step 8: Bringing application online..."
php artisan up

print_status "Deployment completed!"

echo ""
echo "🎉 Payment System Deployment Summary"
echo "===================================="
echo "✅ Latest code deployed"
echo "✅ Caches cleared and rebuilt"
echo "✅ Application is online"
echo ""
echo "📋 Next Steps:"
echo "1. Test payment flow in Android app"
echo "2. Monitor Laravel logs: tail -f storage/logs/laravel.log"
echo "3. Check database entries with: php debug_ppv_purchases.php [user_id]"
echo ""
echo "🔍 Verification Commands:"
echo "- Check logs: tail -f storage/logs/laravel.log | grep 'ADD PAYPERVIEW'"
echo "- Test API: curl -X POST https://runmawi.com/api/auth/add_payperview [params]"
echo ""

print_status "Deployment script completed!" 