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

    /**
        * Get app loader
        *
        * @return \Vine\Component\Loader\Base
     */
    abstract protected function getLoader();


    public function __construct($appName)
    {/*{{{*/
        $this->appName = $appName;
        $this->loader  = $this->getLoader();
    }/*}}}*/

    /**
        * Run bootstrap
        *
        * @param \Vine\Component\Bootstrap\Base $bootstrap
        *
        * @return \Vine\Framework\App\Base
     */
    final public function bootStrap(\Vine\Component\Bootstrap\Base $bootstrap)
    {/*{{{*/
        $bootstrap->boot($this->loader);

        return $this;
    }/*}}}*/
}/*}}}*/
