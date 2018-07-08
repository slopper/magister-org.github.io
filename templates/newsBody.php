<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Новости</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Новости</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/news/add" class="btn btn-primary">Добавить новость</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <?php
        if($routes[1] == "delete" && $routes[2] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Вы подтверджаете удаление новости(ID: {$routes[2]}) ? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/confirm' class='btn btn-default pull-right'>Удалить</a><br/><br/>");
                $routes[3] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[3] == "confirm") {
                $id = mysqli_real_escape_string($_MS_ID, $routes[2]);
                $query = "DELETE FROM `news` WHERE `id` = '{$id}';";
                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Новость (ID: {$id}) успешно удален");
            }
        }
    ?>

    <h1 class="text-center">Список</h1>
    <br>

    <div id="shopTable" class="white-bg">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Дата</td>
                    <td>Запись</td>
                    <td>Действия</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $nInfo = "SELECT * FROM `news` ORDER BY `id` DESC;";
                    $nInfo = mysqli_query($_MS_ID, $nInfo);

                    while($n = mysqli_fetch_array($nInfo)) {
                        $txt = htmlspecialchars(substr($n['text'], 0,40)) . "...";
                        echo "
                            <tr>
                                <td>ID: {$n['id']}</td> 
                                <td class='text-center'>{$n['date']}</td> 
                                <td>{$txt}</td>
                                <td>
                                    <a class='btn btn-warning btn-xs' href='/news/edit/{$n['id']}'><i class='fa fa-pencil'></i> EDIT</a>
                                    <a class='btn btn-danger btn-xs pull-right' href='/news/delete/{$n['id']}'><i class='fa fa-times'></i> DELETE</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>