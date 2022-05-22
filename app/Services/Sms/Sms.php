<?php


namespace App\Services\Sms;


use App\Services\Sms\Providers\Contracts\Smsable;

/**
 * @method send(string $mobileNumber, string $text)
 * @method sendWithAdvertisingNumber(string $mobile, string $text): string
 * @method sendByPattern(string $mobile, string $patternCode, array $inputParameters):string
 * @method getDeliveryStatus(string $messageId)
 */
class Sms
{
    public function __call($name, $arguments)
    {
        $providerName = __NAMESPACE__ . "\Providers\\" . config('services.sms.provider') . "Provider";
        if (!class_exists($providerName)) {
            throw new \Exception("Class Not Exists");
        }
        $providerInstance = new $providerName();
        if (!is_subclass_of($providerInstance, Smsable::class)) {
            throw new \Exception("Class Not Is A " . Smsable::class);
        }
        return $providerInstance->$name(...$arguments);
    }
}
