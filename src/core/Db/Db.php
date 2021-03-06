<?php

namespace core\Db;

use exceptions\DbException;
use mvc\View\View;
use PDO;

class Db
{
    private static $instance;

    private PDO $pdo;

    private function __construct()
    {
        $options = (require __DIR__ . '/../settings.php')['db'];
        try {
            $this->pdo = new PDO(
                'mysql:host=' . $options['host'] . ';dbname=' . $options['dbname'],
                $options['user'],
                $options['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException("Ошибка подключения к базе данных!<br>" . $e->getMessage());
        }
    }

    public function query(string $sql, array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === false) {
            return null;
        }

        return $sth->fetchAll();
    }

    public static function getInstance(): ?self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}