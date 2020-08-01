<?php

namespace WZ\Yunxin\Responses;

/**
 * Class FailureResponse
 * @package WZ\Yunxin\Responses
 */
class FailureYunxinResponse extends YunxinResponse
{
    /**
     * FailureResponse constructor.
     *
     * @param array         $headers
     * @param string        $body
     * @param int           $http_code
     * @param callable|null $failure_callback
     */
    public function __construct($headers, $body, $http_code, callable $failure_callback = null)
    {
        parent::__construct($headers, $body, $http_code);

        if ($failure_callback) {
            call_user_func($failure_callback, $this);
        }
    }
}
