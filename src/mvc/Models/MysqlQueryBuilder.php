<?php

namespace mvc\Models;

use exceptions\SqlException;
use interfaces\SqlQueryBuilder;

class MysqlQueryBuilder implements SqlQueryBuilder {

    protected \stdClass $query;
    private static $instance;

    private function __construct()
    {

    }

    protected function reset() :void
    {
        $this->query = new \stdClass();
    }


    public function select(string $table, array $fields) :SqlQueryBuilder
    {
        $this->reset();
        $this->query->base = 'SELECT ' . implode(', ', $fields) . ' FROM `' . $table . '` ';
        $this->query->type = 'select';

        return $this;
    }

    public function where(string $field, string $value, string $operator = '=') :SqlQueryBuilder
    {
        if(!in_array($this->query->type, ['select', 'update', 'delete'])){
            throw new SqlException('WHERE can only be added to SELECT, UPDATE OR DELETE');
        }

        $this->query->where[] = "$field $operator `$value`";
        return $this;
    }

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

    public function limit(int $start, int $offset): SqlQueryBuilder
    {
        if(!$this->query->type = 'select') {
            throw new SqlException('LIMIT can only be added to SELECT');
        }
        $this->query->limit = " LIMIT " . $start . ',' . $offset;
        return $this;
    }

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

    public static function getInstance() :self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;
    }
}