<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Настройка конфигураций</h2>
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
            if(isset($_POST['sellProducts'])) {
               
                    $titleInfo = mysqli_real_escape_string($_MS_ID, $_POST['titleInfo']);
                    $sellProducts = mysqli_real_escape_string($_MS_ID, $_POST['sellProducts']);
                    $countBuyers = mysqli_real_escape_string($_MS_ID, $_POST['countBuyers']);
                    $offlineMessage = mysqli_real_escape_string($_MS_ID, $_POST['offlineMessage']);
                    $sortMethod = mysqli_real_escape_string($_MS_ID, $_POST['sortMethod']);

                    if($_POST['offlineMode'] == TRUE) $offlineMode = ", `offlineMode` = 1";
                    else $offlineMode = ", `offlineMode` = 0";

                    $query = "UPDATE `main` SET `titleInfo` = '{$titleInfo}', `sellProducts` = '{$sellProducts}', `countBuyers` = '{$countBuyers}', `offlineMessage` = '{$offlineMessage}', `sortMethod` = '{$sortMethod}' {$offlineMode};";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Настройки успешно отредактированы");
                    else showMessage("warning", "При редактировании настроек произошла ошибка");
                
            }

            $settingsInfo = "SELECT * FROM `main`;";
            $settingsInfo = mysqli_get_query($settingsInfo);
        ?>
        <div class="ibox-title"><h5>Конфигурация сайта</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Сообщение в шапке:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="titleInfo" value="<?=$settingsInfo['titleInfo']?>" required="">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Продано товаров:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="sellProducts" value="<?=$settingsInfo['sellProducts']?>" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Всего покупателей:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="countBuyers" value="<?=$settingsInfo['countBuyers']?>" required="">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Сортировка при выдаче:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="sortMethod">
                            <option <?=$settingsInfo['sortMethod']?"selected":"";?> value="0">От старых к новым</option>
                            <option <?=$settingsInfo['sortMethod']?"selected":"";?> value="1">От новых к старым</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Сообщение</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="offlineMessage" value="<?=$settingsInfo['offlineMessage']?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10 m-b">
                        <div><label><input type="checkbox" name="offlineMode" value="true" <?php if($settingsInfo['offlineMode'] == 1) echo "checked" ?>> Отключить сайт ?</label></div>
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