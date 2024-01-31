<?php

namespace Controller;

use Core\Database;

class Staff
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM `staff` WHERE `email` = :u";
        $data = $this->db->run($query, array(':u' => $email))->one();
        if (!empty($data)) {
            if (password_verify($password, $data["password"])) {
                return $data;
            }
        }
        return 0;
    }

    public function add(array $data)
    {
        $query = "INSERT INTO `staff`(`number`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `prefix`, `gender`, `role`, `fk_department`) 
                VALUES (:num, :em, :pas, :fn, :mn, :ln, :pre, :gen, :rol, :fkd)";
        $added = $this->db->run($query, array(
            ':num' => $data["add-lec-number"],
            ':em' => $data["add-lec-email"],
            ':pas' => $data["add-lec-password"],
            ':fn' => $data["add-lec-fname"],
            ':mn' => $data["add-lec-mname"],
            ':ln' => $data["add-lec-lname"],
            ':pre' => $data["add-lec-prefix"],
            ':gen' => $data["add-lec-gender"],
            ':rol' => $data["add-lec-role"],
            ':fkd' => $data["add-lec-depart"]
        ))->add();
        return  $added;
    }

    public function currentSemester()
    {
        $data = $this->db->run("SELECT * FROM `semester` WHERE `active` = 1")->one();
        if (!empty($data)) return $data["id"];
        return 0;
    }

    public function assignCourse(array $data)
    {
        $courses = json_decode($data["assign-course-list"][0], true);
        $to = $data["assign-to"];
        $who = $data["assign-who"];

        if ($to === "lecturer") return $this->assignCourseToLecturer($courses, $who);
        elseif ($to === "class") return $this->assignCourseToClass($courses, $who);
    }

    public function assignCourseToLecturer(array $sections, string $lecturer)
    {
        $added = 0;
        foreach ($sections as $section) {
            $query = "INSERT INTO `lecture` (`fk_staff`, `fk_section`, `fk_semester`) VALUES (:s, :c, :m)";
            $added += $this->db->run($query, array(
                ':s' => $lecturer,
                ':c' => $section,
                ':m' => $this->currentSemester()
            ))->add();
        }
        return "{$added} courses assign to this lecturer [ID: {$lecturer}]!";
    }

    public function assignCourseToClass(array $courses, string $class)
    {
        $added = 0;
        foreach ($courses as $course) {
            $query = "INSERT INTO `section` (`fk_class`, `fk_course`, `fk_semester`) VALUES (:s, :c, :m)";
            $added += $this->db->run($query, array(
                ':s' => $class,
                ':c' => $course,
                ':m' => 1 //$this->currentSemester()
            ))->add();
        }
        return "{$added} courses assign to this class [Code: {$class}]!";
    }

    public function classToStudent(array $students, string $class)
    {
        $added = 0;
        foreach ($students as $student) {
            $query = "UPDATE `student` SET `fk_class` = :c WHERE `index_number` = :i) VALUES (:c, :i)";
            $added += $this->db->run($query, array(
                ':c' => $class,
                ':i' => 1 //$student["index-number"]
            ))->add();
        }
        return "{$added} students assign to this class [Code: {$class}]!";
    }

    public function fetchSectionByDepartment($departmentID, bool $isArchived = false): mixed
    {
        $query = "SELECT c.`code` AS courseCode, CONCAT(c.`code`, ' - ', c.`name`) AS courseName, c.`credit_hours` AS creditHours, 
        FROM `course` AS c, department AS d, class AS s, section AS t 
        WHERE c.`fk_department` = d.`id` AND d.`id` = :d AND t.`fk_course` = c.`code` AND t.`fk_class` = s.`code` AND c.`archived` = :a";
        return $this->db->run($query, array(':d' => $departmentID, ":a" => $isArchived))->all();
    }
}
