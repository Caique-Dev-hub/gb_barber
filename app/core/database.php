<?php
 
class Database{
   
    protected ?object $db = null;
 
    public function __construct()
    {
        if(is_null($this->db)){
            $this->conection($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
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
 