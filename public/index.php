<?php

require_once('../config/config.php');

env();

$token = Token::gerar_token([
    'teste' => 'Gustavo',
    'oi' => 'idade'
]);

var_dump(Token::validar_token($token));

exit;

new Database();

Router::url();
