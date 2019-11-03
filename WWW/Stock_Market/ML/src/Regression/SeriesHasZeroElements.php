<?php

namespace MachineLearning\Regression;


use Throwable;

/**
 * Class SeriesHasZeroElements
 *
 * @package MachineLearning\Regression
 */
class SeriesHasZeroElements extends \Exception
{

    /**
     * SeriesHasZeroElements constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}