<?php


namespace WZ\Yunxin\Resources;


use WZ\Yunxin\Requests\Objects\RoomMessageParams;

class Chatrooms extends Resource
{
    public $urlPrefix = "/chatroom";

    const CREATE_URL = "/create.action";
    const ADD_ROBOT_URL = "/addRobot.action";
    const REMOVE_ROBOT_URL = "/removeRobot.action";
    const REQUEST_ADDR_URL = "/requestAddr.action";
    const SEND_MSG_URL = "/sendMsg.action";
    const TOGGLE_STAT_URL = "/toggleCloseStat.action";

    public function create($accid, $name, $broadcastUrl)
    {
        $this->endpointToSet = self::CREATE_URL;
        $this->payloadToSend = [
            'creator' => $accid,
            'name' => $name,
            'broadcasturl' => $broadcastUrl
        ];
    }

    public function addRobot($roomId, array $username)
    {
        $this->endpointToSet = self::ADD_ROBOT_URL;
        $this->payloadToSend = [
            'accids' => json_encode($username),
            'roomid' => $roomId,
        ];
    }

    public function removeRobot($roomId, $username)
    {
        $this->endpointToSet = self::REMOVE_ROBOT_URL;
        $this->payloadToSend = [
            'accids' => json_encode($username),
            'roomid' => $roomId,
        ];
    }

    public function requestAddr($roomId, $username)
    {
        $this->endpointToSet = self::REQUEST_ADDR_URL;
        $this->payloadToSend = [
            'accid' => $username,
            'roomid' => $roomId,
        ];
    }

    public function sendMessage(RoomMessageParams $params)
    {
        $this->endpointToSet = self::SEND_MSG_URL;
        $this->payloadToSend = [
            'roomid' => $params->roomId,
            'fromAccid' => $params->from,
            'msgType' => $params->msgType,
            'attach' => $params->content,
            'ext' => $params->ext,
            'msgId' => $params->msgId ?? hexdec(uniqid()),
        ];
    }

    public function closeRoom($username, $roomId, $valid)
    {
        $this->endpointToSet = self::TOGGLE_STAT_URL;
        $this->payloadToSend = [
            'operator' => $username,
            'roomid' => $roomId,
            'valid' => $valid
        ];
    }
}
