<?php

namespace WZ\Yunxin\Requests;

use WZ\Yunxin\Exceptions\YunxinException;
use WZ\Yunxin\Exceptions\YunxinSDKException;

class Request
{
    /** @var string */
    protected $urlPrefix;

    public function getUrlPrefix(): string
    {
        return $this->urlPrefix;
    }

    /**
     * An array of valid methods that can be used for a request
     * @var array
     */
    private static $valid_methods = ['GET', 'POST', 'PATCH', 'PUT', 'DELETE'];

    /*************************************
     * Request Components
     *************************************/

    /**
     * The base URL for a request
     * @var string
     */
    private $base_url;

    /**
     * The endpoint portion of the URL
     * @var string
     */
    private $endpoint;

    /**
     * The query string for the request URL
     * @var string
     */
    private $query_string;

    /**
     * The API key used to set the auth header
     * @var null
     */
    private $apikey;

    /**
     * The API secret used to set the auth header
     * @var null
     */
    private $apiSecret;

    /**
     * The payload that is serialized and sent
     * @var object
     */
    private $payload;

    /**
     * The method for this request
     * @var string
     */
    private $method;

    /**
     * The headers for this request
     * @var array
     */
    private $headers = [];

    /**
     * The success callback to be executed on a successful request
     * @var callable
     */
    private $success_callback;

    /**
     * The failure callback to be executed on a failed request
     * @var callable
     */
    private $failure_callback;

    /**
     * @param $apikey
     * @throws YunxinException
     */
    public function __construct($apikey = null, $apiSecret = null)
    {
        $this->apikey = $apikey;

        $this->apiSecret = $apiSecret;

        $this->checkKey($apikey, $apiSecret);

        $this->setBaseUrl("https://api.netease.im/nimserver");

        $this->setAuth();
    }

    /*************************************
     * GETTERS
     *************************************/

    /**
     * Get the APi key
     * @return mixed
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Get the endpoint
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get the payload
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Get the method
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the base URL
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * Get the valid methods
     * @return array
     */
    public function getValidMethods()
    {
        return self::$valid_methods;
    }

    /**
     * Get the headers
     * @return array
     * @throws YunxinException
     */
    public function getHeaders()
    {
        if (!is_array($this->headers)) {
            throw new YunxinSDKException("Request headers must be of type array");
        }
        return $this->headers;
    }

    /**
     * Gets the entire request URI
     * @return string
     */
    public function getUrl()
    {
        return $this->base_url . $this->endpoint . $this->query_string;
    }

    /**
     * Get the success callback
     * @return callable
     */
    public function getSuccessCallback()
    {
        return $this->success_callback;
    }

    /**
     * Get the failure callback
     * @return callable
     */
    public function getFailureCallback()
    {
        return $this->failure_callback;
    }

    /**
     * Sets the Authorization header for this request
     */
    public function setAuth()
    {
        $now = time();
        $nonce = $this->makeNonce();
        $join_string = $this->apiSecret . $nonce . $now;
        $checkSum = sha1($join_string);

        $this->addHeader("AppKey: {$this->apikey}");
        $this->addHeader("CheckSum: {$checkSum}");
        $this->addHeader("CurTime: {$now}");
        $this->addHeader("Nonce: {$nonce}");

    }

    public function makeNonce()
    {
        $characters = '0123456789abcdef';
        $hex_digits = $characters;
        $nonce = '';

        for ($i=0;$i<128;$i++) {			//随机字符串最大128个字符，也可以小于该数
            $nonce .= $hex_digits[rand(0, 15)];
        }

       return $nonce;
    }

    /**
     * Sets the payload for a request
     *
     * @param mixed   $payload
     * @param boolean $shouldSerialize
     *
     * @throws YunxinException when cant serialize payload
     */
    public function setPayload($payload, $shouldSerialize = true)
    {
        if ($shouldSerialize) {
            $payload = $this->serializePayload($payload);
        }
        $this->payload = $payload;
    }

    /**
     * Sets the endpoint for the request
     *
     * @param mixed $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Sets the request method
     *
     * @param mixed $method
     *
     * @throws YunxinException
     */
    public function setMethod($method)
    {
        if (!in_array($method, self::$valid_methods)) {
            throw new YunxinSDKException("Method not allowed");
        }

        $this->method = $method;
    }

    /**
     * Sets the base URL
     *
     * @param mixed $base_url
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
    }

    /**
     * Sets the query string from an array
     *
     * @param array $query_array
     */
    public function setQueryString($query_array)
    {
        $this->query_string = $this->constructQueryParams($query_array);
    }

    /**
     * Sets the request headers
     *
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Sets the success callback
     *
     * @param callable $success_callback
     */
    public function setSuccessCallback(callable $success_callback)
    {
        $this->success_callback = $success_callback;
    }

    /**
     * Sets the failure callback
     *
     * @param callable $failure_callback
     */
    public function setFailureCallback(callable $failure_callback)
    {
        $this->failure_callback = $failure_callback;
    }

    /*************************************
     * Helpers
     *************************************/

    /**
     * JSON serializes the current payload
     *
     * @param $payload
     *
     * @return mixed
     * @throws YunxinException
     */
    public function serializePayload($payload)
    {
        return $this->formEncode($payload);
    }

    public function formEncode($payload)
    {
        $postDataArray = [];
        foreach ($payload as $key => $value) {
            if (is_array($value)) {
                $stringValue = $this->jsonEncode($value);
            } else {
                $stringValue = urlencode($value);
            }
            $postDataArray[] = $key . '=' . $stringValue;
        }
        $postdata = join('&', $postDataArray);

        return $postdata;
    }

    public function jsonEncode($payload)
    {
        $encoded = json_encode($payload);

        if (!$encoded) {
            throw new YunxinSDKException("Unable to serialize payload");
        }

        return $encoded;
    }

    /**
     * Construct a query string from an array
     *
     * @param array $query_input
     *
     * @return string
     */
    public function constructQueryParams($query_input)
    {
        $query_string = '?';
        foreach ($query_input as $parameter => $value) {
            $encoded_value = urlencode($value);
            $query_string .= $parameter . '=' . $encoded_value . '&';
        }
        $query_string = trim($query_string, '&');
        return $query_string;
    }

    /**
     * Adds a new header
     *
     * @param string $header_string
     */
    public function addHeader($header_string)
    {
        array_push($this->headers, $header_string);
    }

    /**
     * Pushes a string to the end of the current endpoint
     *
     * @param string $string
     */
    public function appendToEndpoint($string)
    {
        $this->endpoint = $this->endpoint .= $string;
    }

    public function checkKey($apikey, $apiSecret)
    {
        if (!$apikey) {
            throw new YunxinSDKException('You must provide a valid API key');
        }
        if (!$apiSecret) {
            throw new YunxinSDKException('You must provide a valid API secret');
        }
    }

}
