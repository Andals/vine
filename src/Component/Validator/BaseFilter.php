<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/2/6
 * Time: 17:09
 */

namespace Vine\Component\Validator;

use Vine\Component\Validator\Conf;

abstract class BaseFilter
{
    abstract protected function initFilterResult();
    abstract protected function saveParamValue($valid, $name, $value);

    /**
     * @var Conf
     */
    protected $conf = null;

    protected $filterResult = array();
    protected $originParams = array();

    public function filterParams(Conf $conf, $originParams)
    {
        $this->conf = $conf;
        $this->originParams = $originParams;
        $this->initFilterResult();

        foreach ($this->conf->getParamNames() as $name) {
            $value = $this->parseParamValue($name);
            if (is_null($value) && $this->conf->getParamFilterNull($name)) {
                continue;
            }

            $checkerFunc      = $this->conf->getParamCheckFunc($name);
            $checkerExtParams = $this->conf->getParamCheckExtParams($name);
            array_unshift($checkerExtParams, $value);

            $valid = true;
            if (is_callable($checkerFunc)) {
                $valid = call_user_func_array($checkerFunc, $checkerExtParams);
            }

            $this->saveParamValue($valid, $name, $value);
        }

        return $this->filterResult;
    }

    /**
     * parse the params value
     * @param  string $name param name
     * @return mixed
     */
    protected function parseParamValue($name)
    {
        $default = $this->conf->getParamDefaultValue($name);

        switch ($this->conf->getParamType($name)) {
            case Validator::TYPE_STR:
                return $this->getStrParam($name, $default);
            case Validator::TYPE_NUM:
                return $this->getNumParam($name, $default);
            case Validator::TYPE_ARR:
                return $this->getArrParam($name, $default);
            case Validator::TYPE_FLOAT:
                return $this->getFloatParam($name, $default);
            default:
                return $this->getParam($name, $default);
        }
    }

    /**
     * Gets the request params
     * @param  string $key params key
     * @param  mixed $default default value
     * @return mixed
     */
    protected function getParam($key, $default = null)
    {
        return isset($this->originParams[$key]) ? $this->originParams[$key] : $default;
    }

    /**
     * Gets the string format request params
     * @param  string $key params key
     * @param  mixed $default default value
     * @return mixed
     */
    protected function getStrParam($key, $default = '')
    {
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : trim($value);
    }

    /**
     * Gets the number format request params
     * @param  string $key params key
     * @param  mixed $default default value
     * @return mixed
     */
    protected function getNumParam($key, $default = 0)
    {
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : intval($value);
    }

    /**
     * Gets the array format request params
     * @param  string $key params key
     * @param  mixed $default default value
     * @return mixed
     */
    protected function getArrParam($key, $default = array())
    {
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : $this->fmtArrValue($value);
    }

    protected function getFloatParam($key, $default = array())
    {
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : floatval($value);
    }

    /**
     * format the array params
     * @param  mixed $value
     * @return array
     */
    protected function fmtArrValue($value)
    {
        foreach ($value as $k => $v) {
            if (is_array($v)) {
                $v = $this->fmtArrValue($v);
            } else {
                $v = trim($v);
            }
            $value[$k] = $v;
        }
        return $value;
    }
}