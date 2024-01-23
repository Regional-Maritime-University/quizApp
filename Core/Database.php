<?php

namespace Core;

use PDO;
use PDOException;
use Exception;
use Core\Base;

class Database
{
    private $conn = null;
    private $query;
    private $stmt;

    public function __construct($config, $dbServer = "mysql", $user = "root", $pass = "")
    {
        $dsn = "{$dbServer}:" . http_build_query($config, "", ";");
        try {
            $this->conn = new PDO($dsn, $user, $pass, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function run($query, $params = array()): mixed
    {
        try {
            $this->query = $query;
            $this->stmt = $this->conn->prepare($this->query);
            $this->stmt->execute($params);
            return $this;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function add()
    {
        if (explode(' ', $this->query)[0] == 'INSERT') return 1;
    }

    public function remove()
    {
        if (explode(' ', $this->query)[0] == 'DELETE') return 1;
    }

    public function update()
    {
        if (explode(' ', $this->query)[0] == 'DELETE') return 1;
    }

    public function all()
    {
        if (explode(' ', $this->query)[0] == 'SELECT') return $this->stmt->fetchAll();
    }

    public function one()
    {
        if (explode(' ', $this->query)[0] == 'SELECT') return $this->stmt->fetch();
    }
}
