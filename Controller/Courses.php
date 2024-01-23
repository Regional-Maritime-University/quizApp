<?php

namespace Controller;

use Core\Database;

class Courses
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    // Create a course
    public function add(array $courses)
    {
        $added = 0;
        foreach ($courses as $course) {
            $query = "INSERT INTO `course` (`code`, `name`, `credit_hours`, `fk_department`) VALUES (:c, :n, :h, :fkd)";
            $params = array(
                ':c' => $course["code"],
                ':n' => $course["name"],
                ':h' => $course["credit_hours"],
                ':fkd' => $course["department"]
            );
            $added += $this->db->run($query, $params)->add();
        }
        return $added;
    }

    public function update($data)
    {
        $query = "UPDATE courses SET `code` = :c, `name` = :n , `credit_hours` = :h, `fk_department` = :fkd";
        $params = array(
            ":c" => $data["code"],
            ":n" => $data["name"],
            ":h" => $data["credit-hours"],
            ":fkd" => $data["department"],
        );
        return $this->db->run($query, $params)->update();
    }

    public function archive($data)
    {
        $query = "UPDATE courses SET `archive` = 1 WHERE `code` = :c";
        $params = array(":c" => $data["code"]);
        return $this->db->run($query, $params)->update();
    }

    public function delete($data)
    {
        $query = "DELETE FROM courses WHERE `code` = :c";
        $params = array(":c" => $data["code"]);
        return $this->db->run($query, $params)->delete();
    }

    public function fetchByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS courseCode, c.`name` AS courseName, c.`credit_hours` AS creditHours, 
        d.`id` AS departmentID, d.`name` AS departmentName FROM `course` AS c, department AS d 
        WHERE c.`fk_department` = d.`id` AND d.`id` = :d AND c.`archived` = :a";
        return $this->db->run($query, array(':d' => $departmentID, ":a" => $isArchived))->all();
    }

    public function fetchByCode($courseCode, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS courseCode, c.`name` AS courseName, c.`credit_hours` AS creditHours, 
        d.`id` AS departmentID, d.`name` AS departmentName FROM `course` AS c, department AS d 
        WHERE c.`fk_department` = d.`id` AND c.`code` = :c AND c.`archived` = :a";
        return $this->db->run($query, array(':c' => $courseCode, ":a" => $isArchived))->all();
    }

    public function fetchByName($courseName, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS courseCode, c.`name` AS courseName, c.`credit_hours` AS creditHours, 
        d.`id` AS departmentID, d.`name` AS departmentName FROM `course` AS c, department AS d 
        WHERE c.`fk_department` = d.`id` AND c.`name` = :n AND c.`archived` = :a";
        return $this->db->run($query, array(':n' => $courseName, ":a" => $isArchived))->all();
    }
}
