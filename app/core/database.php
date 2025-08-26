<?php

class Database{
    protected mixed $db;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $dbuser = $_ENV['DB_USER'];
        $dbpassword = $_ENV['DB_PASSWORD'];

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Erro: {$e->getMessage()}");
        }
    }
}