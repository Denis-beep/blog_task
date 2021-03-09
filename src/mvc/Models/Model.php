<?php


namespace mvc\Models;


use core\Db\Db;
use interfaces\SqlQueryBuilder;


/**
 * Class Model
 * @package mvc\Models
 */
abstract class Model
{
    protected static string $tableName;

    public static function findAll(): ?array
    {
        $builder = self::getBuilder();
        $query = $builder->select(static::$tableName, ['*'])
                ->limit(1, 1)
                ->order( ['name'], 'ASC')
                ->getSQL();

        $db = Db::getInstance();
        return $db->query($query);
    }
    public static function getById(int $id):?array
    {
        $builder = self::getBuilder();
        $query = $builder->select(static::$tableName, ['*'])
            ->where('id', $id, '=')
            ->limit(1, 1)
            ->getSQL();

        $db = Db::getInstance();
        return $db->query($query);
    }

    private static function getBuilder(): SqlQueryBuilder
    {
        $con = ucfirst(strtolower($_ENV['db_service']));
        switch ($con)
        {
            case ('Mysql'):
                return $builder = MysqlQueryBuilder::getInstance();
                break;
        }
    }

}