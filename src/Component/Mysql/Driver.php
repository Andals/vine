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
	const DEF_CHARSET = 'utf8mb4';

    private $dbConf = array();
    private $logger = null;

    private $dsn = '';
    private $dbh = null;


    /**
        * New driver
        *
        * @param $dbConf, eg:
            $dbConf = array(
                'host'       => '127.0.0.1',
                'user'       => 'root',
                'pass'       => '123',
                'name'       => 'test',
                'port'       => 3306,
                'persistent' => false,
                'charset'    => 'UTF8',
            );
        *
        * @param $logger
        *
        * @return 
     */
    public function __construct($dbConf, \Psr\Log\LoggerInterface $logger = null)
    {/*{{{*/
        $this->initDbConf($dbConf);

        if (is_null($logger)) {
            $logger = new \Psr\Log\NullLogger();
        }
        $this->logger = $logger;

        $this->initDsn();
        $this->initConnect();
    }/*}}}*/

    /**
        * Select rows
        *
        * @param $sql
        * @param $values
        *
        * @return array
     */
    public function query($sql, $values = array())
    {/*{{{*/
		$execResult = $this->doExecute($sql, $values);
		$sth        = $execResult['sth'];
		$ret        = $execResult['ret'];
        if ($ret) {
            return $sth->fetchAll( \PDO::FETCH_ASSOC );
        }

        return array();
    }/*}}}*/

    /**
        * Insert update and so on
        *
        * @param $sql
        * @param $values
        *
        * @return int
     */
    public function execute($sql, $values = array())
    {/*{{{*/
		$execResult = $this->doExecute($sql, $values);
		$sth        = $execResult['sth'];
		$ret        = $execResult['ret'];

        if ($ret) {
			return $sth->rowCount();
        }

		return false;
    }/*}}}*/

    /**
        * Begin transaction
        *
        * @return bool
     */
    public function beginTrans()
    {/*{{{*/
        $this->logSql('begin');

        $this->dbh->beginTransaction();
    }/*}}}*/

    /**
        * Commit transaction
        *
        * @return bool
     */
    public function commit()
    {/*{{{*/
        $this->logSql('commit');

        return $this->dbh->commit();
    }/*}}}*/

    /**
        * Rollback transaction
        *
        * @return bool
     */
    public function rollback()
    {/*{{{*/
        $this->logSql('rollback');

        return $this->dbh->rollback();
    }/*}}}*/


    private function initDBConf($dbConf)
    {/*{{{*/
        $this->dbConf = array(
            'host'       => $dbConf['host'],
            'user'       => $dbConf['user'],
            'pass'       => $dbConf['pass'],
            'name'       => $dbConf['name'],
            'port'       => $dbConf['port'],
            'persistent' => isset($dbConf['persistent']) ? $dbConf['persistent'] : false,
            'charset'    => isset($dbConf['charset']) ? $dbConf['charset'] : self::DEF_CHARSET,
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
            $this->initDbh();
        } catch(\PDOException $e) {
            $logger->warning($e->getMessage());

            if(Error::lostConnection($e)) {
                $this->initDbh();
            } else {
                throw $e;
            }
        }
    }/*}}}*/
    private function initDbh()
    {/*{{{*/
        $this->dbh = new \PDO(
            $this->dsn,
            $this->dbConf['user'],
            $this->dbConf['pass'],
            array(
                \PDO::ATTR_PERSISTENT => $this->dbConf['persistent'],
            )
        );

        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->query('set names '.$this->dbConf['charset']);
    }/*}}}*/

    private function logSql($sql, $values = array())
    {/*{{{*/
    	if(!empty($values))
    	{
            $sql = str_replace('%', '{#}', $sql);
            $sql = vsprintf(str_replace('?', '%s', $sql), $this->fmtValues($values));
            $sql = str_replace('{#}', '%', $sql);
    	}

        $this->logger->info($sql);
    }/*}}}*/
    private function fmtValues($values)
    {/*{{{*/
        $result = array();
        foreach($values as $k => $v)
        {
        	if(is_string($v))
        	{
        		$result[$k] = "'".$v."'";
        		continue;
        	}
        	if(is_null($v))
        	{
        		$result[$k] = 'null';
        	}
        	$result[$k] = $v;
        }
        return $result;
    }/*}}}*/

	private function doExecute($sql, $values)
	{/*{{{*/
        $this->logSql($sql,$values);

		$sth = $this->prepareExecute($sql, $values);
		try {
			$ret = $sth->execute();
		} catch(\PDOException $e) {
            $this->logger->warning($e->getMessage());

            if (!Error::goneAway($e)) {
                throw $e;
            }

            $this->initConnect();
			$sth = $this->prepareExecute($sql, $values);
			$ret = $sth->execute();
		}

		return array(
			'sth' => $sth,
			'ret' => $ret,
		);
	}/*}}}*/
	private function prepareExecute($sql, $values)
	{/*{{{*/
        $i   = 0;
        $sth = $this->dbh->prepare($sql);

        if (!empty($values)) {
	        foreach ($values as $value) {
	            $sth->bindValue(++$i, $value);
	        }
        }
		return $sth;
	}/*}}}*/
}/*}}}*/
