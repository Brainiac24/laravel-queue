<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 09.07.2018
 * Time: 9:46
 */

namespace App\Services\Common\Gateway\Processing;


interface ProcessingTransportContract
{
    public function pay($txn_id,$sum,$prv_id,$number);
    public function check($txn_id, $sum, $prv_id, $number);
    public function status($txn_id,$sum,$prv_id,$number);

}