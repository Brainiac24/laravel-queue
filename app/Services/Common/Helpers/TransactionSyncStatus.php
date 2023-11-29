<?php

namespace App\Services\Common\Helpers;

class TransactionSyncStatus
{
    const NOT_NEED_SYNC = '82c98a81-5c3f-11e9-a7b0-b06ebfbfa715';
    const NEED_TO_SYNC = 'dcb4fb51-5c45-11e9-a7b0-b06ebfbfa715';
    const IN_PROCESS_QUEUE = '03cc4ebe-5c40-11e9-a7b0-b06ebfbfa715';
    const ERROR_QUEUE = '44107c44-5c40-11e9-a7b0-b06ebfbfa715';
    const IN_PROCESS_BUS = '0c9ab26d-5c40-11e9-a7b0-b06ebfbfa715';
    const ERROR_BUS = '4f652d25-5c40-11e9-a7b0-b06ebfbfa715';
    const COMPLETED_BUS = '56414fbe-5c40-11e9-a7b0-b06ebfbfa715';
}