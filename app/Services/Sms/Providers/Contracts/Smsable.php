<?php


namespace App\Services\Sms\Providers\Contracts;


interface Smsable
{
    public function send(string $mobile, string $messageText): string;

    public function sendByPattern(string $mobile, string $patternCode, array $inputParameters): string;

    public function sendWithAdvertisingNumber(string $mobile, string $messageText): string;

    public function getDeliveryStatus($messageId): string;

    public function info();
}
