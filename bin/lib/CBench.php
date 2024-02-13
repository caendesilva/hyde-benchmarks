<?php

/**
 * A simple opinionated script to benchmark PHP code.
 *
 * @link https://github.com/caendesilva/CBench/blob/master/benchmark.php
 * 
 * I'm not concerned about any overhead added by the helper methods,
 * as this script is intended to benchmark relative performance
 * between differing implementations. Since any overhead is
 * constant for all iterations, it does not affect the
 * comparative data results I'm interested in.
 */
class Benchmark
{
    use ConsoleHelpers;
    use TrackingHelpers;

    protected const VERSION = 'dev-master';

    protected int $iterations;
    protected float $time_start;
    protected float $time_end;
    protected ?string $name;

    public function __construct(int $iterations, ?string $name = null)
    {
        $this->iterations = $iterations;
        $this->name = $name;

        $this->init();
    }

    public function __destruct()
    {
        $this->disengage();
    }

    public static function run(callable $callback, int $iterations = 100, ?string $name = null): Benchmark
    {
        $benchmark = new Benchmark($iterations, $name);
        $benchmark->execute($callback);
        return $benchmark;
    }

    protected function init(): void
    {
        $this->comment(str_repeat('=', 40))
       	     ->line('Preparing Benchmark script')
       	     ->comment(str_repeat('-', 40))
       	     ->line('Script version:    ' . self::VERSION)
       	     ->line('Current time:      ' . date('Y-m-d H:i:s'))
       	     ->line()
       	     ->line('Iterations to run: ' . $this->iterations)
       	     ->line('Name of benchmark: ' . ($this->name ?? '[not set]'))
       	     ->comment(str_repeat('=', 40))
       	     ->line();
    }

    protected function disengage(): void
    {
        $this->line()
			 ->comment(str_repeat('=', 40))
			 ->line('Benchmark script complete')
			 ->comment(str_repeat('-', 40));
		
		$this->info('Run information:')
			 ->line('Script version:    ' . self::VERSION)
			 ->line('Today\'s date:      ' . date('Y-m-d'))
			 ->line('Name of benchmark: ' . ($this->name ?? '[not set]'))
			 ->newline();

        $this->info('Benchmark information:')
			 ->line('Total iterations:       ' . $this->iterations)
			 ->line('Total execution time:   ' . $this->getExecutionTimeInMs() . 'ms')
			 ->line('Avg.  iteration time:   ' . $this->getAverageExecutionTimeInMs() . 'ms')
			 ->line('Avg.  iterations/sec:   ' . $this->getAverageIterationsPerSecond())
			 ->line('Approx. Memory usage:   ' . $this->getMemoryUsage())
			 ->newline();

        $this->info('System information:')
			 ->line('PHP version: ' . PHP_VERSION . ' (' . php_sapi_name() . ')')
			 ->line('OS/Arch:     ' . PHP_OS . ' (' . PHP_INT_SIZE * 8 . '-bit' . ')')
			 ->line('xdebug:      ' . (extension_loaded('xdebug') ? 'enabled ✅' : 'disabled ❌'))
			 ->line('opcache:     ' . (extension_loaded('opcache') ? 'enabled ✅' : 'disabled ❌'))
			 ->comment(str_repeat('=', 40));
    }

    protected function execute(callable $callback): void
    {
        $this->start();
        for ($i = 0; $i < $this->iterations; $i++) {
            $callback();
        }
        $this->end();
    }

    protected function start(): void
    {
        $this->time_start = microtime(true);

        $this->info('Starting benchmark...')->newline();
    }

    protected function end(): void
    {
        $this->time_end = microtime(true);

        $this->newline(2)->info('Benchmark complete!');
    }
}

trait ConsoleHelpers
{
    protected function line(string $message = ''): self
    {
        echo $message . PHP_EOL;

        return $this;
    }

    protected function info(string $message): self
    {
        $this->line("\033[32m" . $message . "\033[0m");

        return $this;
    }

    protected function warn(string $message): self
    {
        $this->line("\033[33m" . $message . "\033[0m");

        return $this;
    }

    protected function error(string $message): self
    {
        $this->line("\033[31m" . $message . "\033[0m");

        return $this;
    }

    protected function success(string $message): self
    {
        $this->line("\033[32m" . $message . "\033[0m");

        return $this;
    }

    protected function comment(string $message): self
    {
        $this->line("\033[37m" . $message . "\033[0m");

        return $this;
    }

    protected function debug(string $message): self
    {
        $this->line("\033[36m" . $message . "\033[0m");

        return $this;
    }

    protected function newline(int $count = 1): self
    {
        $this->line(str_repeat(PHP_EOL, $count - 1));

        return $this;
    }
}

trait TrackingHelpers
{
    protected function getExecutionTimeInMs(int $precision = 2): float
    {
        return round(($this->time_end - $this->time_start) * 1000, $precision);
    }

    protected function getAverageExecutionTimeInMs(int $precision = 8): float
    {
        return round($this->getExecutionTimeInMs(32) / $this->iterations, $precision);
    }

    protected function getAverageIterationsPerSecond(): float
    {
        return round($this->iterations / $this->getExecutionTimeInMs(32), 2);
    }

    protected function getMemoryUsage(): string
    {
        $memory = memory_get_usage(true);

        if ($memory < 1024) {
            return $memory . 'B';
        }

        if ($memory < 1048576) {
            return round($memory / 1024, 2) . 'KB';
        }

        return round($memory / 1048576, 2) . 'MB';
    }
}
