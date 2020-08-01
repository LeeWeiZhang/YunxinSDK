<?php


namespace WZ\Yunxin\Exceptions;


class YunxinResponseException extends YunxinException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
