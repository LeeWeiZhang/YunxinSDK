<?php

namespace WZ\Yunxin\Resources;

use WZ\Yunxin\Requests\Request;

class Users extends Resource
{
    public $urlPrefix = "/user";

    const INFO_URL = "/getUinfos.action";
    const CREATE_URL = "/create.action";
    const UPDATE_URL = "/update.action";
    const BAN_URL = "/block.action";
    const UNBAN_URL = "/unblock.action";
    const UPDATE_INFO_URL = "/updateUinfo.action";
    const SPECIAL_RELATIONSHIP_URL = "/setSpecialRelation.action";

    const RELATIONSHIP_BLACK_LIST = 1;
    const RELATIONSHIP_MUTE = 2;

    const RELATIONSHIP_CANCEL = 0;
    const RELATIONSHIP_MAKE = 1;

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function getUsersInfo(array $accids) : void
    {
        $this->endpointToSet = self::INFO_URL;
        $this->payloadToSend = ['accids' => json_encode($accids, true)];
    }

    public function create(array $userArray) : void
    {
        $this->endpointToSet = self::CREATE_URL;
        $this->payloadToSend = $userArray;
    }

    /**
     * Able to update user token
     * @param array $userArray
     */
    public function update(array $userArray) : void
    {
        $this->endpointToSet = self::UPDATE_URL;
        $this->payloadToSend = $userArray;
    }

    /**
     * Update user information
     * @param array $data
     */
    public function updateInfo(array $data) : void
    {
        $this->endpointToSet = self::UPDATE_INFO_URL;
        $this->payloadToSend = $data;
    }

    public function ban(array $data) : void
    {
        $this->endpointToSet = self::BAN_URL;
        $this->payloadToSend = $data;
    }

    public function unBan(array $data) : void
    {
        $this->endpointToSet = self::UNBAN_URL;
        $this->payloadToSend = $data;
    }

    public function setSpecialRelationship(array $data) : void
    {
        $this->endpointToSet = self::SPECIAL_RELATIONSHIP_URL;
        $this->payloadToSend = $data;
    }
}
