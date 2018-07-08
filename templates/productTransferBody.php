<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Переместить товары</h2>
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
            if(isset($_POST['from'])) {
                if($_POST['captcha'] != $_SESSION['rand_code']) showMessage("warning", "Указан неверный проверочный код, повторите попытку");
                else {
                    $from = mysqli_real_escape_string($_MS_ID, $_POST['from']);
                    $to = mysqli_real_escape_string($_MS_ID, $_POST['to']);

                    if($from == "none" || $to == "none" || $from == $to) showMessage("warning", "Неправильно выбранны категории перемещения");
                    else {
                        if(isset($_POST['onlySells']) && $_POST['onlySells'] == TRUE) $status = "AND `status` = 1";

                        $query = "UPDATE `product` SET `category` = '{$to}' WHERE `category` = '{$from}' {$status};";
                        if(mysqli_query($_MS_ID, $query)) showMessage("info", "Товары успешно перемещены");
                        else showMessage("warning", "При изменении категории товара произошла ошибка");

                        updateCountersCategories();
                    }
                }
            }

            $productInfo = "SELECT * FROM `product` WHERE `id` = '{$id}';";
            $productInfo = mysqli_get_query($productInfo);
        ?>
        <div class="ibox-title"><h5>Перемещение товара</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Из:</label>
                    <div class="col-sm-10 m-b">
                        <select class="form-control" name="from">
                            <option value="none">--------------</option>
                            <?php
                                $categoryList = "SELECT `id`, `name`, `filterText` FROM `category`;";
                                $categoryList = mysqli_query($_MS_ID, $categoryList);

                                while($category = mysqli_fetch_array($categoryList)) {
                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-sm-2 control-label">В:</label>
                    <div class="col-sm-10 m-b">
                        <select class="form-control" name="to">
                            <option value="none">--------------</option>
                            <?php
                                $categoryList = "SELECT `id`, `name`, `filterText` FROM `category`;";
                                $categoryList = mysqli_query($_MS_ID, $categoryList);

                                while($category = mysqli_fetch_array($categoryList)) {
                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10 m-b">
                        <div><label><input type="checkbox" name="onlySells" value="true" checked> Только проданные ?</label></div>
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