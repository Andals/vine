<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/2/6
 * Time: 17:01
 */

namespace Vine\Component\Validator;


class ExceptionFilter extends BaseFilter
{
    protected function initFilterResult()
    {
    }

    protected function saveParamValue($valid, $name, $value)
    {
        if (!$valid) {
            $message = $this->conf->getParamErrorMsg($name);
            $errorno = $this->conf->getParamErrorErrno($name);

            throw new ParamException($message, $errorno);
        }

        $this->filterResult[$name] = $value;
    }

}