<?php


namespace mvc\Models;


use core\Db\Db;
use interfaces\SqlQueryBuilder;
use traits\hasGetters;


/**
 * Class Model
 * @package mvc\Models
 */
abstract class Model
{
    /**
     * TODO: Documentation
     */

    /**
     * @var int
     */
    protected int $id;

    /**
     * @var string
     */
    protected static string $tableName;

    /**
     * @var array
     */
    public array $fillable;


    /**
     * @return array|null
     */
    public static function findAll(): ?array
    {
        $builder = self::getBuilder();
        $query = $builder->select(static::$tableName, ['*'])
                ->order( ['id'], 'ASC')
                ->getSQL();

        $db = Db::getInstance();
        return $db->query($query, static::class);
    }


    /**
     * @param int $id
     * @return array|null
     */
    public static function getById(int $id):?array
    {
        $builder = self::getBuilder();
        $query = $builder->select(static::$tableName, ['*'])
            ->where('id', $id, '=')
            ->limit(1, 1)
            ->getSQL();

        $db = Db::getInstance();
        return $db->query($query, static::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return SqlQueryBuilder
     *
     *
     */
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

    /**
     * @param string $source
     * @return string
     */
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * @param string $name
     * @param $value
     */
    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

}