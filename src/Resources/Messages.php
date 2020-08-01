<?php


namespace WZ\Yunxin\Resources;


use WZ\Yunxin\Requests\Objects\BatchMessageParams;
use WZ\Yunxin\Requests\Objects\MessageParams;

class Messages extends Resource
{
    public $urlPrefix = '/msg';

    const SEND_MESSAGE_URL = '/sendMsg.action';
    const SEND_BATCH_URL = '/sendBatchMsg.action';

    public function sendMessage(MessageParams $messageParams) {
        $this->endpointToSet = self::SEND_MESSAGE_URL;
        $this->payloadToSend = [
            'from' => $messageParams->from,
            'to' => $messageParams->to,
            'ope' => $messageParams->ope,
            'type' => $messageParams->type,
            'body' => $messageParams->body,
            'option' => json_encode($messageParams->option),
            'pushcontent' => $messageParams->pushContent,
        ];
    }

    public function sendBatchMessage(BatchMessageParams $messageParams)
    {
        $this->endpointToSet = self::SEND_BATCH_URL;
        $this->payloadToSend = [
            'fromAccid' => $messageParams->from,
            'toAccids' => json_encode($messageParams->receivers),
            'type' => $messageParams->type,
            'body' => $messageParams->body,
            'option' => json_encode($messageParams->option)
        ];
    }
}
