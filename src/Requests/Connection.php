<?php

namespace WZ\Yunxin\Requests;


use WZ\Yunxin\Exceptions\YunxinException;
use WZ\Yunxin\Responses\FailureYunxinResponse;
use WZ\Yunxin\Responses\SuccessYunxinResponse;
use WZ\Yunxin\Responses\YunxinResponse;

/**
 * Class Connection
 * @package MailchimpAPI\Requests
 */
class Connection implements HttpRequest
{

    /**
     * Custom user agent for this library
     */
    const USER_AGENT = 'WZ/Yunxin (https://github.com/LeeWeiZhang/YunxinSDK)';

    /**
     * The current request object passed into this connection
     * @var Request
     */
    private $current_request;

    /**
     * Raw response from yunxin api
     * @var string
     */
    private $response;

    /**
     * Response body
     * @var string
     */
    private $response_body;

    /**
     * Decoded body
     * @var object
     */
    private $response_object;

    /**
     * An integer representation of the http response code
     * @var int
     */
    private $http_code;

    /**
     * The parsed response headers from the request
     * @var array
     */
    private $headers = [];

    /**
     * The curl handle for this connection
     * @var resource
     */
    private $handle;

    /**
     * A holder for the option that are set on this connections handle
     * @var array
     */
    private $current_options = [];


    /**
     * Connection constructor.
     *
     * @param Request       $request
     */
    public function __construct(Request &$request)
    {
        $this->current_request = $request;

        $this->handle = curl_init();

        $this->prepareHandle();
        $this->setHandlerOptionsForMethod();
    }

    /**
     * Prepares this connections handle for execution
     *
     * @return void
     * @throws YunxinException
     */
    private function prepareHandle()
    {
        // set the URL for this request
        $this->setOption(CURLOPT_URL, $this->current_request->getUrl());

        // set headers to be sent
        $this->setOption(CURLOPT_HTTPHEADER, $this->current_request->getHeaders());

        // set custom user-agent
        $this->setOption(CURLOPT_USERAGENT, self::USER_AGENT);

        // make response returnable
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        // get headers in return
        $this->setOption(CURLOPT_HEADER, true);

        // set the callback to run against each of the response headers
        $this->setOption(CURLOPT_HEADERFUNCTION, [&$this, "parseResponseHeader"]);
    }

    /**
     * Set custom curl handler options
     *
     * @param array $options
     */
    private function setCustomHandleOptions(array $options)
    {
        if (!empty($options)) {
            foreach ($options as $option => $value) {
                $this->setOption($option, $value);
            }
        }
    }

    /**
     * Prepares the handler for a request based on the requests method
     * @return void
     */
    private function setHandlerOptionsForMethod()
    {
        $method = $this->current_request->getMethod();

        switch ($method) {
            case "POST":
                $this->setOption(CURLOPT_POST, true);
                $this->setOption(CURLOPT_POSTFIELDS, $this
                    ->current_request
                    ->getPayload());
                break;
            case "PUT":
            case "PATCH":
                $this->setOption(CURLOPT_CUSTOMREQUEST, $method);
                $this->setOption(CURLOPT_POSTFIELDS, $this
                    ->current_request
                    ->getPayload());
                break;
            case "DELETE":
                $this->setOption(CURLOPT_CUSTOMREQUEST, $method);
                break;
        }
    }

    /**
     * Executes a connection with the current request and settings
     *
     * @param bool $close close this connection after execution
     *
     * @return YunxinResponse
     * @throws YunxinException
     */
    public function execute($close = true)
    {
        $this->response = $this->executeCurl();
        if (!$this->response) {
            throw new YunxinException("The curl request failed: " . $this->getError());
        }

        $this->http_code = $this->getInfo(CURLINFO_HTTP_CODE);
        $head_len = $this->getInfo(CURLINFO_HEADER_SIZE);
        $this->response_body = substr(
            $this->response,
            $head_len,
            strlen($this->response)
        );
        $this->response_object = json_decode($this->response_body);

        if ($close) {
            $this->close();
        }

        if ($this->isSuccess()) {
            return new SuccessYunxinResponse(
                $this->headers,
                $this->response_body,
                $this->http_code,
                $this->current_request->getSuccessCallback()
            );
        } else {
            return new FailureYunxinResponse(
                $this->headers,
                $this->response_body,
                $this->http_code,
                $this->current_request->getFailureCallback()
            );
        }
    }

    /**
     * Gets the currently set curl options by key
     *
     * @param $key
     *
     * @return mixed
     */
    public function getCurrentOption($key)
    {
        return $this->current_options[$key];
    }

    /**
     * Bulk set curl options
     * Update current settings
     *
     * @param array $options
     */
    public function setCurrentOptions($options)
    {
        $this->current_options = [];
        foreach ($options as $option_name => $option_value) {
            $this->setOption($option_name, $option_value);
        }
    }

    /**
     * Sets a curl option on the handler
     * Updates the current settings array with ne setting
     * @inheritdoc
     */
    public function setOption($name, $value)
    {
        curl_setopt($this->handle, $name, $value);
        $this->current_options[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function executeCurl()
    {
        return curl_exec($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function getInfo($name)
    {
        return curl_getinfo($this->handle, $name);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return curl_error($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function close()
    {
        curl_close($this->handle);
    }

    /**
     * Called statically during prepareHandle();
     *
     * @param $handle
     * @param $header
     *
     * @return int
     */
    private function parseResponseHeader($handle, $header)
    {
        $header_length = strlen($header);
        $header_array = explode(':', $header, 2);
        if (count($header_array) == 2) {
            $this->pushToHeaders($header_array);
        }

        return $header_length;
    }

    /**
     * @param array $header
     */
    private function pushToHeaders($header)
    {
        $this->headers[$header[0]] = trim($header[1]);
    }

    /**
     * A function for evaluating if a connection was successful
     * @return bool
     */
    private function isSuccess()
    {
        if (!($this->http_code > 199 && $this->http_code < 300)) {
            return false;
        }

        return $this->response_object->code > 199 && $this->response_object->code < 300;
    }
}
