<?php

namespace WZ\Yunxin\Tests;


use WZ\Yunxin\Resources\Friends;

class FriendsTest extends YunXinTest
{

    /** @var Friends $friend */
    protected $friend;

    public function setUp(): void
    {
        parent::setUp();

        $this->isFriendsResource();
    }

    public function isFriendsResource()
    {
        $this->friend = $this->yunxin->friends();

        $this->assertInstanceOf(\WZ\Yunxin\Resources\Friends::class, $this->friend);

        $this->assertSame($this->friend->urlPrefix, $this->friend->getUrlPrefix());
    }

    public function testAddFriend()
    {
        $this->friend->addFriend(12, 34, '1', 'Hello, will you be my friend');

        $this->assertSame(
            Friends::ADD_FRIEND_URL,
            $this->friend->endpointToSet
        );

        $this->assertSame(
            $this->friend->payloadToSend,
            [
                'accid' => 12,
                'faccid' => 34,
                'type' => '1',
                'msg' => 'Hello, will you be my friend'
            ]
        );
    }

    public function testUpdateFriend()
    {
        $this->friend->updateFriend('user', 'target_user', '1');
        $this->assertSame(
            Friends::UPDATE_FRIEND_URL,
            $this->friend->endpointToSet
        );

        $this->assertSame(
            $this->friend->payloadToSend,
            [
                'accid' => 'user',
                'faccid' => 'target_user',
                'alias' => '1',
            ]
        );
    }

    public function testGetFriend()
    {
        $this->friend->getFriend('user');

        $this->assertSame(
            Friends::GET_FRIEND_URL,
            $this->friend->endpointToSet
        );

        $this->assertSame(
            $this->friend->payloadToSend,
            $this->friend->payloadToSend = [
                'accid' => 'user',
                'createtime' => (string) (time() * 100)
            ]
        );
    }

    public function testDeleteFriend()
    {
        $this->friend->deleteFriend('user', 'target_id');

        $this->assertSame(
            Friends::DELETE_FRIEND_URL,
            $this->friend->endpointToSet
        );

        $this->assertSame(
            $this->friend->payloadToSend,
            [
                'accid' => 'user',
                'faccid' => 'target_id'
            ]
        );
    }
}
