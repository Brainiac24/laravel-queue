<?php
/**
 * Created by PhpStorm.
 * User: Nabijon
 * Date: 23.09.2021
 * Time: 9:55
 */

namespace App\Jobs\AbsTransport\Accounts\Traits;


use App\Services\Common\Helpers\Logger\Logger;
use Illuminate\Support\Facades\Log;

trait AccountJobPropertiesHelperTrait
{
    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 222;
    public $timeout = 60;
    private $intervalNextTryAt = 5;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        Log::info('$data');
        Log::info($data);
        $this->data = $data;
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger = new Logger('gateways/abs', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public function setBaseLogParams()
    {
        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);

        return $log_params;
    }
}
