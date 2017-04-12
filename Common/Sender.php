<?php
/**
 * Created by PhpStorm.
 * User: puig
 * Date: 10/04/17
 * Time: 10:20
 */

namespace Jpuig\LocalyticsBundle\Common;


class Sender
{
    private $apiKey;
    private $apiSecret;

    public function __construct($apiKey,$apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function send($endpoint,$data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$endpoint);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            'Content-Type: application/json',
            'Content-Length: '.strlen($data)
        ]);
        curl_setopt($ch,CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":" . $this->apiSecret);
        return curl_exec($ch);
    }
}
