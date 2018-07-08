<?php

    if($currentUser == null){
        redirect('/auth');
        return;
    }

    $idOrder = mysqli_real_escape_string($_MS_ID, $routes[1]);
    $orderInfo = "SELECT * FROM `orders` WHERE `id` = '{$idOrder}' AND `userId` = '{$currentUser['id']}';";
    $orderInfo = mysqli_get_query($orderInfo);

    if(is_null($orderInfo) || $orderInfo['category'] < 0) showMessage("warning", "Извините, данная страница сейчас недоступна, повторите попытку позже");
    else {
        $orderInfo = getOrderCategory($idOrder, $orderInfo);

        if($orderInfo['status'] == 1) $orderInfo['statusText'] = "Выдано";
        else $orderInfo['statusText'] = "Ожидает получения";
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>Заказ №<?=$orderInfo['id']?></h5></div>
            <div class="ibox-content">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Статус:</label>
                        <div class="col-sm-10 m-b has-info">
                            <input type="text" readonly class="form-control" value="<?=$orderInfo['statusText']?>">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Товар:</label>
                        <div class="col-sm-10 m-b">
                            <input type="text" readonly class="form-control" value="<?=$orderInfo['nameCategory']?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Количество:</label>
                        <div class="col-sm-10 m-b">
                            <input type="text" readonly class="form-control" value="<?=$orderInfo['count']?> шт.">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ваши логи:</label>
                        <div class="col-sm-10 m-b">
                            <textarea rows="12" warp="off" id="logsArea" readonly style="width: 100%; resize: none;" onclick="this.select()"><?=$orderInfo['logs']?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php } ?>