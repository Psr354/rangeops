<?php
// RangeOps Command Center - Single Pane of Glass
$services = [
    ["name" => "Wazuh SIEM", "url" => "https://10.172.210.53:8443", "desc" => "Blue Team Monitoring & Alerting", "color" => "blue"],
    ["name" => "KotH Arena", "url" => "http://10.172.210.53:8080", "desc" => "Web RCE + SSH PrivEsc + Scoreboard", "color" => "red"],
    ["name" => "Jenkins CI/CD", "url" => "http://10.172.210.53:8083", "desc" => "CVE-2018-1000861 ACL Bypass", "color" => "orange"],
    ["name" => "Juice Shop", "url" => "http://10.172.210.53:3001", "desc" => "Modern Web/API Vulnerabilities", "color" => "green"],
    ["name" => "Portainer", "url" => "https://10.172.210.53:9443", "desc" => "Docker Container Management", "color" => "cyan"],
    ["name" => "Cockpit", "url" => "https://10.172.210.53:9090", "desc" => "Linux Server Administration", "color" => "gray"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RangeOps | Command Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'JetBrains Mono', monospace; background-color: #0a0a0a; color: #e5e5e5; }
        .card { transition: all 0.3s ease; border: 1px solid #333; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); border-color: #3b82f6; }
        .glow-text { text-shadow: 0 0 10px rgba(59, 130, 246, 0.5); }
    </style>
</head>
<body class="min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold glow-text mb-2">🛡️ RANGEOPS COMMAND CENTER</h1>
            <p class="text-gray-400">Purple Team Cyber Range Environment v2.0</p>
            <div class="mt-4 inline-block px-4 py-1 bg-green-900/30 border border-green-500/30 rounded-full text-green-400 text-sm">
                ● SYSTEM OPERATIONAL
            </div>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php foreach ($services as $svc): ?>
            <a href="<?= $svc['url'] ?>" target="_blank" 
               class="card bg-zinc-900/80 p-6 rounded-xl block group">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-<?= $svc['color'] ?>-400"><?= $svc['name'] ?></h3>
                    <span class="text-xs bg-zinc-800 px-2 py-1 rounded text-gray-400">ACTIVE</span>
                </div>
                <p class="text-gray-400 text-sm mb-4"><?= $svc['desc'] ?></p>
                <div class="text-xs text-gray-600 group-hover:text-<?= $svc['color'] ?>-400 transition-colors">
                    <?= parse_url($svc['url'], PHP_URL_HOST) ?>:<?= parse_url($svc['url'], PHP_URL_PORT) ?? '80/443' ?> →
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Quick Kill-Chain Reference -->
        <div class="bg-zinc-900/80 border border-zinc-800 rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-6 text-white border-b border-zinc-800 pb-4">📋 Active Kill-Chains</h2>
            <div class="space-y-4 text-sm">
                <div class="flex gap-4">
                    <span class="text-red-400 font-bold w-32 shrink-0">KOTH ARENA</span>
                    <span class="text-gray-300">Ping RCE → db_config.php.bak Looting → SSH Pivoting → /usr/local/bin/privshell -p</span>
                </div>
                <div class="flex gap-4">
                    <span class="text-orange-400 font-bold w-32 shrink-0">JENKINS</span>
                    <span class="text-gray-300">ACL Bypass → Groovy ASTTest Compile-Time Exfil → sudo apt-get Privesc</span>
                </div>
                <div class="flex gap-4">
                    <span class="text-green-400 font-bold w-32 shrink-0">JUICE SHOP</span>
                    <span class="text-gray-300">SQLi Auth Bypass → JWT Token Theft → XXE Data Exfiltration</span>
                </div>
            </div>
        </div>

        <footer class="text-center mt-12 text-gray-600 text-xs">
            Built for Purple Team Training | ZeroTier Network: 10.172.210.0/24
        </footer>
    </div>
</body>
</html>
