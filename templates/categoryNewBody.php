<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Новая категория</h2>
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
            if(isset($_POST['name'])) {
                if($_POST['captcha'] != $_SESSION['rand_code']) showMessage("warning", "Указан неверный проверочный код, повторите попытку");
                else {
                    $name = mysqli_real_escape_string($_MS_ID, $_POST['name']);
                    $price = mysqli_real_escape_string($_MS_ID, $_POST['price']);
                    $advice = mysqli_real_escape_string($_MS_ID, $_POST['advice']);
                    $filter = mysqli_real_escape_string($_MS_ID, $_POST['filter']);
                    $discount = mysqli_real_escape_string($_MS_ID, $_POST['discount']);
                    

                    $maxPlace = "SELECT MAX(`place`) FROM `category`;";
                    $maxPlace = mysqli_get_query($maxPlace);
                    $maxPlace = $maxPlace['MAX(`place`)'];
                    $maxPlace++;
                    
                    $query = "INSERT INTO `category`(`name`, `priceRub`, `place`, `filterText`, `discount`, `advice`) VALUES ('{$name}', '{$price}', '{$advice}', '{$maxPlace}', '{$filter}', '{$discount}');";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Категория успешно добавлена, ID — ".mysqli_insert_id($_MS_ID));
                    else showMessage("warning", "При добавлении категории произошла ошибка");
                }
            }
        ?>
        <div class="ibox-title"><h5>Добавление категории</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Название:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="name" required="">
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-sm-2 control-label">Цена:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="price" required="">
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Рекомендуемое число покупок(число):</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="advice" value="500" required="">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Текст для поиска:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="filter" value="">
                        <span class="help-block m-b-none">Текст который искать функции для авто-определения категории при добавлении товара.</span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Добавьте html-код скидки(если она нужна, если нет- то оставьте пустым):</label>
                    <div class="col-sm-10">
                       <textarea class="form-control" name="discount" cols="40" rows="5"  name="discount" value=""></textarea>
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