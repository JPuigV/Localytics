<?php
/**
 * Created by PhpStorm.
 * User: puig
 * Date: 29/12/17
 * Time: 10:37
 */

namespace Jpuig\LocalyticsBundle\Push;


class PushMessage
{
    private $message;
    private $title;
    private $target;
    private $iOSSound;
    private $iOSBadge;
    private $deepLink;

    public function __construct($message, $title = null, $target = null, $iOSSound = null, $iOSBadge = null, $deepLink = null)
    {
        $this->message = $message;
        $this->title = $title;
        $this->target = $target;
        $this->iOSSound = $iOSSound;
        $this->iOSBadge = $iOSBadge;
        $this->deepLink = $deepLink;
    }

    public function getAsArray(){
        $pushMessage = [];
        if(!empty($this->target)){
            $pushMessage['target'] = (string)$this->target;
        }

        $pushMessage['alert'] = [
            'body' => $this->message,
            'title' => $this->title,
        ];

        $pushMessage['ios'] = $this->getIOSParametersAsArray();
        $pushMessage['android'] = $this->getAndroidParametersAsArray();

        return $pushMessage;
    }

    private function getIOSParametersAsArray(){
        $iOSParameters = [];
        if(!empty($this->iOSSound)){
            $iOSParameters['sound'] = $this->iOSSound;
        }

        if(!empty($this->iOSBadge)){
            $iOSParameters['badge'] = $this->iOSBadge;
        }

        if(!empty($this->deepLink)){
            $iOSParameters['extra'] = ['ll_deep_link_url' => $this->deepLink ];
        }
        return $iOSParameters;
    }

    private function getAndroidParametersAsArray(){
        $androidParameters = [];
        if(!empty($this->deepLink)){
            $androidParameters['extra'] = ['ll_deep_link_url' => $this->deepLink ];
        }
        return $androidParameters;
    }

}