<?php


namespace WZ\Yunxin\Resources;


class Histories extends Resource
{
    const GET_SESSION_URL = '/querySessionMsg.action';
    const GET_GROUP_URL = '/queryTeamMsg.action';

    public $urlPrefix = '/history';

    public function getMessage($from, $to, $beginTime, $endTime = '', $limit = '100', $reverse = '1')
    {
        $this->endpointToSet = self::GET_SESSION_URL;
        $this->payloadToSend = [
            'from' => $from,
            'to' => $to,
            'begintime' => $beginTime,
            'endtime' => $endTime,
            'limit' => $limit,
            'reverse' => $reverse
        ];
    }

    public function getGroupMessage($targetId, $accId, $beginTime, $endTime = '', $limit = '100', $reverse = '1')
    {
        $this->endpointToSet = self::GET_GROUP_URL;
        $this->payloadToSend = [
            'tid' => $targetId,
            'accid' => $accId,
            'begintime' => $beginTime,
            'endtime' => $endTime,
            'limit' => $limit,
            'reverse' => $reverse
        ];
    }
}
