<?php
/**
* @file Base.php
* @author ligang
* @version 1.0
* @date 2015-08-06
 */

namespace Vine\Component\Mysql\Dao;

/**
    * Dao base
 */
abstract class Base
{/*{{{*/
    protected $driver    = null;
    protected $tableName = '';

    protected $simpleSqlBuilder = null;

    /**
        * Set tableName
        *
        * @param mixed $hash
        *
        * @return Base
     */
    abstract public function setTableName($hash = null);

    public function __construct()
    {/*{{{*/
        $this->simpleSqlBuilder = new SimpleSqlBuilder();
    }/*}}}*/

    /**
        * Set mysql driver
        *
        * @param \Vine\Component\Mysql\Driver $driver
        *
        * @return Base
     */
    public function setDriver(\Vine\Component\Mysql\Driver $driver)
    {/*{{{*/
        $this->driver = $driver;

        return $this;
    }/*}}}*/

    /**
        * Insert one item
        *
        * @param array $item, eg:
        *     $item = array(
        *         'id'(columnName)   => 1001(columnValue),
        *         'name'(columnName) => 'vine'(columnValue),
        *     );
        *
        * @return int
     */
    public function insert($item)
    {/*{{{*/
        $this->simpleSqlBuilder
             ->insert($this->tableName, array_keys($item))
             ->values(array_values($item));

        return $this->simpleExecute();
    }/*}}}*/

    /**
        * Delete one item
        *
        * @param int $id
        *
        * @return int
     */
    public function deleteById($id)
    {/*{{{*/
        $this->simpleSqlBuilder
             ->delete($this->tableName)
             ->where(array('id' => '='), array('id' => $id));

        return $this->simpleExecute();
    }/*}}}*/

    /**
        * Update one item
        *
        * @param int $id
        * @param array $columnNamesValues
        *
        * @return int
     */
    public function updateById($id, $columnNamesValues)
    {/*{{{*/
        $this->simpleSqlBuilder
             ->update($this->tableName)
             ->set($columnNamesValues)
             ->where(array('id' => '='), array('id' => $id));

        return $this->simpleExecute();
    }/*}}}*/

    /**
        * Select one item
        *
        * @param int $id
        * @param array $columnNames
        *
        * @return array
     */
    public function selectById($id, $columnNames = array())
    {/*{{{*/
        $this->simpleSqlBuilder
             ->select($this->getSimpleWhat($columnNames), $this->tableName)
             ->where(array('id' => '='), array('id' => $id));

        $data = $this->simpleQuery();

        return empty($data) ? null : $data[0];
    }/*}}}*/

    /**
        * Select some items
        *
        * @param array $ids
        * @param array $columnNames
        *
        * @return array
     */
    public function selectByIds($ids, $columnNames = array())
    {/*{{{*/
        $this->simpleSqlBuilder
             ->select($this->getSimpleWhat($columnNames), $this->tableName)
             ->where(array('id' => 'in'), array('id' => $ids));

        return $this->simpleQuery();
    }/*}}}*/

    /**
        * Begin transaction
        *
        * @return bool
     */
    public function beginTrans()
    {/*{{{*/
        try {
            $this->rollback();
        } catch (\Exception $e) {
        }

        return $this->driver->beginTrans();
    }/*}}}*/

    /**
        * Commit transaction
        *
        * @return bool
     */
    public function commit()
    {/*{{{*/
        return $this->driver->commit();
    }/*}}}*/

    /**
        * Rollback transaction
        *
        * @return bool
     */
    public function rollback()
    {/*{{{*/
        return $this->driver->rollback();
    }/*}}}*/

    /**
        * Select last_insert_id
        *
        * @return int
     */
    public function lastInsertID()
    {/*{{{*/
        return $this->driver->lastInsertId();
    }/*}}}*/


    protected function getSimpleWhat($columnNames)
    {/*{{{*/
        return empty($columnNames) ? '*' : implode(',', $columnNames);
    }/*}}}*/

    protected function simpleExecute()
    {/*{{{*/
        return $this->driver->execute($this->simpleSqlBuilder->getSql(), $this->simpleSqlBuilder->getBindValues());
    }/*}}}*/
    protected function simpleQuery()
    {/*{{{*/
        return $this->driver->query($this->simpleSqlBuilder->getSql(), $this->simpleSqlBuilder->getBindValues());
    }/*}}}*/
}/*}}}*/
