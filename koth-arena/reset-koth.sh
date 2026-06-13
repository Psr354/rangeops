#!/bin/bash
echo "🔄 Resetting KotH Arena to factory vulnerable state..."
cd ~/rangeops/koth-arena
docker compose down
docker compose up -d
echo "✅ Arena ready! Scoreboard reset, vulns restored."
