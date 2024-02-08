<?php

namespace Controller;

use Core\Database;

class Counts
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    public function totalClasses($departmentID)
    {
        $query = "SELECT COUNT(*) as total FROM `class` AS c, `program` AS p, `department` AS d 
        WHERE p.`code` = c.`fk_program` AND p.`fk_department` = d.`id` AND d.`id` = :d AND c.`archived` = 0";
        $data = $this->db->run($query, [":d" => $departmentID])->one();
        return $data["total"];
    }

    public function totalStudents($departmentID)
    {
        $query = "SELECT COUNT(*) as total FROM `student` WHERE `fk_department` = :d AND `archived` = 0";
        $data = $this->db->run($query, [":d" => $departmentID])->one();
        return $data["total"];
    }

    public function totalLecturers($departmentID)
    {
        $query = "SELECT COUNT(*)  as total FROM `staff` WHERE `fk_department` = :d AND `archived` = 0";
        $data = $this->db->run($query, [":d" => $departmentID])->one();
        return $data["total"];
    }

    public function totalCourses($departmentID)
    {
        $query = "SELECT COUNT(*)  as total FROM `course` WHERE `fk_department` = :d AND `archived` = 0";
        $data = $this->db->run($query, [":d" => $departmentID])->one();
        return $data["total"];
    }

    public function totalPrograms($departmentID)
    {
        $query = "SELECT COUNT(*)  as total FROM `program` WHERE `fk_department` = :d AND `archived` = 0";
        $data = $this->db->run($query, [":d" => $departmentID])->one();
        return $data["total"];
    }

    // ... (existing code)
}
