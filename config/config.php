<?php
// DB_HOST=br61-cp.valueserver.com.br
// DB_NAME=alve6465_gbbarbearia
// DB_USER=alve6465_codexdev
// DB_PASSWORD=Tipi03@123
 
define('URL_BASE', 'http://localhost/gb_barber/public/');


define('DB_HOST', 'localhost');
define('DB_NAME', 'db_barber');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

spl_autoload_register(function($class){
    $caminhos = [
        "../app/controllers/$class.php",
        "../app/models/$class.php",
        "../app/core/$class.php",
        "../routes/$class.php"
    ];
 
    foreach($caminhos as $valor){
        if(file_exists($valor)){
            require_once($valor);
        }
    }
});
 
function env(): void
{
    $arquivo = file("../.env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 
    foreach($arquivo as $valor){
        if(str_contains($valor, '#')){
            continue;
        }
 
        $env = explode('=', $valor, 2);
 
        $_ENV[$env[0]] = $env[1];
    }
}
 
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
 