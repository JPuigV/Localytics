<?php
/**
 * Created by PhpStorm.
 * User: puig
 * Date: 29/12/17
 * Time: 10:52
 */

namespace Jpuig\LocalyticsBundle\Push;


class PushPayload
{
    private $requestId;
    private $targetType;
    private $messages;

    public function __construct($requestId, $targetType)
    {
        $this->requestId = $requestId;
        $this->targetType = $targetType;
        $this->messages = [];
    }

    public function addMessage(PushMessage $pushMessage){
        $this->messages[] = $pushMessage;
    }

    public function getJSONEncoded(){
        $messagesAsArray = [];
        /** @var PushMessage $message */
        foreach($this->messages as $message){
            $messagesAsArray[] = $message->getAsArray();
        }

        return json_encode([
            'request_id' => $this->requestId,
            'target_type' => $this->targetType,
            'messages' => $messagesAsArray
        ]);
    }

}