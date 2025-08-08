<?php

class Reserva extends Database
{
    public function getReserva($id)
    {
        $sql = "SELECT * FROM tbl_reserva WHERE id_reserva = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => (int)$id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addcombo($campos)
    {
        extract($campos);
        $sql = "INSERT INTO tbl_reserva(nome_reserva, email_reserva, whatsapp_reserva, id_combo, id_horario) 
        VALUES (:nome , :email, :telefone, :servico)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindValue(':servico', $combo, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addservico($campos)
    {
        extract($campos);
        $sql = "INSERT INTO tbl_reserva(nome_reserva, email_reserva, 
        whatsapp_reserva, id_servico) VALUES(:nome , :email, :telefone, :servico)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindValue(':servico', $servico, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
