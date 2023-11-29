<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 24.09.2018
 * Time: 9:07
 */

namespace App\Services\Common\Helpers\Logger;


interface LoggerContract
{
    public function info($message, array $context = []);

    public function error($message, array $context = []);
}