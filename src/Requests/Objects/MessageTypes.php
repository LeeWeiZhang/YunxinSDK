<?php


namespace WZ\Yunxin\Requests\Objects;


class MessageTypes
{
    const TEXT = 0;

    const IMAGE = 1;

    const VOICE = 2;

    const VIDEO = 3;

    const LOCATION = 4;

    const FILE = 6;

    const TIPS = 10;

    const CUSTOM = 100; //自定义消息类型（特别注意，对于未对接易盾反垃圾功能的应用，该类型的消息不会提交反垃圾系统检测）

}
