<?php

namespace WZ\Yunxin\Tests;


use WZ\Yunxin\Requests\Objects\MessageTypes;
use WZ\Yunxin\Requests\Objects\RoomMessageParams;
use WZ\Yunxin\Resources\Chatrooms;

class ChatroomsTest extends YunXinTest
{
    /** @var Chatrooms $chatroom */
    protected $chatroom;

    public function setUp(): void
    {
        parent::setUp();

        $this->isChatroomsResource();
    }

    public function isChatroomsResource()
    {
        $this->chatroom = $this->yunxin->chatrooms();

        $this->assertInstanceOf(\WZ\Yunxin\Resources\Chatrooms::class, $this->chatroom);

        $this->assertSame($this->chatroom->urlPrefix, $this->chatroom->getUrlPrefix());
    }

    public function testCreate()
    {
        $this->chatroom->create('john_doe', 'john_doe', '');

        $this->assertSame(
            Chatrooms::CREATE_URL,
            $this->chatroom->endpointToSet
        );

        $this->assertSame(
            $this->chatroom->payloadToSend,
            [
                'creator' => 'john_doe',
                'name' => 'john_doe',
                'broadcasturl' => ''
            ]
        );
    }

    public function testAddRobot()
    {
        $this->chatroom->addRobot(65465654654, ['john_doe']);

        $this->assertSame(
            Chatrooms::ADD_ROBOT_URL,
            $this->chatroom->endpointToSet
        );

        $this->assertSame(
            $this->chatroom->payloadToSend,
            [
                'accids' => json_encode(['john_doe']),
                'roomid' => 65465654654,
            ]
        );
    }

    public function testRemoveRobot()
    {
        $this->chatroom->removeRobot(65465654654, ['john_doe']);

        $this->assertSame(
            Chatrooms::REMOVE_ROBOT_URL,
            $this->chatroom->endpointToSet
        );

        $this->assertSame(
            $this->chatroom->payloadToSend,
            [
                'accids' => json_encode(['john_doe']),
                'roomid' => 65465654654,
            ]
        );
    }

    public function testGetRoomAddress()
    {
        $this->chatroom->requestAddr(65465654654, 'john_doe');

        $this->assertSame(
            Chatrooms::REQUEST_ADDR_URL,
            $this->chatroom->endpointToSet
        );

        $this->assertSame(
            $this->chatroom->payloadToSend,
            [
                'accid' => 'john_doe',
                'roomid' => 65465654654,
            ]
        );
    }

    public function testSendMessage()
    {
        $params = new RoomMessageParams();
        $params->roomId = 65465654654;
        $params->from = 'john_doe';
        $params->msgId = hexdec(uniqid());
        $params->content = 'content';
        $this->chatroom->sendMessage($params);

        $this->assertSame(
            Chatrooms::SEND_MSG_URL,
            $this->chatroom->endpointToSet
        );

        $this->assertSame(
            $this->chatroom->payloadToSend,
            [
                'roomid' => 65465654654,
                'fromAccid' => 'john_doe',
                'msgType' => MessageTypes::TEXT,
                'attach' => 'content',
                'ext' => null,
                'msgId' => $params->msgId,
            ]
        );
    }

    public function testCloseRoom()
    {
        $this->chatroom->closeRoom('user_id', 123, 'false');

        $this->assertSame(
            Chatrooms::TOGGLE_STAT_URL,
            $this->chatroom->endpointToSet
        );

        $this->assertSame(
            $this->chatroom->payloadToSend,
            [
                'operator' => 'user_id',
                'roomid' => 123,
                'valid' => 'false'
            ]
        );
    }

}
