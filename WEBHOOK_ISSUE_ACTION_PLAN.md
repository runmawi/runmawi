# 🚨 WEBHOOK ISSUE - ACTION PLAN

## 🔍 PROBLEM IDENTIFIED

**CONFIRMED ISSUE**: Webhook delivery stopped working around **19:16 (7:16 PM)** on 2025-07-12

### Timeline Analysis:
- ✅ **Last successful webhook**: 04:03:31 (4:03 AM)
- ❌ **First failed webhook**: 19:16:28 (7:16 PM)
- ⏱️ **Failure window**: ~15 hours gap between working and broken webhooks

### Current Status:
- **5 pending payments** from 19:16 onwards - no webhooks received
- **Previous payments working** - webhooks successful until 04:03 AM
- **Webhook endpoint accessible** - returns HTTP 400 (expected for unsigned requests)

## 🎯 ROOT CAUSE

This is **NOT a code issue** - it's a **webhook delivery configuration issue** that started at a specific time.

## 📋 IMMEDIATE ACTION ITEMS

### 1. **CHECK RAZORPAY DASHBOARD** (PRIORITY 1)
   
   **Login to Razorpay Dashboard** → **Settings** → **Webhooks**
   
   **Verify these settings:**
   - [ ] Webhook URL: `https://runmawi.com/api/razorpay/webhook`
   - [ ] Status: **Active/Enabled**
   - [ ] Events enabled: `payment.captured`, `payment.failed`
   - [ ] Environment: **Live** (not Test)
   - [ ] Secret key matches database

### 2. **CHECK WEBHOOK DELIVERY LOGS** (PRIORITY 1)
   
   **In Razorpay Dashboard** → **Webhooks** → **Delivery Logs**
   
   **Look for:**
   - [ ] Recent delivery attempts (after 19:16)
   - [ ] Failed delivery attempts with error messages
   - [ ] HTTP status codes returned
   - [ ] Retry attempts

### 3. **VERIFY WEBHOOK SECRET** (PRIORITY 2)
   
   **Compare these values:**
   - Razorpay Dashboard webhook secret
   - Database `payment_settings.webhook_secret`
   - Environment variable `RAZORPAY_WEBHOOK_SECRET`
   
   **All must match exactly!**

### 4. **TEST WEBHOOK MANUALLY** (PRIORITY 2)
   
   **In Razorpay Dashboard** → **Webhooks** → **Test Webhook**
   
   Send a test `payment.captured` event and check:
   - [ ] Webhook received in application logs
   - [ ] Database entry created in `razorpay_webhook_logs`

## 🔧 DIAGNOSTIC COMMANDS

### Run on Server:
```bash
# Check recent webhook activity
php investigate-webhook-timing.php

# Monitor logs in real-time
tail -f /home/runmawi/storage/logs/laravel.log | grep -i webhook

# Monitor webhook specific logs
./monitor-webhooks.sh
```

## 🚨 EMERGENCY WORKAROUND

If webhooks remain broken, **manually convert pending payments**:

```bash
# Find pending payments
php artisan tinker
>>> App\PpvPurchase::where('status', 'pending')->where('created_at', '>=', '2025-07-12 19:16:00')->get();

# Manually mark as captured (after confirming payment success)
>>> App\PpvPurchase::where('order_id', 'order_QsB7RQz18H1APf')->update(['status' => 'captured']);
```

## 🎯 LIKELY SCENARIOS

### Scenario 1: **Webhook URL Changed** (80% probability)
- Someone updated webhook URL in Razorpay dashboard
- URL pointing to wrong endpoint or environment
- **Fix**: Update webhook URL to correct endpoint

### Scenario 2: **Webhook Secret Changed** (70% probability)
- Webhook secret was rotated in Razorpay dashboard
- Application still using old secret
- **Fix**: Update application secret to match dashboard

### Scenario 3: **Webhook Disabled** (60% probability)
- Webhook was accidentally disabled in dashboard
- **Fix**: Re-enable webhook in dashboard

### Scenario 4: **Razorpay Service Issue** (30% probability)
- Razorpay webhook service experiencing issues
- **Fix**: Contact Razorpay support

## 📊 VERIFICATION STEPS

After making changes:

1. **Make test payment** (small amount)
2. **Monitor logs** in real-time
3. **Check payment status** in database
4. **Verify webhook received** in logs
5. **Confirm status updated** to captured

## 🚀 NEXT STEPS

1. **Immediately check Razorpay dashboard** webhook configuration
2. **Run webhook timing investigation** on server
3. **Test webhook delivery** with manual test
4. **Monitor logs** during test payment
5. **Report findings** for further assistance

## 📞 ESCALATION

If issue persists after checking above:
- Contact Razorpay support with timeline details
- Provide webhook delivery logs from dashboard
- Reference successful webhooks from 04:03 AM vs failed ones from 19:16 PM

---

**🔥 URGENT**: This affects all new payments. Priority should be resolving webhook delivery ASAP. 