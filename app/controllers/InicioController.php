<?php

class InicioController extends Controller{
    public function index(){
        $dados = [];

        $servico = $this->db_servico->getServicos();
        $combo = $this->db_servico->getCombos();
        $todosservico = $this->db_servico->getcombotodos();

        $dados['datas'] = $this->db_data->getDatas();

        $dados['servicos'] = array_merge($servico , $combo);
        $dados['todosservico'] = array_merge($servico, $todosservico);

        $this->view('inicio', $dados);
    }

    public function listar_horarios($id){
        $getHorarios = $this->db_data->getHorarios($id);

        foreach($getHorarios as $atributo){
            extract($atributo);

            echo "<option value='$id_data_horario'>$hora_inicio</option>";
        }
    }
}