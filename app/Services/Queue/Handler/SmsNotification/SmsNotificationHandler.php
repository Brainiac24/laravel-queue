<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 07.09.2018
 * Time: 9:20
 */

namespace App\Services\Queue\Handler\SmsNotification;


use App\Notifications\SmsNotification;
use App\Services\Common\Gateway\SMSTransporter\SMSTransporterRouteService;
use App\Services\Queue\Handler\BaseHandler;
use Illuminate\Foundation\Bus\Dispatchable;

class SmsNotificationHandler extends BaseHandler
{
    use Dispatchable;

    public static function rules()
    {
        return [
            'to' => 'required|numeric',
            'message' => 'required'
        ];
    }

    public function handle()
    {
        (new SMSTransporterRouteService($this->data['to']))->notify(new SmsNotification($this->data['message']));

    }

    public function tags()
    {
        return [$this->data['to']];
    }


}