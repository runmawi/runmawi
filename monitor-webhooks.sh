#!/bin/bash

# Webhook monitoring script
# This script helps monitor webhook activity in real-time

echo "🔍 Webhook Monitoring Script"
echo "============================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Default log file path (adjust as needed)
LOG_FILE="/home/runmawi/storage/logs/laravel.log"

# Check if log file exists
if [ ! -f "$LOG_FILE" ]; then
    echo -e "${RED}❌ Log file not found: $LOG_FILE${NC}"
    echo "Please update the LOG_FILE path in this script"
    echo ""
    echo "Common Laravel log locations:"
    echo "- storage/logs/laravel.log"
    echo "- /var/log/laravel/laravel.log"
    echo "- /home/user/app/storage/logs/laravel.log"
    exit 1
fi

echo -e "${GREEN}✅ Monitoring log file: $LOG_FILE${NC}"
echo ""

# Function to display help
show_help() {
    echo "Usage: $0 [option]"
    echo ""
    echo "Options:"
    echo "  live        - Monitor webhook logs in real-time"
    echo "  recent      - Show recent webhook logs (last 50 lines)"
    echo "  search      - Search for specific webhook logs"
    echo "  test        - Test webhook endpoint"
    echo "  help        - Show this help message"
    echo ""
}

# Function to monitor live webhook logs
monitor_live() {
    echo -e "${CYAN}🔄 Starting live webhook monitoring...${NC}"
    echo -e "${YELLOW}Press Ctrl+C to stop${NC}"
    echo ""
    
    # Monitor logs with colored output
    tail -f "$LOG_FILE" | grep --line-buffered -E '🚀|💳|🎯|👤|✅|❌|📦|🔐|💰|📝|💾|📋' | \
    while IFS= read -r line; do
        if [[ $line == *"🚀"* ]]; then
            echo -e "${GREEN}$line${NC}"
        elif [[ $line == *"💳"* ]]; then
            echo -e "${BLUE}$line${NC}"
        elif [[ $line == *"🎯"* ]]; then
            echo -e "${PURPLE}$line${NC}"
        elif [[ $line == *"👤"* ]]; then
            echo -e "${CYAN}$line${NC}"
        elif [[ $line == *"✅"* ]]; then
            echo -e "${GREEN}$line${NC}"
        elif [[ $line == *"❌"* ]]; then
            echo -e "${RED}$line${NC}"
        else
            echo "$line"
        fi
    done
}

# Function to show recent webhook logs
show_recent() {
    echo -e "${CYAN}📜 Recent webhook logs (last 50 lines):${NC}"
    echo ""
    
    grep -E '🚀|💳|🎯|👤|✅|❌|📦|🔐|💰|📝|💾|📋' "$LOG_FILE" | tail -50
}

# Function to search webhook logs
search_logs() {
    echo -e "${CYAN}🔍 Searching webhook logs...${NC}"
    echo ""
    
    echo "Enter search term (e.g., 'order_QsAIdG0m65YZpX', 'VIDEO 39', 'USER 201673'):"
    read -r search_term
    
    if [ -z "$search_term" ]; then
        echo -e "${RED}❌ No search term provided${NC}"
        return 1
    fi
    
    echo -e "${YELLOW}Searching for: $search_term${NC}"
    echo ""
    
    grep -i "$search_term" "$LOG_FILE" | grep -E '🚀|💳|🎯|👤|✅|❌|📦|🔐|💰|📝|💾|📋' | tail -20
}

# Function to test webhook endpoint
test_webhook() {
    echo -e "${CYAN}🧪 Testing webhook endpoint...${NC}"
    echo ""
    
    php test-webhook-logging.php
}

# Main script logic
case "${1:-live}" in
    "live")
        monitor_live
        ;;
    "recent")
        show_recent
        ;;
    "search")
        search_logs
        ;;
    "test")
        test_webhook
        ;;
    "help")
        show_help
        ;;
    *)
        echo -e "${RED}❌ Unknown option: $1${NC}"
        echo ""
        show_help
        exit 1
        ;;
esac 