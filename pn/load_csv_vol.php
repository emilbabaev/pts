<?
Header("Content-Type: text/html;charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
	class CSV {

		private $_csv_file = null;

		/**
		 * @param string $csv_file  - путь до csv-файла
		 */
		public function __construct($csv_file) {
			if (file_exists($csv_file)) { //Если файл существует
				$this->_csv_file = $csv_file; //Записываем путь к файлу в переменную
			}
			else { //Если файл не найден то вызываем исключение
				throw new Exception("Файл \"$csv_file\" не найден"); 
			}
		}

		public function setCSV(Array $csv) {
			//Открываем csv для до-записи, 
			//если указать w, то  ифнормация которая была в csv будет затерта
			$handle = fopen($this->_csv_file, "a"); 

			foreach ($csv as $value) { //Проходим массив
				//Записываем, 3-ий параметр - разделитель поля
				fputcsv($handle, explode(";", $value), ";"); 
			}
			fclose($handle); //Закрываем
		}

		/**
		 * Метод для чтения из csv-файла. Возвращает массив с данными из csv
		 * @return array;
		 */
		public function getCSV() {
			$handle = fopen($this->_csv_file, "r"); //Открываем csv для чтения

			$array_line_full = array(); //Массив будет хранить данные из csv
			//Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
			while (($line = fgetcsv($handle, 0, ";")) !== FALSE) { 
				$array_line_full[] = $line; //Записываем строчки в массив
			}
			fclose($handle); //Закрываем файл
			return $array_line_full; //Возвращаем прочтенные данные
		}

	}
	function db_fetch_array($result, $resulttype = MYSQLI_BOTH )
	{
	  return $result->fetch_array($resulttype);
	}
	//$csv = new CSV($_SERVER['DOCUMENT_ROOT']."/load/catalog.csv"); 
	$SQL = "SELECT `prod_vologda`.`name`, `prod_vologda`.`id`, `prod_vologda`.`price`, `prod_vologda`.`count_pallet`, `prod_vologda`.`weight`, `producer`.`name` as `producer_name`, `size`.`name` as `size_name`, `brand_strength`.`name` as `brand_strength_name`, `color`.`name` as `color_name`
	FROM `prod_vologda` 
	LEFT OUTER JOIN `producer` 
	ON `producer`.`id`=`prod_vologda`.`id_manufacturer`
	LEFT OUTER JOIN `size` 
	ON `size`.`id`=`prod_vologda`.`id_size`
	LEFT OUTER JOIN `brand_strength` 
	ON `brand_strength`.`id`=`prod_vologda`.`id_brand_strength`
	LEFT OUTER JOIN `color` 
	ON `color`.`id`=`prod_vologda`.`id_color`";
	$result = mysql_query($SQL);
	$handle = fopen($_SERVER['DOCUMENT_ROOT']."/load/catalog-vologda.csv", "w+");
	while($catalog = mysql_fetch_array($result)) {
		fputcsv($handle, array($catalog['id'], iconv("UTF-8", "Windows-1251", $catalog['name']), iconv("UTF-8", "Windows-1251", $catalog['size_name']), iconv("UTF-8", "Windows-1251", $catalog['count_pallet']), iconv("UTF-8", "Windows-1251", $catalog['producer_name']), iconv("UTF-8", "Windows-1251", str_replace(".", ",", $catalog['weight'])), iconv("UTF-8", "Windows-1251", $catalog['brand_strength_name']), iconv("UTF-8", "Windows-1251", $catalog['color_name']), str_replace(".", ",", $catalog['price'])), ";"); 
	}
	
	
?>

