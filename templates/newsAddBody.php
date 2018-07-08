<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Создание новости</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
            <li class="active">
                <strong>Создание новости</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/news" class="btn btn-primary">Список новостей</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <?php
            if(isset($_POST['text'])) {
               
                    $text = mysqli_real_escape_string($_MS_ID, $_POST['text']);
                    
                    $query = "INSERT INTO `news`(`text`) VALUES ('{$text}');";
                    if(mysqli_query($_MS_ID, $query)) showMessage("info", "Новость создана, ID — ".mysqli_insert_id($_MS_ID));
                    else showMessage("warning", "При добавлении новости произошла ошибка");
                
            }
        ?>
        <div class="ibox-title"><h5>Создание новости</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Текст:</label>
                    <div class="col-sm-10 m-b">
                        <input type="text" class="form-control" name="text" required="">
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