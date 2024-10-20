<?php

declare(strict_types=1);

namespace App\Configs;

class Environment
{
    public static function loadEnv($file)
    {
        if (!file_exists($file)) {
            return;
        }

        $lines = file($file);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);


            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}
