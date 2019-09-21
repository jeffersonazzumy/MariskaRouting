<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 11/09/2019
 * Time: 23:43
 */

namespace Mariska\Router;


class Connect
{
    public function connect()
    {
        try {
            $conn = new \PDO('mysql:host=localhost;dbname=sys', "jefferson", "33124959jf");
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return $conn;
    }
}