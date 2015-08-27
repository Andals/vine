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
        *        'id'(columnName)   => 1(value),
        *        'name'(columnName) => 'vine'(value),
        *    );
     */
    protected $columns   = array();
    protected $validator = null;

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

    public function setValidator(\Vine\Component\Validator\Validator $validator)
    {/*{{{*/
        $this->validator = $validator;
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
        if (!is_null($this->validator) && method_exists($this, 'setColumnsValidatorConf')) {
            $this->setColumnsValidatorConf($this->validator->getConf());
            $this->columns = $this->validator->filterParams($item);
        } else {
            foreach ($this->columns as $name => $value) {
                if (isset($item[$name])) {
                    $this->columns[$name] = $item[$name];
                }
            }
        }
    }/*}}}*/

    /**
        * Extract columns item
        *
        * @return array
     */
    public function toItem()
    {/*{{{*/
        return $this->columns;
    }/*}}}*/

    /**
        * Quick extract item for insert
        *
        * @param array $item
        *
        * @return array
     */
    public static function extractItem($item, \Vine\Component\Validator\Validator $validator = null)
    {/*{{{*/
        $entity = new static();
        $entity->setValidator($validator);
        $entity->setColumnsValues($item);

        return $entity->toItem();
    }/*}}}*/
}/*}}}*/
