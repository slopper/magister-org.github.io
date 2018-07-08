<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Редактирование категории</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Список категорий</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/logs/category" class="btn btn-primary">Список категорий</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <?php
            $id = mysqli_real_escape_string($_MS_ID, $routes[3]);

            if(isset($_POST['name'])) {
                if($_POST['captcha'] != $_SESSION['rand_code']) showMessage("warning", "Указан неверный проверочный код, повторите попытку");
                else {
                    $name = mysqli_real_escape_string($_MS_ID, $_POST['name']);
                    $price = mysqli_real_escape_string($_MS_ID, $_POST['price']);
                    $advice = mysqli_real_escape_string($_MS_ID, $_POST['advice']);
                    $count = mysqli_real_escape_string($_MS_ID, $_POST['count']);
                    $minCount = mysqli_real_escape_string($_MS_ID, $_POST['minCount']);
                    $filter = mysqli_real_escape_string($_MS_ID, $_POST['filter']);
                    $discount = mysqli_real_escape_string($_MS_ID, $_POST['discount']);
                    $special = 0;
                    if(isset($_POST['isSpecial']) && $_POST['isSpecial'] == TRUE)
                        $special = 1;

                    if($count == "" || $count == 0) {
                        $count = "SELECT COUNT(*) FROM `product` WHERE `category` = {$id} AND `status` = 0;";
                        $count = mysqli_get_query($count);
                        $count = $count['COUNT(*)'];
                    }

                    $query = "UPDATE `category` SET `name` = '{$name}', `priceRub` = '{$price}', `count` = '{$count}', `minCount` = '{$minCount}', `special` = '{$special}', `filterText` = '{$filter}', `advice` = '{$advice}', `discount` = '{$discount}'  WHERE `id` = '{$id}';";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Категория успешно отредактирована");
                    else showMessage("warning", "При редактировании категории произошла ошибка");
                }
            }

            $categoryInfo = "SELECT * FROM `category` WHERE `id` = '{$id}';";
            $categoryInfo = mysqli_get_query($categoryInfo);
        ?>
        <div class="ibox-title"><h5>Изменение категории</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Название:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="name" value="<?=$categoryInfo['name']?>" required="">
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-sm-2 control-label">Цена:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="price" value="<?=$categoryInfo['priceRub']?>" required="">
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Рекомендуемое число покупок(число):</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="advice" value="500" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Количество:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="count" value="<?=$categoryInfo['count']?>">
                        <span class="help-block m-b-none">Оставьте поле пустым или укажите 0 чтобы система автоматически посчитала количество товара.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Минимальное количество для покупки:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="minCount" value="<?=$categoryInfo['minCount']?>">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <div><label><input type="checkbox" name="isSpecial" value="false" <? if($categoryInfo['special'] == 1) echo('checked');?> > Отдельный раздел ?</label></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Текст для поиска:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="filter" value="<?=$categoryInfo['filterText']?>">
                        <span class="help-block m-b-none">Текст который искать функции для авто-определения категории при добавлении товара(<strong>_none_</strong> - отключить поиск.).</span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Добавьте html-код скидки (если она нужна, если нет - то оставьте пустым):</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="discount" cols="40" rows="5" value="<button class="btn btn-sm btn-primary pull-right"> <?=$categoryInfo['discount']?></textarea>
						 <span class="help-block m-b-none">Пример html-кода: <strong>&lt;button class="btn btn-sm btn-primary pull-right"&gt;СКИДКА 50 &lt;i class="fa fa-percent" aria-hidden="true"&gt;&lt;/i&gt;&lt;/button&gt;</strong></span>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><img src="/main/captcha.php" id="captcha"></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="captcha" value="" placeholder="Enter captcha code here...">
                    </div>
                </div>
             
                <div class="form-group">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4">
                        <input id="sub_button" name="buy" class="btn btn-primary pull-right" type="submit" value="Подтвердить">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>