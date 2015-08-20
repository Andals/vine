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
    protected $appName   = '';
    protected $container = null;

    /**
        * Run bootstrap
        *
        * @param mixed $bootstrap
        *
        * @return self
     */
    abstract public function bootstrap($bootstrap);

    /**
        * Run app process
        *
        * @param string $moduleName
        *
        * @return 
     */
    abstract public function run($moduleName);

    /**
        * Get app container
        *
        * @return \Vine\Component\Container\Base
     */
    abstract protected function getContainer();


    public function __construct($appName)
    {/*{{{*/
        $this->appName   = $appName;
        $this->container = $this->getContainer();
    }/*}}}*/
}/*}}}*/
