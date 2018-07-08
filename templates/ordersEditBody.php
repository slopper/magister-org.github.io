<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Редактирование заказа</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>История покупок</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/logs/orders" class="btn btn-primary">Все заказы</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <?php
            $id = mysqli_real_escape_string($_MS_ID, $routes[3]);

            if(isset($_POST['edit'])) {
                if(checkReCaptcha($_POST['g-recaptcha-response']) == false) showMessage("warning", "Указан неверный проверочный код, повторите попытку");
                else {
                    $userId = mysqli_real_escape_string($_MS_ID, $_POST['userId']);

                    $query = "UPDATE `orders` SET `userId` = '{$userId}' WHERE `id` = '{$id}';";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Заказ успешно отредактирован");
                    else showMessage("warning", "При редактировании заказа произошла ошибка");
                }
            }

            if(isset($_POST['reorder'])) {
                
                    $ordersInfo = "SELECT * FROM `orders` WHERE `id` = '{$id}';";
                    $ordersInfo = mysqli_get_query($ordersInfo);

                    $countLogsInCategory = mysqli_get_query("SELECT `count` FROM `category` WHERE `id` = '{$ordersInfo['category']}';")['count'];
                    if($countLogsInCategory < $ordersInfo['count']) showMessage("warning", "Недостаточно товара в категории, пополните базу");
                    else {
                        mysqli_query($_MS_ID, "UPDATE `product` SET `lastOrder` = '-1' WHERE `lastOrder` = '{$id}';");

                        $sort = "DESC";

                        $sql = "UPDATE `product` as t, \n"
                        . "(\n"
                        . " SELECT id\n"
                        . " FROM `product`\n"
                        . " WHERE `status` = 0 AND `category` = '{$ordersInfo['category']}'\n"
                        . " ORDER BY `id` DESC\n"
                        . " LIMIT {$ordersInfo['count']}\n"
                        . ") as temp\n"
                        . "SET `status` = 1, `lastOrder` = '{$id}' WHERE temp.id = t.id";
                        mysqli_query($_MS_ID, $sql);

                        mysqli_query($_MS_ID, "UPDATE `category` SET `count` = `count`-{$ordersInfo['count']} WHERE `id` = '{$ordersInfo['category']}';");
                        
                        showMessage("info", "Замена готова.");
                    }
                
            }

            $ordersInfo = "SELECT * FROM `orders` WHERE `id` = '{$id}';";
            $ordersInfo = mysqli_get_query($ordersInfo);

            $catName = mysqli_get_query("SELECT * FROM  `category` WHERE `id` = '{$ordersInfo['category']}';")['name'];
        ?>
        <div class="ibox-title"><h5>Изменение товара</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">User:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="userId" value="<?=$ordersInfo['userId']?>" required="">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Товар:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="count" value="<?=$catName?>" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Количество:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="count" value="<?=$ordersInfo['count']?>" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">К оплате:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="price" value="<?=$ordersInfo['price']?>" disabled>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <?php

                    $infoNicks = [];

                    if($ordersInfo['status'] == 1) { 
                        $getLogs = mysqli_query($_MS_ID, "SELECT `text` FROM `product` WHERE `lastOrder` = '{$id}';");
                        while($log = mysqli_fetch_array($getLogs, 1)) {                          
                            $sInfo = $log['text'];

                            preg_match_all('/Login: (\[|)(.*?)(\]|)\s/',$sInfo, $matches, PREG_SET_ORDER, 0);
                            $nick = $matches[0][2];
                            if(array_key_exists($nick,$infoNicks) == false){
                                $infoNicks[$nick] = array('nick' => $nick, 'count' => 0);
                            }
                            $infoNicks[$nick]['count'] += 1;

                            $logs .= $sInfo . PHP_EOL;
                        }
                ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <textarea rows="12" warp="off" readonly style="resize: none; width: 100%;"><?=$logs?></textarea>
                    </div>
                </div>

                <?php 
                    $floodWarningInfo = "";
                    foreach ($infoNicks as $key => $value) {
                        $percent = round(($value['count'] / $ordersInfo['count']) * 100);
                        if($percent >= 10)
                            $floodWarningInfo .= $value['nick'] . " - " . $percent . "% ";
                    }
                    if(strlen($floodWarningInfo) > 0){
                        ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Информация о флуде:</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled class="form-control" name="balance" value="<?=$floodWarningInfo?>" required="">
                                </div>
                            </div>
                        <?php
                    }
                ?>

                <div class="hr-line-dashed"></div>
                <?php } ?>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label"><img src="/main/captcha.php" id="captcha"></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="captcha" value="" placeholder="Enter captcha code here...">
                    </div>
                </div>

                
             
                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <input id="sub_button" name="reorder" class="btn btn-warning" type="submit" value="Замена">
                        <input id="sub_button" name="edit" class="btn btn-primary pull-right" type="submit" value="Подтвердить">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>