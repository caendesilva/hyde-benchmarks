# HydePHP - Benchmarks

Just a sample project to run benchmarks on.

## Usage

### Setup

```bash
composer install
php bin/setup.php

# Run the build command once to generate the cache
php hyde build
```

### Run the benchmarks

```bash
php bin/benchmark.php
```

### Dataset size

- Markdown files: 300 (100 markdown pages, 100 markdown posts, 100 markdown docs)
- Total words: 1,465,500 (about 5,862 pages of text, which equals to 15 novels)
- Total bytes: 9.37 MB (plaintext)


## Result overviews

### Workstation (https://github.com/hydephp/hyde-benchmarks/issues/1)

#### Test abstract:

Running the build command with a dataset of 300 pages.

#### System:

```
Windows 10 Pro Workstation 
AMD Ryzen 7 1800X Eight-Core/Sixteen-thread Processor @ 3,60 GHz
KINGSTON SA400S37120G SSD
PHP 8.1.10 CLI
```

#### Results:

```
Total iterations:       5
Total execution time:   84680.56ms
Avg.  iteration time:   16936.11159325ms
Pages per iteration:    300
```

Summary: 56.4537053 milliseconds average per page
