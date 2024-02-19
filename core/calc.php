<div class="calc">
	<div class="calc-header">
		<a class="accordion-toggle <?if (!isset($calc_open)) {?>collapsed<?}?>" data-toggle="collapse" data-parent="#accordion2" href="#calc"><i class="icon-12"></i>Рассчитать количество кирпича<i class="fa fa-caret-down"></i></a>
	</div>
	<div id="calc" class="collapse <?if (isset($calc_open)) {?>in<?}?>">
		<div class="panel-body">
			<form name="calcForm" id="calcForm">
				<div class="top">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">Толщина стены</div>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn dropdown-toggle" data-placeholder="Выберите поле">в 0,5 кирпича<span class="caret fa fa-chevron-down"></span></button>
										<ul class="dropdown-menu">
											<li><input type="radio" name="calc_wall_width" id="width_wall_0" checked value="0.5"><label for="width_wall_0">в 0,5 кирпича</label></li>
											<li><input type="radio" name="calc_wall_width" id="width_wall_1" value="1"><label for="width_wall_1">в 1 кирпич</label></li>
											<li><input type="radio" name="calc_wall_width" id="width_wall_1_5" value="1.5"><label for="width_wall_1_5">в 1,5 кирпича</label></li>
											<li><input type="radio" name="calc_wall_width" id="width_wall_2" value="2"><label for="width_wall_2">в 2 кирпича</label></li>
											<li><input type="radio" name="calc_wall_width" id="width_wall_2_5" value="2.5"><label for="width_wall_2_5">в 2,5 кирпича</label></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">Площадь / объем</div>
									<input type="text" class="form-control floatNumber" name="calc_area" value="1">
									<div class="input-group-calc">
										<div class="btn-group">
											<button data-toggle="dropdown" class="btn dropdown-toggle" data-placeholder="Выберите поле">м²<span class="caret fa fa-chevron-down"></span></button>
											<ul class="dropdown-menu">
												<li><input type="radio" name="calc_area_type" id="calc_area_type_0" checked value="1"><label for="calc_area_type_0">м²</label></li>
												<li><input type="radio" name="calc_area_type" id="calc_area_type_1" value="2"><label for="calc_area_type_1">м³</label></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">Типоразмер кирпича</div>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn dropdown-toggle" data-placeholder="Выберите поле">одинарный<span class="caret fa fa-chevron-down"></span></button>
										<ul class="dropdown-menu">
											<li><input type="radio" name="calc_size" id="calc_size_1" checked value="1"><label for="calc_size_1">одинарный</label></li>
											<li><input type="radio" name="calc_size" id="calc_size_0" value="1.5"><label for="calc_size_0">утолщенный</label></li>
											<li><input type="radio" name="calc_size" id="calc_size_2" value="2"><label for="calc_size_2">двойной</label></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">Учитывать толщину<br/>раствора</div>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn dropdown-toggle" data-placeholder="Выберите поле">да<span class="caret fa fa-chevron-down"></span></button>
										<ul class="dropdown-menu">
											<li><input type="radio" name="calc_with_thickness_cement" id="calc_with_thickness_cement_0" value="0"><label for="calc_with_thickness_cement_0">нет</label></li>
											<li><input type="radio" name="calc_with_thickness_cement" id="calc_with_thickness_cement_1" checked value="1"><label for="calc_with_thickness_cement_1">да</label></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<button class="btn btn-main btn-4" type="button" onClick="calc();$('.result .btn-4').show(); yaCounter35844745.reachGoal('rasschet'); return true;"><span>Рассчитать <i class="icon-5"></i></span></button>
				</div>
				<div class="bottom">
					<div class="result">Количество кирпичей: <span class="count-brick">0</span> шт. 
					<a class="btn btn-main btn-4" style="display: none;" href="javascript: void(0)" onClick="if ($('.count-brick').text() != '0') {$('#myModalCalc').modal(); $('#count_k').val($('.count-brick').text());}else{alert('Необходимо расчитать кол-во кирпича');} yaCounter35844745.reachGoal('rasschet-predvaritelnoi-stoimosti'); return true;"><span>Рассчитать предварительную стоимость <i class="icon-5"></i></span></a></div>
				</div>
			</form>
		</div>
	</div>
</div>