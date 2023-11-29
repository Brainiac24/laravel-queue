<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 20.02.2019
 * Time: 8:50
 */
namespace App\Services\Common\Gateway\Rucard\Base;

interface IRequest
{
    public function getAllParamsToArray();
}