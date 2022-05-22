<?php


namespace App\Services\Notification\Providers;


use App\Services\Notification\Providers\Contracts\Provider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SmsProvider implements Provider
{
    private $mobileNumber;
    private $text;

    public function __construct(string $mobileNumber, string $text)
    {
        $this->mobileNumber = $mobileNumber;
        $this->text = $text;
    }

    public function send()
    {
        $client = new Client();
        try {
            $response = $client->post(config("services.sms.uri"), $this->prepareDataForSms());
        } catch (GuzzleException $e) {
            return 'error';
        }

        $httpResponse = json_decode($response->getBody()->getContents(), true);
        $httpStatus = $httpResponse[0];
        $httpResult = $httpResponse[1];
        if ($httpStatus != 0) {
            return 'error';
        }
        return $httpResult;
    }

    public function prepareDataForSms()
    {
        $data = array_merge(
            config("services.sms.auth"),
            [
                'message' => $this->text,
                'to' => json_encode($this->mobileNumber),
                'op' => 'send']
        );
        return [
            "form_params" => $data
        ];
    }
}
