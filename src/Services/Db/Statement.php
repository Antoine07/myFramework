<?php

namespace Services\Db;

final class Statement extends \PDOStatement {

    protected static $pdo=null;
    protected static $className=null;


    public function fetchObjectOfClass($className)
    {
        $table    = $this->prepareFetchObject($className);
        $instance = new $className(self::$pdo, $table[1]);
        $this->setFetchMode(\PDO::FETCH_INTO, $instance);
        return parent::fetch(\PDO::FETCH_INTO);
    }

    public function fetchAllObjectOfClass($className)
    {
        $table = $this->prepareFetchObject($className);
        return parent::fetchAll(\PDO::FETCH_CLASS, $className, array(self::$pdo, $table[1]));
    }

    private function prepareFetchObject($className)
    {

        if (!preg_match("/.*FROM\s(.*)[\s|;]?/i", $this->queryString, $table)) {
            throw new \InvalidArgumentException("Could not find table name in query");
        }

        if (!class_exists($className, true)) {
            throw new \InvalidArgumentException("Class $className does not exist");
        }

        return $table;
    }

    public static function setPDOInstance(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __call($method, $args)
    {
        if (preg_match("/^fetchAll(\w+)$/", $method, $matches)) {
            return $this->fetchAllObjectOfClass($matches[1]);
        } elseif (preg_match("/^fetchOne(\w+)$/", $method, $matches)) {
            return $this->fetchObjectOfClass($matches[1]);
        }
        throw new \BadMethodCallException("Call to undefined method $matches[1]");
    }

} 