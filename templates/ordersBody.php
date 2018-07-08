<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Все заказы</h2>
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
            <?
                if($routes[2] == "stats") { ?> <a href="/logs/orders" class="btn btn-primary">Список заказов</a> <? }
                    else { ?> <a href="/logs/orders/stats" class="btn btn-primary">Статистика по заказам</a> <?}
            ?>
        </div>
    </div>
</div>

<?
if($routes[2] != "stats")  { ?>
<div class="wrapper wrapper-content">
    <?php
        if($routes[2] == "delete" && $routes[3] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Вы подтверджаете удаление заказа(ID: {$routes[3]}) ? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/{$routes[3]}/confirm' class='btn btn-default pull-right'>Удалить заказ</a><br/><br/>");
                $routes[4] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[4] == "confirm") {
                $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
                $query = "DELETE FROM `orders` WHERE `id` = '{$id}';";
                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Заказ(ID: {$id}) успешно удален");
            }
        }
    ?>

    <div class="row">
    	<form class="form-inline" method="POST">
    		<div class="form-group col-md-11">
    			<input type="text" name="searchtext" placeholder="ID заказа / ID пользователя" class="form-control" style="width: 100%;">			
    		</div>
    		<button class="btn btn-info col-md-1" name="search" type="submit">Поиск</button>
    	</form>
    </div>
    <hr>
    <div class="row white-bg">
        <table class="table table-bordered">
            <tbody>
                <?php
                    $ordersInfo = "SELECT * FROM `orders` ORDER BY `id` DESC LIMIT 50;";

                    if(isset($_POST['search'])){
                    	$txt = mysqli_real_escape_string($_MS_ID, $_POST['searchtext']);
                    	$ordersInfo = "SELECT * FROM `orders` WHERE `id` = '{$txt}' OR `userId` = '{$txt}' ORDER BY `id` DESC;";
                    }

                    $ordersInfo = mysqli_query($_MS_ID, $ordersInfo);

                    while($orders = mysqli_fetch_array($ordersInfo)) {
                        if($orders['status'] == 1) $status = "<span class='label label-primary'>Оплачено — {$orders['dateComplete']}</span>";
                        else $status = "<span class='label label-plain'>Не оплачено</span>";

                        $orders['text'] = substr($orders['text'], 0, 80)."...";
                        echo "
                            <tr>
                                <td>{$orders['id']}:{$orders['category']}</td> 
                                <td class='text-center'>{$orders['dateCreate']}</td> 
                                <td class='text-center'>User - {$orders['userId']}</td>
                                <td class='text-center'>{$orders['count']} шт</td>
                                <td class='text-center'>{$orders['price']} руб</td>
                                <td class='text-center'>{$status}</td>
                                <td>
                                    <a class='btn btn-danger btn-xs pull-right' href='/logs/orders/delete/{$orders['id']}'><i class='fa fa-times'></i> DELETE</a>
                                    <a class='btn btn-warning btn-xs' href='/logs/orders/edit/{$orders['id']}'><i class='fa fa-pencil'></i> EDIT</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?
} else {
?>
<div class="wrapper wrapper-content">


    <div class="ibox animated fadeIn">
        <div class="ibox-content">        
            <h1 class="text-center">Продано логов за последнию неделю(В рублях)</h1>        
            <canvas id="orderStat" height="100px"></canvas>
        </div>
    </div>

    <?
        function getColor($num) {
            $hash = md5('color' . $num);
            return array(
                hexdec(substr($hash, 0, 2)), 
                hexdec(substr($hash, 2, 2)), 
                hexdec(substr($hash, 4, 2)));
        }

        $aName = array();

        $catList = [];
        $catIdList = array();

        $aCount = array();
        $aColor = array();
        $countSum = 0; 

        $categoryInfo = "SELECT * FROM `category` WHERE `special` = 0 ORDER BY `id`;";
        $categoryInfo = mysqli_query($_MS_ID, $categoryInfo);

        while($category = mysqli_fetch_array($categoryInfo)){
            $catList[$category['id']] = [];
            $catList[$category['id']]['name'] = $category['name'];
            $catList[$category['id']]['count'] = 0;
            $color = getColor($category['count'] + rand(0,100));
            $catList[$category['id']]['color'] = "rgba({$color[0]}, {$color[1]}, {$color[2]}, 0.5)";
            array_push($catIdList, $category['id']);
        }

        for($i = 6; $i >= 0; $i--){
            $date = date('Y-m-d',strtotime(date('Y/m/d') . "-{$i} days"));
            $orders = mysqli_query($_MS_ID, "SELECT * FROM `orders` WHERE `dateComplete` LIKE '".$date."%';");

            while($order = mysqli_fetch_array($orders)){
                if(in_array($order['category'], $catIdList) && isset($catList[$order['category']])){
                    $catList[$order['category']]['count'] = $catList[$order['category']]['count'] + $order['price'];
                }
            }
        }

        foreach ($catList as $value){
            array_push($aName, $value['name']);
            array_push($aCount, $value['count']);
            array_push($aColor, $value['color']);
        }
    ?>

    <script>
        var ctx = document.getElementById("orderStat").getContext('2d');
        var myChart = Chart.PolarArea(ctx, {
            type: 'line',
            data: {
                labels: <?=json_encode($aName)?>,
                datasets: [{
                    label: 'Продано логов за последнию неделю',
                    data: <?=json_encode($aCount)?>,
                    backgroundColor: <?=json_encode($aColor)?>,
                }]
            },
            options: {
                legend: {
                    position: 'right',
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
</div>
<?
}