<?php

define('URL_BASE', 'http://localhost/gb-barber/public/');

// Configurações do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_barber');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configurações do Email
define('EMAIL_HOST', '');
define('EMAIL_PORT', '');
define('EMAIL_USER', '');
define('EMAIL_PASS', '');

spl_autoload_register(function($class){
if (file_exists('../app/controllers/' . $class . '.php')){
    require_once '../app/controllers/' . $class . '.php';
}
if (file_exists('../app/models/' . $class . '.php')){
    require_once '../app/models/' . $class . '.php';
}
if (file_exists('../rotas/' . $class . '.php')){
    require_once '../rotas/' . $class . '.php';
}

});