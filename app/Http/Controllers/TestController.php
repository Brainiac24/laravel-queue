<?php

namespace App\Http\Controllers;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Gateway\Rucard\Requests\FillCardRequest;
use App\Services\Common\Gateway\Rucard\Rucard;
use App\Services\Common\Helpers\Array2XML;

use App\Services\Common\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\json_decode;
use App\Jobs\RucardTransport\FillCardJob;

class TestController extends Controller
{
    public $absTransport;
    public $rucardTransport;
    public function __construct(AbsTransportService $absTransport)
    {
        $this->absTransport = $absTransport;
    }

    public function php_info()
    {
        echo phpinfo(INFO_MODULES);
    }

    /*public function searchCard(IlluminateRequest $request)
    {

        // dd($request);

        $res = $this->absTransport->getCardService()->searchRequest($request['pan'], $request['exp_date']);

        dd($res);

    }
    public function cardList(IlluminateRequest $request)
    {

        // dd($request);

        $res = $this->absTransport->getCardService()->listRequest($request->all()['user_id']);

        dd($res);

    }

    public function rucardFill(IlluminateRequest $request)
    {
        $data = new FillCardRequest('6463100000001323', 20, '0001', Carbon::now(), 0, 971, "sa");
        $result = $this->rucardTransport->fillCard($data);

        //print_r($result);
    }
*/
    public function Callback(Request $req)
    {

        Log::info($req->getContent());
        //$arr = Helper::xmlToArray((string)$req->getContent());
        //dd($arr);

        $toArr = new Array2XML();
        $res = $toArr::XML_TO_ARR((string) $req->getContent());
        //dd($res);
        /*$xml = json_decode(json_encode((array) simplexml_load_string($req->getContent())), 1);
        $finalItem = $this->getChild($xml);
        dd($finalItem);
         */
        return response()->xml([
            'head' => [
                'session_id' => $res['head']['session_id'],
            ],
            'response' => [
                'protocol-version' => '1.4',
                'request-type' => 'EO_R_CARDS_LIST',
                'state' => 1,
                'state_msg' => 'OK',
            ],
        ], 200, [], 'root');
    }


    public function callbackRucard(Request $req)
    {

        Log::info(json_encode($req->all()));
        //$arr = Helper::xmlToArray((string)$req->getContent());
        //dd($arr);

        return json_encode([
            'success' => json_encode($req->all())
        ]);
    }

    public function getChild($xml, $finalItem = [])
    {
        foreach ($xml as $key => $value) {
            if (!is_array($value)) {
                $finalItem[$key] = $value;
            } else {
                $finalItem = $this->getChild($value, $finalItem);
            }
        }
        return $finalItem;
    }

    public function fillCardRucard(Request $req)
    {
        $res = new FillCardJob($req->all()['payload']);

        $text = json_encode($res->handle(new Rucard()));

        //Log::info($text);
        //$arr = Helper::xmlToArray((string)$req->getContent());
        //dd($arr);

        return $text;
    }

    public function testRucard(Request $req)
    {
        $res = new FillCardJob($req->all()['payload']);

        $text = json_encode($res->handle(new Rucard()));

        //Log::info($text);
        //$arr = Helper::xmlToArray((string)$req->getContent());
        //dd($arr);

        return $text;
    }

}
