<?php

use app\modules\module_page_malesex_stats\ext\MalesexStats;

$malesexStats = new MalesexStats();

$malesexStats->serverNum = isset($_COOKIE['SERVER_NUM']) ? $_COOKIE['SERVER_NUM']:$pdo->serverNum  ;

$raw = $malesexStats->getRecordsAll();

$new_raw = [];

foreach ($raw as $key => $value) {
    $img = "";

    $new_raw[$key] = $value;
    $steam_id = con_steam32to64($value['auth']);

    if ($General->arr_general['avatars']) {

        $src = $General->getAvatar($steam_id, 2);
        $img = "<img class='rounded-circle' id='{$steam_id}' src='{$src}'>";
    }

    if ($Modules->array_modules['module_page_profiles']['setting']['status'] === 1) {

        $link = $General->arr_general['site'] . 'profiles/' . $value['auth'] . '/' . $server_group;
        $new_raw[$key]['name'] = "<a href='{$link}' >{$value['name']}</a>";
    }

    $new_raw[$key]['avatar'] = $img;
}
$data = json_encode($new_raw);

?>

<link rel="stylesheet" href="/app/modules/module_page_malesex_stats/assets/css/style.css">
<link rel="stylesheet" href="/app/modules/module_page_malesex_stats/assets/css/jquery.dataTables.min.css">

<div class="row">
    <div class="col-md-12">
        <div class="card-cacheebaniy">
            <div class="card-header" style="margin-left: 15px">
                
                <div class="select-panel select-panel-table badge">
                    <select onchange="window.location.href = this.value">
                        <?php                   
                            foreach ($malesexStats->getDbOptons() as $key => $value) {
                                $url = $malesexStats->getUrl() . '/malesex_stats/?server_num=' . $key;
                                $selected = $malesexStats->serverNum == $key ? 'selected' : '';
                                echo "<option value='{$url}' {$selected} >{$value['SERVER_NAME']} </option>";
                            }
                        ?>
                        </option>
                    </select>
                </div>
                <a href="?action=settings"><button class="btn" style="float: right; margin-right: 15px;"><i class="zmdi zmdi-settings zmdi-hc-fw"></i></button></a>
            </div>
            <div class="blocks">
                <div class="loading-huevina scryta"></div>
                <div class="seryi-fon">
                    <div id="progress-wrp">
                        <div class="progress-bar hide"></div >
                    </div>
                    <div id="contents" class="block-2">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="malesex_stats_avatar"></th>
                                    <th><?= $malesexStats->trans('_NAME') ?></th>
                                    <th><?= $malesexStats->trans('_COUNT_SEX') ?></th>
                                    <th><?= $malesexStats->trans('_COUNT_CHILDREN') ?></th>
                                    <th><?= $malesexStats->trans('_COUNT_UNCHILDREN') ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Plugin file -->
<script src="/app/modules/module_page_malesex_stats/assets/js/datatables.min.js"></script>

<script>$(document).ready(function () {
                        $.noConflict();

                        var data = <?= $data ?>;

                        var table = $('#example').DataTable({
                            data: data,
                            bInfo : false,
                            "stateSave": true,
                            columns: [
                                {data: 'avatar'},
                                {data: 'name'},
                                {data: 'count_sex'},
                                {data: 'count_children'},
                                {data: 'count_unchildren'}
                            ],
                            language: {
                                "emptyTable": "<?= $malesexStats->trans('table_no_data') ?>",
                                "lengthMenu": "<?= $malesexStats->trans('lengthMenu') ?>",
                                "search": "<?= $malesexStats->trans('search') ?>:",
                                "paginate": {
                                    "next": "<?= $malesexStats->trans('next') ?>",
                                    "last": "<?= $malesexStats->trans('last') ?>",
                                    "first": "<?= $malesexStats->trans('first') ?>",
                                    "previous": "<?= $malesexStats->trans('previous') ?>"
                                }
                            }
                        });
                    });
</script>