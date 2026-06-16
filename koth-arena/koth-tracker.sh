#!/bin/bash
KING_FILE="/root/king.txt"
SCORE_FILE="/var/www/html/scores.json"
STATE_FILE="/var/www/html/state.json"
WIN_SECONDS=300 # 5 Menit
INTERVAL=10     # Cek setiap 10 detik

# Inisialisasi File JSON
echo '{"scores":{}, "winner":null}' > $SCORE_FILE
echo '{"current_king":"NOBODY", "hold_time":0}' > $STATE_FILE
chmod 644 $SCORE_FILE $STATE_FILE

while true; do
    # Baca isi king.txt dan bersihkan dari spasi/newline
    OWNER=$(cat $KING_FILE 2>/dev/null | tr -d '\n\r ' | tr -cd 'A-Za-z0-9_.-' | head -c 30)
    if [ -z "$OWNER" ]; then OWNER="NOBODY"; fi

    STATE=$(cat $STATE_FILE)
    PREV_KING=$(echo $STATE | jq -r '.current_king')
    HOLD_TIME=$(echo $STATE | jq -r '.hold_time')
    WINNER=$(jq -r '.winner' $SCORE_FILE)

    # Jika sudah ada pemenang, hentikan perhitungan (Game Over)
    if [ "$WINNER" != "null" ]; then
        sleep $INTERVAL
        continue
    fi

    # Logika Poin
    if [ "$OWNER" == "$PREV_KING" ]; then
        HOLD_TIME=$((HOLD_TIME + INTERVAL))
    else
        # Raja berganti! Reset waktu tahan
        PREV_KING=$OWNER
        HOLD_TIME=$INTERVAL
    fi

    # Update State
    echo "{\"current_king\":\"$PREV_KING\", \"hold_time\":$HOLD_TIME}" > $STATE_FILE
    chmod 644 $STATE_FILE

    # Cek Kondisi Menang (300 detik)
    if [ "$HOLD_TIME" -ge "$WIN_SECONDS" ] && [ "$OWNER" != "NOBODY" ]; then
        jq --arg w "$OWNER" '.winner = $w' $SCORE_FILE > tmp.json && mv tmp.json $SCORE_FILE
        chmod 644 $SCORE_FILE
    fi

    # Tambahkan poin ke scoreboard
    if [ "$OWNER" != "NOBODY" ]; then
        jq --arg o "$OWNER" --argjson pts "$INTERVAL" '.scores[$o] = ((.scores[$o] // 0) + $pts)' $SCORE_FILE > tmp.json && mv tmp.json $SCORE_FILE
        chmod 644 $SCORE_FILE
    fi

    sleep $INTERVAL
done
