<?php

defined('IN_LR') != true && die();
/*
 * @author Hodakovskiy <hodakovskiy@gmail.com>
 * 
 */

use app\modules\module_page_malesex_stats\ext\Install;


// Задаём заголовок страницы.
$Modules->set_page_title($General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_module_phrase('module_page_malesex_stats', '_TITLE'));

// Задаём описание страницы.
$Modules->set_page_description($General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_module_phrase('module_page_malesex_stats', '_DESCRIPTION'));

$optons = $_POST;



if (isset($optons['action']) && $optons['action'] == 'install') {

    $install = new Install($optons);

    $install->install();
    
}


