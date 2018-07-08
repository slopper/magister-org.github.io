<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Весь товар</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Список товара</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/logs/product/transfer" class="btn btn-primary">Переместить товары</a>
            <a href="/logs/product/add" class="btn btn-primary">Добавить товар</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <?php
        if($routes[2] == "delete" && $routes[3] > 0) {
            if($_SESSION['confirm'] != $routes) {
                showMessage("danger", "Вы подтверджаете удаление товара(ID: {$routes[3]}) ? <hr/><a href='/{$routes[0]}/{$routes[1]}/{$routes[2]}/{$routes[3]}/confirm' class='btn btn-default pull-right'>Удалить товар</a><br/><br/>");
                $routes[4] = "confirm";
                $_SESSION['confirm'] = $routes;
            }
            else if($routes[4] == "confirm") {
                $id = mysqli_real_escape_string($_MS_ID, $routes[3]);
                $query = "DELETE FROM `product` WHERE `id` = '{$id}';";
                if(mysqli_query($_MS_ID, $query)) showMessage("info", "Товар(ID: {$id}) успешно удален");
            }
        }
    ?>
    <div id="shopTable" class="white-bg">
        <table class="table table-bordered">
            <tbody>
                <?php
                    $productInfo = "SELECT * FROM `product` ORDER BY `id` DESC LIMIT 100;";
                    $productInfo = mysqli_query($_MS_ID, $productInfo);

                    while($product = mysqli_fetch_array($productInfo)) {
                        if($product['status'] == 1) $status = "Оплачено для заказа #{$product['lastOrder']}";
                        else $status = "В продаже";

                        $product['text'] = substr($product['text'], 0, 80)."...";
                        echo "
                            <tr>
                                <td>ID: {$product['id']} / CAT: {$product['category']}</td> 
                                <td>{$product['text']}</td> 
                                <td class='text-center'>{$status}</td>
                                <td>
                                    <a class='btn btn-danger btn-xs pull-right' href='/logs/product/delete/{$product['id']}'><i class='fa fa-times'></i> DELETE</a>
                                    <a class='btn btn-warning btn-xs' href='/logs/product/edit/{$product['id']}'><i class='fa fa-pencil'></i> EDIT</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>