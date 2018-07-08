<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Логи оплаты</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Логи</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
  

    <form class="form-vertical" method="POST">
        <div class="input-group m-b">
            <input type="text" placeholder="ID пользователя" class="input-sm form-control" name="searchById">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-sm btn-primary" name='btnSearch' value="Искать">
            </span>
        </div>
    </form>

    <div class="white-bg">
        <table class="table table-stripped toggle-arrow-tiny" data-page-size="15">
                        <thead>
                            <tr>
                                <th>ID пользователя</th>
                                <th>Сумма</th>
                                <th>Дата создания платежа</th>
                                <th>Дата оплаты платежа</th>
                                <th>Статус</th>
                            </tr>
                        </thead>

            <tbody>
                <?php
                    $uInfo = "SELECT * FROM `freekassa_payments` ORDER BY `id` DESC LIMIT 30;";
					
					
					if(isset($_POST['btnSearch'])){
                        if(strlen($_POST['searchById']) > 0){
                            $val = mysqli_real_escape_string($_MS_ID, $_POST['searchById']);
                            $uInfo = "SELECT * FROM `freekassa_payments` WHERE `account` = '{$val}';";
                        }
                        if(strlen($_POST['searchByVK']) > 0){
                            $val = mysqli_real_escape_string($_MS_ID, $_POST['searchByVK']);
                            $uInfo = "SELECT * FROM `users` WHERE `vkName` LIKE '%{$val}%';";
                        }
                    }

                    $uInfo = mysqli_query($_MS_ID, $uInfo);

                    while($pay = mysqli_fetch_array($uInfo)) {

                        echo "
                            <tr>
                                <td>ID: {$pay['account']}</td>
                                <td>{$pay['sum']} рублей</td>
                                <td>{$pay['dateCreate']}</td>
                                <td>{$pay['dateComplete']}</td>
                                <td>{$pay['status']}</td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>