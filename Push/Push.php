<?php
/**
 * Created by PhpStorm.
 * User: puig
 * Date: 10/04/17
 * Time: 09:43
 */

namespace Jpuig\LocalyticsBundle\Push;

use Jpuig\LocalyticsBundle\Common\Sender;

class Push
{
    const TARGET_TYPE_BROADCAST = 'broadcast';
    const TARGET_TYPE_CUSTOMER_ID = 'customer_id';
    const TARGET_TYPE_AUDIENCE_ID = 'audience_id';
    const TARGET_TYPE_PROFILE = 'profile';

    const ENDPOINT = 'https://messaging.localytics.com/v2/push/';

    private $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function send($appId,PushTarget $target,$message){
        $pushMessage = $this->buildPushMessage($target,$message);
        return $this->sender->send(self::ENDPOINT . $appId,$pushMessage);
    }

    private function buildPushMessage(PushTarget $target,$message){
        $payload = [
            'request_id' => bin2hex(random_bytes(10)),
            'target_type' => $target->getType()
        ];

        $pushMessage = [];
        if(in_array($target->getType(),[self::TARGET_TYPE_PROFILE,self::TARGET_TYPE_AUDIENCE_ID])){
            $pushMessage['target'] = $target->getId();
        }
        $pushMessage['alert'] = [
            'body' => 'message'
        ];
        $pushMessage['ios'] = ['sound' => 'default.wav','badge' => 1];

        $payload['messages'] = [$pushMessage];

        return json_encode($payload);
    }
}
