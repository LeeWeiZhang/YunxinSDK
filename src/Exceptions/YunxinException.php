<?php

namespace WZ\Yunxin\Exceptions;

/**
 * Class YunxinException
 * @package Yunxin
 */
class YunxinException extends \Exception
{
    /**
     * YunxinException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
