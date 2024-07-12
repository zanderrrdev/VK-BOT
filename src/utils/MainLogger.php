<?php

namespace App\utils;

class MainLogger
{
    public static function log(string $message, string $type = 'info')
    {
        $colors = [
            'info' => "\x1b[38;5;231m",
            'notice' => "\x1b[38;5;87m",
            'warning' => "\x1b[38;5;227m",
            'error' => "\x1b[38;5;203m",
        ];

        echo $colors['notice'] . "[" . date('H:i:s') . "] " . $colors[$type] . "[VK-BOT thread/" . strtoupper($type) . "]: " . $message . "\033[0m\n";
    }
}