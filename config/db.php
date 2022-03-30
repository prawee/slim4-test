<?php

class Db {
    private $host = 'localhost';
    private $user = 'pod';
    private $pass = 'p@ssw0rd';
    private $dbname = 'slim_test';

    public function connect() {
        $connStr = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($connStr, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}