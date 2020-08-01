<?php


namespace WZ\Yunxin\Requests\Objects;

/**
 * This object contains a message params to send a message
 */
class MessageParams
{
    /**
     * Sender's account ID
     * @var string
     */
    public $from;

    /**
     * Receiver's account ID or team's ID
     * accid (Account ID) when ope is 0
     * tid (Team ID) when ope is 1
     * @var string
     */
    public $to;

    /**
     * Messages type
     * Enum [0 表示文本消息,1 表示图片,2 表示语,3 表示视频,4 表示地理位置信息,6 表示文件,100 自定义消息类型]
     * @var int
     */
    public $type = 0;

    /**
     * Enum [0：点对点个人消息，1：群消息，其他返回414]
     * @var int
     */
    public $ope = 0;

    /**
     * Messages contents
     * @var string
     */
    public $body = '';

    /**
     * Options when sending messages
     * 发消息时特殊指定的行为选项
     * 可用于指定消息的漫游，存云端历史，发送方多端同步，推送，消息抄送等特殊行为;
     * @var array
     */
    public $option = [];

    /**
     * This is push contents when in push notification
     * only valid when option contain（push=true)
     * @var string
     */
    public $pushContent = '';
}
