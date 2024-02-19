<div class="col-xs-12 position-manufacturers">
    <div class="col-xs-12 col-sm-6 col-md-4 title-block-manufacturers">
        <h2>Заводы-производители</h2>
        <p>Наши надежные партнеры, зарекомендовавшие себя на рынке.</p>
    </div>

    <? $result = mysql_query("SELECT * FROM `producer` WHERE `img` <> '' AND (SELECT COUNT(*) FROM `prod` WHERE `id_manufacturer` = `producer`.`id`) > 0");
    $count = mysql_num_rows($result);
    if ($count > 0) {
    $catalog = mysql_fetch_array($result);
    ?>
    <?
    do { ?>
    <div class="col-xs-12 col-sm-6 col-md-4 block-manufacturers">
        <a href="/brand/<?= $catalog['url'] ?>">
            <div class="img-block-manufacturers">
                <img src="/images/producer/<?= $catalog['img'] ?>" alt="<?= $catalog['name'] ?>">
                <span class="manufacturers-info" data-toggle="tooltip-1" data-placement="" title="Смотреть продукцию завода"></span>
            </div>
            <div class="text-block-manufacturers">
                <span><?= $catalog['name'] ?></span>
            </div>
        </a>
    </div>
    <? } while ($catalog = mysql_fetch_array($result));
        ?><?
    } ?>
</div>
