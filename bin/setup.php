<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Track time so we can show in milliseconds
$timeStart = microtime(true);
$filesCreated = 0;
$bytesWritten = 0;
$words = 0;

$bodyLines = 1000;
$fileCount = 1000;

$filesystem = new \Illuminate\Filesystem\Filesystem();
$filesystem->cleanDirectory(__DIR__ . '/../_pages');

$carbon = \Carbon\Carbon::parse('2024-01-01 12:00:00');

$loremIpsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec purus feugiat, molestie ipsum et, consequat nibh. Etiam non elit dui. Nullam vel eros sit amet arcu vestibulum accumsan in in leo. Fusce malesuada vulputate faucibus. Integer in hendrerit nisi. Praesent a hendrerit neque. Curabitur ac fringilla turpis.';
$body = str_repeat($loremIpsum . "\n\n", $bodyLines);

for ($i = 0; $i < $fileCount; $i++) {
    $markdown = <<<EOF
    ---
    title: 'Post $i'
    description: 'Post $i'
    category: blog
    author: default
    date: '$carbon'
    ---
    
    ## Write something awesome.
    
    ### This is a subheading
    
    > This is a blockquote.
    
    >info This is a colored blockquote.
    
    ```php
    echo 'Hello, world!';
    ```
    
        this is a code block
    
    1. List item 1
    2. List item 2
    3. List item 3
    
    - Unordered list item 1
    - Unordered list item 2
    - Unordered list item 3
    
    **Bold text**, _italic text_, and [a link](https://example.com).

    ### A table
    
    | Header 1 | Header 2 |
    |----------|----------|
    | Cell 1   | Cell 2   |
    | Cell 3   | Cell 4   |
    
    
    ## A long body
    
    $body
    
    EOF;

    $types = ['_pages' => 'page'];

    foreach ($types as $type => $prefix) {
        file_put_contents(__DIR__ . "/../$type/{$prefix}-$i.md", $markdown);
        $filesCreated++;
        $bytesWritten += strlen($markdown);
        $words += str_word_count($markdown);
    }

    $carbon->addDay();
}

$timeEnd = microtime(true);
$time = $timeEnd - $timeStart;
$time = number_format($time * 1000, 2);

echo sprintf("Files created: %s\n", number_format($filesCreated));
echo sprintf("Bytes written: %s\n", \Illuminate\Support\Number::fileSize($bytesWritten, 2));
echo sprintf("Words written: %s\n", number_format($words));
// put words into context
echo sprintf("  (about %s pages of text, which equals to %s novels)\n", number_format($words / 250), number_format($words / 100000));
echo "Time taken: $time ms\n";
