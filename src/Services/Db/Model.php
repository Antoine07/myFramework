<?php

namespace Services\Db;

class Model extends Object implements iModel
{

    /**
     * Save resource
     *
     */
    protected $table;

    /**
     * Save resource update or insert if pk exist then update else insert
     */
    public function save()
    {
        if ($this->pk == null || !property_exists($this, 'pk')) {
            throw new \InvalidArgumentException("Primary key must exist before saving");
        }

        $saved = false;
        foreach ($this->fetchPublicMembers() as $col => $val) {
            if (!preg_match('/id/', $col)) {
                $set[] = sprintf("%s=%s", $col, $this->pdo->quote($val));
                $data[] = sprintf("'%s'", $val);
                $field[] = sprintf("%s", $col);
            } else
                $saved = true;
        }

        if ($saved) {
            $query = sprintf("UPDATE %s SET %s WHERE %s = %s",
                $this->tableName,
                implode(',', $set),
                $this->pk,
                $this->id);
        } else {
            $query = sprintf("INSERT INTO %s (%s) VALUES (%s) ",
                $this->tableName,
                implode(',', $field),
                implode(',', $data)
            );
        }

        $this->pdo->exec($query);

    }

    /**
     * Return all resources
     *
     * @return array resources
     */
    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()}");
        $className = get_called_class();

        return $stmt->fetchAllObjectOfClass($className);

    }

    /**
     * @param array $id
     * @return mixed
     */
    public function find($id)
    {

        $query = sprintf(
            'SELECT * FROM %s WHERE %s=%s',
            $this->getTableName(),
            $this->pk,
            (int)$id
        );

        $stmt = $this->pdo->query($query);
        $className = get_called_class();

        return $stmt->fetchObjectOfClass($className);
    }

    /**
     * Delete resource by pk
     *
     * @param int $id
     * @return \PDOStatement
     */
    public function delete($id)
    {
        $query = sprintf(
            'DELETE FROM %s WHERE %s=%s ',
            $this->getTableName(),
            $this->pk,
            (int)$id
        );

        return $this->pdo->query($query);
    }

    /**
     * query method
     *
     * @param array $data
     * @return resource
     */
    public function query(array $data)
    {

        $set = [];
        foreach ($data as $col => $val) {
            $set[] = sprintf("%s=%s", $col, $this->pdo->quote($val));
        }

        $query = sprintf(
            'SELECT * FROM %s WHERE %s',
            $this->getTableName(),
            implode(' AND ', $set)
        );

        $stmt = $this->pdo->query($query);
        $className = get_called_class();

        return $stmt->fetchObjectOfClass($className);
    }

}