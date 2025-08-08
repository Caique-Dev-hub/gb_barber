<?php

class Contato extends Database{
    public function getComentarios(){
        $sql = "SELECT * FROM tbl_contato
        LEFT JOIN tbl_resposta ON tbl_contato.id_contato = tbl_resposta.id_contato";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addcombo($campos){
        extract($campos);
        $sql = "INSERT INTO tbl_reserva(nome_reserva, email_reserva, 
        whatsapp_reserva, id_combo) VALUES(:nome , :email, :telefone, :servico)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome',$nome,PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindValue(':servico', $combo, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function addservico($campos){
        extract($campos);
        $sql = "INSERT INTO tbl_reserva(nome_reserva, email_reserva, 
        whatsapp_reserva, id_servico) VALUES(:nome , :email, :telefone, :servico)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome',$nome,PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindValue(':servico', $servico, PDO::PARAM_STR);
        return $stmt->execute();
    }
}