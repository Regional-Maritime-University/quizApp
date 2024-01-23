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
}
