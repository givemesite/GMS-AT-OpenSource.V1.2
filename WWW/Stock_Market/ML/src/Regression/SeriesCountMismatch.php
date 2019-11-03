<?php

namespace MachineLearning\Regression;


use Throwable;

class SeriesCountMismatch extends \Exception
{

    /**
     * SeriesCountMismatch constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @internal param string $string
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}