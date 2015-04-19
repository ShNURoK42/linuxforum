<div class="container">
    <div class="ads-box clearfix" style="margin: 10px 0 30px; color: #566579; padding: 0;">
        <div class="left">
            <?php require Yii::$app->basePath . '/ads/slibs/csKeysDb.php' ?>
            <?= csKeysDb::getBlock($_SERVER["REQUEST_URI"], 2) ?>
        </div>
        <div class="right" style="border-radius: 10px; color: #566579; border: 1px solid #cad7e1;">
            <ul style="margin: 10px; padding: 0; line-height: 1; font-size: 11px; list-style: outside none none;">
                <?php if (Yii::$app->controller->route == 'site/index'): ?>
                    <li><a href=http://www.zapravkairemont.ru>заправка картриджей hp</a></li>
                    <li>Профессиональная <a href=http://pchlp.ru/>компьютерная помощь на дому</a> в Москве</li>
                    <li><a href=http://www.bergab.ru>подшипники</a> для пользователей linux</li>
                    <li>Недорогие <a href=http://www.saletur.ru>горящие туры</a> на сайте SaleTur.ru</li>
                <?php else: ?>
                    <li>Продаем <a href=http://www.realxenon.ru/modules/shop/cat_188.html>камеры заднего вида</a> на все марки автомобилей</li>
                    <li><a href=http://www.bergab.ru>Подшипники</a> для пользователей linux</li>
                    <li>Купить <a href=http://elitpack.ru/>полиэтиленовые пакеты</a> с логотипом, производство пакетов</li>
                    <li>Мегаполис <a href=http://www.megapolistaxi.ru/>такси москва</a> - заказ такси дешево и быстро!</li>
                    <li>Недорогие <a href=http://www.saletur.ru>горящие туры</a> на сайте SaleTur.ru </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>