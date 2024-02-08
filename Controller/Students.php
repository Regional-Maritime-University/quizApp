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

    public function add(array $data)
    {

        // so change the id name from the students.php
        $exists = $this->fetchByIndexNumber($data["add-stud-num"]);
        if (!empty($exists)) return array("success" => false, "message" => "Index number exists!");

        $query = "INSERT INTO `student`(`index_number`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `gender`, `fk_department`, `fk_class`) 
                VALUES (:num, :em, :ps, :fn, :mn, :ln,  :gn,  :fkd, :cl)";
        $added = $this->db->run($query, array(
            ':num' => $data["add-stud-num"],
            ':em' => $data["add-stud-email"],
            ':ps' => password_hash("123@password", PASSWORD_BCRYPT),
            ':fn' => $data["add-stud-fname"],
            ':mn' => $data["add-stud-mname"],
            ':ln' => $data["add-stud-lname"],
            ':gn' => $data["add-stud-gender"],
            ':fkd' => $data["add-stud-depart"],
            ':cl' => $data["class-code"]
        ))->add();
        return $added ? array("success" => true, "message" => "New Student added!") : array("success" => false, "message" => "Failed to add staff!");
    }
    public function edit($student): mixed
    {
        $query = "UPDATE `student` SET `email` = :em, `first_name` = :fn, `middle_name` = :mn, `last_name` = :ln WHERE `index_number` = :num";
        $updated = $this->db->run($query, array(
            ':num' => $student["edit-stud-index"],
            ':em' => $student["edit-stud-email"],
            ':fn' => $student["edit-stud-fname"],
            ':mn' => $student["edit-stud-mname"],
            ':ln' => $student["edit-stud-lname"],
        ))->update();
        return $updated ? array("success" => true, "message" => "Student information updated!") : array("success" => false, "message" => "Failed to add staff!");
    }

     public function archive($student): mixed
    {
        $query = "UPDATE `student` SET `archived` = 1 WHERE `index_number` = :n";
        $removed = $this->db->run($query, array(':n' => $student["archive-stud-number"]))->update();
        return $removed ? array("success" => true, "message" => "Student information archived!") : array("success" => false, "message" => "Failed to archive staff!");
    }

    public function remove(array $students)
    {
        $removed = 0;
        foreach ($students as $student) {
            $query = "DELETE FROM `student` WHERE `index_number` = :i";
            $removed += $this->db->run($query, array(":i" => $student["indexNumber"]))->delete();
        }
        return $removed;
    }

    public function fetchByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT s.`index_number` AS indexNumber,s.`fk_class` As studClass, s.`app_number` AS appNumber, s.`email`, s.`phone_number` AS phoneNumber, 
        s.`first_name` AS firstName, s.`middle_name` AS middleName, s.`last_name` AS lastName, s.`suffix`, s.`gender`, s.`dob`, 
        s.`nationality`, s.`photo`, s.`date_admitted` AS dateAdmitted, s.`term_admitted` AS termAdmitted, 
        s.`stream_admitted` AS streamAdmitted, s.`archived`, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `student` AS s, `department` AS d 
        WHERE s.`fk_department` = d.`id` AND d.`id` = :d AND s.`archived` = :a";
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
        return $this->db->run($query, array(":i" => $indexNumber, ":a" => $isArchived))->one();
    }
    
}
