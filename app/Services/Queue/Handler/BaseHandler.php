<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 07.09.2018
 * Time: 9:20
 */

namespace App\Services\Queue\Handler;


abstract class BaseHandler
{
    protected $data;

    /**
     * BaseHandler constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public static function rules();
    abstract public function handle();
    abstract public function tags();
}