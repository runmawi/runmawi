#!/bin/bash

echo "🔍 Finding Laravel log file..."
echo "============================="
echo ""

# Possible log locations
locations=(
    "/home/runmawi/storage/logs/laravel.log"
    "/home/runmawi/storage/log/laravel.log"
    "storage/logs/laravel.log"
    "storage/log/laravel.log"
    "/var/log/laravel/laravel.log"
    "/var/log/runmawi/laravel.log"
    "/home/runmawi/laravel.log"
    "laravel.log"
)

echo "Checking common locations..."
echo ""

found_files=()

for location in "${locations[@]}"; do
    if [ -f "$location" ]; then
        echo "✅ Found: $location"
        found_files+=("$location")
    else
        echo "❌ Not found: $location"
    fi
done

echo ""
echo "🔍 Searching for any laravel.log files..."
echo ""

# Search for laravel.log files
find /home/runmawi -name "laravel.log" -type f 2>/dev/null | while read -r file; do
    echo "📁 Found Laravel log: $file"
    echo "   Size: $(du -h "$file" | cut -f1)"
    echo "   Last modified: $(stat -c %y "$file")"
    echo ""
done

echo ""
echo "🔍 Checking current directory structure..."
echo ""

# Check current directory
if [ -d "storage" ]; then
    echo "✅ Found storage directory"
    if [ -d "storage/logs" ]; then
        echo "✅ Found storage/logs directory"
        ls -la storage/logs/
    elif [ -d "storage/log" ]; then
        echo "✅ Found storage/log directory"
        ls -la storage/log/
    fi
else
    echo "❌ No storage directory in current path"
fi

echo ""
echo "💡 Recommendations:"
echo "==================="

if [ ${#found_files[@]} -gt 0 ]; then
    echo "Found ${#found_files[@]} Laravel log file(s):"
    for file in "${found_files[@]}"; do
        echo "  - $file"
    done
    echo ""
    echo "Use the most recent one for monitoring:"
    echo "  ./monitor-webhooks.sh live"
else
    echo "No Laravel log files found in common locations."
    echo ""
    echo "Try these commands to find the log file:"
    echo "  find /home -name 'laravel.log' -type f 2>/dev/null"
    echo "  find /var -name 'laravel.log' -type f 2>/dev/null"
    echo "  find . -name 'laravel.log' -type f 2>/dev/null"
fi

echo ""
echo "🔧 To update the monitoring script:"
echo "==================================="
echo "Edit monitor-webhooks.sh and change the LOG_FILE path to the correct location" 