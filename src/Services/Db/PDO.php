<?php

namespace Services\Db;

class PDO extends \PDO
{

    final public function __construct($dsn, $username = '', $password = '', $driverOptions = [])
    {

        $driverOptions = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_STATEMENT_CLASS => [__NAMESPACE__.'\Statement']
        );
        parent::__construct($dsn, $username, $password, $driverOptions);
        Statement::setPDOInstance($this);
    }

    public function setObject($className)
    {
        $instance = new $className($this);
        return $instance;
    }

} 