<?php

namespace WZ\Yunxin\Requests;

/**
 * Interface HttpRequest
 * @package WZ\Yunxin\Requests
 */
interface HttpRequest
{

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function setOption($name, $value);

    /**
     * @return mixed
     */
    public function executeCurl();

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getInfo($name);

    /**
     * @return string
     */
    public function getError();

    /**
     * @return mixed
     */
    public function close();
}
