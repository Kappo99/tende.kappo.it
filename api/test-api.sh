#!/bin/bash

echo "========================================"
echo "  Test API - Tende Kappo"
echo "========================================"
echo ""

BASE_URL="http://localhost:8000"

echo "[1/5] Test Health Check..."
curl -X GET "$BASE_URL/api/health" -H "Content-Type: application/json"
echo ""
echo ""

echo "[2/5] Test Wind Sensor (GET)..."
curl -X GET "$BASE_URL/api/wind-sensor?limit=5" -H "Content-Type: application/json"
echo ""
echo ""

echo "[3/5] Test Rain Sensor (GET)..."
curl -X GET "$BASE_URL/api/rain-sensor?limit=5" -H "Content-Type: application/json"
echo ""
echo ""

echo "[4/5] Test Alarm Register (GET)..."
curl -X GET "$BASE_URL/api/alarm-register?limit=5" -H "Content-Type: application/json"
echo ""
echo ""

echo "[5/5] Test Wind Sensor Minutes..."
curl -X GET "$BASE_URL/api/wind-sensor/minutes" -H "Content-Type: application/json"
echo ""
echo ""

echo "========================================"
echo "  Test completati!"
echo "========================================"
