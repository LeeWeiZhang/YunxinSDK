<?php

namespace WZ\Yunxin\Tests;

use WZ\Yunxin\Exceptions\YunxinSDKException;
use WZ\Yunxin\Yunxin;

class YunXinTest extends TestCase
{
    protected $isRealEnv = false;

    public function setUp() : void
    {
        parent::setup();
    }

    public function testYunxin()
    {
        $this->expectException(YunxinSDKException::class);
        new Yunxin("","");

        $this->isRealEnv = strtolower(getenv('IS_ENV_REAL')) == "true";
    }

}
