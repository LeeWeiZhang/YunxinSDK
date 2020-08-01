<?php


namespace WZ\Yunxin\Resources;


use WZ\Yunxin\Requests\Objects\TeamParams;

class Teams extends Resource
{
    public $urlPrefix = '/team';

    const CREATE_URL = '/create.action';
    const UPDATE_URL = '/update.action';
    const UPDATE_NICK_URL = '/updateTeamNick.action';
    const QUERY_URL = '/query.action';
    const REMOVE_URL = '/remove.action';
    const CHANGE_OWNER_URL = '/changeOwner.action';
    const ADD_MANAGER_URL = '/addManager.action';
    const REMOVE_MANAGER_URL = '/removeManager.action';
    const ADD_MEMBER_URL = '/add.action';
    const KICK_MEMBER_URL = '/kick.action';
    const GET_USER_TEAMS_URL = '/joinTeams.action';

    public function create(TeamParams $params)
    {
        $this->endpointToSet = self::CREATE_URL;
        $this->payloadToSend = [
            'tname' => $params->name,
            'owner' => $params->owner,
            'members' => json_encode($params->members),
            'announcement' => $params->announcement,
            'intro' => $params->intro,
            'msg' => $params->message,
            'magree' => $params->magree,
            'joinmode' => $params->joinMode,
            'custom' => $params->custom
        ];

    }

    public function update(TeamParams $params)
    {
        $this->endpointToSet = self::UPDATE_URL;
        $this->payloadToSend = [
            'tname' => $params->name,
            'owner' => $params->owner,
            'members' => json_encode($params->members),
            'announcement' => $params->announcement,
            'intro' => $params->intro,
            'msg' => $params->message,
            'magree' => $params->magree,
            'joinmode' => $params->joinMode,
            'custom' => $params->custom
        ];
    }

    public function updateNick($tid, $owner, $accid, $nick)
    {
        $this->endpointToSet = self::UPDATE_NICK_URL;
        $this->payloadToSend = [
            'tid' => $tid,
            'owner' => $owner,
            'accid' => $accid,
            'nick' => $nick
        ];
    }

    /**
     * @param array $teamIds
     * @param string $ope [0 - group info only, 1 group info with members]
     */
    public function query(array $teamIds, $ope = '0')
    {
        $this->endpointToSet = self::QUERY_URL;
        $this->payloadToSend = [
            'tids' => json_encode($teamIds),
            'ope' => $ope
        ];
    }

    public function remove($tid, $owner)
    {
        $this->endpointToSet = self::REMOVE_URL;
        $this->payloadToSend = [
            'tid' => $tid,
            'owner' => $owner
        ];
    }

    /**
     * @param $tid
     * @param $owner
     * @param $newowner
     * @param string $leave 1: leave group after owner changed，2：become member after owner changed
     */
    public function changeOwner($tid, $owner, $newowner, $leave = '2')
    {
        $this->endpointToSet = self::CHANGE_OWNER_URL;
        $this->payloadToSend = [
            'tid' => $tid,
            'owner' => $owner,
            'newowner' => $newowner,
            'leave' => $leave
        ];
    }

    public function addManager($tid, $owner, $members)
    {
        $this->endpointToSet = self::ADD_MANAGER_URL;
        $this->payloadToSend = [
            'tid' => $tid,
            'owner' => $owner,
            'members' => json_encode($members)
        ];
    }

    public function removeManager(string $tid, string $owner, array $members)
    {
        $this->endpointToSet = self::REMOVE_MANAGER_URL;
        $this->payloadToSend = [
            'tid' => $tid,
            'owner' => $owner,
            'members' => json_encode($members)
        ];
    }

    public function addMember(string $tid, string $owner, array $members, $magree = '0', $msg = '请您入伙')
    {
        $this->endpointToSet = self::ADD_MEMBER_URL;
        $this->payloadToSend = [
            'tid' => $tid,
            'owner' => $owner,
            'members' => json_encode($members),
            'magree' => $magree,
            'msg' => $msg
        ];

    }

    public function kickMember(string $tid, string $owner, string $member)
    {
        $this->endpointToSet = self::KICK_MEMBER_URL;
        $this->payloadToSend = [
            'tid' => $tid,
            'owner' => $owner,
            'member' => $member
        ];
    }

    public function getUserTeams(string $acccountId)
    {
        $this->endpointToSet = self::GET_USER_TEAMS_URL;
        $this->payloadToSend = [
            'accid' => $acccountId
        ];
    }
}
