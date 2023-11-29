<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 05.09.2018
 * Time: 15:12
 */

namespace App\Services\Common\Gateway\SMSTransporter;


use Illuminate\Notifications\Notifiable;

class SMSTransporterRouteService
{
    use Notifiable;

    protected $to;
    protected $gateway;

    /**
     * SMSTransporterRouteService constructor.
     * @param $to
     */
    public function __construct($to, $gateway)
    {
        $this->to = $to;
        $this->gateway = $gateway;
    }

    public function routeNotificationForSmsTj()
    {
        return $this->to;
    }

    public function gatewayNotificationForSmsTj()
    {
        return $this->gateway;
    }
}