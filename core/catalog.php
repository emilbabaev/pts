<!--фильтр-->
<div class="container">
    <div class="row">
        <div class="col-sm-5 col-md-4 col-lg-3 filter-price">
            <form id="formFilter" name="formFilter">
                <a class="link-filter" href="javascript:refreshData();">Сбросить настройки</a>

                <input type="hidden" name="page" id="page" value="1">
                <input type="hidden" name="priceMin" id="priceMin" value="0">
                <input type="hidden" name="parentId" value="<?if (isset($categoryParent) && $categoryParent == 0) {echo "0";}?>">
                <input type="hidden" id="id_prod" name="id_prod" value="<?if (isset($id_prod)) {echo $id_prod;}?>">
                <input type="hidden" name="priceMax" id="priceMax" value="<?if (isset($id_category)) {if (isset($categoryParent) && $categoryParent == 0) {$SQL = "SELECT MAX(`price`) as `priceMax` FROM `prod`, `category` WHERE `prod`.`id_category`=`category`.`id` and (`category`.`parentId`=".$id_category." or `category`.`id`=".$id_category.")";}else{$SQL = "SELECT MAX(`price`) as `priceMax` FROM `prod` WHERE `prod`.`id_category`=".$id_category."";}}else{$SQL = "SELECT MAX(`price`) as `priceMax` FROM `prod`";}$result = mysql_query($SQL);$catalog = mysql_fetch_array($result);echo $catalog['priceMax'];?>">
                <input type="hidden" name="limit" value="30">
                <input type="hidden" name="category" value="<?if (isset($id_category)) {echo $id_category;}?>">

                <div class="panel-group" id="filtre">
                    <div class="panel panel-default" id="filtre-0">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="js-collapsed" href="#sort-filter">
                                    Сортировка<img src="/img/svg/arrow-filter.svg">
                                </a>
                            </h4>
                        </div>
                        <div id="sort-filter" class="panel-collapse collapse in js-in">
                            <div class="panel-body">
                                <div class="divSelect">
                                    <select class="sortSelect" name="sort" onchange="load_Data(1);">
                                        <option value="">По умолчанию</option>
                                        <option value="1/2">По убыванию цены</option>
                                        <option value="1/1">По возрастанию цены</option>
                                        <option value="2/2">Новые позиции</option>
                                        <option value="2/1">Старые позиции</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="filtre-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="js-collapsed" href="#color-filter">
                                    Цвет<img src="/img/svg/arrow-filter.svg">
                                </a>
                            </h4>
                        </div>
                        <div id="color-filter" class="panel-collapse collapse in js-in">
                            <div class="panel-body">
                                <?
                                if (isset($id_category)){
                                    if (isset($categoryParent) && $categoryParent == 0) {
                                        $SQL = "SELECT `color`.`id`, `color`.`text`, `color`.`name` FROM `color`, `prod`, `category` WHERE `prod`.`id_category`=`category`.`id` and `prod`.`id_color`=`color`.`id` and `category`.`parentId`=".$id_category." GROUP BY `color`.`id` ORDER BY `color`.`id` ASC LIMIT 0, 10";
                                    }
                                    else {
                                        $SQL = "SELECT `color`.`id`, `color`.`text`, `color`.`name` FROM `color`, `prod` WHERE `prod`.`id_color`=`color`.`id` and `prod`.`id_category`=".$id_category." GROUP BY `color`.`id` ORDER BY `color`.`id` ASC LIMIT 0, 10";
                                    }
                                } else {
                                    $SQL = "SELECT * FROM `color` ORDER BY `id` ASC LIMIT 0, 10";
                                }
                                $result = mysql_query($SQL);
                                $count = mysql_num_rows($result);
                                if ($count > 0) {
                                    $catalog = mysql_fetch_array($result);
                                    do {?>
                                        <label class="label">
                                            <input class="checkbox" type="checkbox" name="color_<?=$catalog['id']?>" id="color_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);" >
                                            <span class="checkbox-custom" style="background: <?=($catalog["name"] == 'Многоцветные') ? 'url(/img/svg/color-filter.svg)' : $catalog["text"] ;?>" title="<?=$catalog["name"]?>"></span>
                                        </label>
                                    <?} while($catalog = mysql_fetch_array($result));
                                } else {?>
                                    <style>#filtre-1{display:none;}</style>
                                <?}?>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="filtre-2">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="js-collapsed" href="#size-filter">
                                    Размер<img src="/img/svg/arrow-filter.svg">
                                </a>
                            </h4>
                        </div>
                        <div id="size-filter" class="panel-collapse collapse in js-in">
                            <div class="panel-body">
                                <?
                                if (isset($id_category)){
                                    if (isset($categoryParent) && $categoryParent == 0) {
                                        $SQL = "SELECT `size`.`id`, `size`.`name` FROM `size`, `prod`, `category` WHERE `prod`.`id_category`=`category`.`id` and  `prod`.`id_size`=`size`.`id` and `category`.`parentId`=".$id_category." GROUP BY `size`.`id` ORDER BY `size`.`id` DESC";
                                    } else {
                                        $SQL = "SELECT `size`.`id`, `size`.`name` FROM `size`, `prod` WHERE `prod`.`id_size`=`size`.`id` and `prod`.`id_category`=".$id_category." GROUP BY `size`.`id` ORDER BY `size`.`id` DESC";
                                    }
                                } else {
                                    $SQL = "SELECT * FROM `size` ORDER BY `id` DESC";
                                }
                                $result = mysql_query($SQL);
                                $count = mysql_num_rows($result);
                                if ($count > 0) {
                                    $catalog = mysql_fetch_array($result);
                                    do {?>
                                        <label class="label">
                                            <input class="checkbox" type="checkbox" name="size_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);">
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-name"><?=$catalog['name']?></span>
                                        </label>
                                    <?} while($catalog = mysql_fetch_array($result));
                                } else {?>
                                    <style>#filtre-2{display:none;}</style>
                                <?}?>



                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="filtre-3">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="js-collapsed" href="#manufacturer-filter">
                                    Производитель<img src="/img/svg/arrow-filter.svg">
                                </a>
                            </h4>
                        </div>
                        <div id="manufacturer-filter" class="panel-collapse collapse in js-in">
                            <div class="panel-body">
                                <?
                                if (isset($id_category)){
                                    if (isset($categoryParent) && $categoryParent == 0) {
                                        $SQL = "SELECT `producer`.`id`, `producer`.`name` FROM `producer`, `prod`, `category` WHERE `prod`.`id_category`=`category`.`id` and  `prod`.`id_manufacturer`=`producer`.`id` and (`category`.`parentId`=".$id_category." or `category`.`id`=".$id_category.") GROUP BY `producer`.`id` ORDER BY `producer`.`id` DESC";
                                    } else {
                                        $SQL = "SELECT `producer`.`id`, `producer`.`name` FROM `producer`, `prod` WHERE `prod`.`id_manufacturer`=`producer`.`id` and `prod`.`id_category`=".$id_category." GROUP BY `producer`.`id` ORDER BY `producer`.`id` DESC";
                                    }
                                } else {
                                    $SQL = "SELECT * FROM `producer` ORDER BY `id` DESC";
                                }
                                $result = mysql_query($SQL);
                                $count = mysql_num_rows($result);
                                if ($count > 0) {
                                    $catalog = mysql_fetch_array($result);
                                    do {?>
                                        <label class="label">
                                            <input <?if (isset($id_brand) && $id_brand == $catalog['id']){?>checked<?}?> class="checkbox" type="checkbox" name="producer_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);">
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-name"><?=$catalog['name']?></span>
                                        </label>
                                    <?} while($catalog = mysql_fetch_array($result));
                                } else {?>
                                    <style>#filtre-3{display:none;}</style>
                                <?}?>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="filtre-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="js-collapsed" href="#mark-filter">
                                    Марка<img src="/img/svg/arrow-filter.svg">
                                </a>
                            </h4>
                        </div>
                        <div id="mark-filter" class="panel-collapse collapse in js-in">
                            <div class="panel-body">
                                <?

                                if (isset($id_category)){
                                    if (isset($categoryParent) && $categoryParent == 0) {
                                        $SQL = "SELECT `brand_strength`.`id`, `brand_strength`.`name` FROM `brand_strength`, `prod`, `category` WHERE `prod`.`id_category`=`category`.`id` and `prod`.`id_brand_strength`=`brand_strength`.`id` and `category`.`parentId`=".$id_category." GROUP BY `brand_strength`.`id` ORDER BY `brand_strength`.`id` DESC";
                                    } else {
                                        $SQL = "SELECT `brand_strength`.`id`, `brand_strength`.`name` FROM `brand_strength`, `prod` WHERE `prod`.`id_brand_strength`=`brand_strength`.`id` and `prod`.`id_category`=".$id_category." GROUP BY `brand_strength`.`id` ORDER BY `brand_strength`.`id` DESC";
                                    }
                                } else {
                                    $SQL = "SELECT * FROM `brand_strength` ORDER BY `id` DESC";
                                }
                                // var_dump($SQL);
                                $result = mysql_query($SQL);
                                $count = mysql_num_rows($result);
                                if ($count > 0) {
                                    $catalog = mysql_fetch_array($result);
                                    do {?>
                                        <label class="label">
                                            <input class="checkbox" type="checkbox" name="brand_strength_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);">
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-name"><?=$catalog['name']?></span>
                                        </label>
                                    <?} while($catalog = mysql_fetch_array($result));
                                } else {?>
                                    <style>#filtre-4{display:none;}</style>
                                <?}?>
                            </div>
                        </div>
                    </div>

                    <div style="display: none">
                        <input type="hidden" id="range_03" name="range_03" value="" />
                    </div>
                </div>
            </form>
        </div>


        <div class="col-sm-7 col-md-8 col-lg-9 price-filter">
            <div id="load-data"><!--каталог загружается из load_catalog.php-->

            </div>

            <div class="col-xs-12 nav-price" id="light-pagination"></div>
        </div>
    </div>
</div>