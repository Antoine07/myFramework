<?php

namespace Services\Db;

abstract class Object
{
    /**
     * @var PDO
     */
    protected $pdo = null;

    /**
     * @var string table name
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $pk = 'id';

    /**
     * @var array
     */
    private $props = [];

    /**
     *
     * @param \PDO $pdo
     * @param string $tableName
     */
    final public function __construct(\PDO $pdo, $tableName = null)
    {
        $this->pdo = $pdo;

        if (is_null($tableName)) {
            $className = get_called_class();
            $pos = strrpos($className, '\\');

            $add = 1; // position symbol regex
            if (!$pos) $add = 0;

            $className = substr($className, $pos + $add);
            $className = (substr($className, strlen($className) - 1) == 'y') ? substr($className, 0, strlen($className) - 1) . 'ies' : $className . 's';
            $this->tableName = strtolower($className);
        } else {
            $this->tableName = $tableName;
        }
        $this->init();
    }

    /**
     *
     * @return void
     */
    protected function init()
    {

    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Retrieves all public attributes
     *
     * @return array
     */
    final public function fetchPublicMembers()
    {
        if ($this->props) {
            return $this->props;
        }
        $reflect = new \ReflectionObject($this);
        foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $var) {
            $this->props[$var->getName()] = $this->{$var->getName()};
        }

        return $this->props;
    }

    /**
     * Should allow saving the object
     */
    abstract public function save();
}
