<?php


namespace App\Services\Notification;


use App\Services\Notification\Providers\Contracts\Provider;
use Illuminate\Mail\Mailable;

/**
 * @method sendSms(string $mobileNumber, string $text)
 * @method sendEmail(App\User $user, Mailable $mailable)
 */
class Notification
{
    public function __call($method, $arguments)
    {
        $providerName = __NAMESPACE__ . "\Providers\\" . substr($method, 4) . "Provider";
        if (!class_exists($providerName)) {
            throw new \Exception("class not exists");
        }
        $providerInstance = new $providerName(...$arguments);
        if (!is_subclass_of($providerInstance, Provider::class)) {
            throw new \Exception("class not is a App\Services\Notification\Providers\Contracts\Provider");
        }
        return $providerInstance->send();
    }

}
