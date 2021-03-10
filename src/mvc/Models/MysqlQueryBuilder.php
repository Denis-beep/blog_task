<?php

namespace mvc\Models;

use exceptions\SqlException;
use interfaces\SqlQueryBuilder;

/**
 * Class MysqlQueryBuilder
 * @package mvc\Models
 */
class MysqlQueryBuilder implements SqlQueryBuilder {

    /**
     * @var \stdClass
     */
    protected \stdClass $query;
    /**
     * @var
     */
    private static $instance;

    /**
     * MysqlQueryBuilder constructor.
     */
    private function __construct()
    {

    }

    /**
     *
     */
    protected function reset() :void
    {
        $this->query = new \stdClass();
    }


    /**
     * @param string $table
     * @param array $fields
     * @return SqlQueryBuilder
     */
    public function select(string $table, array $fields) :SqlQueryBuilder
    {
        $this->reset();
        $this->query->base = 'SELECT ' . implode(', ', $fields) . ' FROM `' . $table . '` ';
        $this->query->type = 'select';

        return $this;
    }

    /**
     * @param string $table
     * @param array $columns
     * @param array $params
     * @return SqlQueryBuilder
     */
    public function insert(string $table, array $columns, array $params) :SqlQueryBuilder
    {
        $this->reset();
        $this->query->base = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES (" . implode(', ', $params) . ")";
        $this->query->type="insert";
        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SqlQueryBuilder
     * @throws SqlException
     */
    public function where(string $field, string $value, string $operator = '=') :SqlQueryBuilder
    {
        if(!in_array($this->query->type, ['select', 'update', 'delete'])){
            throw new SqlException('WHERE can only be added to SELECT, UPDATE OR DELETE');
        }

        $this->query->where[] = "$field $operator `$value`";
        return $this;
    }

    /**
     * @param array $fields
     * @param string $orderBy
     * @return SqlQueryBuilder
     * @throws SqlException
     */
    public function order(array $fields, string $orderBy = 'ASC') :SqlQueryBuilder
    {
        if(!$this->query->type = 'select') {
            throw new SqlException('ORDER can only be added to SELECT');
        }

        if(!$orderBy == 'ASC' || !$orderBy == 'DESC'){
            throw new SqlException('ORDER can only be ASC or DESC');
        }

        $this->query->order[] = 'ORDER BY `' . implode("` {$orderBy}, `", $fields) . "` {$orderBy} ";
        return $this;

    }

    /**
     * @param int $start
     * @param int $offset
     * @return SqlQueryBuilder
     * @throws SqlException
     */
    public function limit(int $start, int $offset): SqlQueryBuilder
    {
        if(!$this->query->type = 'select') {
            throw new SqlException('LIMIT can only be added to SELECT');
        }
        $this->query->limit = " LIMIT " . $start . ',' . $offset;
        return $this;
    }

    /**
     * @return string
     */
    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if(isset($query->order))
        {
            $sql .= implode(", ", $query->order);
        }
        if(isset($query->limit))
        {
            $sql .= $query->limit;
        }

        $sql .= ';';
        return $sql;
    }

    /**
     * @return static
     */
    public static function getInstance() :self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;
    }
}