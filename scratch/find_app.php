<?php

$dir = __DIR__ . '/../src';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($iterator as $file) {
    if ($file->isDir() || $file->getExtension() !== 'php') {
        continue;
    }

    $filePath = $file->getRealPath();
    $code = file_get_contents($filePath);

    if (preg_match('/use\s+App\\\\/i', $code)) {
        echo "Found: " . $file->getFilename() . " -> " . $filePath . PHP_EOL;
        // Print the lines containing App
        $lines = explode("\n", $code);
        foreach ($lines as $i => $line) {
            if (strpos($line, 'App\\') !== false) {
                echo "  Line " . ($i + 1) . ": " . trim($line) . PHP_EOL;
            }
        }
    }
}
