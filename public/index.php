<?php
session_start();

require_once('../config/config.php');

$caminho = new Rotas();
$caminho -> execute();


?>