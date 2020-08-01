<?php


namespace WZ\Yunxin\Resources;


use WZ\Yunxin\Exceptions\YunxinResponseException;
use WZ\Yunxin\Requests\Connection;
use WZ\Yunxin\Requests\Request;
use WZ\Yunxin\Responses\SuccessYunxinResponse;

abstract class Resource
{
    /** @var Request $request */
    protected $request;

    /** @var string $urlPrefix */
    protected $urlPrefix;

    /** @var string $endpointToSet */
    public $endpointToSet;

    /** @var array $payloadToSend */
    public $payloadToSend;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getUrlPrefix(): string
    {
        return $this->urlPrefix;
    }

    protected function getConnection(Request $request)
    {
        $connection = new Connection($request);
        return $connection;
    }

    public function execute()
    {
        /** @var SuccessYunxinResponse $response */
        $response =  $this->postToActionEndpoint(
            self::getUrlPrefix() . $this->endpointToSet,
            $this->payloadToSend
        );
        return json_decode($response->getBody());
    }

    /**
     * @param $endpoint
     * @param array $params
     * @return mixed
     * @throws \WZ\Yunxin\Exceptions\YunxinException
     */
    public function postToActionEndpoint(string $endpoint, array $params = []): SuccessYunxinResponse
    {
        $this->request->setEndpoint($endpoint);
        $this->request->setMethod("POST");
        if (!empty($params)) {
            $this->request->setPayload($params);
        }

        $connection = $this->getConnection($this->request);

        $response = $connection->execute();

        if ($response->getHttpCode() !== 200) {
            throw new YunxinResponseException('Unexpected Error');
        }
        $data = $response->deserialize(true);

        if ($response->wasFailure()) {
            throw new YunxinResponseException($data['desc']);
        }

        return $response;
    }
}
