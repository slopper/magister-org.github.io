<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Все категории</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Список категорий</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/logs/category/new" class="btn btn-primary">Новая категория</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <?php
        $maxPlace = "SELECT MAX(`place`) FROM `category`;";
        $maxPlace = mysqli_get_query($maxPlace);
        $maxPlace = $maxPlace['MAX(`place`)'];

        if($routes[2] == "delete" && $routes[3] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Вы подтверджаете удаление категории(ID: {$routes[3]}) ? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/{$routes[3]}/confirm' class='btn btn-default pull-right'>Удалить категорию</a><br/><br/>");
                $routes[4] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[4] == "confirm") {
                $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
                $query = "DELETE FROM `category` WHERE `id` = '{$id}';";
                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Категория(ID: {$id}) успешно удалена");
            }
        } else if($routes[2] == "clear" && $routes[3] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Вы подтверджаете очищение категории(ID: {$routes[3]}) ? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/{$routes[3]}/confirm' class='btn btn-default pull-right'>Очистить категорию</a><br/><br/>");
                $routes[4] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[4] == "confirm") {
                $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
                $query = "DELETE FROM `product` WHERE `category` = '{$id}' AND (`lastOrder` = '-1' OR `lastOrder` = '0');";
                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Категория(ID: {$id}) успешно очищена");
                updateCountersCategories();
            }
        } else if($routes[2] == "down" && $routes[3] > 0 && $routes[4] > 0) {
            $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
            $place = mysqli_real_escape_string($_MS_ID, $routes[4]);
            $place++;
            mysqli_query($_MS_ID, "UPDATE `category` SET `place` = `place`-1 WHERE `place` = '{$place}';");
            mysqli_query($_MS_ID, "UPDATE `category` SET `place` = `place`+1 WHERE `id` = '{$id}';");

            redirect("/logs/category/");
        } else if($routes[2] == "up" && $routes[3] > 0 && $routes[4] > 0) {
            $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
            $place = mysqli_real_escape_string($_MS_ID, $routes[4]);
            $place--;
            mysqli_query($_MS_ID, "UPDATE `category` SET `place` = `place`+1 WHERE `place` = '{$place}';");
            mysqli_query($_MS_ID, "UPDATE `category` SET `place` = `place`-1 WHERE `id` = '{$id}';");

            redirect("/logs/category/");
        }
    ?>
    <div id="shopTable" class="white-bg">
        <table class="table table-bordered">
            <tbody>
                <?php

                    $categoryInfo = "SELECT * FROM `category` ORDER BY `place`;";
                    $categoryInfo = mysqli_query($_MS_ID, $categoryInfo);

                    while($category = mysqli_fetch_array($categoryInfo)) {
                        if($category['place'] == 1) $down = "disabled";
                        if($category['place'] == $maxPlace) $up = "disabled";
                        echo "
                            <tr>
                                <td>ID: {$category['id']}</td> 
                                <td>{$category['name']}</td> 
                                <td class='text-center'>{$category['priceRub']} RUB</td>
                                <td class='text-center'>{$category['count']} шт</td>
                                <td>
                                    <a class='btn btn-danger btn-xs pull-right' href='/logs/category/delete/{$category['id']}'><i class='fa fa-times'></i> DELETE</a>
                                    <a class='btn btn-danger btn-xs pull-right' style='margin-right: 5px;' href='/logs/category/clear/{$category['id']}'><i class='fa fa-trash'></i> CLEAR</a>
                                    <a class='btn btn-warning btn-xs' href='/logs/category/edit/{$category['id']}'><i class='fa fa-pencil'></i> EDIT</a>
                                </td>
                                <td style='max-width: 45px; min-width: 45px;'>
                                    <a class='btn btn-info btn-xs block-center {$up}' href='/logs/category/down/{$category['id']}/{$category['place']}'><i class='fa fa-arrow-down'></i></a>
                                    <a class='btn btn-info btn-xs block-center {$down}' href='/logs/category/up/{$category['id']}/{$category['place']}'><i class='fa fa-arrow-up'></i></a>
                                </td>
                            </tr>
                        ";
                        unset($up);
                        unset($down);
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>