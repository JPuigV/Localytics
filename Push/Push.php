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
    private $deepLinkDomain;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function send($appId,$pushId,PushTarget $target,$message,$deepLink = null){
        $pushMessage = $this->buildPushMessage($pushId,$target,$message,$deepLink);
        return $this->sender->send(self::ENDPOINT . $appId,$pushMessage);
    }

    private function buildPushMessage($pushId,PushTarget $target,$message,$deepLink){
        $payload = [
            'request_id' => $pushId,
            'target_type' => $target->getType()
        ];

        $pushMessage = [];
        if(in_array($target->getType(),[self::TARGET_TYPE_CUSTOMER_ID,self::TARGET_TYPE_AUDIENCE_ID])){
            $pushMessage['target'] = (string)$target->getId();
        }
        $pushMessage['alert'] = [
            'body' => $message
        ];
        
        $extra = [];
        if(!empty($deepLink)){
            $extra = ['ll_deep_link_url' => $deepLink ]
        }
        $pushMessage['ios'] = ['sound' => 'default.wav','badge' => 1,'extra' => $extra];
        

        $payload['messages'] = [$pushMessage];

        return json_encode($payload);
    }
}
