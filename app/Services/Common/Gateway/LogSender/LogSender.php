<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 05.07.2019
 * Time: 9:47
 */

namespace App\Services\Common\Gateway\LogSender;


class LogSender extends LogSenderBase
{
    public function __construct(LogSenderEntity $entity)
    {
        parent::__construct($entity->getAllParams());
    }
}