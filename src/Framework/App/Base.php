<?php
/**
* @file Base.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Framework\App;

/**
    * This is app base
 */
abstract class Base
{/*{{{*/
    protected $appName = '';
    protected $loader  = null;

    /**
        * Run app process
        *
        * @param string $moduleName
        *
        * @return 
     */
    abstract public function run($moduleName);


    public function __construct($appName)
    {/*{{{*/
        $this->appName = $appName;
        $this->loader  = \Vine\Framework\Loader::getInstance();
    }/*}}}*/

    /**
        * Run bootstrap
        *
        * @param \Vine\Framework\Bootstrap $bootstrap
        *
        * @return \Vine\Framework\App\Base
     */
    final public function bootStrap(\Vine\Framework\Bootstrap $bootstrap)
    {/*{{{*/
        $bootstrap->boot($this->loader);

        return $this;
    }/*}}}*/
}/*}}}*/
