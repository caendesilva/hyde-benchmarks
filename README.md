# HydePHP - Benchmarks (Stress test branch)

See the main branch for setup. This branch experiments with pushing the limits of how many pages can be generated.

## Dataset size

Lorem ipsum lines were increased from 100 to 1000. Only page type is Markdown page. Page count is variable.

Benchmark is performed by running `php hyde build` twice and using the result of the second run.

## Results

### 100 pages

Files created: 100
Bytes written: 30.67 MB
Words written: 4,808,500
(about 19,234 pages of text, which equals to 48 novels)
Time taken: 223.62 ms

All done! Finished in 10.80 seconds (10,803.60ms) with 48.01MB peak memory usage
Congratulations! 🎉 Your static site has been built!