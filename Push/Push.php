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

    public function send($appId,$pushId,PushTarget $target,$message,$messageTitle,$deepLink = null){
        $pushMessage = $this->buildPushMessage($pushId,$target,$message,$messageTitle,$deepLink);
        return $this->sender->send(self::ENDPOINT . $appId,$pushMessage);
    }

    private function buildPushMessage($pushId,PushTarget $target,$message,$messageTitle,$deepLink){

        $pushPayload = new PushPayload($pushId,$target->getType());
        $pushMessage = new PushMessage(
            $message,
            $messageTitle,
            in_array($target->getType(),[self::TARGET_TYPE_CUSTOMER_ID,self::TARGET_TYPE_AUDIENCE_ID]) ? $target->getId() : null,
            'default.wav',
            1,
            $deepLink);
        $pushPayload->addMessage($pushMessage);

        return $pushPayload->getJSONEncoded();
    }
}
