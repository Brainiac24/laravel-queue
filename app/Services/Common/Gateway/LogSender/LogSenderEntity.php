<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 05.07.2019
 * Time: 9:47
 */

namespace App\Services\Common\Gateway\LogSender;


use Carbon\Carbon;
use Illuminate\Http\Request;

class LogSenderEntity
{
    private $data = [];

    private $logLevelText = [
        '-1' => 'Error',
        '1' => 'Information'
    ];

    public function __construct($message, $exceptionTrace, $properties = [], $level = LogSenderLevelEnum::ERROR)
    {
        $this->data = [
            'Events' => [
                [
                    'Timestamp' => (string)Carbon::now(),
                    //'MessageTemplate' => mb_convert_encoding($message, "utf-8", "windows-1251"),
                    'MessageTemplate' => $message,
                    'Exception' => $exceptionTrace,
                    'Level' => $this->logLevelText[$level],
                    'Properties' => $properties
                ]
            ]
        ];
    }

    public function getAllParams()
    {
        return $this->data;
    }
}