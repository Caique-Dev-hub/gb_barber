<?php
 
class Database{
   
    protected ?object $db = null;
 
    public function __construct()
    {
        if(is_null($this->db)){
            $this->conection(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        }
    }
 
 
    private function conection(string $host, string $dbName, string $dbUser, string $dbPassword): void
    {
        try{
            $this->db = new PDO("mysql:host=$host;dbname=$dbName", $dbUser, $dbPassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
}
 