<?php


namespace mvc\Models;


use core\Db\Db;
use interfaces\SqlQueryBuilder;
use ReflectionObject;
use traits\hasGetters;


/**
 * Class Model
 * @package mvc\Models
 */
abstract class Model
{
    /** Model id.
     * @var int
     */
    protected int $id;

    /**
     * Get model id.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Late static linking.
     * @var string
     */
    protected static string $tableName;

    /**
     * An array for listing the properties available to getters.
     * @var array
     */
    public array $fillable = [];


    /**
     * A magic method to handle access to protected methods.
     *
     * @param string $name
     * @param $value
     */
    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    /**
     * Get all data from table.
     *
     * @return array|null
     */
    public static function findAll(): ?array
    {
        $builder = self::getBuilder();
        $query = $builder->select(static::$tableName, ['*'])
            ->order(['id'], 'ASC')
            ->getSQL();

        $db = Db::getInstance();
        return $db->query($query, static::class);
    }


    /**
     * Get data by id.
     *
     * @param int $id
     * @return array|null
     */
    public static function getById(int $id): ?array
    {
        $builder = self::getBuilder();
        $query = $builder->select(static::$tableName, ['*'])
            ->where('id', $id, '=')
            ->limit(1, 0)
            ->getSQL();

        $db = Db::getInstance();
        return $db->query($query, static::class);
    }

    /**
     * Get data by a specific column.
     *
     * @param string $column
     * @param $value
     * @return static|null
     */
    public static function findBy(string $column, $value): ?self
    {
        $builder = self::getBuilder();
        $db = Db::getInstance();
        $query = $builder->select(static::$tableName, '*')
            ->where($column, $value, '=')
            ->limit('1', '0')
            ->getSQL();
        $result = $db->query($query, static::class);
        if (!$result) return null;
        return $result[0];
    }


    /**
     * Returns builder depending on the database type.
     * @return SqlQueryBuilder
     *
     */
    private static function getBuilder(): SqlQueryBuilder
    {

        $con = ucfirst(strtolower($_ENV['db_service']));
        switch ($con) {
            case ('Mysql'):
                return $builder = MysqlQueryBuilder::getInstance();
                break;
        }
    }


    /**
     * Formatting data from the current object for direct entry into the database.
     * @return array
     */
    public function mapPropertiesToDbFormat() :array
    {
        $reflector = new ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];

        foreach ($properties as $property)
        {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    /**
     * Format underscore style to camelCase.
     * @param string $source
     * @return string
     */
    private function underscoreToCamelCase(string $source): string
    {

        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * Format camelCase style to underscore.
     * @param string $source
     * @return string
     */
    private function camelCaseToUnderscore(string $source) :string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }


}