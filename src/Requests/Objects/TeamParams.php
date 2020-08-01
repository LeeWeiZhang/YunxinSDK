<?php


namespace WZ\Yunxin\Requests\Objects;


class TeamParams
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $owner;

    /**
     * @var array
     */
    public $members;

    /**
     * @var string
     */
    public $announcement = '';

    /**
     * @var string
     */
    public $intro = '';

    /**
     * @var string
     */
    public $message = '';

    /**
     * 0 - user join when get invitation, 1 - user join when accept invitation
     * @var string
     */
    public $magree = '0';

    /**
     * 0 - no verification need，1 - need verification, 2 - nobody can join
     * @var string
     */
    public $joinMode = '0';

    /**
     * @maxlength 1024
     * @var string
     */
    public $custom = '';
}
