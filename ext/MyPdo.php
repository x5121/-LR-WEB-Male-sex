<?php

namespace app\modules\module_page_malesex_stats\ext;

use PDO;
use app\modules\module_page_malesex_stats\ext\Base;

/**
 * Description of DB
 *
 * @author sergey
 */
class MyPdo extends Base
{

    public $pdo;
    public $tableName = 'server1_malesex_stats';
    public $modulName = 'module_page_malesex_stats';
    public $dbOptons = array();
    public $serverNum = 0;

    public function __construct($tableName = '', $modulName = '')
    {

        $this->dbOptons = empty($this->dbOptons) ? $this->getDbOpton() : $this->dbOptons;
        if (!$this->dbOptons) {
            return false;
        }
      
        $this->tableName = empty($tableName) ? $this->tableName : $tableName;
        $this->modulName = empty($modulName) ? $this->modulName : $modulName;
        $this->pdo = $this->setPdo($this->dbOptons);
    }

    public function run($sql, $args = NULL)
    {
        if (!$args) {
            return $this->pdo->query($sql);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    /**
     * Получение настроек базы данных.
     *
     * @since 0.2
     *
     * @return array                 Массив с настройками.
     */
    private static function getDbOptions()
    {

        $db_setings['DB_NAME'] = $db_setings['DB'][0]['DB'];
        unset($db_setings['DB']);
        return $db_setings;
    }

    public function setPdo($db_setings)
    {
        if (empty($db_setings)) {
            return false;
        }
        $host = $db_setings['HOST'];
        $dbname = $db_setings['DB_NAME'];
        $port = $db_setings['PORT'];
        $username = $db_setings['USER'];
        $password = $db_setings['PASS'];
        $this->tableName = $db_setings['TABLE'];
        
        $default_options = [
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($default_options, $options);
        $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4";

        try {
            return $this->pdo = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            return $msg = $e->getMessage() . $e->getCode();
        }
    }

    public function getFileDbSeting()
    {
        return file_exists(SESSIONS . '/db.php') ? require SESSIONS . '/db.php' : null;
    }
    
     public function getDbOptons() {
         $db_setings_arr = $this->getFileDbSeting();
         return $db_setings_arr[$this->modulName];
     }

    public function getDbOpton()
    {
        $opt = $this->getDbOptons();
        return empty($opt[$this->serverNum]) ?
            false :
            $opt[$this->serverNum];
    }

    /**
     * Получаем опции из других модулей
     * @return array
     */
    public function getDefaultOptons()
    {

        $db_setings_arr = $this->getFileDbSeting();

        if (empty(current($db_setings_arr))) {
            return array('HOST' => '91.211.118.56',
              'PORT' => '3306',
              'USER' => 'lr28929',
              'PASS' => '',
              'DB_TABLE' => $this->tableName
            );
        } else {
            $current_modul = current($db_setings_arr)[0];
            $current_modul['DB_NAME'] = $current_modul['DB'][0]['DB'];
            $current_modul['DB_TABLE'] = $this->tableName;
//            unset($current_modul['PASS']);
            unset($current_modul['DB']);

            return $current_modul;
        }
    }

}
