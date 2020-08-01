<?php


namespace WZ\Yunxin\Tests;


use WZ\Yunxin\Resources\Users;

class UsersTest extends YunXinTest
{
    /** @var Users */
    protected $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->isUsersResource();
    }

    public function isUsersResource()
    {
        $this->users = $this->yunxin->users();

        $this->assertInstanceOf(\WZ\Yunxin\Resources\Users::class, $this->users);

        $this->assertSame($this->users->urlPrefix, $this->users->getUrlPrefix());
    }

    public function testGetUsers()
    {
        $this->users->getUsersInfo(['user_accid']);

        $this->assertSame(
            Users::INFO_URL,
            $this->users->endpointToSet
        );

        $this->assertSame(
            $this->users->payloadToSend,
            ['accids' => json_encode(['user_accid'], true)]
        );
    }

    public function testCreateUsers()
    {
        $userArr = [
            'accid' => 'accid',
            'name' => 'name',
        ];
        $this->users->create($userArr);

        $this->assertSame(
            Users::CREATE_URL,
            $this->users->endpointToSet
        );

        $this->assertSame(
            $this->users->payloadToSend,
            $userArr
        );
    }

    public function testUpdateUsers()
    {
        $userArr = [
            'accid' => 'user_accid',
            'name'  => 'name',
            'props' => '{}',
            'token' => ''
        ];
        $this->users->update($userArr);

        $this->assertSame(
            Users::UPDATE_URL,
            $this->users->endpointToSet
        );

        $this->assertSame(
            $this->users->payloadToSend,
            $userArr
        );
    }

    public function testUpdateUserInfo()
    {
         $userArr = [
             'accid' => 'accid',
             'name' => 'name',
             'icon' => 'icon',
             'sign' => 'sign',
             'email' => 'email',
             'birth' => 'birth',
             'mobile' => 'mobile',
             'gender' => 'gender',
             'ex' => 'ex',
         ];
        $this->users->updateInfo($userArr);

        $this->assertSame(
            Users::UPDATE_INFO_URL,
            $this->users->endpointToSet
        );

        $this->assertSame(
            $this->users->payloadToSend,
            $userArr
        );
    }

    public function testBanUser()
    {
        $data = [
            'accid' => 'user_accid',
            'needkick' => true
        ];

        $this->users->ban($data);
        $this->assertSame(
            Users::BAN_URL,
            $this->users->endpointToSet
        );

        $this->assertSame(
            $this->users->payloadToSend,
            $data
        );
    }

    public function testUnbanUser()
    {
        $data = [
            'accid' => 'user_accid',
        ];

        $this->users->unBan($data);
        $this->assertSame(
            Users::UNBAN_URL,
            $this->users->endpointToSet
        );

        $this->assertSame(
            $this->users->payloadToSend,
            $data
        );
    }

    public function testSetSpecialRelationship()
    {
        $data = [
            'accid' => 'user_accid',
            'targetAcc' => 'target_acc',
            'relationType' => Users::RELATIONSHIP_BLACK_LIST,
            'value' => Users::RELATIONSHIP_MAKE,
        ];

        $this->users->setSpecialRelationship($data);
        $this->assertSame(
            Users::SPECIAL_RELATIONSHIP_URL,
            $this->users->endpointToSet
        );

        $this->assertSame(
            $this->users->payloadToSend,
            $data
        );
    }

}
