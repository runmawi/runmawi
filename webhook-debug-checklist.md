# Razorpay Webhook Debug Checklist

## Current Issue
- ✅ Webhook endpoint is properly configured in code (`/api/razorpay/webhook`)
- ✅ Webhook handler has extensive logging
- ❌ **NO webhook logs in production** - Razorpay is not reaching our endpoint
- ❌ Payments succeed but remain "pending" in database

## Debugging Steps

### 1. Check Razorpay Dashboard Configuration
**Login to Razorpay Dashboard:**
1. Go to **Settings** → **Webhooks**
2. Verify webhook URL: `https://runmawi.com/api/razorpay/webhook`
3. Check if these events are enabled:
   - ✅ `payment.captured`
   - ✅ `payment.failed`
   - ✅ `payment.authorized` (optional)
4. Verify webhook secret is configured
5. Check webhook status (Active/Inactive)

### 2. Test Webhook Endpoint Accessibility
**Run the test script:**
```bash
php test-webhook-accessibility.php
```

**Expected results:**
- HTTP Code: 400 (Invalid signature) - means endpoint is reachable
- Should see `=== RAZORPAY WEBHOOK ENTRY POINT ===` in logs

### 3. Check Laravel Configuration
**Route Registration:**
```bash
php artisan route:list | grep webhook
```

**Check if webhook is excluded from CSRF:**
- API routes are typically not subject to CSRF
- No authentication required for webhook endpoint

### 4. Network/Infrastructure Issues
**Common causes:**
- Firewall blocking Razorpay IP ranges
- SSL certificate issues
- Domain not accessible from internet
- Load balancer/proxy configuration

### 5. Check Webhook Secret Configuration
**Environment variables:**
```bash
grep -i webhook .env
```

**Database settings:**
```sql
SELECT * FROM payment_settings WHERE payment_type = 'Razorpay';
```

### 6. Manual Webhook Testing
**Test with actual Razorpay webhook format:**
```bash
curl -X POST https://runmawi.com/api/razorpay/webhook \
  -H "Content-Type: application/json" \
  -H "X-Razorpay-Signature: your_signature" \
  -d '{"event":"payment.captured","payload":{"payment":{"entity":{"id":"pay_test123","amount":5000,"order_id":"order_test123","status":"captured","notes":{"user_id":"201673","video_id":"39"}}}}}'
```

## Quick Fixes

### Option 1: Manual Payment Confirmation
Use our fallback endpoint to confirm the payment:
```bash
curl -X POST https://runmawi.com/api/auth/confirm_payment_success \
  -H "Content-Type: application/json" \
  -d '{"order_id":"order_QsAIdG0m65YZpX","payment_id":"pay_xxxxx","user_id":"201673"}'
```

### Option 2: Update Database Directly
If webhook is not working, update the purchase status:
```sql
UPDATE ppv_purchases 
SET status = 'captured', updated_at = NOW() 
WHERE user_id = 201673 AND video_id = 39 AND order_id = 'order_QsAIdG0m65YZpX';
```

## Monitoring

### Check Webhook Logs
```bash
tail -f storage/logs/laravel.log | grep -i webhook
```

### Check for Entry Point Logs
```bash
grep "=== RAZORPAY WEBHOOK ENTRY POINT ===" storage/logs/laravel.log
```

## Most Likely Causes (In Order)

1. **Webhook URL not configured in Razorpay dashboard**
2. **Webhook events not enabled** (payment.captured)
3. **Firewall/network blocking Razorpay servers**
4. **SSL certificate issues**
5. **Domain not accessible from internet**

## Next Steps

1. **Check Razorpay dashboard configuration** (most likely cause)
2. **Test endpoint accessibility** with the test script
3. **Enable webhook events** if not already enabled
4. **Contact hosting provider** about firewall rules for Razorpay IPs
5. **Use manual confirmation** as temporary workaround 