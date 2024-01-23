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
}
