<?php

namespace Controller;

use Core\Database;

class Assign
{

    private $db;

    public function __construct($config)
    {
        $this->db = new Database($config);
    }

    public function sectionToLecturer(array $sections, string $lecturer, int $semester = 1)
    {
        $added = 0;
        foreach ($sections as $section) {
            $query = "INSERT INTO `lecture` (`fk_staff`, `fk_section`, `fk_semester`) VALUES (:s, :c, :m)";
            $added += $this->db->run($query, array(
                ':s' => $lecturer,
                ':c' => $section["section"],
                ':m' => $semester
            ))->add();
        }
        return $added;
    }

    public function courseToClass(array $courses, string $class, int $semester = 1)
    {
        $added = 0;
        foreach ($courses as $course) {
            $query = "INSERT INTO `section` (`fk_class`, `fk_course`, `fk_semester`) VALUES (:s, :c, :m)";
            $added += $this->db->run($query, array(
                ':s' => $class,
                ':c' => $course,
                ':m' => $semester
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
                ':i' => $student["index-number"]
            ))->add();
        }
        return $added;
    }
}
