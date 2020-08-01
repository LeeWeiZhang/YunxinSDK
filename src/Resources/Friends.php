<?php


namespace WZ\Yunxin\Resources;


class Friends extends Resource
{
    public $urlPrefix = "/friend";

    const GET_FRIEND_URL = "/GET.action";
    const ADD_FRIEND_URL = "/add.action";
    const UPDATE_FRIEND_URL = "/update.action";
    const DELETE_FRIEND_URL = "/delete.action";

    public function getFriend($accid)
    {
        $this->endpointToSet = self::GET_FRIEND_URL;
        $this->payloadToSend = [
            'accid' => $accid,
            'createtime' => (string) (time() * 100)
        ];
    }

    public function addFriend($accId, $faccId, $type = '1', $msg = '')
    {
        $this->endpointToSet = self::ADD_FRIEND_URL;
        $this->payloadToSend = [
            'accid' => $accId,
            'faccid' => $faccId,
            'type' => $type,
            'msg' => $msg
        ];
    }

    public function updateFriend($accId, $faccId, $alias)
    {
        $this->endpointToSet = self::UPDATE_FRIEND_URL;
        $this->payloadToSend = [
            'accid' => $accId,
            'faccid' => $faccId,
            'alias' => $alias,
        ];
    }

    public function deleteFriend($accId, $faccId)
    {
        $this->endpointToSet = self::DELETE_FRIEND_URL;
        $this->payloadToSend = [
            'accid' => $accId,
            'faccid' => $faccId
        ];
    }
}
