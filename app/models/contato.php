<?php

class Contato extends Database{
    public function getComentarios(){
        $sql = "SELECT * FROM tbl_contato
        LEFT JOIN tbl_resposta ON tbl_contato.id_contato = tbl_resposta.id_contato";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}