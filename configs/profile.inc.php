<?php
define('FRONT', 'front/');//front skin
define('ADMIN', 'admin/');//admin skin
define('SMARTY_TEMPLATE_DIR', ROOT_PATH.'/view/');//template directory
define('SMARTY_COMPILE_DIR', ROOT_PATH.'/compile/');//compile directory
define('SMARTY_CONFIG_DIR', ROOT_PATH.'/configs/');//config directory
define('SMARTY_CACHE_DIR', ROOT_PATH.'/cache/');//cache directory
define('SMARTY_CACHING', 0);//cache default close cache
define('SMARTY_CACHE_LIFETIME', 60*60*24);//cache time
define('SMARTY_LEFT_DELIMITER', '{');//define left location mark
define('SMARTY_RIGHT_DELIMITER', '}');//define right location mark

//database setting
define('DB_DNS', 'mysql:host=localhost;dbname=newfdclibrary');//database
define('DB_USER', 'root');//database username
define('DB_PASS', 'root');//database password
define('DB_CHARSET', 'UTF8');//charset 
define('DB_FREFIX', 'ecs_');//frefix

//system config
define('PAGE_SIZE', 10);//page
define('UPDIR','uploads/');//upload directory
 
?>