<?php

class Dashboard extends Database{
    public function getAdmin(){
        $sql = "SELECT * FROM tbl_admin";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}