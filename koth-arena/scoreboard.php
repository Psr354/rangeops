<?php
$data = json_decode(file_get_contents('scores.json'), true);
$state = json_decode(file_get_contents('state.json'), true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>RangeOps KotH Scoreboard</title>
    <meta http-equiv="refresh" content="5"> <!-- Auto-refresh tiap 5 detik -->
    <style>
        body { font-family: 'Courier New', monospace; background: #0d1117; color: #c9d1d9; text-align: center; padding: 50px; }
        h1 { color: #58a6ff; text-shadow: 0 0 10px #58a6ff; }
        table { margin: 20px auto; border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #30363d; padding: 12px; font-size: 1.2em; }
        th { background: #161b22; color: #58a6ff; }
        .winner { color: #3fb950; font-weight: bold; font-size: 2em; text-shadow: 0 0 15px #3fb950; animation: pulse 1s infinite; }
        .king { color: #d29922; font-weight: bold; }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
    </style>
</head>
<body>
    <h1>⚔️ RANGEOPS KING OF THE HILL ⚔️</h1>
    <?php if ($data['winner'] && $data['winner'] != 'null'): ?>
        <p class="winner">🏆 WINNER: <?= htmlspecialchars($data['winner']) ?> 🏆</p>
        <p>Game Over! Restart container untuk bermain lagi.</p>
    <?php else: ?>
        <p>Raja Saat Ini: <span class="king"><?= htmlspecialchars($state['current_king'] ?? 'NOBODY') ?></span></p>
        <p>Waktu Bertahan: <span class="king"><?= $state['hold_time'] ?? 0 ?>s</span> / 300s</p>
    <?php endif; ?>
    
    <table>
        <tr><th>Team / Player</th><th>Score (Detik Bertahan)</th></tr>
        <?php 
        if (!empty($data['scores'])) {
            arsort($data['scores']); // Urutkan dari yang tertinggi
            foreach ($data['scores'] as $team => $score): 
        ?>
            <tr><td><?= htmlspecialchars($team) ?></td><td><?= $score ?>s</td></tr>
        <?php 
            endforeach; 
        } else {
            echo '<tr><td colspan="2">Belum ada yang menguasai tahta...</td></tr>';
        }
        ?>
    </table>
</body>
</html>
