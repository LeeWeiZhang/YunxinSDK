<?php

namespace WZ\Yunxin\Tests;


use WZ\Yunxin\Requests\Objects\BatchMessageParams;
use WZ\Yunxin\Requests\Objects\MessageParams;
use WZ\Yunxin\Resources\Messages;

class MessagesTest extends YunXinTest
{
    /** @var Messages $messages */
    protected $messages;

    public function setUp(): void
    {
        parent::setUp();

        $this->isMessagesResource();
    }

    public function isMessagesResource()
    {
        $this->messages = $this->yunxin->messages();

        $this->assertInstanceOf(\WZ\Yunxin\Resources\Messages::class, $this->messages);

        $this->assertSame($this->messages->urlPrefix, $this->messages->getUrlPrefix());
    }

    public function testSendMessage()
    {
        $messageParams = new MessageParams();
        $messageParams->from = 'from_user';
        $messageParams->to = 'to_user';
        $messageParams->body = 'body';

        $this->messages->sendMessage($messageParams);

        $this->assertSame(
            Messages::SEND_MESSAGE_URL,
            $this->messages->endpointToSet
        );
        $this->assertSame(
            [
                'from' => 'from_user',
                'to' => 'to_user',
                'ope' => 0,
                'type' => 0,
                'body' => 'body',
                'option' => json_encode([]),
                'pushcontent' => ''
            ],
            $this->messages->payloadToSend
        );
    }

    public function testSendBatchMessage()
    {
        $messageParams = new BatchMessageParams();
        $messageParams->from = 'from_user';
        $messageParams->receivers = ['to_user'];
        $messageParams->body = 'body';
        $this->messages->sendBatchMessage($messageParams);

        $this->assertSame(
            Messages::SEND_BATCH_URL,
            $this->messages->endpointToSet
        );

        $this->assertSame(
            [
                'fromAccid' => 'from_user',
                'toAccids' => json_encode(['to_user']),
                'type' => 0,
                'body' => 'body',
                'option' => json_encode([])
            ],
            $this->messages->payloadToSend
        );
    }
}
