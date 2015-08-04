<?php
/**
* @file SimpleSqlBuilder.php
* @author ligang
* @version 1.0
* @date 2015-08-07
 */

namespace Vine\Component\Mysql\Dao;

class SimpleSqlBuilder
{/*{{{*/
    private $sql = '';
    private $bindValues = array();

    /**
        * Get builded sql
        *
        * @return string
     */
    public function getSql()
    {/*{{{*/
        return $this->sql;
    }/*}}}*/

    /**
        * Get bind values
        *
        * @return array
     */
    public function getBindValues()
    {/*{{{*/
        return $this->bindValues;
    }/*}}}*/

    /**
        * Insert $tableName (a, b, c ... )
        *
        * @param string $tableName
        * @param string $columnNames
        *
        * @return SimpleSqlBuilder
     */
    public function insert($tableName, $columnNames)
    {/*{{{*/
        $this->bindValues = array();

        $this->sql = 'insert '.$tableName.' (';
        $this->sql.= implode(',', $columnNames). ')';

        return $this;
    }/*}}}*/

    /**
        * Values ('a', 'b', 'c' ...), (...) ...
        *
        * @param array $columnValuesData, eg:
        *   insert one entity: array('a', 'b', 'c')
        *   insert some entities: array(array('a', 'b', 'c') ... )
        *
        * @return SimpleSqlBuilder
     */
    public function values($columnValuesData)
    {/*{{{*/
        $this->sql.= ' values ';

        if (is_array($columnValuesData[0])) {
            foreach ($columnValuesData as $columnValues) {
                $this->sql.= $this->buildValues($columnValues);
            }
            $this->sql = rtrim($this->sql, ',');
        } else {
            $this->sql.= $this->buildValues($columnValuesData);
        }

        return $this;
    }/*}}}*/

    /**
        * Delete $tableName
        *
        * @param string $tableName
        *
        * @return SimpleSqlBuilder
     */
    public function delete($tableName)
    {/*{{{*/
        $this->bindValues = array();

        $this->sql = 'delete from '.$tableName;

        return $this;
    }/*}}}*/

    /**
        * Update $tableName
        *
        * @param string $tableName
        *
        * @return SimpleSqlBuilder
     */
    public function update($tableName)
    {/*{{{*/
        $this->bindValues = array();

        $this->sql = 'update '.$tableName;

        return $this;
    }/*}}}*/

    /**
        * set a = ?, b = ?, c = ? ...
        *
        * @param array $columnNamesValues
        *
        * @return SimpleSqlBuilder
     */
    public function set($columnNamesValues)
    {/*{{{*/
        $this->sql.= ' set ';

        foreach ($columnNamesValues as $name => $value) {
            $this->sql.= $name.' = ?,';
            $this->bindValues[] = $value;
        }
        $this->sql = rtrim($this->sql, ',');

        return $this;
    }/*}}}*/

    /**
        * Select *(what)
        *
        * @param string $what
        * @param string $tableName
        *
        * @return SimpleSqlBuilder
     */
    public function select($what, $tableName)
    {/*{{{*/
        $this->bindValues = array();

        $this->sql = 'select '.$what;
        $this->sql.= ' from '.$tableName;

        return $this;
    }/*}}}*/

    /**
        * Where a = 1, and b = 2, and c = 3 ...
        *
        * @param array $columnComparisons, eg:
        *   $columnComparisons = array('a' => '=', 'b' => 'in' ...);
        *
        * @param array $columnNamesValues, eg:
        *   $columnComparisons = array('a' => 1, 'b' => array(2, 3) ...);
        *
        * @param string $logic
        *
        * @return SimpleSqlBuilder
     */
    public function where($columnComparisons, $columnNamesValues, $logic = 'and')
    {/*{{{*/
        $this->sql.= ' where ';

        $sqls = array();
        foreach ($columnComparisons as $name => $comparison) {
            if (isset($columnNamesValues[$name])) {
                $sqls[]= $this->buildComparison($comparison, $name, $columnNamesValues[$name]);
            }
        }

        $spr = ' '.$logic.' ';
        $this->sql.= implode($spr, $sqls);

        return $this;
    }/*}}}*/

    /**
        * Order by id(columnName) asc(order)
        *
        * @param string $columnName
        * @param string $order
        *
        * @return SimpleSqlBuilder
     */
    public function orderBy($columnName, $order)
    {/*{{{*/
        if ($columnName != '') {
            $this->sql.= ' order by '.$columnName.' '.$order;
        }

        return $this;
    }/*}}}*/

    /**
        * Limit $bgn, $cnt
        *
        * @param int $bgn
        * @param int $cnt
        *
        * @return SimpleSqlBuilder
     */
    public function limit($bgn, $cnt)
    {/*{{{*/
        if ($cnt != 0) {
            $this->sql.= ' limit '.$bgn.', '.$cnt;
        }

        return $this;
    }/*}}}*/


    private function buildValues($columnValues)
    {/*{{{*/
        $sql = '(';

        foreach ($columnValues as $value) {
            $sql.= '?,';
            $this->bindValues[] = $value;
        }

        $sql = rtrim($sql, ',');
        $sql.= ')';

        return $sql;
    }/*}}}*/
    private function buildComparison($comparison, $name, $value)
    {/*{{{*/
        $sql = '';

        switch ($comparison) {
            case '=' :
            case '!=' :
            case '<' :
            case '<=' :
            case '>' :
            case '>=' :
                $sql = $name.' '.$comparison.' ?';
                $this->bindValues[] = $value;
                break;
            case 'between' :
                $sql = $name.' between ? and ?';
                $this->bindValues = array_merge($this->bindValues, $value);
                break;
            case 'like' :
                $sql = $name.' like ?';
                $this->bindValues[] = '%'.$value.'%';
                break;
            case 'in' :
                $sql = $name.' in ';
                $sql.= $this->buildComparisonIn($value);
                break;
            case 'not in' :
                $sql = $name.' not in ';
                $sql.= $this->buildComparisonIn($value);
                break;
        }

        return $sql;
    }/*}}}*/
    private function buildComparisonIn($values)
    {/*{{{*/
        $sql = '(';

        foreach ($values as $value) {
            if (is_numeric($value)) {
                $value = intval($value);
            }

            $sql.= '?,';
            $this->bindValues[] = $value;
        }

        $sql = rtrim($sql, ',');
        $sql.= ')';

        return $sql;
    }/*}}}*/
}/*}}}*/
