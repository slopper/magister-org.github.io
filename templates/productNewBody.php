<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Добавление товара</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Список товара</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/logs/product" class="btn btn-primary">Весь товар</a>
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
                    $text = nl2br(mysqli_real_escape_string($_MS_ID, $_POST['text']));
                    
                    $query = "INSERT INTO `product`(`name`, `price`, `text`, `status`) VALUES ('{$name}', '{$price}', '{$text}', '2');";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Товар успешно добавлен, ID — ".mysqli_insert_id($_MS_ID));
                    else showMessage("warning", "При добавлении товара произошла ошибка");
                }
            }
        ?>
        <div class="ibox-title"><h5>Добавление товара</h5></div>
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

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Содержимое товара:</label>
                    <div class="col-sm-10">
                        <textarea rows="6" warp="off" class="form-control" name="text"></textarea>
                        <span class="help-block m-b-none">Текст который будет выдан покупателю после оплаты заказа.</span>
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