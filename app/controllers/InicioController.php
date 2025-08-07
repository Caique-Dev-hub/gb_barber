<?php

class InicioController extends Controller{
    public function index(){
        $dados = [];
        $servico = $this->db_servico->getservico();
        $combo = $this->db_servico->getcombo();
        $todosservico = $this->db_servico->getcombotodos();

        $dados['servicos'] = array_merge($servico , $combo);
        $dados['todosservico'] = array_merge($servico, $todosservico);

        $this->view('inicio', $dados);
    }
}