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

    public function assignCourseToLecturer(array $courses, string $lecturer)
    {
        $added = 0;
        foreach ($courses as $course) {
            $query = "INSERT INTO `lecture` (`fk_staff`, `fk_course`, `fk_semester`) VALUES (:s, :c, :m)";
            $added += $this->db->run($query, array(
                ':s' => $lecturer,
                ':c' => $course,
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
}
