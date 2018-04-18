<?php

namespace Units\System\Traits;


trait DataPropExtender
{

    public function setPropValue($prop, $value)
    {
        $this->{$prop} = $value;
    }

    public function modifyPropValue($prop, $value)
    {
        $this->setPropValue($prop, $value);
    }

    public function unsetPropValue($prop)
    {
        $this->{$prop} = null;
    }
}
