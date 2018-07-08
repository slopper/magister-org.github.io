<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Все заказы</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Жалобы</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">

    </div>
</div>

<div class="wrapper wrapper-content">
    <?php

        if($routes[2] == "close" && $routes[3] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Закрыть жалобу (ID: {$routes[3]}) ? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/{$routes[3]}/confirm' class='btn btn-default pull-right'>Готово</a><br/><br/>");
                $routes[4] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[4] == "confirm") {
                $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
                $query = "UPDATE `order_report` SET `status` = 1 WHERE `id` = '{$id}';";
                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Жалоба(ID: {$id}) убрана из списка.");
            }
        }
        if($routes[2] == "closeuser" && $routes[3] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Закрыть жалобу (ID: {$routes[3]}) в <strong>пользу пользователя</strong>? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/{$routes[3]}/confirm' class='btn btn-default pull-right'>Готово</a><br/><br/>");
                $routes[4] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[4] == "confirm") {
            	$id = mysqli_real_escape_string($_MS_ID, $routes[3]);

            	$repInfo = "SELECT * FROM `order_report` WHERE `id` = '{$id}';";
        		$repInfo = mysqli_get_query($repInfo);

        		$userInfo = getUserInfo($repInfo['userId']);
        		if($userInfo){

                    $url = "https://broadcast.vkforms.ru/api/v2/broadcast?token=api_27438_lw0PIJNTPuLGM9fIWubulasu";
                    $content = json_encode(array(
                        'message' => array('message' => "Вы получили замену на заказ № {$repInfo['orderId']}."),
                        'user_ids' => array($userInfo['vkId']),
                        'run_now' => '1'
                        ));
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER,
                            array("Content-type: application/json"));
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                    $json_response = curl_exec($curl);
                    curl_close($curl);

	          
	                $query = "UPDATE `order_report` SET `status` = 1 WHERE `id` = '{$id}';";
	                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Жалоба(ID: {$id}) закрыта, юзер оповещён.");
            	}else{
            		showMessage("warning", "Ошибка в поиске юзера.");
            	}
            }
        }
    ?>
    <div id="shopTable" class="white-bg">
        <table class="table table-bordered">
            <tbody>
                <?php
                    $repInfo = "SELECT * FROM `order_report` WHERE `status` = 0 ORDER BY `id` DESC;";
                    $repInfo = mysqli_query($_MS_ID, $repInfo);

                    while($report = mysqli_fetch_array($repInfo)) {
                        echo "
                            <tr>
                                <td>ID: {$report['id']}</td> 
                                <td class='text-center'>{$report['message']}</td> 
                                <td class='text-center'>User -  {$report['userId']}</td>
                                <td class='text-center'>
                                    <a class='btn btn-warning btn-xs' target='_blank' href='/logs/orders/edit/{$report['orderId']}'><i class='fa fa-pencil'></i> Открыть заказ</a>
                                </td>
                                <td>
                                    <a class='btn btn-xs btn-primary' href='/logs/reports/closeuser/{$report['id']}'><i class='fa fa-pencil'></i> Закрыть</a>
                                    <a class='btn btn-xs btn-danger' href='/logs/reports/close/{$report['id']}'><i class='fa fa-pencil'></i> Закрыть</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>