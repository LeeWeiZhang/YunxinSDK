<?php

namespace WZ\Yunxin;

class Yunxin
{
    protected $appKey;

    protected $appSecret;

    protected $request;

    public function __construct($appKey, $appSecret)
    {
        $this->appKey = $appKey;

        $this->appSecret = $appSecret;

        $this->request = new Requests\Request($appKey, $appSecret);
    }

    public function users()
    {
        return new Resources\Users($this->request);
    }

    public function chatrooms()
    {
        return new Resources\Chatrooms($this->request);
    }

    public function friends()
    {
        return new Resources\Friends($this->request);
    }

    public function histories()
    {
        return new Resources\Histories($this->request);
    }

    public function messages()
    {
        return new Resources\Messages($this->request);
    }

    public function teams()
    {
        return new Resources\Teams($this->request);
    }
}
