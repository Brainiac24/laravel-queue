<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 16.04.2020
 * Time: 12:58
 */

namespace  App\Services\Common\Gateway\Transfer\Base;

abstract class Base
{
    protected abstract function send(IRequest $model);

}