<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 20.02.2019
 * Time: 8:13
 */

 namespace App\Services\Common\Gateway\Rucard\Base;

 use App\Services\Common\Gateway\Rucard\Base\IRequest;

abstract class RucardBase
{
    protected abstract function send(IRequest $model);

    protected function convertArrayToXml(array $data)
    {
        return $this->array2xml($data, 'REQ');
        // return $this->array2xml($data, 'REQ');
    }

    protected function convertXmlToArray($data)
    {
        $content = mb_convert_encoding($data, "utf-8", "windows-1251");;
//        $data= mb_convert_encoding($data, "windows-1251", "utf-8");
        $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA, '', true);

        $json = json_encode($xml);
        $dataArray[$xml->getName()] = json_decode($json, TRUE);

        return $dataArray;

//        return XmlToArray::convert((string)$data);
    }

    protected function response($success, $code, $message, $responseXml)
    {
        return [
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'response' => mb_convert_encoding($responseXml, "utf-8", "windows-1251")
        ];
    }

     protected function array2xml($array, $wrap='REQ', $upper=true) {
        // set initial value for XML string
        $xml = '';
        // wrap XML with $wrap TAG
        if ($wrap != null) {
            $xml .= "<$wrap>\n";
        }
        // main loop
        foreach ($array as $key=>$value) {
            // set tags in uppercase if needed
            if ($upper == true) {
                $key = strtoupper($key);
            }
            // append to XML string
            $xml .= "<$key>" . htmlspecialchars(trim($value)) . "</$key>";
        }
        // close wrap TAG if needed
        if ($wrap != null) {
            $xml .= "\n</$wrap>\n";
        }
        // return prepared XML string
        return $xml;
    }
  
}