<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 09/04/2017
 * Time: 16:53
 */

namespace MachineLearning\Regression;


use PHPUnit\Framework\TestCase;

class LeastSquaresTest extends TestCase
{

    /**
     * Test data
     *
     * @return array
     */
    function seriesDataProvider()
    {
        return [
            [
                [0, 0.5, 1.3, 1.9, 0.5, 0.4, 0.1, 0, 0.2, 0.2, 0, 0, 0, 0, 1.2, 0.8, 0, 0.5], // x targets
                [
                    201868.1605,
                    475056.2663,
                    468251.4275,
                    467885.0131,
                    373297.7536,
                    387378.5355,
                    476129.337,
                    503034.6228,
                    467649.461,
                    499841.583,
                    479034.4797,
                    426009.0819,
                    409965.3658,
                    520701.0312,
                    486729.1821,
                    531955.1877,
                    530280.1505,
                    505206.9367
                ], // y samples
                [
                    -244980.1864,
                    17220.8581,
                    -7163.278864,
                    -20714.16688,
                    -84537.6546,
                    -68259.46043,
                    27083.57788,
                    56186.27595,
                    16406.28961,
                    48598.41161,
                    32186.13285,
                    -20839.26495,
                    -36882.98105,
                    73852.68435,
                    13511.88801,
                    67527.54269,
                    83431.80365,
                    47371.5285
                ], // diffs from regression line
                [
                    -244980.1864,
                    -227759.3283,
                    -234922.6071,
                    -255636.774,
                    -340174.4286,
                    -408433.889,
                    -381350.3112,
                    -325164.0352,
                    -308757.7456,
                    -260159.334,
                    -227973.2012,
                    -248812.4661,
                    -285695.4472,
                    -211842.7628,
                    -198330.8748,
                    -130803.3321,
                    -47371.5285,
                    5.82E-10
                ], // Cumulative Sum of diffs
                21974.1227,  // slope
                446848.3469,  // intercept
                0.0240439, // R Squared
            ]
        ];
    }

    /**
     * @dataProvider seriesDataProvider
     *
     */
    function testSlope($x, $y, $diffs, $cumSumDiffs, $slope, $intercept, $rSquared)
    {
        $regression = new LeastSquares();
        $regression->train($x, $y);
        $this->assertEquals($slope, $regression->getSlope(), 'Slope doesn\'t match', 0.0001);
    }

    /**
     * @dataProvider seriesDataProvider
     *
     */
    function testIntercept($x, $y, $diffs, $cumSumDiffs, $slope, $intercept, $rSquared)
    {
        $regression = new LeastSquares();
        $regression->train($x, $y);
        $this->assertEquals($intercept, $regression->getIntercept(), 'Intercept doesn\'t match', 0.0001);
    }

    /**
     * @dataProvider seriesDataProvider
     *
     */
    function testRSquared($x, $y, $diffs, $cumSumDiffs, $slope, $intercept, $rSquared)
    {
        $regression = new LeastSquares();
        $regression->train($x, $y);
        $this->assertEquals($rSquared, $regression->getRSquared(), 'R Squared doesn\'t match', 0.0001);
    }

    /**
     * @dataProvider seriesDataProvider
     *
     */
    function testDifferences($x, $y, $diffs, $cumSumDiffs, $slope, $intercept, $rSquared)
    {
        $regression = new LeastSquares();
        $regression->train($x, $y);
        $this->assertEquals($diffs, $regression->getDifferencesFromRegressionLine(), 'Differences don\'t match',
            0.0001);
    }

    /**
     * @dataProvider seriesDataProvider
     *
     */
    function testCumulativeSumOfDifferences($x, $y, $diffs, $cumSumDiffs, $slope, $intercept, $rSquared)
    {
        $regression = new LeastSquares();
        $regression->train($x, $y);
        $this->assertEquals($cumSumDiffs, $regression->getCumulativeSumOfDifferencesFromRegressionLine(),
            'Cumulative sum of differences don\'t match', 0.0001);
    }
}
