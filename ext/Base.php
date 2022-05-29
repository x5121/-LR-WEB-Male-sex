<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\modules\module_page_malesex_stats\ext;

use app\ext\Translate;

/**
 * Description of Base
 *
 * @author sergey
 */
class Base
{

    /**
     * Отображает сообщение json формате
     * 
     * @param bool $success
     * @param string $msg
     * @param array|object $data
     */
    public function sendNotification($success = true, $msg = '', $data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $notification = array(
          'success' => $success,
          'data' => $data,
          'messenge' => $this->trans($msg),
          'status' => $success ? 'success' : 'error'
        );

        try {

            $json = json_encode($notification);
            die($json);
        } catch (Exception $exc) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 400);
            $notification = array(
              'success' => false,
              'data' => null,
              'status' => 'error',
              'messenge' => $exc->getTraceAsString()
            );

            die(json_encode($notification));
        }
    }

    public function trans($msg = '')
    {
        $translate = new Translate();
        $messadge = $translate->get_translate_module_phrase($this->modulName, $msg);

        return ($messadge == 'No Translation') ? $msg : $messadge;
    }

    public function getUrl()
    {
        $http = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';

        return $http . "://" . $_SERVER['SERVER_NAME'];
    }

}
