<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Редактирование новости</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Редактирование новости</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/news" class="btn btn-primary">Все новости</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <?php
            $id = mysqli_real_escape_string($_MS_ID, $routes[2]);

            if(isset($_POST['edit'])) {
				
                    $text = mysqli_real_escape_string($_MS_ID, $_POST['text']);

                    $query = "UPDATE `news` SET `text` = '{$text}' WHERE `id` = '{$id}';";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Новость успешно отредактирован");
                    else showMessage("warning", "При редактировании новости произошла ошибка");
                
            }

            $nInfo = "SELECT * FROM `news` WHERE `id` = '{$id}';";
            $nInfo = mysqli_get_query($nInfo);
        ?>
        <div class="ibox-title"><h5>Изменение новости</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Текст:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="text" value="<?=htmlspecialchars($nInfo['text'])?>" required="">
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
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <input id="sub_button" name="edit" class="btn btn-primary pull-right" type="submit" value="Подтвердить">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>