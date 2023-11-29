<?php

namespace App\Services\Common\Gateway\Rucard\Base;

use Carbon\Carbon;
use App\Services\Common\Gateway\Rucard\Base\IRequest;

class RucardEntity implements IRequest
{
    private $opt;
    private $stan;
    private $date;
    private $nterm;
    private $check;
    private $pan;
    private $exp;
    private $cvv2;
    private $c_pan;
    private $amount;
    private $fee;
    private $curr;
    private $block;
    private $errc;
    private $errt;
    private $auth;
    private $rref;
    private $c_max;
    private $c_fee;
    private $c_rref;
    private $c_auth;
    private $c_amt;
    private $c_text;
    private $msdata;
    private $msrdr;
    private $mstat;
    private $clntname;
    private $cardtype;
    private $cardprog;
    private $orig_stan;
    private $orig_date;
    private $orig_nterm;
    private $comment;
    private $c_comment;
    private $async;
    private $p039;


    public function getAllParamsToArray()
    {
        $exceptMethod = __FUNCTION__;
        // динамический получая название методов генериреум название параметров в виде массива
        $getters = array_filter(get_class_methods($this), function ($method) use ($exceptMethod) {
            return 'get' === substr($method, 0, 3) && $method !== $exceptMethod;
        });

        foreach ($getters as $item) {

            if ($this->{$item}() !== null || !empty($this->{$item}())) {
                $key = substr($item, 3, strlen($item) - 3);
                $this->data[strtoupper($key)] = $this->{$item}();
            }
        }

        return $this->data;
    }

    /**
     * Get the value of opt
     */
    public function getOpt()
    {
        return $this->opt;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setOpt($opt)
    {
        $this->opt = $opt;
    }

    /**
     * Get the value of stan
     */
    public function getStan(): ?int
    {
        return $this->stan;
    }

    /**
     * Set the value of stan
     *
     * @return  self
     */
    public function setStan(int $stan)
    {
        $this->stan = $stan;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate(Carbon $date)
    {
        $this->date = $date->format('ymdHis');
    }

    /**
     * Get the value of nterm
     */
    public function getNterm(): ?string
    {
        return $this->nterm;
    }

    /**
     * Set the value of nterm
     *
     * @return  self
     */
    public function setNterm(string $nterm)
    {
        $this->nterm = $nterm;
    }

    /**
     * Get the value of check
     */
    public function getCheck(): ?int
    {
        return $this->check;
    }

    /**
     * Set the value of check
     *
     * @return  self
     */
    public function setCheck(?int $check)
    {
        $this->check = $check;
    }

    /**
     * Get the value of pan
     */
    public function getPan(): ?string
    {
        return $this->pan;
    }

    /**
     * Set the value of pan
     *
     * @return  self
     */
    public function setPan(string $pan)
    {
        $this->pan = str_replace(' ', '', $pan);
    }

    /**
     * Get the value of exp
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * Set the value of exp
     *
     * @return  self
     */
    public function setExp(int $exp)
    {
        $this->exp = $exp;

    }

    /**
     * Get the value of cvv2
     */
    public function getCvv2(): ?int
    {
        return $this->cvv2;
    }

    /**
     * Set the value of cvv2
     *
     * @return  self
     */
    public function setCvv2(?int $cvv2)
    {
        $this->cvv2 = $cvv2;
    }

    /**
     * Get the value of c_pan
     */
    public function getC_pan(): ?string
    {
        return $this->c_pan;
    }

    /**
     * Set the value of c_pan
     *
     * @return  self
     */
    public function setC_pan(string $c_pan)
    {
        $this->c_pan = $c_pan;
    }

    /**
     * Get the value of amount
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */
    public function setAmount(float $amount)
    {
         $this->amount = $amount * 100.0;
    }

    /**
     * Get the value of fee
     */
    public function getFee(): ?float
    {
        return $this->fee;
    }

    /**
     * Set the value of fee
     *
     * @return  self
     */
    public function setFee(?float $fee)
    {
        $this->fee = $fee;
    }

    /**
     * Get the value of curr
     */
    public function getCurr(): ?int
    {
        return $this->curr;
    }

    /**
     * Set the value of curr
     *
     * @return  self
     */
    public function setCurr(int $curr)
    {
        $this->curr = $curr;
    }

    /**
     * @return mixed
     */
    public function getBlock(): ?int
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock(int $block)
    {
        $this->block = $block;
    }

    /**
     * Get the value of errc
     */
    public function getErrc()
    {
        return $this->errc;
    }

    /**
     * Set the value of errc
     *
     * @return  self
     */
    public function setErrc($errc)
    {
        $this->errc = $errc;
    }

    /**
     * Get the value of errt
     */
    public function getErrt()
    {
        return $this->errt;
    }

    /**
     * Set the value of errt
     *
     * @return  self
     */
    public function setErrt($errt)
    {
        $this->errt = $errt;
    }

    /**
     * Get the value of auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Set the value of auth
     *
     * @return  self
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get the value of rref
     */
    public function getRref()
    {
        return $this->rref;
    }

    /**
     * Set the value of rref
     *
     * @return  self
     */
    public function setRref($rref)
    {
        $this->rref = $rref;
    }

    /**
     * Get the value of c_max
     */
    public function getC_max()
    {
        return $this->c_max;
    }

    /**
     * Set the value of c_max
     *
     * @return  self
     */
    public function setC_max($c_max)
    {
        $this->c_max = $c_max;
    }

    /**
     * Get the value of c_fee
     */
    public function getC_fee()
    {
        return $this->c_fee;
    }

    /**
     * Set the value of c_fee
     *
     * @return  self
     */
    public function setC_fee($c_fee)
    {
        $this->c_fee = $c_fee;
    }

    /**
     * Get the value of c_rref
     */
    public function getC_rref()
    {
        return $this->c_rref;
    }

    /**
     * Set the value of c_rref
     *
     * @return  self
     */
    public function setC_rref($c_rref)
    {
        $this->c_rref = $c_rref;
    }

    /**
     * Get the value of c_auth
     */
    public function getC_auth()
    {
        return $this->c_auth;
    }

    /**
     * Set the value of c_auth
     *
     * @return  self
     */
    public function setC_auth($c_auth)
    {
        $this->c_auth = $c_auth;
    }

    /**
     * Get the value of c_amt
     */
    public function getC_amt()
    {
        return $this->c_amt;
    }

    /**
     * Set the value of c_amt
     *
     * @return  self
     */
    public function setC_amt($c_amt)
    {
        $this->c_amt = $c_amt;
    }

    /**
     * Get the value of c_text
     */
    public function getC_text()
    {
        return $this->c_text;
    }

    /**
     * Set the value of c_text
     *
     * @return  self
     */
    public function setC_text($c_text)
    {
        $this->c_text = $c_text;
    }

    /**
     * Get the value of msdata
     */
    public function getMsdata()
    {
        return $this->msdata;
    }

    /**
     * Set the value of msdata
     *
     * @return  self
     */
    public function setMsdata($msdata)
    {
        $this->msdata = $msdata;
    }

    /**
     * Get the value of msrdr
     */
    public function getMsrdr()
    {
        return $this->msrdr;
    }

    /**
     * Set the value of msrdr
     *
     * @return  self
     */
    public function setMsrdr($msrdr)
    {
        $this->msrdr = $msrdr;
    }

    /**
     * Get the value of mstat
     */
    public function getMstat()
    {
        return $this->mstat;
    }

    /**
     * Set the value of mstat
     *
     * @return  self
     */
    public function setMstat($mstat)
    {
        $this->mstat = $mstat;
    }

    /**
     * Get the value of clntname
     */
    public function getClntname()
    {
        return $this->clntname;
    }

    /**
     * Set the value of clntname
     *
     * @return  self
     */
    public function setClntname($clntname)
    {
        $this->clntname = $clntname;
    }

    /**
     * Get the value of cardtype
     */
    public function getCardtype()
    {
        return $this->cardtype;
    }

    /**
     * Set the value of cardtype
     *
     * @return  self
     */
    public function setCardtype($cardtype)
    {
        $this->cardtype = $cardtype;
    }

    /**
     * Get the value of cardprog
     */
    public function getCardprog()
    {
        return $this->cardprog;
    }

    /**
     * Set the value of cardprog
     *
     * @return  self
     */
    public function setCardprog($cardprog)
    {
        $this->cardprog = $cardprog;
    }

    /**
     * Get the value of orig_stan
     */
    public function getOrig_stan(): ?int
    {
        return $this->orig_stan;
    }

    /**
     * Set the value of orig_stan
     *
     * @return  self
     */
    public function setOrig_stan(?int $orig_stan)
    {
        $this->orig_stan = $orig_stan;
    }

    /**
     * Get the value of orig_date
     */
    public function getOrig_date()
    {
        return $this->orig_date;
    }

    /**
     * Set the value of orig_date
     *
     * @return  self
     */
    public function setOrig_date(?Carbon $orig_date)
    {
        $this->orig_date = isset($orig_date) ? $orig_date->format('ymdHis') : null;
    }

    /**
     * Get the value of orig_nterm
     */
    public function getOrig_nterm(): ?string
    {
        return $this->orig_nterm;
    }

    /**
     * Set the value of orig_nterm
     *
     * @return  self
     */
    public function setOrig_nterm(?string $orig_nterm)
    {
        $this->orig_nterm = $orig_nterm;
    }

    /**
     * Get the value of comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */
    public function setComment(?string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the value of c_comment
     */
    public function getC_comment() : ?string
    {
        return $this->c_comment;
    }

    /**
     * Set the value of c_comment
     *
     * @return  self
     */
    public function setC_comment(?string $c_comment)
    {
        $this->c_comment = $c_comment;
    }

    /**
     * Get the value of async
     */
    public function getAsync()
    {
        return $this->async;
    }

    /**
     * Set the value of async
     *
     * @return  self
     */
    public function setAsync($async)
    {
        $this->async = $async;
    }

    /**
     * Get the value of p039
     */
    public function getP039()
    {
        return $this->p039;
    }

    /**
     * Set the value of p039
     *
     * @return  self
     */
    public function setP039($p039)
    {
        $this->p039 = $p039;
    }
} 