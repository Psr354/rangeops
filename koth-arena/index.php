<?php
$output = "";
if (isset($_REQUEST["ip"])) {
    // 2>&1 menggabungkan error output agar terlihat di browser jika command salah
    $output = shell_exec("ping -c 3 " . $_REQUEST["ip"] . " 2>&1");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>RangeOps Router - Diagnostics</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #00ff00; padding: 40px; }
        h1 { border-bottom: 2px solid #00ff00; padding-bottom: 10px; }
        input[type="text"] { padding: 8px; width: 250px; background: #333; color: #fff; border: 1px solid #00ff00; }
        input[type="submit"] { padding: 8px 15px; background: #00ff00; color: #000; border: none; cursor: pointer; font-weight: bold; }
        pre { background: #000; padding: 20px; border: 1px solid #333; min-height: 150px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>[ SYSTEM NETWORK DIAGNOSTICS ]</h1>
    <p>Enter target IP address to verify connectivity:</p>
    <form method="GET">
        <input type="text" name="ip" value="127.0.0.1">
        <input type="submit" value="EXECUTE PING">
    </form>
    <br>
    <pre><?php echo $output; ?></pre>
</body>
</html>
