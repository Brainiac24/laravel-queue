<?php

namespace App\Services\Common\Helpers;

class TransactionStatusV2
{
    const NOT_VERIFIED = '353914a2-b03b-11e8-904b-b06ebfbfa715';
    const NEW = 'f78ab5e3-867a-11e8-90c7-b06ebfbfa715';

    const BLOCK = '047b2326-4a2c-11e9-9335-b06ebfbfa715';
    const BLOCK_IN_PROCESS = '06dcb201-4a2c-11e9-9335-b06ebfbfa715';
    const BLOCKED = '09bbfe59-4a2c-11e9-9335-b06ebfbfa715';
    const BLOCK_REJECTED = '0d77a89f-4a2c-11e9-9335-b06ebfbfa715';
    const BLOCK_UNKNOWN = 'e6c7abdd-4b04-11e9-9335-b06ebfbfa715';
    
    const PAY_CREATED = '101422b2-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_IN_PROCESS = '02936e72-867b-11e8-90c7-b06ebfbfa715';
    const PAY_ACCEPTED = '11ef885c-867b-11e8-90c7-b06ebfbfa715';
    const PAY_COMPLETED = '178b384d-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_REJECTED = '1a49f5cd-4a2c-11e9-9335-b06ebfbfa715';
    const PAY_UNKNOWN = 'ef86bff4-4b04-11e9-9335-b06ebfbfa715';
    //const FILL_UNKNOWN = 'f82f27fb-4faa-11e9-9335-b06ebfbfa715';

    
    const CONFIRM = '1c969acc-4a2c-11e9-9335-b06ebfbfa715';
    const CONFIRM_IN_PROCESS = '1f389efb-4a2c-11e9-9335-b06ebfbfa715';
    const CONFIRMED = '22860b1d-4a2c-11e9-9335-b06ebfbfa715';
    const CONFIRM_REJECTED = '24cffcb1-4a2c-11e9-9335-b06ebfbfa715';
    const CONFIRM_UNKNOWN = '012a60ca-4b05-11e9-9335-b06ebfbfa715';

    const CANCEL = '34dbc065-4a2c-11e9-9335-b06ebfbfa715';
    const CANCEL_IN_PROCESS = '37f676e4-4a2c-11e9-9335-b06ebfbfa715';
    const CANCELED = '3ae6dbec-4a2c-11e9-9335-b06ebfbfa715';
    const CANCEL_REJECTED = '3de9374f-4a2c-11e9-9335-b06ebfbfa715';
    const CANCEL_UNKNOWN = '0815b7ca-4b05-11e9-9335-b06ebfbfa715';

    const COMPLETED = '1d001ec2-867b-11e8-90c7-b06ebfbfa715';
    const REJECTED  = '28be6b80-867b-11e8-90c7-b06ebfbfa715';
    const UNKNOWN = '2c8cb161-4a2c-11e9-9335-b06ebfbfa715';
    const RETURNED = '6a30ce6d-bb41-11e8-92b3-b06ebfbfa715';

}
