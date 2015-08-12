<?php
/**
* @file Base.php
* @author ligang
* @version 1.0
* @date 2015-08-11
 */

namespace Vine\Component\Mysql\Entity;

/**
    * Entity base
 */
abstract class Base
{/*{{{*/

    /**
        * eg:
        *    $columns = array(
        *        'id'(columnName) => array(
        *            'value' => 0,
        *            'func'  => array($this, processSimpleInt),
        *            'ext'   => array(),
        *        ),
        *        'name'(columnName) => array(
        *            'value' => '',
        *            'func'  => array($this, processSimpleString),
        *            'ext'   => array('maxLen' => 20),
        *        ),
        *    );
     */
    protected $columns = array();

    /**
        * Every entity must init self columns
        *
        * @return 
     */
    abstract protected function initColumns();


    public function __construct()
    {/*{{{*/
        $this->initColumns();
    }/*}}}*/

    /**
        * Set columns values
        *
        * @param array $item
        *
        * @throws
        *
        * @return
     */
    public function setColumnsValues($item)
    {/*{{{*/
        foreach ($this->columns as $name => $conf) {
            $this->columns[$name]['value'] = isset($item[$name]) ? call_user_func($conf['func'], $item[$name], $conf['ext']) : $conf['value'];
        }
    }/*}}}*/

    /**
        * Extract columns item
        *
        * @return array
     */
    public function toItem()
    {/*{{{*/
        $item = array();

        foreach ($this->columns as $name => $conf) {
            $item[$name] = $conf['value'];
        }

        return $item;
    }/*}}}*/

    /**
        * Quick extract item for insert
        *
        * @param $item
        *
        * @return 
     */
    public static function extractItem($item)
    {/*{{{*/
        $entity = new static();
        $entity->setColumnsValues($item);

        return $entity->toItem();
    }/*}}}*/


    protected function addColumn($columnName, $value, $func, $ext = null)
    {/*{{{*/
        if (!is_callable($func)) {
            throw new \Exception("func must be callable");
        }

        $this->columns[$columnName] = array(
            'value' => $value,
            'func'  => $func,
            'ext'   => $ext,
        );
    }/*}}}*/

    protected function processSimpleInt($value, $ext = null)
    {/*{{{*/
        if (!is_numeric($value)) {
            throw new \Exception("$value is not int");
        }

        return intval($value);
    }/*}}}*/
    protected function processSimpleString($value, $ext = null)
    {/*{{{*/
        if (!is_string($value)) {
            throw new \Exception("$value is not string");
        }

        if (isset($ext['maxLen'])) {
            if (strlen($value) > $ext['maxLen']) {
                throw new \Exception("$value exceed maxLen");
            }
        }

        return trim($value);
    }/*}}}*/
}/*}}}*/
