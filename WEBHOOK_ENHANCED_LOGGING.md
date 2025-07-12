# Enhanced Webhook Logging Implementation

## 🎯 Purpose
We've enhanced the webhook logging system to help debug why webhooks are not being received for specific payments (like order_QsAIdG0m65YZpX for user 201673 video 39).

## 🚀 What's Been Added

### 1. Enhanced Webhook Handler Logging
**File**: `app/Http/Controllers/RazorpayController.php`

#### Entry Point Logging
- 🚀 **Webhook Entry Point**: Logs every webhook request with detailed headers and metadata
- 📦 **Raw Payload**: Logs complete webhook payload for debugging
- 🔐 **Signature Verification**: Detailed logging of signature validation process

#### Enhanced Payment Processing
- 💳 **Payment Handler Start**: Marks beginning of payment processing
- 💰 **Payment Data Extraction**: Logs all payment fields and metadata
- 📝 **Webhook Record**: Logs database insertion details
- 📋 **Notes Processing**: Detailed logging of payment notes

#### Special Detection
- 🎯 **Video 39 Detection**: Special logging when video 39 is detected
- 👤 **User 201673 Detection**: Special logging when user 201673 is detected
- ✅ **Success Logging**: Confirms successful webhook processing

#### Error Handling
- ❌ **Signature Failures**: Detailed signature validation failures
- 💥 **Fatal Errors**: Comprehensive error logging with stack traces

### 2. Signature Verification Enhancements
**Enhanced logging includes:**
- Secret configuration validation
- Signature comparison details
- Body hash verification
- Database vs environment configuration checks

### 3. Testing Tools

#### Test Webhook Script
**File**: `test-webhook-logging.php`
- Simulates webhook calls with test data
- Tests signature validation
- Provides feedback on webhook processing

#### Monitoring Script
**File**: `monitor-webhooks.sh`
- Real-time webhook log monitoring
- Colored output for easy reading
- Search functionality for specific events

## 🔧 How to Use

### 1. Test Webhook Endpoint
```bash
php test-webhook-logging.php
```

### 2. Monitor Live Webhooks
```bash
chmod +x monitor-webhooks.sh
./monitor-webhooks.sh live
```

### 3. Search for Specific Events
```bash
./monitor-webhooks.sh search
```

### 4. View Recent Webhooks
```bash
./monitor-webhooks.sh recent
```

## 📊 Log Patterns to Look For

### Successful Webhook Processing
```
🚀 === RAZORPAY WEBHOOK ENTRY POINT === 🚀
📦 Razorpay Webhook Raw Payload
🔐 Webhook Signature Verification
✅ Signature verification passed
📋 Parsed Webhook Payload
💳 Processing payment.captured event
💳 === PAYMENT CAPTURED HANDLER START ===
💰 Payment captured data extraction
📝 Inserting webhook event record
📋 Extracted notes for processing
🎯🎯🎯 VIDEO 39 WEBHOOK DETECTED (if video 39)
👤👤👤 USER 201673 WEBHOOK DETECTED (if user 201673)
✅ Webhook processing completed successfully
```

### Failed Webhook Processing
```
🚀 === RAZORPAY WEBHOOK ENTRY POINT === 🚀
📦 Razorpay Webhook Raw Payload
🔐 Webhook Signature Verification
❌ Razorpay Webhook: Invalid signature - REJECTING REQUEST
```

### No Webhook Received
```
(No logs at all - means Razorpay is not sending webhooks)
```

## 🔍 Debugging Process

### Step 1: Check if Webhooks Are Being Received
```bash
grep "🚀 === RAZORPAY WEBHOOK ENTRY POINT ===" /home/runmawi/storage/logs/laravel.log
```

### Step 2: Look for Specific Order/Payment
```bash
grep -i "order_QsAIdG0m65YZpX" /home/runmawi/storage/logs/laravel.log
```

### Step 3: Check for Video 39 Events
```bash
grep "🎯🎯🎯 VIDEO 39 WEBHOOK DETECTED" /home/runmawi/storage/logs/laravel.log
```

### Step 4: Check for User 201673 Events
```bash
grep "👤👤👤 USER 201673 WEBHOOK DETECTED" /home/runmawi/storage/logs/laravel.log
```

## 🎯 Expected Outcomes

### If Webhooks Are Working
- You'll see detailed logs for every webhook received
- Special logging for video 39 and user 201673
- Clear processing flow from entry to completion

### If Webhooks Are Not Working
- No entry point logs at all
- Need to check Razorpay dashboard configuration
- May need to contact Razorpay support

### If Webhooks Are Received But Failing
- Entry point logs will show
- Error logs will indicate the specific failure point
- Can fix based on specific error messages

## 📋 Troubleshooting Guide

### No Webhook Logs at All
1. Check Razorpay dashboard webhook configuration
2. Verify webhook URL: `https://runmawi.com/api/razorpay/webhook`
3. Ensure events are enabled (payment.captured, payment.failed)
4. Check firewall/network connectivity

### Webhook Received But Signature Invalid
1. Verify webhook secret configuration
2. Check database payment_settings table
3. Ensure secret matches Razorpay dashboard

### Webhook Processed But No Database Update
1. Check for database transaction errors
2. Verify payment notes contain required fields
3. Check for duplicate event handling

## 🔄 Next Steps

1. **Deploy the enhanced logging** to production
2. **Test with the test script** to verify logging works
3. **Monitor for real webhook events** using the monitoring script
4. **Make a test payment** to see if webhooks are received
5. **Check logs for the specific missing webhook** (order_QsAIdG0m65YZpX)

## 📞 Support

If you still don't see webhook logs after a real payment:
1. Check Razorpay dashboard webhook logs
2. Verify webhook URL configuration
3. Contact Razorpay support for webhook delivery issues
4. Use the fallback payment confirmation endpoint as a workaround

## 🎉 Success Indicators

✅ **Webhook endpoint is accessible** (confirmed by HTTP 400 response)
✅ **Enhanced logging is implemented** (comprehensive debugging info)
✅ **Special detection for video 39 and user 201673** (targeted debugging)
✅ **Monitoring tools available** (real-time and historical analysis)

The webhook system is now fully instrumented for debugging. Any webhook activity will be clearly visible in the logs! 