<?php

namespace WZ\Yunxin\Responses;

/**
 * Class SuccessResponse
 * @package WZ\Yunxin\Responses
 */
class SuccessYunxinResponse extends YunxinResponse
{
    /**
     * SuccessResponse constructor.
     *
     * @param array         $headers
     * @param string        $body
     * @param int           $http_code
     * @param callable|null $success_callback
     */
    public function __construct($headers, $body, $http_code, callable $success_callback = null)
    {
        parent::__construct($headers, $body, $http_code);

        if ($success_callback) {
            call_user_func($success_callback, $this);
        }
    }
}
