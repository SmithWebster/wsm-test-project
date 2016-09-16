<?php

// PHP version checking
preg_match('/([0-9])\./', phpversion(), $matches);
$phpVer = null;
if (!empty($matches[1])) {
    $phpVer = (int) $matches[1];
}
unset($matches);

if ($phpVer < 7) {
    echo "Terminated! Minimum PHP 7 required for execution.\n";
    exit(0);
}

require_once('src/SplClassLoader.php');

$loader = new SplClassLoader(null, 'src');
$loader->register();

$jsonFilePath = 'data/200610120800.json';

file_exists($jsonFilePath) or (call_user_func(function() use($jsonFilePath) {
    echo 'Terminated! Couse your file "' . $jsonFilePath . ' isn\'t exists!' . "\n";
    echo 'Make sure that your file is there among of the list:' . "\n";

    $dir = dirname($jsonFilePath);
    $files = scandir($dir);

    foreach ($files as &$file) {
        switch ($file) {
            case '.':
            case '..':
                continue;

            default:
                echo $file . "\n";
                break;
        }
    }
    exit(0);
}));

