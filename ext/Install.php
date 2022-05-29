<?php

namespace app\modules\module_page_malesex_stats\ext;

use app\modules\module_page_malesex_stats\ext\MyPdo;

/**
 * Description of install
 *
 * @author sergey
 */
class Install extends MyPdo
{

    protected $dbNewOptons = array();

    public function __construct($dbNewOptons = array())
    {
        $this->dbNewOptons = $dbNewOptons;
    }

    /**
     * Проверяе правельность переданных параметров
     * 
     * @param array $dbOptons
     * 
     * return bool
     */
    private function valibdateDbOptions($dbNewOptons)
    {

        if (empty($dbNewOptons['db_host']) || empty($dbNewOptons['db_user']) || empty($dbNewOptons['db_pass']) || empty($dbNewOptons['db_name'])) {
            $this->sendNotification(false, 'error_db_host');
        }

        $this->parseNewDbOptons($dbNewOptons);
       
        $db_conect = $this->setPdo($this->dbOptons);

        if (!$db_conect) {
            $this->sendNotification(false, 'error_db_conect', ['error' => $db_conect]);
        }


        return true;
    }

    public function install($dbNewOptons = array())
    {
        $dbOptons = empty($dbNewOptons) ? $this->dbNewOptons : $dbNewOptons;

        $dbOptons['db_table'] = empty($dbOptons['db_table']) ? $this->tableName : $dbOptons['db_table'];

        $this->valibdateDbOptions($dbOptons);

        if (empty($dbOptons['check_table']) && $this->checkTable($dbOptons['db_table'])) {

            $this->sendNotification(false, 'error_db_check_table');
        }  elseif (!$this->checkTable($dbOptons['db_table'])) {

            $this->createTable($dbOptons['db_table']);
        }


        $this->insertSeting($this->dbOptons);

        $this->sendNotification(true, 'module_install');

        return true;
    }

    private function druoTable($table_name)
    {

        return $this->run("DROP TABLE {$table_name};")->execute();
    }

    private function createTable($table_name)
    {
        $sql = "CREATE TABLE `{$table_name}`( 
                    `id` Int( 11 ) AUTO_INCREMENT NOT NULL,
                    `auth` VarChar( 32 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                    `name` VarChar( 32 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unknown',
                    `count_sex` Int( 11 ) NOT NULL DEFAULT 0,
                    `count_children` Int( 11 ) NOT NULL DEFAULT 0,
                    `count_unchildren` Int( 11 ) NOT NULL DEFAULT 0,
                    PRIMARY KEY ( `id` ) )
            CHARACTER SET = utf8mb4
            COLLATE = utf8mb4_general_ci
            ENGINE = InnoDB";

        return $this->run($sql)->execute();
    }

    private function insertSeting($param)
    {
        $db = $this->getFileDbSeting();
        
        $db[$this->modulName][] = $param;
        file_put_contents(SESSIONS . 'db.php', '<?php return ' . var_export_opt($db, true) . ";");
    }

    /**
     * Проверяет на доступность таблицы
     * 
     * @param string $table_name
     * 
     * @return bool вернет true если таблица есть
     */
    private function checkTable($table_name)
    {
        $res = $this->run("CHECK TABLE {$table_name} FAST QUICK")->fetch();

        return (!empty($res[3]) && stristr($res[3], 'ok') === FALSE) ? false : true;
    }

    public function parseNewDbOptons($dbNewOptons)
    {
        $db_setings['HOST'] = $dbNewOptons['db_host'];
        $db_setings['DB_NAME'] = $dbNewOptons['db_name'];
        $db_setings['PORT'] = $dbNewOptons['db_port'];
        $db_setings['USER'] = $dbNewOptons['db_user'];
        $db_setings['PASS'] = $dbNewOptons['db_pass'];
        $db_setings['TABLE'] = $dbNewOptons['db_table'];
        $db_setings['SERVER_NAME'] = $dbNewOptons['server_name'];

        return $this->dbOptons = $db_setings;
    }

}
