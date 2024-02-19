<?
session_start();
$title = "Корзина товаров. Компания «Кирпич на Гоголя 51»";
$description = "Отправить заявку на заказ товара в компанию «Кирпич на Гоголя 51». Вы можете распечатать заказ или скачать файл заказа на компьютер для следующей покупки.";
$keywords = "Корзина, заказ кирпечей";
include $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
include $_SERVER['DOCUMENT_ROOT'] . "/data/header.html";
?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 breadcrumbs">
                <a href="/">Главная</a><span>Корзина</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="title-main">Корзина</h2>
            </div>

            <div class="col-xs-12 link-basket">
                <form id="printForm" action="/core/print_cart.php" method="POST">
                    <a href="javascript: $('#printForm').submit();"><img src="/img/svg/xls.svg"><span>Скачать файл заказа</span></a>
                </form>
                <a href="javascript:CallPrint('load-data');"><img src="/img/svg/print.svg"><span>Распечатать заказ</span></a>
            </div>

            <div id="load-data">
                <? include $_SERVER['DOCUMENT_ROOT'] . "/core/load_cart.php"; ?>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-gray-form">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-8 col-md-offset-2 form-data-order">
                        <h3 class="title-order">Заполните данные, чтобы оформить заказ</h3>
                        <form id="cartForm" onsubmit="yaCounter46843548.reachGoal('otpravil_zayvky');>
                            <div class="row">
                                <div class="col-xs-12 col-sm-5 form-data-left">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Имя" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" name="tel" class="form-control phone-mask" placeholder="Телефон" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-7 form-data-right">
                                    <div class="form-group">
                                        <textarea name="text" class="form-control" rows="4" placeholder="Комментарий" required></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn animated-button btn-yellow"><span>Отправить заявку</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?
include $_SERVER['DOCUMENT_ROOT'] . "/data/footer.html";
?>