<?php


namespace WZ\Yunxin\Requests\Objects;


class RoomMessageParams
{
    public $roomId;

    public $from;

    /**
     * const in MessageTypes
     * @var int
     */
    public $msgType = 0;

    /**
     * @var
     */
    public $content = null;

    /**
     * @var array
     */
    public $ext = null;

    /**
     * @var int
     */
    public $msgId;

}
