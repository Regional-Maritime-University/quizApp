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
    public function add(array $data)
    {
        $exists = $this->fetchByStaffNumber($data["add-lec-number"]);
        if (!empty($exists)) return array("success" => false, "message" => "Staff number exist!");

        $query = "INSERT INTO `staff`(`number`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `prefix`, `gender`, `role`, `fk_department`) 
                VALUES (:num, :em, :ps, :fn, :mn, :ln, :pr, :gn, :rl, :fkd)";
        $added = $this->db->run($query, array(
            ':num' => $data["add-lec-number"],
            ':em' => $data["add-lec-email"],
            ':ps' => password_hash("123@password", PASSWORD_BCRYPT),
            ':fn' => $data["add-lec-fname"],
            ':mn' => $data["add-lec-mname"],
            ':ln' => $data["add-lec-lname"],
            ':pr' => $data["add-lec-prefix"],
            ':gn' => $data["add-lec-gender"],
            ':rl' => $data["add-lec-role"],
            ':fkd' => $data["add-lec-depart"]
        ))->add();
        return $added ? array("success" => true, "message" => "New staff added!") : array("success" => false, "message" => "Failed to add statff!");
    }
    public function edit(array $lecturer): mixed
    {
        $query = "UPDATE `staff` SET `email` = :em, `first_name` = :fn, `middle_name` = :mn, `last_name` = :ln, `prefix` = :pr, `role` = :rl WHERE `number` = :num";
        $updated = $this->db->run($query, array(
            ':num' => $lecturer["edit-lec-number"],
            ':em' => $lecturer["edit-lec-email"],
            ':fn' => $lecturer["edit-lec-fname"],
            ':mn' => $lecturer["edit-lec-mname"],
            ':ln' => $lecturer["edit-lec-lname"],
            ':pr' => $lecturer["edit-lec-prefix"],
            ':rl' => $lecturer["edit-lec-role"]
        ))->update();
        return $updated ? array("success" => true, "message" => "Staff information updated!") : array("success" => false, "message" => "Failed to add statff!");
    }

    public function archive($lecturer): mixed
    {
        $query = "UPDATE `staff` SET `archived` = 1 WHERE `number` = :n";
        $removed = $this->db->run($query, array(':n' => $lecturer["archive-lec-number"]))->update();
        return $removed ? array("success" => true, "message" => "Staff information archived!") : array("success" => false, "message" => "Failed to archive statff!");
    }

    public function remove(array $lecturers)
    {
        $removed = 0;
        foreach ($lecturers as $lecturer) {
            $query = "DELETE FROM `staff` WHERE `number` = :n";
            $removed += $this->db->run($query, array(":n" => $lecturer["number"]))->delete();
        }
        return $removed;
    }

    public function fetchAll(bool $isArchived = false): mixed
    {
        $query = "SELECT s.* FROM `staff` AS s WHERE s.`archived` = :a";
        return $this->db->run($query, array(":a" => $isArchived))->all();
    }

    public function fetchByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT s.* FROM `staff` AS s, `department` AS d WHERE s.`fk_department` = d.`id` AND d.`id` = :d AND s.`archived` = :a ORDER BY s.`added_at` DESC";
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
