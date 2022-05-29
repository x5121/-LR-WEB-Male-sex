<?php
!isset($_SESSION['user_admin']) && die();

use app\modules\module_page_malesex_stats\ext\MyPdo;

$pdo = new MyPdo();
$defaultOptons = $pdo->getDefaultOptons();
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge">Установка модуля</h5>
            </div>
            <div style="margin-left: 15px;">
                <form action="javascript:void(null);" onsubmit="InstallModule()" id="db_check" method="POST">
                    <div class="form-group row">
                        <label for="db_host" class="col-sm-2 col-form-label">Mysql Хост</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="db_host"  name="db_host"  value="<?= $defaultOptons['HOST'] ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_user" class="col-sm-2 col-form-label">Пользователь</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="db_user" name="db_user" placeholder="Пользователь"  value="<?= $defaultOptons['USER'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_pass" class="col-sm-2 col-form-label">Пароль</label>
                        <div class="col-sm-10">
                            <input  class="form-control" id="db_pass" name="db_pass" placeholder="Пароль"  value="<?= $defaultOptons['PASS'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_name" class="col-sm-2 col-form-label">База данных</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="db_name" name="db_name" placeholder="База данных"  value="<?= $defaultOptons['DB_NAME'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_port" class="col-sm-2 col-form-label">Порт</label>
                        <div class="col-sm-10">
                            <input class="form-control"  id="db_port" name="db_port" value="3306" placeholder="Порт (Обычно 3306)"  value="<?= $defaultOptons['PORT'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_table" class="col-sm-2 col-form-label">Имя таблицы</label>
                        <div class="col-sm-10">
                            <input class="form-control" d="db_table" name="db_table"  placeholder="Имя таблицы" value="<?= $defaultOptons['DB_TABLE'] ?>" title="если оставить пустым то имя будет дефолтное">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="check_table" class="col-sm-2 col-form-label">Не создавать таблицу</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="checkbox" name="check_table"> <span>Не создавать таблицу </span>
                        </div>
                         <label for="check_table" class="col-sm-2 col-form-label"></label>
                    </div>
                    <div class="form-group row">
                        <label for="server_name" class="col-sm-2 col-form-label">Название сервера</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="server_name" name="server_name" placeholder="Название сервера">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                           <input class="btn" name="sohranit" type="submit" value="Install" style="margin-top: 20px;">
                        </div>
                    </div>
                    </br>
                </form>
            </div>
        </div>
    </div>
</div>

