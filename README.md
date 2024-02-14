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

108.03600ms per page

### 1000 pages

Files created: 1,000
Bytes written: 306.74 MB
Words written: 48,085,000
(about 192,340 pages of text, which equals to 481 novels)
Time taken: 4,425.23 ms

All done! Finished in 335.09 seconds (335,090.99ms) with 330.67MB peak memory usage
Congratulations! 🎉 Your static site has been built!

335.09099ms per page


### Analysis

As can be seen, the time per page increases with the number of pages. It is interesting that the increase factor is factor 10,
which is the same as the increase in the number of pages. This suggests that as the workload increases, the efficiency decreases.

All in all, this is more than acceptable results, as this is truly a massive amount of data.
