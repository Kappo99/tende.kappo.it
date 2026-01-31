#!/bin/bash

echo "========================================"
echo "  Tende Kappo API - Development Server"
echo "========================================"
echo ""
echo "Avvio del server PHP su http://localhost:8000"
echo ""
echo "Premi CTRL+C per fermare il server"
echo ""

php -S localhost:8000 -t public
