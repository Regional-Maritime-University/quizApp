<?php

namespace Controller;

use Core\Database;

class Classes
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    // CRUD for Class
    public function add(array $classes): mixed
    {
        $added = 0;
        foreach ($classes as $class) {
            $query = "INSERT INTO `class` (`code`, `fk_program`) VALUES (:c, :fkp)";
            $added += $this->db->run($query, array(
                ':c' => $class["code"],
                ':fkp' => $class["program"]
            ))->add();
        }
        return $added;
    }

    public function edit(array $class): mixed
    {
        $query = "UPDATE `class` SET `code` = :c, `fk_program` = :fkp WHERE `code` = :c";
        return $this->db->run($query, array(
            ':c' => $class["code"],
            ':fkp' => $class["program"]
        ))->update();
    }

    public function archive(array $classes): mixed
    {
        $archived = 0;
        foreach ($classes as $class) {
            $query = "UPDATE `class` SET `archived` = 1  WHERE `code` = :c";
            $archived += $this->db->run($query, array(':c' => $class["code"]))->update();
        }
        return $archived;
    }

    public function remove(array $classes)
    {
        $removed = 0;
        foreach ($classes as $class) {
            $query = "DELETE FROM class WHERE `code` = :c";
            $removed += $this->db->run($query, array(":c" => $class["code"]))->delete();
        }
        return $removed;
    }

    public function fetchByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS classCode, p.`code` AS programCode, p.`name` AS programName 
                    FROM `class` AS c, `program` AS p, `department` AS d 
                    WHERE p.`code` = c.`fk_program` AND p.`fk_department` = d.`id` AND d.`id` = :d AND c.`archived` = :a";
        return $this->db->run($query, array(":d" => $departmentID, ":a" => $isArchived))->all();
    }

    public function fetchByProgram($programCode, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS classCode, p.`code` AS programCode, p.`name` AS programName 
                    FROM `class` AS c, `program` AS p 
                    WHERE p.`code` = c.`fk_program` AND p.`code` = :p AND c.`archived` = :a";
        return $this->db->run($query, array(":p" => $programCode, ":a" => $isArchived))->all();
    }

    public function fetchByCode($code, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS classCode, p.`code` AS programCode, p.`name` AS programName 
                    FROM `class` AS c, `program` AS p, `department` AS d 
                    WHERE p.`code` = c.`fk_program` AND p.`fk_department` = d.`id` AND c.`code` = :c AND c.`archived` = :a";
        return $this->db->run($query, array(':c' => $code, ":a" => $isArchived))->all();
    }
}
