<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 25.02.2019
 * Time: 8:51
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class HistoryRequest  extends RucardEntity
{
    function __construct(string $pan,int $exp,int $stan,Carbon $date,int $curr,int $cvv2=null) {

        $this->setOpt(RequestType::HISTORY);

        $this->setPan($pan);

        $this->setExp($exp);

        $this->setStan($stan);

        $this->setDate($date);

        $this->setNterm(config('rucard.nterm_payment'));

        $this->setCurr($curr);

        $this->setCvv2($cvv2);
    }
}