<?php
/**
* @file Driver.php
* @author ligang
* @version 1.0
* @date 2015-07-27
 */

namespace Vine\Component\Mysql;

class Driver
{/*{{{*/
    const CONN_LONG  = true;
    const CONN_SHORT = false;

	const DEF_CHARSET = 'UTF8';

    private $dbConf = array();
    private $logger = null;


    public function __construct($dbConf, $logger=null)
    {/*{{{*/
        $this->initDbConf($dbConf);
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

    private function connect()
    {/*{{{*/
        $dsn = 'mysql:host='.$this->dbConf['host'].';dbname='.$this->dbConf['name'];
        if (0 != $this->dbConf['port']) {
            $dsn.= ';port='.$this->dbConf['port'];
        }
        try
        {
            $this->dbh = new \PDO(
                $dsn,
                $this->dbConf['user'],
                $this->dbConf['pass'],
                array(
                    \PDO::ATTR_PERSISTENT => $this->dbConf['ctype']
                )
            );
        }
        catch(\PDOException $e)
        {
            if(\YueYue\Knowledge\Pdo::lostConnection($e))
            {
                $this->dbh = new \PDO($dsn, $this->dbConf['user'], $this->dbConf['pass'],
                    array(\PDO::ATTR_PERSISTENT => $this->dbConf['ctype']));
            }
            else
            {
                throw $e;
            }
        }
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->query('SET NAMES '.$this->dbConf['charset']);
    }/*}}}*/
    private function reconnect()
    {/*{{{*/
        $this->dbh = null;
        $this->connect();
    }/*}}}*/
}/*}}}*/
