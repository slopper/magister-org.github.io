<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Список пользователей</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Пользователи</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
    <?php
        if($routes[1] == "edit"){
            if($_POST['name'] == 'newBalance'){
                $id = mysqli_real_escape_string($_MS_ID, $_POST['pk']);
                $val = mysqli_real_escape_string($_MS_ID, $_POST['value']);
                $query = "UPDATE `users` SET `balance` = '{$val}' WHERE `id` = '{$id}';";
                mysqli_query($_MS_ID, $query);
                return;
            }
        }
    ?>

    <form class="form-vertical" method="POST">
        <div class="input-group m-b">
            <input type="text" placeholder="ID пользователя" class="input-sm form-control" name="searchById">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-sm btn-primary" name='btnSearch' value="Искать">
            </span>
        </div>
        <div class="input-group m-b">
            <input type="text" placeholder="Имя из ВК" class="input-sm form-control" name="searchByVK">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-sm btn-primary" name='btnSearch' value="Искать">
            </span>
        </div>
    </form>

    <div class="white-bg">
        <table class="table table-stripped toggle-arrow-tiny" data-page-size="15">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя_ФамилияЖ</th>
                                <th>Рассылка сообщений</th>
                                <th>Баланс:</th>
                                <th>Покупок</th>
                                <th>Заказов:</th>
                                <th>Действия:</th>
                            </tr>
                        </thead>

            <tbody>
                <?php
                    $uInfo = "SELECT * FROM `users` ORDER BY `id` DESC LIMIT 20;";

                    if(isset($_POST['btnSearch'])){
                        if(strlen($_POST['searchById']) > 0){
                            $val = mysqli_real_escape_string($_MS_ID, $_POST['searchById']);
                            $uInfo = "SELECT * FROM `users` WHERE `id` = '{$val}';";
                        }
                        if(strlen($_POST['searchByVK']) > 0){
                            $val = mysqli_real_escape_string($_MS_ID, $_POST['searchByVK']);
                            $uInfo = "SELECT * FROM `users` WHERE `vkName` LIKE '%{$val}%';";
                        }
                    }

                    $uInfo = mysqli_query($_MS_ID, $uInfo);

                    while($user = mysqli_fetch_array($uInfo)) {
                        if($user['isInGroup'] == '1')
                            $vkGroupPM = "разрешил";
                        else
                            $vkGroupPM = "запретил";

                        echo "
                            <tr>
                                <td>ID: {$user['id']}</td>
                                <td>{$user['vkName']}</td>
                                <td>ЛС от группы: {$vkGroupPM}</td>
                                <td><a data-pk='{$user['id']}' class='ubal' href='#'>{$user['balance']}</a> руб.</td>
                                <td>На {$user['purchasesAmount']} руб.</td>
                                <td>{$user['purchasesCount']}</td>
                                <td>
                                    <a class='btn btn-info btn-xs' target='_blank' href='https://vk.com/id{$user['vkId']}'><i class='fa fa-vk'></i> VK</a>
                                    <a class='btn btn-info btn-xs' target='_blank' href='https://vk.me/{$user['vkId']}'><i class='fa fa-envelope'></i> PM</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        $('.ubal').editable({
                           type:  'text',
                           name:  'newBalance',
                           url:   '/users/edit',  
                           title: 'Баланс:'
                        });
    </script>
</div>