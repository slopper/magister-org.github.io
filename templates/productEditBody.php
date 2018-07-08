<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Редактирование товара</h2>
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
            $id = mysqli_real_escape_string($_MS_ID, $routes[3]);

            if(isset($_POST['name'])) {
                if($_POST['captcha'] != $_SESSION['rand_code']) showMessage("warning", "Указан неверный проверочный код, повторите попытку");
                else {
                    $text = mysqli_real_escape_string($_MS_ID, $_POST['text']);
                    $category = mysqli_real_escape_string($_MS_ID, $_POST['category']);

                    $query = "UPDATE `product` SET `text` = '{$text}', `category` = '{$category}' WHERE `id` = '{$id}';";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Товар успешно отредактирован");
                    else showMessage("warning", "При редактировании товара произошла ошибка!");
                }
            }

            $productInfo = "SELECT * FROM `product` WHERE `id` = '{$id}';";
            $productInfo = mysqli_get_query($productInfo);
        ?>
        <div class="ibox-title"><h5>Изменение товара</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Текст:</label>
                    <div class="col-sm-10 m-b">
                        <textarea rows="6" class="form-control" name="name"><?=$productInfo['text']?></textarea>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-sm-2 control-label">Категория:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="category" value="<?=$productInfo['category']?>" required="">
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