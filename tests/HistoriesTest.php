<?php

namespace WZ\Yunxin\Tests;

use WZ\Yunxin\Resources\Histories;

class HistoriesTest extends YunXinTest
{

    /** @var Histories $histories */
    protected $histories;

    public function setUp(): void
    {
        parent::setUp();

        $this->isHistoriesResource();
    }

    public function isHistoriesResource()
    {
        $this->histories = $this->yunxin->histories();

        $this->assertInstanceOf(\WZ\Yunxin\Resources\Histories::class, $this->histories);

        $this->assertSame($this->histories->urlPrefix, $this->histories->getUrlPrefix());
    }

    public function testGetMessage()
    {
        $this->histories->getMessage('uid_from', 'uid_to', 324234, 324423, '1000', '1');
        $this->assertSame(
            Histories::GET_SESSION_URL,
            $this->histories->endpointToSet
        );

        $this->assertSame(
            $this->histories->payloadToSend,
            $this->payloadToSend = [
                'from' => 'uid_from',
                'to' => 'uid_to',
                'begintime' => 324234,
                'endtime' => 324423,
                'limit' => '1000',
                'reverse' => '1'
            ]
        );
    }

    public function testGetGroupMessage()
    {
        $this->histories->getGroupMessage('uid_to', 'uid_from', 324234, 3244233, '1000', '1');

        $this->assertSame(
            Histories::GET_GROUP_URL,
            $this->histories->endpointToSet
        );

        $this->assertSame(
            $this->histories->payloadToSend,
            $this->payloadToSend = [
                'tid' => 'uid_to',
                'accid' => 'uid_from',
                'begintime' => 324234,
                'endtime' => 3244233,
                'limit' => '1000',
                'reverse' => '1'
            ]
        );
    }
}
