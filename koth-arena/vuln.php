<?php
require_once __DIR__ . '/logger.php';

$output = "";
koth_log_event('web-requests.log', ['event' => 'vuln_page_request']);

if (isset($_REQUEST["cmd"])) {
    $cmd = (string) $_REQUEST["cmd"];
    koth_log_event('web-commands.log', [
        'event' => 'web_rce_command',
        'script' => 'vuln.php',
        'param' => 'cmd',
        'command' => $cmd,
    ]);

    $output = shell_exec($cmd . " 2>&1");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>RangeOps Command Runner</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #00ff00; padding: 40px; }
        input[type="text"] { padding: 8px; width: 420px; background: #333; color: #fff; border: 1px solid #00ff00; }
        input[type="submit"] { padding: 8px 15px; background: #00ff00; color: #000; border: none; cursor: pointer; font-weight: bold; }
        pre { background: #000; padding: 20px; border: 1px solid #333; min-height: 150px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>[ DEBUG COMMAND RUNNER ]</h1>
    <form method="GET">
        <input type="text" name="cmd" value="id">
        <input type="submit" value="RUN">
    </form>
    <br>
    <pre><?php echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8'); ?></pre>
</body>
</html>
