<?php

class Servico extends Model{
    public function get_servico(){
        $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}