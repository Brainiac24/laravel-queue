<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 05.09.2018
 * Time: 16:06
 */

namespace App\Services\Common\Gateway\MailTransport;


use Illuminate\Notifications\Notifiable;

class MailTransportRouteService
{
    use Notifiable;

    public $email;

    /**
     * MailTransportRouteService constructor.
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }


    public function routeNotificationForMail()
    {
        return $this->email;
    }
}