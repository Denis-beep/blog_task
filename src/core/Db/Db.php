<?php

namespace core\Db;

use exceptions\DbException;
use mvc\View\View;
use PDO;

/**
 * Class Db
 * @package core\Db
 */
class Db
{
    /**
     * @var
     */
    private static $instance;

    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Db constructor.
     * @throws DbException
     */
    private function __construct()
    {
        $settings = (require __DIR__ . '/../../core/settings.php')['db'];
        try {
            $this->pdo = new PDO(
                'mysql:host=' . $settings['db_host'] . ';dbname=' . $settings['db_database'],
                $settings['db_user'],
                $settings['db_password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException("Ошибка подключения к базе данных!<br>" . $e->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $className
     * @return array|null
     */
    public function query(string $sql, string $className = '\stdClass', array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === false) {
            return null;
        }

        return $sth->fetchAll(PDO::FETCH_CLASS, $className);
    }

    /**
     * @return static|null
     */
    public static function getInstance(): ?self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}