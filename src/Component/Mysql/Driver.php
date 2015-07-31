<?php
/**
* @file Driver.php
* @author ligang
* @version 1.0
* @date 2015-07-27
 */

namespace Vine\Component\Mysql;

/**
    * This is mysql driver
 */
class Driver
{/*{{{*/
    const CONN_LONG  = true;
    const CONN_SHORT = false;

	const DEF_CHARSET = 'UTF8';


    private $dbConf = array();
    private $logger = null;

    private $dsn = '';
    private $pdo = null;


    public function __construct($dbConf, $logger = null)
    {/*{{{*/
        $this->initDbConf($dbConf);
        $this->logger = $logger;

        $this->initDsn();
        $this->initConnect();
    }/*}}}*/


    private function initDBConf($dbConf)
    {/*{{{*/
        $this->dbConf = array(
            'host'    => $dbConf['host'],
            'user'    => $dbConf['user'],
            'pass'    => $dbConf['pass'],
            'name'    => $dbConf['name'],
            'port'    => $dbConf['port'],
            'ctype'   => isset($dbConf['ctype']) ? $dbConf['ctype'] : self::CONN_SHORT,
            'charset' => isset($dbConf['charset']) ? $dbConf['charset'] : self::DEF_CHARSET,
        );
    }/*}}}*/
    private function initDsn()
    {/*{{{*/
        $this->dsn = 'mysql:host='.$this->dbConf['host'].';dbname='.$this->dbConf['name'];
        if ($this->dbConf['port'] != 0) {
            $this->dsn.= ';port='.$this->dbConf['port'];
        }
    }/*}}}*/
    private function initConnect()
    {/*{{{*/
        try {
            $this->initPdo();
        } catch(\PDOException $e) {
            if(Error::lostConnection($e)) {
                $this->initPdo();
            } else {
                throw $e;
            }
        }

        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->query('SET NAMES '.$this->dbConf['charset']);
    }/*}}}*/
    private function initPdo()
    {/*{{{*/
        $this->pdo = new \PDO(
            $this->dsn,
            $this->dbConf['user'],
            $this->dbConf['pass'],
            array(
                \PDO::ATTR_PERSISTENT => $this->dbConf['ctype'],
            )
        );
    }/*}}}*/
}/*}}}*/
