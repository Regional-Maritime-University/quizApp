<?php

namespace Controller;

use Core\Database;

class Lecturers
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    //CRUD For Program
    public function add(array $lecturers): mixed
    {
        $added = 0;
        foreach ($lecturers as $lecturer) {
            $query = "INSERT INTO `program` (`code`, `name`, `duration`, `dur_format`, `fk_department`) VALUES (:c, :n, :d, :f, :fkd)";
            $params = array(
                ':c' => $lecturer["code"],
                ':n' => $lecturer["name"],
                ':d' => $lecturer["duration"],
                ':f' => $lecturer["dur_format"],
                ':n' => $lecturer["department"]
            );
            $added += $this->db->run($query, $params)->add();
        }
        return $added;
    }

    public function edit(array $lecturer): mixed
    {
        $query = "UPDATE `program` SET `code` = :c, `name` = :n, `duration` = :d, `dur_format` = :f, `fk_department` = :fkd WHERE code = :c";
        return $this->db->run($query, array(
            ':c' => $lecturer["code"],
            ':n' => $lecturer["name"],
            ':d' => $lecturer["duration"],
            ':f' => $lecturer["dur_format"],
            ':fkd' => $lecturer["department"]
        ))->update();
    }

    public function archive(array $lecturers): mixed
    {
        $removed = 0;
        foreach ($lecturers as $lecturer) {
            $query = "UPDATE `program` SET `archived` = 1 WHERE `code` = :c";
            $removed += $this->db->run($query, array(':c' => $lecturer["code"]))->update();
        }
        return $removed;
    }

    public function remove(array $lecturers)
    {
        $removed = 0;
        foreach ($lecturers as $course) {
            $query = "DELETE FROM `program` WHERE `code` = :p";
            $removed += $this->db->run($query, array(":p" => $course["code"]))->delete();
        }
        return $removed;
    }


    public function fetchByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT s.* FROM `staff` AS s, `department` AS d WHERE s.`fk_department` = d.`id` AND d.`id` = :d AND s.`archived` = :a";
        return $this->db->run($query, array(':d' => $departmentID, ":a" => $isArchived))->all();
    }

    public function fetchByStaffNumber($staffNumber, bool $isArchived = false): mixed
    {
        $query = "SELECT `number`, `email`, `first_name`, `middle_name`, `last_name`, `prefix`, `gender`, `role`, `fk_department` 
        FROM `staff` WHERE `number` = :n AND `archived` = :a";
        return $this->db->run($query, array(':n' => $staffNumber, ":a" => $isArchived))->one();
    }

    public function fetchByName($lecturerName, bool $isArchived = false): mixed
    {
        $query = "SELECT p.`code` AS programCode, p.`name` AS programName, p.`duration` AS programDuration, 
        p.`dur_format` AS durationFormat, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `program` AS p, `department` AS d WHERE p.`fk_department` = d.`id` AND p.`name` = :n AND p.`archived` = :a";
        return $this->db->run($query, array(':n' => $lecturerName, ":a" => $isArchived))->all();
    }
}
