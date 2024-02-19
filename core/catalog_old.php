		<div class="catalog-content">
			<form id="formFilter" name="formFilter">
				<input type="hidden" name="page" id="page" value="1">
				<input type="hidden" name="priceMin" id="priceMin" value="0">
				<input type="hidden" name="parentId" value="<?if (isset($categoryParent) && $categoryParent == 0) {echo "0";}?>">
				<input type="hidden" id="id_prod" name="id_prod" value="<?if (isset($id_prod)) {echo $id_prod;}?>">
				<input type="hidden" name="priceMax" id="priceMax" value="<?if (isset($id_category)) {if (isset($categoryParent) && $categoryParent == 0) {$SQL = "SELECT MAX(`price`) as `priceMax` FROM `prod`, `category` WHERE `prod`.`id_category`=`category`.`id` and (`category`.`parentId`=".$id_category." or `category`.`id`=".$id_category.")";}else{$SQL = "SELECT MAX(`price`) as `priceMax` FROM `prod` WHERE `prod`.`id_category`=".$id_category."";}}else{$SQL = "SELECT MAX(`price`) as `priceMax` FROM `prod`";}$result = mysql_query($SQL);$catalog = mysql_fetch_array($result);echo $catalog['priceMax'];?>">
				<input type="hidden" name="limit" value="30">
				<input type="hidden" name="category" value="<?if (isset($id_category)) {echo $id_category;}?>">
				<div class="filtre">
					<div class="calc-header">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#filtre"><i class="icon-13"></i>Фильтр<i class="fa fa-caret-down"></i></a>
					</div>
					<div id="filtre" class="collapse">
						<div class="panel-body">
							<div class="top">
								<div class="row">
									<div class="col-sm-2" id="filtre-1">
										<div class="caption">Цвет</div>
										<ul class="item">
											<?
											if (isset($id_category)){
												if (isset($categoryParent) && $categoryParent == 0) {
													$SQL = "SELECT `color`.`id`, `color`.`text`, `color`.`name` FROM `color`, `prod`, `category` WHERE `prod`.`id_category`=`category`.`id` and `prod`.`id_color`=`color`.`id` and `category`.`parentId`=".$id_category." GROUP BY `color`.`id` ORDER BY `color`.`id` ASC LIMIT 0, 10";
												} else {
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
													<li><input type="checkbox" name="color_<?=$catalog['id']?>" class="checkbox" id="color_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);" /><label for="color_<?=$catalog['id']?>"><?=$catalog['name']?></label></li>
													<style>
													#color_<?=$catalog['id']?>:checked + label:before{border:2px solid #FF6400;}
													#color_<?=$catalog['id']?>:not(checked) + label:before{border:2px solid transparent;background:<?=$catalog['text']?>;}
													#color_<?=$catalog['id']?>:checked + label:after{content:'';}
													</style>
												<?} while($catalog = mysql_fetch_array($result));
											} else {?>
												<style>#filtre-1{display:none;}</style>
											<?}?>
										</ul>
									</div>
									<div class="col-sm-3" id="filtre-2">
										<div class="caption">Размер</div>
										<ul class="item">
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
													<li><input type="checkbox" name="size_<?=$catalog['id']?>" class="checkbox" id="size_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);" /><label for="size_<?=$catalog['id']?>"><?=$catalog['name']?></label></li>
												<?} while($catalog = mysql_fetch_array($result));
											} else {?>
												<style>#filtre-2{display:none;}</style>
											<?}?>
										</ul>
									</div>
									<div class="col-sm-4" id="filtre-3">
										<div class="caption">Производитель</div>
										<ul class="item">
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
													<li><input <?if (isset($id_brand) && $id_brand == $catalog['id']){?>checked<?}?> type="checkbox" name="producer_<?=$catalog['id']?>" class="checkbox" id="producer_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);" /><label for="producer_<?=$catalog['id']?>"><?=$catalog['name']?></label></li>
												<?} while($catalog = mysql_fetch_array($result));
											} else {?>
												<style>#filtre-3{display:none;}</style>
											<?}?>
										</ul>
									</div>
									<div class="col-sm-3" id="filtre-4">
										<div class="caption">Марка прочности</div>
										<ul class="item">
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
											$result = mysql_query($SQL);
											$count = mysql_num_rows($result);
											if ($count > 0) {
												$catalog = mysql_fetch_array($result);
												do {?>
													<li><input type="checkbox" name="brand_strength_<?=$catalog['id']?>" class="checkbox" id="brand_strength_<?=$catalog['id']?>" value="<?=$catalog['id']?>" onchange="load_Data(1);" /><label for="brand_strength_<?=$catalog['id']?>"><?=$catalog['name']?></label></li>
												<?} while($catalog = mysql_fetch_array($result));
											} else {?>
												<style>#filtre-4{display:none;}</style>
											<?}?>
										</ul>
									</div>
									<div class="clearfix"></div><br/>
									<div class="col-sm-2 range-price ">
										Цена, руб./шт
									</div>
									<div class="col-sm-10">
										<div class="form-group">
											<input type="text" id="range_03" name="range_03" value="" />
										</div>
									</div>
								</div>
								<button class="btn btn-main btn-4" type="button" onClick="refreshData();"><span>Сбросить настройки</span></button>
							</div>
							<div class="bottom"><br/></div>
						</div>
					</div>
				</div>
			</form>
				<div class="sort-content hidden">
					<div class="form-group sort hidden">
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn dropdown-toggle" data-placeholder="Сортировать по цене">Сортировать по цене<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><input type="radio" name="sort" id="sort_0" value=" `prod`.`price` ASC " onchange="load_Data(1);"><label for="sort_0">Цена по возрастанию</label></li>
								<li><input type="radio" name="sort" id="sort_1" value=" `prod`.`price` DESC " onchange="load_Data(1);"><label for="sort_1">Цена по убыванию</label></li>
							</ul>
						</div>
					</div>
					<div class="form-group price-list">
						
					</div>
					<div class="clearfix"></div>
				</div><br/>
				<div id="load-data" class="catalog-list">
					
				</div>
				<div id="load-img" class="text-center"><img src="/img/loading.gif" width="60" alt=""/></div>
				<div class="pagination-container"><div id="light-pagination" class="pagination light-theme simple-pagination"></div></div>
			
		</div>