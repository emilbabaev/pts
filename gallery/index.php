<?
session_start();
$title = "Фото каминов и проектов печей для дома сложенных печниками в Череповце";
$description = "Услуги печника в Череповце. Работы с фото кладки печей из кирпича для частного дома и каминов для дачи с контактами печников.";
$keywords = "Галерея печей и каминов, услуги печника";
include $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT'] . "/data/header.html";
?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 breadcrumbs">
                <a href="/">Главная</a><span>Услуги печников</span>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="title-main">Услуги печников</h2>
            </div>

            <div class="col-xs-12 btn-data-services">
                <button class="btn animated-button btn-yellow" data-toggle="modal" data-target="#myModalGalleryAdd"><span>Добавить свои данные</span></button>
            </div>
        </div>

        <?php
        $SQL = "SELECT * FROM `gallery_category` ORDER BY `id`";
        $result_category = mysql_query($SQL);
        $count = mysql_num_rows($result_category);
        if ($count > 0) {
            $category = mysql_fetch_array($result_category);
            do {
                ?>
                <div class="row">
                    <?php
                    $SQL = "SELECT *, (SELECT name FROM city WHERE id = gallery.city_id) AS name_city FROM `gallery` WHERE status = 1 AND `category_id` = ".$category["id"]." ORDER BY name, id, tel, email DESC";
                    //die(var_dump($SQL));
                    //and `city_id`=".(!empty($city['id']) ? $city['id'] : '1')."
                    $result = mysql_query($SQL);
                    $count = mysql_num_rows($result);
                    if ($count > 0) {
                    $number_section = 0;
                    for ($i = 0;
                    $i < $count;
                    $i++) {

                    $name = $catalog['name'];
                    $tel = $catalog['tel'];
                    $catalog = mysql_fetch_array($result);
                    if ($catalog['name'] !== $name || $catalog['tel'] !== $tel) {
                        $number_section++;
                    ?></ul><?
                    ?>
                    <ul class="ul-specialist">
                        <div class="col-xs-12 col-md-6">
                            <div class="col-xs-12 card-specialist">
                                <div class="col-xs-12 col-sm-7 info-specialist">
                                    <img src="<?=(!empty($catalog['photo'])) ? $catalog['photo'] : '/img/svg/user.svg'?>">
                                    <p><?= $catalog['name'] ?></p>
                                    <span>г. <?= $catalog['name_city'] ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-5 phone-specialist">
                                    <span><img src="/img/svg/phone-specialist.svg"><?= $catalog['tel'] ?></span>
                                </div>
                                <div class="col-xs-12 photo-specialist">
                                    <div class="row block-photo-services">
                                        <div class="wrapper scrollbar-inner tooltip-2">
                                            <? }
                                            $imgs = explode("\n", $catalog['imgs']); ?>

                                            <? foreach ($imgs as $img): ?>
                                                <? if ($img != ""): ?>
                                                <a href="/images/gallery/<?= $img ?>" data-fancybox="group-<?= $number_section ?>">
                                                    <div class="div-photo-specialist" style="background: url('/images/gallery/s<?= $img ?>');"></div>
                                                    <span data-toggle="tooltip-2" data-placement="" title="Приблизить"></span>
                                                </a>
                                                    <? endif;?>
                                            <? endforeach; ?>

                                            <? } ?>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
                <?
            } while ($category = mysql_fetch_array($result_category));
        }
        ?>

<!--        <div class="row">-->
<!--            <div class="col-xs-12 text-info-specialist">-->
<!--                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
<!---->
<!--                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
<!---->
<!--                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
<!--            </div>-->
<!--        </div>-->
    </div>

<?
include $_SERVER['DOCUMENT_ROOT'] . "/data/footer.html";
?>