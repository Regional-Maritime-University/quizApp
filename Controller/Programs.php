<?php

namespace Controller;

use Core\Database;

class Programs
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    //CRUD For Program

    
    public function add(array $data)
    {
        $exists = $this->fetchByCode($data["add-prog-code"]);
        if (!empty($exists)) return array("success" => false, "message" => "Program Code exists!");

        $query = "INSERT INTO `program` (`code`, `name`, `duration`, `fk_department`) VALUES (:c, :n, :d, :fkd)";
        $added = $this->db->run($query, array(
          
                ':c' => $data["add-prog-code"],
                ':n' => $data["add-prog-name"],
                ':d' => $data["add-prog-duration"],
                ':fkd' => $data["department"]
      
        ))->add();
        return $added ? array("success" => true, "message" => "New Program added!") : array("success" => false, "message" => "Failed to add program!");
    }
  

    public function edit(array $programs): mixed
    {
        $query = "UPDATE `program` SET `code` = :c, `name` = :n, `duration` = :d, `dur_format` = :f, `fk_department` = :fkd WHERE code = :c";
        $updated = $this->db->run($query, array(
            ':c' => $programs["edit-prog-code"],
            ':n' => $programs["edit-prog-name"],
            ':d' => $programs["edit-prog-duration"],
            ':f' => $programs["edit-prog-format"],
            ':fkd' => $programs["department"]
        ))->update();
        return $updated ? array("success" => true, "message" => "Program details updated!") : array("success" => false, "message" => "Failed to update program!");

    }

    public function archive(array $program): mixed
    {
     
            $query = "UPDATE `program` SET `archived` = 1 WHERE `code` = :c";
            $removed = $this->db->run($query, array(':c' => $program["archive-prog"]))->update();
            return $removed ? array("success" => true, "message" => "Program archived!") : array("success" => false, "message" => "Failed to archive program!");

    }

    public function remove(array $program): mixed
    {
     
            $query = "DELETE FROM `program` WHERE `code` = :p";
            $removed = $this->db->run($query, array(":p" => $program["code"]))->delete();
            return $removed ? array("success" => true, "message" => "Program removed!") : array("success" => false, "message" => "Failed to remove program!");

    }


    public function fetchByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT p.`code` AS programCode, p.`name` AS programName, p.`duration` AS programDuration, 
        p.`dur_format` AS durationFormat, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `program` AS p, `department` AS d WHERE p.`fk_department` = d.`id` AND d.`id` = :d AND p.`archived` = :a";
        return $this->db->run($query, array(':d' => $departmentID, ":a" => $isArchived))->all();
    }

    public function fetchByCode($programCode, bool $isArchived = false): mixed
    {
        $query = "SELECT p.`code` AS programCode, p.`name` AS programName, p.`duration` AS programDuration, 
        p.`dur_format` AS durationFormat, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `program` AS p, `department` AS d WHERE p.`fk_department` = d.`id` AND p.`code` = :c AND p.`archived` = :a";
        return $this->db->run($query, array(':c' => $programCode, ":a" => $isArchived))->one();
    }

    public function fetchByName($programName, bool $isArchived = false): mixed
    {
        $query = "SELECT p.`code` AS programCode, p.`name` AS programName, p.`duration` AS programDuration, 
        p.`dur_format` AS durationFormat, d.`id` AS departmentID, d.`name` AS departmentName 
        FROM `program` AS p, `department` AS d WHERE p.`fk_department` = d.`id` AND p.`name` = :n AND p.`archived` = :a";
        return $this->db->run($query, array(':n' => $programName, ":a" => $isArchived))->all();
    }
}
