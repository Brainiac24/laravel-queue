<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 04.07.2018
 * Time: 13:57
 */

namespace App\Services\Common\Gateway\AbsCftEskhata;


interface AbsCftEskhataRateContract
{
    public function rGetRate($session_id, $date, $code_iso, $cur_iso, $type_rate);
    public function aGetRate($session_id );


}