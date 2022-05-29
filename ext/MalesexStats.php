<?php


namespace app\modules\module_page_malesex_stats\ext;

use app\modules\module_page_malesex_stats\ext\MyPdo;
/**
 * Description of MalesexStats
 *
 * @author sergey
 */
class MalesexStats extends MyPdo
{
    
    
    public function getRecordsAll()
    {
        return MyPdo::run("SELECT * FROM `{$this->tableName}`")->fetchAll();
    }
    
  
    
}
