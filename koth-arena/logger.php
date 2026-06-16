<?php
function koth_log_event(string $file, array $event): void
{
    $event['ts'] = gmdate('c');
    $event['remote_addr'] = $_SERVER['REMOTE_ADDR'] ?? '-';
    $event['method'] = $_SERVER['REQUEST_METHOD'] ?? '-';
    $event['uri'] = $_SERVER['REQUEST_URI'] ?? '-';
    $event['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '-';

    $line = json_encode($event, JSON_UNESCAPED_SLASHES) . PHP_EOL;
    @file_put_contents('/var/log/koth/' . $file, $line, FILE_APPEND | LOCK_EX);
}
?>
