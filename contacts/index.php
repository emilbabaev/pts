<?
session_start();
$title = "Контакты компании ООО «Кирпич на Гоголя 51» - Череповец";
$description = "Наши контакты: 162690, Вологодская обл., Череповец, ул. Гоголя, дом № 51. тел. 8 (8202) 52-90-93, сотовый 8 (921) 732-90-93. Пн-пт с 08:00 до 17:00";
$keywords = "Контакты";
include $_SERVER['DOCUMENT_ROOT']."/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT']."/data/header.html";
?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 breadcrumbs">
                <a href="index.html">Главная</a><span>Контакты</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="title-main">Контактная информация</h2>
            </div>

            <div class="col-xs-12 col-sm-5 maps-contacts">
                <div class="maps-border">
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A51d56d6cbf4a41888e985a94bef6a76a3ab562eefbe381e124bd87fb86c2be58&amp;width=100%25&amp;height=100%&amp;lang=ru_RU&amp;scroll=false"></script>
                </div>
            </div>

            <div class="col-xs-12 col-sm-7 info-contacts">
                <p>ИП Толстикова Ю.В</p>

                

                <a href="mailto:bricks35@mail.ru" class="link-mail">bricks35@mail.ru</a>

                <p>Юр. адрес: Россия, Вологодская область, г. Череповец,<br>
                    ул. Гоголя 51, индекс 162690</p>

                <div class="form-contacts">
                    <div class="title-form">
                        <h3>Обратная связь</h3>
                    </div>

                    <form id="formSend" onsubmit="yaCounter46843548.reachGoal('otpravil_zayvky');">
                        <input type="hidden" name="reply" value="Сообщение успешно отправлено.">
                        <input type="hidden" name="theme" value="Сообщение с сайта.">
                        <div class="row">
                            <div class="form-top-left form-group col-xs-12 col-sm-6">
                                <input type="text" name="name" class="form-control" placeholder="Имя" required>
                            </div>
                            <div class="form-top-right form-group col-xs-12 col-sm-6">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group col-xs-12">
                                <textarea name="text" class="form-control" rows="4" placeholder="Сообщение" required></textarea>
                            </div>
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn animated-button btn-yellow"><span>Отправить</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?
include $_SERVER['DOCUMENT_ROOT']."/data/footer.html";
?>