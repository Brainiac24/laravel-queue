<?php

namespace App\Services\Common\Gateway\AbsTransport;

class TagEntity
{
    private $key;
    private $value;
    private $_attributes;
    private $all = [];

    public function __construct($key, $value = null)
    {
        $this->setKey($key);
        $this->setValue($value);
        $this->setAttributes('_attributes');
    }

    public static function new ($key, $value = null) {
        return new static($key, $value);
    }

    /**
     * Get the value of key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the value of key
     *
     * @return  self
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of _attributes
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }

    /**
     * Set the value of _attributes
     *
     * @return  self
     */
    public function setAttributes($_attributes)
    {
        $this->_attributes = $_attributes;

        return $this;
    }

    public function attr(array $attr = null)
    {
        if ($attr !== null) {
            $child = [];
            foreach ($attr as $item) {
                $child += [$item->getKey() => $item->getValue()];
            }
            $res = [
                $this->_attributes => $child,
            ];
            if ($this->value===null) {
                $this->value = [];
            }
            $this->value = $res;
        }

        return $this;
    }

    public function child(array $attr = null)
    {
        if ($attr !== null) {
            $child = [];
            foreach ($attr as $item) {
                $child += [$item->getKey() => $item->getValue()];
            }
            if ($this->value===null) {
                $this->value = [];
            }
            $this->value += $child;
        }

        return $this;
    }

    public function childIndexedArray(array $attr = null)
    {
        if ($attr !== null) {
            $child = [];
            $k=0;
            foreach ($attr as $item) {
                if (is_array($item)) {
                    foreach ($item as $it) {
                        $child[$k]['_attributes'][$it->getKey()] = $it->getValue();
                    }
                }else{
                    $child[] = [$item->getKey() => $item->getValue()];
                }
                $k++;
            }
            if ($this->value===null) {
                $this->value = [];
            }
            $this->value = $child;
        }

        return $this;
    }

    public function toArray()
    {
        $res = [$this->key => $this->value];
        return $res;
    }
}
