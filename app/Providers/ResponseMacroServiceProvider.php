<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->responseApiSuccess();

        $this->responseApiError();

        $this->responseXml();
    }

    private function responseXml()
    {
        \Response::macro('xml', function($vars, $status = 200, array $header = array(), $rootElement = 'response', $xml = null)
        {

            if (is_object($vars) && $vars instanceof Illuminate\Support\Contracts\ArrayableInterface) {
                $vars = $vars->toArray();
            }

            if (is_null($xml)) {
                $xml = new \SimpleXMLElement('<' . $rootElement . '/>');
            }
            foreach ($vars as $key => $value) {
                if (is_array($value)) {
                    if (is_numeric($key)) {
                        \Response::xml($value, $status, $header, $rootElement, $xml->addChild(str_singular($xml->getName())));
                    } else {
                        \Response::xml($value, $status, $header, $rootElement, $xml->addChild($key));
                    }
                } else {
                    $xml->addChild($key, $value);
                }
            }
            if (empty($header)) {
                $header['Content-Type'] = 'application/xml';
            }
            return \Response::make($xml->asXML(), $status, $header);
        });
    }

    private function responseApiSuccess()
    {
        \Response::macro('apiSuccess', function ($data = null, $status = 200, $headers = [], $options = null) {

            $response = [];
            $response['success'] = true;
            //dd($data);
            //$data['message'] = !array_key_exists($status, HttpCodes::$statusTexts) ?  : HttpCodes::$statusTexts[$status];
//            !(isset($data['code'])) ?: $response['code'] = $data['code'];

            !(isset($data['message'])) ?: $response['message'] = $data['message'];
            !(isset($data['errors'])) ?: $response['errors'] = $data['errors'];
            !(isset($data['data'])) ?: $response['data'] = $data['data'];
            !(isset($data['meta'])) ?: $response['meta'] = $data['meta'];

            /*
            if (isset($data['data']) && isset($data['data']->resource) && $data['data']->resource instanceof LengthAwarePaginator) {
                if ($data['data']->hasPages()) {
                    $response['pagination'] = [
                        'current_page' => $data['data']->currentPage(),
                        'first_page_url' => $data['data']->url(1),
                        'last_page_url' => $data['data']->url($data['data']->lastPage()),
                        'prev_page_url' => $data['data']->previousPageUrl(),
                        'next_page_url' => $data['data']->nextPageUrl(),
                        'last_page' => $data['data']->lastPage(),
                        //'path' =>
                        'per_page' => $data['data']->perPage(),
                        'total' => $data['data']->total(),
                        'first_item' => $data['data']->firstItem(),
                        'last_item' => $data['data']->lastItem(),
                    ];
                }
            }
            */

            return response()->json($response, $status, $headers, $options);
        });
    }

    private function responseApiError()
    {
        \Response::macro('apiError', function ($data = null, $status = 200, $headers = [], $options = null) {

            $response = [];
            $response['success'] = false;
            //dd($data);
            //$data['message'] = !array_key_exists($status, HttpCodes::$statusTexts) ?  : HttpCodes::$statusTexts[$status];
//            !(isset($data['code'])) ?: $response['code'] = $data['code'];
            !(isset($data['message'])) ?: $response['message'] = $data['message'];
            !(isset($data['errors'])) ?: $response['errors'] = $data['errors'];
            !(isset($data['error'])) ?: $response['error'] = $data['error'];
            !(isset($data['data'])) ?: $response['data'] = $data['data'];
            !(isset($data['meta'])) ?: $response['meta'] = $data['meta'];

            return response()->json($response, $status, $headers, $options);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
