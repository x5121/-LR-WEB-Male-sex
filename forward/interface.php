<?php

!isset($_SESSION['user_admin']) && die();

use app\modules\module_page_malesex_stats\ext\MyPdo;

$pdo = new MyPdo();

$optons = $_REQUEST;

if (isset($optons['server_num'])) {

    $pdo->serverNum = $optons['server_num'];

    setcookie("SERVER_NUM", $pdo->serverNum, time() + 360000);
}



if (!$pdo->getDbOpton() || (isset($optons['action']) && $optons['action'] == 'settings')) {
    require MODULES . 'module_page_malesex_stats/includes/install.php';
} else {
    require MODULES . 'module_page_malesex_stats/includes/home.php';
}
