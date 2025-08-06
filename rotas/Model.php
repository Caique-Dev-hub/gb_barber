<?php
class Model{
    protected $db;

    public function __construct()
    {
        try {
            $options = array(
                PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_ERRMODE,
                PDO::FETCH_ASSOC,
            );

            $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);//DSN ele so pede o ferrementa, servidor e o nome do DB.
        } catch (PDOException $th) {

        }
    }
}