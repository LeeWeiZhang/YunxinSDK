<?php

namespace WZ\Yunxin\Tests;


use WZ\Yunxin\Requests\Objects\TeamParams;
use WZ\Yunxin\Resources\Teams;

class TeamsTest extends YunXinTest
{

    /** @var Teams $teams */
    protected $teams;

    public function setUp(): void
    {
        parent::setUp();

        $this->isMessagesResource();
    }

    public function isMessagesResource()
    {
        $this->teams = $this->yunxin->teams();

        $this->assertInstanceOf(\WZ\Yunxin\Resources\Teams::class, $this->teams);

        $this->assertSame($this->teams->urlPrefix, $this->teams->getUrlPrefix());
    }
    public function testCreate()
    {
        $messageParams = new TeamParams();
        $messageParams->name = 'team_name';
        $messageParams->owner = 'user_accid';
        $messageParams->members = ['user1','user2'];

        $this->teams->create($messageParams);

        $this->assertSame(
            Teams::CREATE_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tname' => $messageParams->name,
                'owner' => $messageParams->owner,
                'members' => json_encode($messageParams->members),
                'announcement' => '',
                'intro' => '',
                'msg' => '',
                'magree' => '0',
                'joinmode' => '0',
                'custom' => '',
            ],
            $this->teams->payloadToSend
        );
    }

    public function testUpdate()
    {
        $messageParams = new TeamParams();
        $messageParams->name = 'new team_name';
        $messageParams->owner = 'user_accid';
        $messageParams->members = ['user1','user2'];

        $this->teams->update($messageParams);

        $this->assertSame(
            Teams::UPDATE_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tname' => $messageParams->name,
                'owner' => $messageParams->owner,
                'members' => json_encode($messageParams->members),
                'announcement' => '',
                'intro' => '',
                'msg' => '',
                'magree' => '0',
                'joinmode' => '0',
                'custom' => '',
            ],
            $this->teams->payloadToSend
        );
    }

    public function testAddManager()
    {
        $this->teams->addManager('team_id', 'owner_accid', ['member_1', 'member_02']);
        $this->assertSame(
            Teams::ADD_MANAGER_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tid' => 'team_id',
                'owner' => 'owner_accid',
                'members' => json_encode(['member_1', 'member_02'])
            ],
            $this->teams->payloadToSend
        );
    }

    public function testRemoveManager()
    {
        $this->teams->removeManager('team_id', 'owner_accid', ['member_1', 'member_02']);
        $this->assertSame(
            Teams::REMOVE_MANAGER_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tid' => 'team_id',
                'owner' => 'owner_accid',
                'members' => json_encode(['member_1', 'member_02'])
            ],
            $this->teams->payloadToSend
        );
    }

    public function testGetUserTeams()
    {
        $this->teams->getUserTeams('owner_accid');
        $this->assertSame(
            Teams::GET_USER_TEAMS_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'accid' => 'owner_accid'
            ],
            $this->teams->payloadToSend
        );
    }

    public function testRemove()
    {
        $this->teams->remove('team_id', 'owner_accid');
        $this->assertSame(
            Teams::REMOVE_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tid' => 'team_id',
                'owner' => 'owner_accid'
            ],
            $this->teams->payloadToSend
        );
    }

    public function testChangeOwner()
    {
        $this->teams->changeOwner('team_ownerid', 'owner_id', 'new_owner_id');
        $this->assertSame(
            Teams::CHANGE_OWNER_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tid' => 'team_ownerid',
                'owner' => 'owner_id',
                'newowner' => 'new_owner_id',
                'leave' => '2'
            ],
            $this->teams->payloadToSend
        );
    }

    public function testQuery()
    {
        $this->teams->query(['team_1', 'team_2'], '1');
        $this->assertSame(
            Teams::QUERY_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tids' => json_encode(['team_1', 'team_2']),
                'ope' => '1'
            ],
            $this->teams->payloadToSend
        );
    }

    public function testAddMember()
    {
        $this->teams->addMember('team_id', 'owner_id', ['accid1', 'accid2']);
        $this->assertSame(
            Teams::ADD_MEMBER_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tid' => 'team_id',
                'owner' => 'owner_id',
                'members' => json_encode(['accid1', 'accid2']),
                'magree' => '0',
                'msg' => '请您入伙'
            ],
            $this->teams->payloadToSend
        );
    }

    public function testKickMember()
    {
        $this->teams->kickMember('team_id', 'owner_id', 'accid1');
        $this->assertSame(
            Teams::KICK_MEMBER_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tid' => 'team_id',
                'owner' => 'owner_id',
                'member' => 'accid1'
            ],
            $this->teams->payloadToSend
        );
    }

    public function testUpdateNick()
    {
        $this->teams->updateNick('team_id', 'owner_id', 'accid1', 'nickname');
        $this->assertSame(
            Teams::UPDATE_NICK_URL,
            $this->teams->endpointToSet
        );
        $this->assertSame(
            [
                'tid' => 'team_id',
                'owner' => 'owner_id',
                'accid' => 'accid1',
                'nick' => 'nickname',
            ],
            $this->teams->payloadToSend
        );
    }
}
