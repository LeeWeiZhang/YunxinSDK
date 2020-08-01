<?php


namespace WZ\Yunxin\Requests\Objects;


class BatchMessageParams
{
    /**
     * Sender account's ID
     * @var string
     */
    public $from;

    /**
     * Receivers account's ID
     * @var array
     */
    public $receivers;

    /**
     * Types of messages
     * @var int
     */
    public $type = 0;

    /**
     * Content of the messages
     * @var string
     */
    public $body = '';

    /**
     * Options of sending the message
     * @var array
     */
    public $option = [];
}
