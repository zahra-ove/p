<?php


namespace App\Services\Sms\Providers;


use Exception;
use Kavenegar;
use App\Services\Sms\Providers\Contracts\Smsable;

class KavenegarProvider implements Smsable
{

    public function send(string $mobile, string $messageText): string
    {
        try {
            $result = Kavenegar::Send($this->getServiceNumber(), $mobile, $messageText);
            if (!is_array($result) || !count($result) || $result[0]->status > 5) {
                throw new Exception();
            }
            return $result[0]->messageid;
        } catch (Exception $exception) {
            return 'failed';
        }
    }

    public function sendByPattern(string $mobile, string $patternCode, array $inputParameters): string
    {
        $token1 = $inputParameters['token'];
        $token2 = $inputParameters['token2'] ?? '';
        $token3 = $inputParameters['token3'] ?? '';
        $token10 = $inputParameters['token10'] ?? '';
        try {
            $result = Kavenegar::VerifyLookup($mobile, $token1, $token2, $token3, $token10, $patternCode);
            if (!is_array($result) || !count($result) || $result[0]->status > 5) {
                throw new Exception();
            }
            return $result[0]->messageid;
        } catch (Exception $exception) {;
            return 'failed';
        }
    }

    public function sendWithAdvertisingNumber(string $mobile, string $messageText): string
    {
        try {
            $result = Kavenegar::Send($this->getAdvertisingNumber(), $mobile, $messageText);
            if (!is_array($result) || !count($result) || $result[0]->status > 5) {
                throw new Exception();
            }
            return $result[0]->messageid;
        } catch (Exception $exception) {
            return 'failed';
        }
    }

    public function getDeliveryStatus($messageId): string
    {
        try {
            $result = Kavenegar::Status($messageId);
            if (!is_array($result) || !count($result)) {
                throw new Exception();
            }
            $statusNumber = $result[0]->status;
            if (in_array($statusNumber, [1, 2, 3, 4, 5])) {
                return 'sending';
            }
            if ($statusNumber === 10) {
                return 'delivered';
            }
            if (in_array($statusNumber, [11, 13, 14])) {
                return 'failed';
            }
            if ($statusNumber === 100) {
                return 'undefined';
            }
        } catch (Exception $exception) {
            return 'failed';
        }
    }

    public function getServiceNumber()
    {
        return config('services.sms.service_number');
    }

    public function getAdvertisingNumber()
    {
        return config('services.sms.advertisement_number');
    }

    public function info()
    {
        return Kavenegar::AccountInfo();
    }

}
