<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 21.09.2018
 * Time: 15:29
 */

namespace App\Services\Common\Helpers\Logger;


use App\Services\Common\Gateway\LogSender\LogSender;
use App\Services\Common\Gateway\LogSender\LogSenderEntity;
use App\Services\Common\Gateway\LogSender\LogSenderLevelEnum;
use Monolog\Handler\StreamHandler;

class Logger implements LoggerContract
{
    protected $logger;
    protected $serviceName;
    protected $folderPath;

    /**
     * Logger constructor.
     * @throws \Exception
     * @param $folder
     * @param $serviceName
     */
    public function __construct($folder, $serviceName = '')
    {
        $this->serviceName = $serviceName;
        $this->folderPath = $folder;
        $this->logger = new \Monolog\Logger($serviceName);
        $this->logger->pushHandler(new StreamHandler(sprintf('%s/logs/%s/info-%s.log', storage_path(), $folder, \Carbon\Carbon::now()->toDateString()), \Monolog\Logger::INFO));
        $this->logger->pushHandler(new StreamHandler(sprintf('%s/logs/%s/error-%s.log', storage_path(), $folder, \Carbon\Carbon::now()->toDateString()), \Monolog\Logger::ERROR));
    }

    /**
     * @param $message
     * @param array $context
     * @param bool $isHttpSend
     * @throws \Exception
     */
    public function info($message, array $context = [], $isHttpSend = true)
    {
        $this->logger->info($message, $context);


        if($isHttpSend)
        {
            $context['JobName'] = $this->serviceName;
            $context['FolderPath'] = $this->folderPath;
            $entity = new LogSenderEntity($message, '', $context, LogSenderLevelEnum::INFORMATION);

            $logSender = new LogSender($entity);
            $logSender->handle();
        }

    }

    /**
     * @param $message
     * @param array $context
     * @param bool $isHttpSend
     * @throws \Exception
     */
    public function error($message, array $context = [], $isHttpSend = true)
    {
        $this->logger->error($message, $context);


        if($isHttpSend)
        {
            $context['JobName'] = $this->serviceName;
            $context['FolderPath'] = $this->folderPath;
            $entity = new LogSenderEntity($message, '', $context, LogSenderLevelEnum::ERROR);

            $logSender = new LogSender($entity);
            $logSender->handle();
        }
        
    }
}