<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/2/6
 * Time: 18:06
 */

namespace Vine\Component\Validator;


class FullScanFilter extends BaseFilter
{
    protected function initFilterResult()
    {
        $this->filterResult = array(
            'valid'  => true,
            'params' => array(),
            'errors' => array(),
        );
    }

    protected function saveParamValue($valid, $name, $value)
    {
        $this->filterResult['params'][$name] = $value;

        if (!$valid) {
            $this->filterResult['valid'] = false;
            $this->filterResult['errors'][$name] = 1;
        }
    }
}