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

    
    public function add(array $data)
    {
        $exists = $this->fetchByCode($data["addcourseCode"]);
        if (!empty($exists)) return array("success" => false, "message" => "Staff number exist!");

        $query = "INSERT INTO `course` (`code`, `name`, `credit_hours`, `fk_department`) VALUES (:c, :n, :h, :fkd)";
        $added = $this->db->run($query, array(
            ':c' => $data["addcourseCode"],
            ':n' => $data["addcourseName"],
            ':h' => $data["addcreditHours"],
            ':fkd' => $data["department"]
      
        ))->add();
        return $added ? array("success" => true, "message" => "New Class added!") : array("success" => false, "message" => "Failed to add course!");
    }

    public function edit(array $course)
    {
        // Check if the required keys exist in the $course array
        if (isset($course["edit-course-code"], $course["edit-course-name"], $course["edit-credit-hours"])) {
            $query = "UPDATE course SET `name` = :n, `credit_hours` = :h  WHERE code = :c";
            $updated = $this->db->run($query, array(
                ":c" => $course["edit-course-code"],
                ":n" => $course["edit-course-name"],
                ":h" => $course["edit-credit-hours"],
            ))->update();
            return $updated ? array("success" => true, "message" => "Course updated!") : array("success" => false, "message" => "Failed to update course!");
        } else {
            return array("success" => false, "message" => "One or more required keys are missing in the course data!");
        }
    }
    
    public function archive(array $course): mixed
    {      
            $query = "UPDATE course SET `archived` = 1 WHERE `code` = :c";
            $removed = $this->db->run($query, array(':c' => $course["archive-course-code"]))->update();
            return $removed ? array("success" => true, "message" => "Course archived!") : array("success" => false, "message" => "Failed to archive course!");

        
    }
    public function remove(array $courses)
    {
        $removed = 0;
        foreach ($courses as $course) {
            $query = "DELETE FROM course WHERE `code` = :c";
            $removed += $this->db->run($query, array(":c" => $course["code"]))->delete();
        }
        return $removed;
    }

    public function fetchAll(bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS courseCode, c.`name` AS courseName, c.`credit_hours` AS creditHours 
        FROM `course` AS c WHERE c.`archived` = :a";
        return $this->db->run($query, array(":a" => $isArchived))->all();
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
        return $this->db->run($query, array(':c' => $courseCode, ":a" => $isArchived))->one();
    }

    public function fetchByName($courseName, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS courseCode, c.`name` AS courseName, c.`credit_hours` AS creditHours, 
        d.`id` AS departmentID, d.`name` AS departmentName FROM `course` AS c, department AS d 
        WHERE c.`fk_department` = d.`id` AND c.`name` = :n AND c.`archived` = :a";
        return $this->db->run($query, array(':n' => $courseName, ":a" => $isArchived))->all();
    }
}
