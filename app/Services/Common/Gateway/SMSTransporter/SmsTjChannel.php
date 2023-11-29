<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 16.07.2018
 * Time: 16:45
 */

namespace App\Services\Common\Gateway\SMSTransporter;


use App\Exceptions\Frontend\Api\LogicException;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class SmsTjChannel
{
    protected $sms;

    /**
     * SmsTjChannel constructor.
     *
     * @param
     */
    public function __construct(SMSTransporterContract $sms)
    {
        $this->sms = $sms;
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @throws \Exception
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->{'toSmsTj'}($notifiable);

        if (!method_exists($notifiable, 'routeNotificationForSmsTj'))
            throw new \Exception('routeNotificationForSmsTj not found');

        $to = $notifiable->routeNotificationForSmsTj();

        if (!method_exists($notifiable, 'gatewayNotificationForSmsTj'))
            throw new \Exception('gatewayNotificationForSmsTj not found');

        $gateway = $notifiable->gatewayNotificationForSmsTj();

        if (empty($to))
            throw new \Exception('SmsTjChannel route not found');

        //$this->sms->send($to, $message);

        if (!App::environment('local')) {
            $this->sms->send($to, $message, $gateway);
        }else{
            $this->sms->send($to, $message, $gateway);
        }
    }
}