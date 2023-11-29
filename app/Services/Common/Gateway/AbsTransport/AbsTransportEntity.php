<?php

namespace App\Services\Common\Gateway\AbsTransport;

class AbsTransportEntity
{
    private $root;
    private $head;
    private $request;
    private $response;
    private $protocol_version;
    private $session_id;
    private $callback_url;
    private $type;
    private $state_code = 1;
    private $state_msg = '';
    private $data;
    private $date_start;
    private $date_end;

    public function __construct()
    {
        $this->root = TagEntity::new('root');
        $this->head = TagEntity::new('head');
        $this->request = TagEntity::new('request');
        $this->response = TagEntity::new('response');
        $this->protocol_version = TagEntity::new('protocol-version',config('abs.protocol_version'));
        $this->session_id = TagEntity::new('session_id');
        $this->callback_url = TagEntity::new('application_key', config('abs.callback_url'));
        $this->type = TagEntity::new('request-type');
        $this->state_code = TagEntity::new('state', 1);
        $this->state_msg = TagEntity::new('state_msg', '');
        $this->data = TagEntity::new('data');
        $this->date_start = TagEntity::new('date_start');
        $this->date_end = TagEntity::new('date_end');
    }

    
    public function getRoot($root=null)
    {
        empty($root)?:$this->root->setValue($root);
        return $this->root;
    }

    public function setRoot($root)
    {
        $this->root = $root;
    }
    
    public function getHead($head=null)
    {
        empty($head)?:$this->head->setValue($head);
        return $this->head;
    }

    public function setHead($head)
    {
        $this->head = $head;
    }

    public function getRequest($request=null)
    {
        empty($request)?:$this->request->setValue($request);
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getResponse($response=null)
    {
        empty($response)?:$this->response->setValue($response);
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getProtocolVersion($protocol_version=null)
    {
        empty($protocol_version)?:$this->protocol_version->setValue($protocol_version);
        return $this->protocol_version;
    }

    public function setProtocolVersion($protocol_version)
    {
        $this->protocol_version = $protocol_version;
    }

    public function getSessionId($session_id=null)
    {
        empty($session_id)?:$this->session_id->setValue($session_id);
        return $this->session_id;
    }

    public function setSessionId($session_id)
    {
        $this->session_id->setValue($session_id);
    }

    public function getType($type=null)
    {
        empty($type)?:$this->type->setValue($type);
        return $this->type;
    }

    public function setType($type)
    {
        $this->type->setValue($type);
    }

    public function getStateCode($state_code=null)
    {
        empty($state_code)?:$this->state_code->setValue($state_code);
        return $this->state_code;
    }

    public function setStateCode($state_code)
    {
        $this->state_code->setValue($state_code);
    }

    public function getStateMsg($state_msg=null)
    {
        empty($state_msg)?:$this->state_msg->setValue($state_msg);
        return $this->state_msg;
    }

    public function setStateMsg($state_msg)
    {
        $this->state_msg->setValue($state_msg);
    }

    public function getData($data=null)
    {
        empty($data)?:$this->data->setValue($data);
        return $this->data;
    }

    public function setData($data)
    {
        $this->data->setValue($data);
    }

    public function getCallbackUrl($callback_url=null)
    {
        empty($callback_url)?:$this->callback_url->setValue($callback_url);
        return $this->callback_url;
    }

    public function setCallbackUrl($callback_url)
    {
        $this->callback_url->setValue($callback_url);
    }

    public function getDateStart($date_start=null)
    {
        empty($date_start)?:$this->date_start->setValue($date_start);
        return $this->date_start;
    }

    public function setDateStart($date_start)
    {
        $this->date_start->setValue($date_start);
    }

    public function getDateEnd($date_end=null)
    {
        empty($date_end)?:$this->date_end->setValue($date_end);
        return $this->date_end;
    }

    public function setDateEnd($date_end)
    {
        $this->date_end->setValue($date_end);
    }
}