<?php
 define('URL_BASE', 'https://localhost/gb_barber/public/');
 // define('URL_BASE', 'https://localhost/gb_barber/public/');

// define('DB_HOST', 'br61-cp.valueserver.com.br');
// define('DB_NAME', 'alve6465_gbbarbearia');
// define('DB_PASSWORD', 'Tipi03@123');
// define('DB_USER', 'alve6465_codexdev');

define('DB_HOST', 'localhost');
define('DB_NAME', 'db_barbearia');
define('DB_PASSWORD', '');
define('DB_USER', 'root');

 define('CRYPTO_KEY', 'P5SubK2ZRnnbpFxPHxNns+oR43jolVwI');

 define('METHOD_CRYPTO', 'AES-256-GCM');

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
 
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
 