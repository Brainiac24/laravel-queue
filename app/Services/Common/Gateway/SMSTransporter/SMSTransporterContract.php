<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 04.07.2018
 * Time: 16:29
 */

namespace App\Services\Common\Gateway\SMSTransporter;


interface SMSTransporterContract
{
    public function send($to, $text, $gateway);
    public function check($messageId);
}