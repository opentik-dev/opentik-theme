<?php
if (!function_exists('opentik_log')) {
    function opentik_log(string $level, string $message, array $context = []): void
    {
        $level = strtoupper($level);
        $allowed = ['ERROR', 'WARN', 'INFO'];
        if (!in_array($level, $allowed, true)) {
            $level = 'INFO';
        }

        $payload = [
            'time' => gmdate('c'),
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'url' => $_SERVER['REQUEST_URI'] ?? 'cli',
        ];

        $json = wp_json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            return;
        }

        $log_dir = WP_CONTENT_DIR . '/uploads/opentik-logs';
        if (!file_exists($log_dir) && !wp_mkdir_p($log_dir)) {
            return;
        }

        $log_file = $log_dir . '/opentik.log';
        $command = sprintf(
            'php -r %s > /dev/null 2>&1 &',
            escapeshellarg('file_put_contents(' . var_export($log_file, true) . ', ' . var_export($json . PHP_EOL, true) . ', FILE_APPEND | LOCK_EX);')
        );

        if (function_exists('shell_exec')) {
            @shell_exec($command);
            return;
        }

        @file_put_contents($log_file, $json . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}
