<?php

namespace Controller;

use Core\Database;

class Students
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    // CRUD For Students
    public function edit($student): mixed
    {
        $query = "UPDATE `student` SET `class` = :c WHERE `index_number` = :i";
        return $this->db->run($query, array(':i' => $student["index-number"]))->update();
    }

    public function archive(array $students): mixed
    {
        $archived = 0;
        foreach ($students as $student) {
            $query = "UPDATE `student` SET `archived` = 1  WHERE `index_number` = :i";
            $archived += $this->db->run($query, array(':i' => $student["index-number"]))->update();
        }
        return $archived;
    }

    public function fetchByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT s.`index_number` AS indexNumber, s.`app_number` AS appNumber, s.`email`, s.`phone_number` AS phoneNumber, 
        s.`first_name` AS firstName, s.`middle_name` AS middleName, s.`last_name` AS lastName, s.`suffix`, s.`gender`, s.`dob`, 
        s.`nationality`, s.`photo`, s.`date_admitted` AS dateAdmitted, s.`term_admitted` AS termAdmitted, 
        s.`stream_admitted` AS streamAdmitted, s.`archived`, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `student` AS s, `department` AS d 
        WHERE s.`fk_department` = d.`id` AND d.`id` = :d AND c.`archived` = :a";
        return $this->db->run($query, array(":d" => $departmentID, ":a" => $isArchived))->all();
    }

    public function fetchByProgram($programCode, bool $isArchived = false): mixed
    {
        $query = "SELECT s.`index_number` AS indexNumber, s.`app_number` AS appNumber, s.`email`, s.`phone_number` AS phoneNumber, 
        s.`first_name` AS firstName, s.`middle_name` AS middleName, s.`last_name` AS lastName, s.`suffix`, s.`gender`, s.`dob`, 
        s.`nationality`, s.`photo`, s.`date_admitted` AS dateAdmitted, s.`term_admitted` AS termAdmitted, 
        s.`stream_admitted` AS streamAdmitted, s.`archived`, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `student` AS s, `department` AS d, `class` AS c 
        WHERE s.`fk_department` = d.`id` AND s.`class` = c.`code` AND c.`fk_program` = :p AND s.`archived` = :a";
        return $this->db->run($query, array(":p" => $programCode, ":a" => $isArchived))->all();
    }

    public function fetchByClass($classCode, bool $isArchived = false): mixed
    {
        $query = "SELECT s.`index_number` AS indexNumber, s.`app_number` AS appNumber, s.`email`, s.`phone_number` AS phoneNumber, 
        s.`first_name` AS firstName, s.`middle_name` AS middleName, s.`last_name` AS lastName, s.`suffix`, s.`gender`, s.`dob`, 
        s.`nationality`, s.`photo`, s.`date_admitted` AS dateAdmitted, s.`term_admitted` AS termAdmitted, 
        s.`stream_admitted` AS streamAdmitted, s.`archived`, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `student` AS s, `department` AS d, `class` AS c 
        WHERE s.`fk_department` = d.`id` AND s.`class` = c.`code` AND c.`class` = :c AND s.`archived` = :a";
        return $this->db->run($query, array(":c" => $classCode, ":a" => $isArchived))->all();
    }

    public function fetchByIndexNumber($indexNumber, bool $isArchived = false): mixed
    {
        $query = "SELECT s.`index_number` AS indexNumber, s.`app_number` AS appNumber, s.`email`, s.`phone_number` AS phoneNumber, 
        s.`first_name` AS firstName, s.`middle_name` AS middleName, s.`last_name` AS lastName, s.`suffix`, s.`gender`, s.`dob`, 
        s.`nationality`, s.`photo`, s.`date_admitted` AS dateAdmitted, s.`term_admitted` AS termAdmitted, 
        s.`stream_admitted` AS streamAdmitted, s.`archived`, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `student` AS s, `department` AS d 
        WHERE s.`fk_department` = d.`id` AND s.`index_number` = :i AND s.`archived` = :a";
        return $this->db->run($query, array(":i" => $indexNumber, ":a" => $isArchived))->all();
    }
}
