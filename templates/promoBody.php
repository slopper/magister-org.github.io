<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Промокоды</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Промокоды</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/shares/promo/add" class="btn btn-primary">Создать Промокод</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <?php
        if($routes[2] == "delete" && $routes[3] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Вы подтверджаете удаление промокода(ID: {$routes[3]}) ? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/{$routes[3]}/confirm' class='btn btn-default pull-right'>Удалить</a><br/><br/>");
                $routes[4] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[4] == "confirm") {
                $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
                $query = "DELETE FROM `promoCodes` WHERE `id` = '{$id}';";
                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Промокод(ID: {$id}) успешно удален");
            }
        }
    ?>

    <h1 class="text-center">Список Промокодов</h1>
    <br>

    <div id="shopTable" class="white-bg">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Код</td>
                    <td>Скидка</td>
                    <td>Остаток</td>
                    <td>Действия</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $pInfo = "SELECT * FROM `promoCodes` ORDER BY `id` DESC;";
                    $pInfo = mysqli_query($_MS_ID, $pInfo);

                    while($promo = mysqli_fetch_array($pInfo)) {
                        echo "
                            <tr>
                                <td>ID: {$promo['id']}</td> 
                                <td class='text-center'>{$promo['text']}</td> 
                                <td class='text-center'>Скидка - <a data-pk='{$promo['id']}' class='pdis' href='#'>{$promo['discount']}</a> %</td>
                                <td class='text-center'>Осталось - <a data-pk='{$promo['id']}' class='pcout' href='#'>{$promo['activeCount']}</a> шт.</td>
                                <td>
                                    <a class='btn btn-danger btn-xs' href='/shares/promo/delete/{$promo['id']}'><i class='fa fa-times'></i> DELETE</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>