<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Настройка оповещений</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Настройки сайта</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <?php
            if(isset($_POST['settingsSet'])) {
                
                    $indexText = mysqli_real_escape_string($_MS_ID, $_POST['indexText']);
                    $indexType = mysqli_real_escape_string($_MS_ID, $_POST['indexType']);


                    $query = "UPDATE `alerts` SET `index_text` = '{$indexText}', `index_type` = '{$indexType}';";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Настройки успешно отредактированы");
                    else showMessage("warning", "При редактировании настроек произошла ошибка");
                
            }

            $settingsInfo = "SELECT * FROM `alerts`;";
            $settingsInfo = mysqli_get_query($settingsInfo);
        ?>
        <div class="ibox-title"><h5>Настройка оповещений</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Сообщение на главной:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id='indexText' name="indexText" value="<?=htmlspecialchars($settingsInfo['index_text'])?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Тип:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="indexType">
                            <option <?=$settingsInfo['index_type'] == 'success' ? "selected" : "";?> value="success">Выполнено</option>
                            <option <?=$settingsInfo['index_type'] == 'info' ? "selected" : "";?> value="info">Информация</option>
                            <option <?=$settingsInfo['index_type'] == 'primary' ? "selected" : "";?> value="primary">Оповещение</option>
                            <option <?=$settingsInfo['index_type'] == 'warning' ? "selected" : "";?> value="warning">Оповещение (оранжевый)</option>
                            <option <?=$settingsInfo['index_type'] == 'danger' ? "selected" : "";?> value="danger">Ошибка (Красный)</option>
                        </select>
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
                        <input id="sub_button" name="settingsSet" class="btn btn-primary pull-right" type="submit" value="Подтвердить">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>