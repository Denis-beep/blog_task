<?php


namespace mvc\Models;


use core\Db\Db;
use interfaces\SqlQueryBuilder;


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
        $options = (require __DIR__ . '/../../core/settings.php')['db'];
        $con = ucfirst(strtolower($options['db_connection']));
        switch ($con)
        {
            case ('Mysql'):
                return $builder = MysqlQueryBuilder::getInstance();
                break;
        }
    }

}