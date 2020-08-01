<?php


namespace WZ\Yunxin\Tests;


use Dotenv\Dotenv;
use WZ\Yunxin\Yunxin;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $yunxin;

    public function setUp() : void
    {
        parent::setUp();

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->yunxin = new Yunxin(
            getenv('YUNXIN_KEY'),
            getenv('YUNXIN_SECRET'),
        );
    }
}
