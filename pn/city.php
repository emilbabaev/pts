<?
session_start();
Header("Content-Type: text/html;charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT'] . "/pn/classSimpleImage.php";
include $_SERVER['DOCUMENT_ROOT'] . "/pn/url_translit.php";
$title = "Регионы";
include $_SERVER['DOCUMENT_ROOT'] . "/pn/header.html";
if (!isset($_SESSION["user_id"]))
{
?></br><p align="center"><font color="red">Вы не вошли под своим именем</font></p><?
include $_SERVER['DOCUMENT_ROOT'] . "/pn/footer.html";
exit;
}
$table = 'city';
$page_url = 'city';
$title_page = $title;
if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/images/" . $page_url)) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/images/" . $page_url, 0777);
}
if (isset($_GET['del'])) {
    $sql = "DELETE FROM `" . $table . "` WHERE `id` = " . $_GET['del'] . "";
    mysqli_query($link, $sql); // Используйте $link вместо $sql
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 0;
}
$count_data = $page * 20;

$SQL = "SELECT * FROM `" . $table . "`";
$result = mysqli_query($link, $SQL);

$count_base = mysqli_num_rows($result);
$count_page = ceil($count_base / 20);
?>
<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<?
if (isset($_GET['edit']))
{
include $_SERVER['DOCUMENT_ROOT'] . "/pn/editorFull.php";
$SQL = "SELECT * FROM `" . $table . "` WHERE `id`=" . $_GET['edit'] . "";

$result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
mysqli_data_seek($result, 0);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$name = $row['name'];
$tel = $row['tel'];
$addr = $row['addr'];
$lat = $row['lat'];
$lon = $row['lon'];
$work = $row['work'];
$footer = $row['footer'];
$contacts = $row['contacts'];
$caption = $row['caption'];
// Продолжение вашего кода...
?>

    <div class="header">

        <h1 class="page-title"><? echo $title_page; ?></h1>
        <ul class="breadcrumb">
            <li><a href="/pn/">Главная</a></li>
            <li><a href="/pn/<? echo $page_url; ?>.php"><? echo $title_page; ?></a></li>
            <li class="active">Изменить</li>
        </ul>

    </div>
<div class="main-content">
    <div class="row">
        <div class="col-md-12">

            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                    <form id="tab" name="tab" action="/pn/<? echo $page_url; ?>.php" method="post"
                          enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input id="cur_id_city" type="text" value="<? echo $name; ?>" name="name"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Название в п.п.</label>
                                    <input type="text" value="<? echo $caption; ?>" name="caption" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Телефон</label>
                                    <input type="text" value="<? echo $tel; ?>" name="tel" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Адрес</label>
                                    <input id="cur_addr" type="text" value="<? echo $addr; ?>" name="addr"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Рабочее время</label>
                                    <textarea name="work" class="form-control mceEditor"><? echo $work; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Контакты в футере</label>
                                    <textarea name="footer"
                                              class="form-control mceEditor"><? echo $footer; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Контактная информация</label>
                                    <textarea name="contacts"
                                              class="form-control mceEditor"><? echo $contacts; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <p>Место на карте
                                    <p/>
                                    <div id="map-yandex-Company" style="width:100%; height:300px"></div>
                                </div>
                                <input type="hidden" name="lat" value="<? echo $lat; ?>"><input type="hidden" name="lon"
                                                                                                value="<? echo $lon; ?>">
                            </div>
                        </div>

                </div>
            </div>

            <div class="btn-toolbar list-toolbar">
                <input type="submit" class="btn btn-primary" value="Изменить">
                <a href="/pn/<? echo $page_url; ?>.php" class="btn btn-danger">Отмена</a>
                <input type="hidden" name="edit_data" value="<? echo $id; ?>">
                </form>
            </div>
        </div>
    </div>
    <script>
        ymaps.ready(init);
        var myMap;

        function init() {
            var myPlacemark,
                myMap = new ymaps.Map('map-yandex-Company', {
                    center: [59.129986, 37.913123],
                    zoom: 9
                }, {
                    searchControlProvider: 'yandex#search'
                });
            <?if ($lat != 0) {?>
            myMap.setCenter([<?echo $lat;?>, <?echo $lon;?>], 15, {checkZoomRange: true});
            myPlacemark1 = new ymaps.Placemark([<?echo $lat;?>, <?echo $lon;?>], {
                iconContent: '',
                balloonContent: '',
                hintContent: '<?echo $name;?>'
            }, {
                iconLayout: 'default#image',
                iconImageHref: '/img/map.png',
                iconImageSize: [112, 55],
                iconImageOffset: [0, -55]
            });
            myMap.geoObjects.add(myPlacemark1);
            <?}?>
            // Слушаем клик на карте
            myMap.events.add('click', function (e) {
                var coords = e.get('coords');
                document.tab.lat.value = coords[0].toPrecision(6);
                document.tab.lon.value = coords[1].toPrecision(6);
                // Если метка уже создана – просто передвигаем ее
                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function () {
                        getAddress(myPlacemark.geometry.getCoordinates());
                    });
                }
                getAddress(coords);
            });

            // Создание метки
            function createPlacemark(coords) {
                return new ymaps.Placemark(coords, {
                    iconContent: 'поиск...'
                }, {
                    preset: 'islands#violetStretchyIcon',
                    draggable: true
                });
            }

            // Определяем адрес по координатам (обратное геокодирование)
            function getAddress(coords) {
                myPlacemark.properties.set('iconContent', 'поиск...');
                ymaps.geocode(coords).then(function (res) {
                    var firstGeoObject = res.geoObjects.get(0);

                    myPlacemark.properties
                        .set({
                            iconContent: firstGeoObject.properties.get('name'),
                            balloonContent: firstGeoObject.properties.get('text')
                        });
                });
            }

            $("#cur_addr").change(function () {
                var myGeocoder = ymaps.geocode($('#cur_id_city').val() + " " + $("#cur_addr").val());
                myGeocoder.then(
                    function (res) {
                        coords = res.geoObjects.get(0).geometry.getCoordinates();
                        myMap.setCenter([coords[0], coords[1]], 16, {checkZoomRange: true});
                        document.tab.lat.value = coords[0].toPrecision(6);
                        document.tab.lon.value = coords[1].toPrecision(6);
                        // Если метка уже создана – просто передвигаем ее
                        if (myPlacemark) {
                            myPlacemark.geometry.setCoordinates(coords);
                        }
                        // Если нет – создаем.
                        else {
                            myPlacemark = createPlacemark(coords);
                            myMap.geoObjects.add(myPlacemark);
                            // Слушаем событие окончания перетаскивания на метке.
                            myPlacemark.events.add('dragend', function () {
                                getAddress(myPlacemark.geometry.getCoordinates());
                            });
                        }
                        getAddress(coords);
                    },
                    function (err) {
                        alert('Ошибка');
                    }
                );
            });
        }

        function delete_element_img(img, id, number) {
            document.getElementById(img + '_' + number).style.display = 'none';
            $.ajax({
                url: "/pn/delete_element_img.php",
                type: "POST",
                data: {"img": img, "id": id, "number": number, "table": '<?echo $table;?>'},
                cache: false,
                success: function (response) {
                    if (response == 0) {
                    } else {

                    }
                }
            });
        }
    </script>
    <?
    
    }
    else
    {
    if (isset($_GET['add']))
    {
    include $_SERVER['DOCUMENT_ROOT'] . "/pn/editorFull.php";
    ?>
    <div class="header">

        <h1 class="page-title"><? echo $title_page; ?></h1>
        <ul class="breadcrumb">
            <li><a href="/pn/">Главная</a></li>
            <li><a href="/pn/<? echo $page_url; ?>.php"><? echo $title_page; ?></a></li>
            <li class="active">Добавить данные</li>
        </ul>

    </div>
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="home">
                        <form id="tab" name="tab" action="/pn/<? echo $page_url; ?>.php" method="post"
                              enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Название</label>
                                        <input id="cur_id_city" type="text" value="<? echo $name; ?>" name="name"
                                               class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Название в п.п.</label>
                                        <input type="text" value="<? echo $caption; ?>" name="caption"
                                               class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Телефон</label>
                                        <input type="text" value="<? echo $tel; ?>" name="tel" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Адрес</label>
                                        <input id="cur_addr" type="text" value="<? echo $addr; ?>" name="addr"
                                               class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Рабочее время</label>
                                        <textarea name="work"
                                                  class="form-control mceEditor"><? echo $work; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Контакты в футере</label>
                                        <textarea name="footer"
                                                  class="form-control mceEditor"><? echo $footer; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Контактная информация</label>
                                        <textarea name="contacts"
                                                  class="form-control mceEditor"><? echo $contacts; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <p>Место на карте
                                        <p/>
                                        <div id="map-yandex-Company" style="width:100%; height:300px"></div>
                                    </div>
                                    <input type="hidden" name="lat" value=""><input type="hidden" name="lon" value="">
                                </div>
                            </div>

                    </div>
                </div>

                <div class="btn-toolbar list-toolbar">
                    <input type="submit" class="btn btn-primary" value="Добавить">
                    <a href="/pn/<? echo $page_url; ?>.php" class="btn btn-danger">Отмена</a>
                    <input type="hidden" name="add_data">
                    </form>
                </div>
            </div>
        </div>
        <script>

            ymaps.ready(init);
            var myMap;

            function init() {
                var myPlacemark,
                    myMap = new ymaps.Map('map-yandex-Company', {
                        center: [55.753994, 37.622093],
                        zoom: 12
                    }, {
                        searchControlProvider: 'yandex#search'
                    });

                var myGeocoder = ymaps.geocode("Череповец");
                myGeocoder.then(
                    function (res) {
                        //alert('Координаты объекта :' + res.geoObjects.get(0).geometry.getCoordinates());
                        coord = res.geoObjects.get(0).geometry.getCoordinates();
                        myMap.setCenter([coord[0], coord[1]], 12, {checkZoomRange: true});
                    },
                    function (err) {
                        alert('Ошибка');
                    }
                );

                // Слушаем клик на карте
                myMap.events.add('click', function (e) {
                    var coords = e.get('coords');
                    document.tab.lat.value = coords[0].toPrecision(6);
                    document.tab.lon.value = coords[1].toPrecision(6);
                    // Если метка уже создана – просто передвигаем ее
                    if (myPlacemark) {
                        myPlacemark.geometry.setCoordinates(coords);
                    }
                    // Если нет – создаем.
                    else {
                        myPlacemark = createPlacemark(coords);
                        myMap.geoObjects.add(myPlacemark);
                        // Слушаем событие окончания перетаскивания на метке.
                        myPlacemark.events.add('dragend', function () {
                            getAddress(myPlacemark.geometry.getCoordinates());
                        });
                    }
                    getAddress(coords);
                });

                // Создание метки
                function createPlacemark(coords) {
                    return new ymaps.Placemark(coords, {
                        iconContent: 'поиск...'
                    }, {
                        preset: 'islands#violetStretchyIcon',
                        draggable: true
                    });
                }

                // Определяем адрес по координатам (обратное геокодирование)
                function getAddress(coords) {
                    myPlacemark.properties.set('iconContent', 'поиск...');
                    ymaps.geocode(coords).then(function (res) {
                        var firstGeoObject = res.geoObjects.get(0);

                        myPlacemark.properties
                            .set({
                                iconContent: firstGeoObject.properties.get('name'),
                                balloonContent: firstGeoObject.properties.get('text')
                            });
                    });
                }

                $("#cur_addr").change(function () {
                    var myGeocoder = ymaps.geocode($('#cur_id_city').val() + " " + $("#cur_addr").val());
                    myGeocoder.then(
                        function (res) {
                            coords = res.geoObjects.get(0).geometry.getCoordinates();
                            myMap.setCenter([coords[0], coords[1]], 16, {checkZoomRange: true});
                            document.tab.lat.value = coords[0].toPrecision(6);
                            document.tab.lon.value = coords[1].toPrecision(6);
                            // Если метка уже создана – просто передвигаем ее
                            if (myPlacemark) {
                                myPlacemark.geometry.setCoordinates(coords);
                            }
                            // Если нет – создаем.
                            else {
                                myPlacemark = createPlacemark(coords);
                                myMap.geoObjects.add(myPlacemark);
                                // Слушаем событие окончания перетаскивания на метке.
                                myPlacemark.events.add('dragend', function () {
                                    getAddress(myPlacemark.geometry.getCoordinates());
                                });
                            }
                            getAddress(coords);
                        },
                        function (err) {
                            alert('Ошибка');
                        }
                    );
                });
            }
        </script>
        <?
        
        }
        else
        {
        
        ?>
        <div class="header">

            <h1 class="page-title"><? echo $title_page; ?></h1>
            <ul class="breadcrumb">
                <li><a href="/pn/">Главная</a></li>
                <li class="active"><? echo $title_page; ?></li>
            </ul>

        </div>
        <div class="main-content">
            
            <?
            
            if (isset($_POST['add_data'])) {
                $url = str2url($_POST['name']);
                $SQL = "INSERT INTO " . $table . "(
                  `id` ,
                 `name`,
                  `tel`,
                  `addr`,
                  `lat`,
                  `lon`,
                  `footer`,
                  `work`,
                  `contacts`,
                  `caption`
                                                    )
    VALUES (NULL, '" . mysqli_real_escape_string($link, $_POST['name']) . "', '" . mysqli_real_escape_string($link, $_POST['tel']) . "', '" . mysqli_real_escape_string($link, $_POST['addr']) . "', '" . mysqli_real_escape_string($link, $_POST['lat']) . "', '" . mysqli_real_escape_string($link, $_POST['lon']) . "', '" . mysqli_real_escape_string($link, $_POST['footer']) . "', '" . mysqli_real_escape_string($link, $_POST['work']) . "', '" . mysqli_real_escape_string($link, $_POST['contacts']) . "', '" . mysqli_real_escape_string($link, $_POST['caption']) . "');";
                
                $result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
                if ($result) {
                    echo "<p>Данные добавлены</p>";
                } else {
                    echo "<p>Ошибка при добавлении данных</p>";
                }
            }
            if (isset($_POST['edit_data'])) {
                $url = str2url($_POST['name']);
                
                
                $SQL = "UPDATE " . $table . " SET
    `tel`='" . mysqli_real_escape_string($link, $_POST['tel']) . "',
    `addr`='" . mysqli_real_escape_string($link, $_POST['addr']) . "',
    `lat`='" . mysqli_real_escape_string($link, $_POST['lat']) . "',
    `lon`='" . mysqli_real_escape_string($link, $_POST['lon']) . "',
    `footer`='" . mysqli_real_escape_string($link, $_POST['footer']) . "',
    `contacts`='" . mysqli_real_escape_string($link, $_POST['contacts']) . "',
    `work`='" . mysqli_real_escape_string($link, $_POST['work']) . "',
    `caption`='" . mysqli_real_escape_string($link, $_POST['caption']) . "',
    `name`='" . mysqli_real_escape_string($link, $_POST['name']) . "'
    WHERE `id`=" . $_POST['edit_data'] . ";";
                
                $result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
                if ($result) {
                    echo "<p>Данные изменены</p>";
                } else {
                    echo "<p>Ошибка при изменении данных</p>";
                }
            }
            $SQL = "SELECT * FROM `" . $table . "` ORDER BY `id` DESC LIMIT " . $count_data . ", 20";
            $result = mysqli_query($link, $SQL); // Используйте $link вместо $SQL
            
            $count = mysqli_num_rows($result);
            
            ?>

            <div class="btn-toolbar list-toolbar">
                <button class="btn btn-primary" onClick="location.href='/pn/<? echo $page_url; ?>.php?add'"><i
                            class="fa fa-plus"></i> Добавить данные
                </button>
                <div class="btn-group">
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th style="width: 3.5em;"></th>
                    <th style="width: 3.5em;"></th>
                </tr>
                </thead>
                <tbody>
                
                <?
                for ($i = 0; $i < $count; ++$i) {
                    mysqli_data_seek($result, $i);
                    $row = mysqli_fetch_assoc($result);
                    $id = $row['id'];
                    $name = $row['name'];
                    $tel = $row['tel'];
                    $addr = $row['addr'];
                    ?>

                    <tr>
                        <td><? echo $id; ?></td>
                        <td><? echo $name; ?></td>
                        <td><? echo $tel; ?></td>
                        <td><? echo $addr; ?></td>
                        <td>
                            <a href="/pn/<? echo $page_url; ?>.php?edit=<? echo $id; ?>"><i
                                        class="fa fa-pencil"></i></a>
                        </td>
                        <td>
                            <a href="/pn/<? echo $page_url; ?>.php?page=<? echo $page; ?>&del=<? echo $id; ?>"><i
                                        class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    <?
                } ?>
                </tbody>
            </table>

            <ul class="pagination">
                <li><a href="/pn/<? echo $page_url; ?>.php?page=<? if ($page > 0) {
                        echo($page - 1);
                    } else {
                        echo '0';
                    } ?>">&laquo;</a></li>
                <?
                for ($i = 0; $i < $count_page; ++$i) {
                    ?>
                    <li><a href="/pn/<? echo $page_url; ?>.php?page=<? echo $i; ?>"><? if ($i == $page) {
                                echo "<b>" . ($i + 1) . "</b>";
                            } else {
                                echo($i + 1);
                            } ?></a></li>
                    <?
                }
                ?>
                <li><a href="/pn/<? echo $page_url; ?>.php?page=<? if ($page < ($count_page - 1)) {
                        echo($page + 1);
                    } else {
                        echo($count_page - 1);
                    } ?>">&raquo;</a></li>
            </ul>
            <?
            }
            } ?>


<?

include $_SERVER['DOCUMENT_ROOT'] . "/pn/footer.html";
?>