<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 05.09.2018
 * Time: 9:59
 */

namespace App\Services\Common\Gateway\FCMMessage;


use Illuminate\Notifications\Notifiable;

class FCMRouteService
{
    use Notifiable;

    protected $token;

    /**
     * FCMService constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function routeNotificationForFcm()
    {
        return $this->token;
    }

}