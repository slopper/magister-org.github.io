<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Создание купона</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Добавление купона</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/shares/voucher" class="btn btn-primary">Список купонов</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <?php
            if(isset($_POST['name'])) {
                
                    $name = mysqli_real_escape_string($_MS_ID, $_POST['name']);
                    $count = mysqli_real_escape_string($_MS_ID, $_POST['count']);
                    $balance = mysqli_real_escape_string($_MS_ID, $_POST['balance']);

                    
                    $query = "INSERT INTO `vouchers`(`voucher`, `activeCount`, `balance`) VALUES ('{$name}', '{$count}', '{$balance}');";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Купон создан, ID — ".mysqli_insert_id($_MS_ID));
                    else showMessage("warning", "При добавлении купона произошла ошибка");
                
            }
        ?>
        <div class="ibox-title"><h5>Добавление купона</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Код:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="name" required="">
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-sm-2 control-label">Количество активаций:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="count" value="3" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Баланс:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="balance" value="10" required="">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                 <div class="form-group">
                    <label class="col-sm-2 control-label"><img src="/main/captcha.php" id="captcha"></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="captcha" value="" placeholder="Enter captcha code here...">
                    </div>
                </div>
             
                <div class="form-group">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4">
                        <input id="sub_button" name="buy" class="btn btn-primary pull-right" type="submit" value="Добавить">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>