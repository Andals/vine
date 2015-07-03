<?php
/**
* @file Base.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\App;

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
        $this->loader  = \Vine\Loader::getInstance();
    }/*}}}*/

    /**
        * Run bootstrap
        *
        * @param \Vine\Bootstrap $bootstrap
        *
        * @return \Vine\App\Base
     */
    final public function bootStrap(\Vine\Bootstrap $bootstrap)
    {/*{{{*/
        $bootstrap->boot($this->loader);

        return $this;
    }/*}}}*/
}/*}}}*/
