<?php

namespace Controller;

use Core\Database;

class Program
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    //CRUD For Program
    public function add(array $programs): mixed
    {
        $added = 0;
        foreach ($programs as $program) {
            $query = "INSERT INTO `program` (`code`, `name`, `duration`, `dur_format`, `fk_department`) VALUES (:c, :n, :d, :f, :fkd)";
            $params = array(
                ':c' => $program["code"],
                ':n' => $program["name"],
                ':d' => $program["duration"],
                ':f' => $program["dur_format"],
                ':n' => $program["department"]
            );
            $added += $this->db->run($query, $params)->add();
        }
        return $added;
    }

    public function editProgram($data): mixed
    {
        $query = "UPDATE `program` SET `code` = :c, `name` = :n, `duration` = :d, `dur_format` = :f, `fk_department` = :fkd WHERE code = :c";
        return $this->db->run($query, array(
            ':c' => $data["code"],
            ':n' => $data["name"],
            ':d' => $data["duration"],
            ':f' => $data["dur_format"],
            ':fkd' => $data["department"]
        ));
    }

    public function archiveProgram(array $programs): mixed
    {
        $removed = 0;
        foreach ($programs as $program) {
            $query = "UPDATE `program` SET `archived` = 1 WHERE `code` = :c";
            $removed += $this->db->run($query, array(':c' => $program["code"]));
        }
        return $removed;
    }

    public function fetchAllProgramByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT p.`code` AS programCode, p.`name` AS programName, p.`duration` AS programDuration, 
        p.`dur_format` AS durationFormat, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `program` AS p, `department` AS d WHERE p.`fk_department` = d.`id` AND d.`id` = :d AND p.`archived` = :a";
        return $this->db->run($query, array(':d' => $departmentID, ":a" => $isArchived));
    }

    public function fetchProgramByCode($programCode, bool $isArchived = false): mixed
    {
        $query = "SELECT p.`code` AS programCode, p.`name` AS programName, p.`duration` AS programDuration, 
        p.`dur_format` AS durationFormat, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `program` AS p, `department` AS d WHERE p.`fk_department` = d.`id` AND p.`code` = :c AND p.`archived` = :a";
        return $this->db->run($query, array(':c' => $programCode, ":a" => $isArchived));
    }

    public function fetchProgramByName($programName, bool $isArchived = false): mixed
    {
        $query = "SELECT p.`code` AS programCode, p.`name` AS programName, p.`duration` AS programDuration, 
        p.`dur_format` AS durationFormat, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `program` AS p, `department` AS d WHERE p.`fk_department` = d.`id` AND p.`name` = :n AND p.`archived` = :a";
        return $this->db->run($query, array(':n' => $programName, ":a" => $isArchived));
    }
}
