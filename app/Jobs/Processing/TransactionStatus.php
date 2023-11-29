<?php

namespace App\Jobs\Processing;

class TransactionStatus
{
    /*
    const PAY_CREATED = '101422b2-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_IN_PROCESS = '02936e72-867b-11e8-90c7-b06ebfbfa715';
    const PAY_ACCEPTED = '11ef885c-867b-11e8-90c7-b06ebfbfa715';
    const PAY_COMPLETED = '178b384d-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_REJECTED = '1a49f5cd-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_UNKNOWN = 'ef86bff4-4b04-11e9-9335-b06ebfbfa715';
    */

    const PAY_CREATED = '101422b2-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_IN_PROCESS = '02936e72-867b-11e8-90c7-b06ebfbfa715';
    const PAY_ACCEPTED = '11ef885c-867b-11e8-90c7-b06ebfbfa715';
    const PAY_COMPLETED = '178b384d-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_REJECTED = '1a49f5cd-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_UNKNOWN = 'ef86bff4-4b04-11e9-9335-b06ebfbfa715';


    const NEW = '101422b2-4a2c-11e9-9335-b06ebfbfa715';
    const IN_PROCESSING = '02936e72-867b-11e8-90c7-b06ebfbfa715';
    const ACCEPTED = '11ef885c-867b-11e8-90c7-b06ebfbfa715';
    const COMPLETED = '178b384d-4a2c-11e9-9335-b06ebfbfa715';
    const REJECTED = '1a49f5cd-4a2c-11e9-9335-b06ebfbfa715';
    const SEND_STATUS = 'ef86bff4-4b04-11e9-9335-b06ebfbfa715';

    /*
    const NEW = 'f78ab5e3-867a-11e8-90c7-b06ebfbfa715';
    const IN_PROCESSING = '02936e72-867b-11e8-90c7-b06ebfbfa715';
    const ACCEPTED = '11ef885c-867b-11e8-90c7-b06ebfbfa715';
    const COMPLETED = '1d001ec2-867b-11e8-90c7-b06ebfbfa715';
    const REJECTED = '28be6b80-867b-11e8-90c7-b06ebfbfa715';
    const SEND_STATUS = '27be6b80-867b-11e8-90c7-b06ebfbfa715';
    */

    public static function getText($code)
    {
        $data = [
            self::NEW => 'NEW',
            self::IN_PROCESSING => 'IN_PROCESSING',
            self::ACCEPTED => 'ACCEPTED',
            self::COMPLETED => 'COMPLETED',
            self::REJECTED => 'REJECTED',
            self::SEND_STATUS => 'SEND_STATUS',
        ];

        return $data[$code];
    }

    /*
    const NEW = 'f78ab5e3-867a-11e8-90c7-b06ebfbfa715';
    const ACCEPTED = '11ef885c-867b-11e8-90c7-b06ebfbfa715';
    const NOT_ACCEPTED = '28be6b80-867b-11e8-90c7-b06ebfbfa715';
    const IN_PROCESS = '02936e72-867b-11e8-90c7-b06ebfbfa715';
    const COMPLETED = '1d001ec2-867b-11e8-90c7-b06ebfbfa715';
    const NOT_COMPLETED = '34c61d1e-867b-11e8-90c7-b06ebfbfa715';
    const CANCELED = '392cebfa-867b-11e8-90c7-b06ebfbfa715';
    const UNKNOWN = '2e5f0c39-867b-11e8-90c7-b06ebfbfa715';
    */
}