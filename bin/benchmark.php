<?php

require_once 'lib/CBench.php';

$output = '';

chdir(__DIR__ . '/..');

Benchmark::run(function () use ($output) {
    $output .= "\n\n\n" . shell_exec('php hyde build');
}, 5, 'Build site');
