<?php


namespace WZ\Yunxin\Exceptions;


class YunxinSDKException extends YunxinException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
