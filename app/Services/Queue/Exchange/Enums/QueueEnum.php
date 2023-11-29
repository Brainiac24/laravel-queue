<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 30.08.2018
 * Time: 13:01
 */

namespace App\Services\Queue\Exchange\Enums;


class QueueEnum
{
    const PROCESSING = 'processing';
    const NOTIFICATION = 'notification';
    const DEFAULT = 'sync';
    const SEND_STATUS_TO_CALLBACK = 'send_status_to_callback';
    const REQUEST = 'request';
}