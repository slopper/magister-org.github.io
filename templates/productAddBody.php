<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Добавление товара</h2>
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
            <a href="/logs/product" class="btn btn-primary">Весь товар</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <?php
            if(isset($_FILES['filename'])) {
                if($_POST['captcha'] != $_SESSION['rand_code']) showMessage("warning", "Указан неверный проверочный код, повторите попытку");
                else {
                    if(!is_uploaded_file($_FILES["filename"]["tmp_name"])) showMessage("warning", "Ошибка при загрузке файла на сервер");
                    else {
                        move_uploaded_file($_FILES["filename"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/files/".$_FILES["filename"]["name"]);
                        $file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/files/".$_FILES["filename"]["name"]);

                        mb_detect_order("windows-1251,ansi,ascii,utf-8");
                        if(isset($_POST['isChancgeEncoding']) && $_POST['isChancgeEncoding'] == TRUE){
                            $file = iconv("windows-1251", "utf-8", $file);
                        }
                        $file = iconv(mb_detect_encoding($file, mb_detect_order(), true), "UTF-8", $file);;

                        $allText = explode("\n", $file);

                        $countProducts = 0;
                        foreach($allText as $text) {
                            if(strlen($text) < 3) continue;
                            $text = mysqli_real_escape_string($_MS_ID, $text);

                            if(isset($_POST['isLog']) && $_POST['isLog'] == TRUE) $text = substr_replace($text, null, 0, 20);
                            if($_POST['category'] == "auto") {
                                $categoryList = "SELECT `id`, `filterText` FROM `category`;";
                                $categoryList = mysqli_query($_MS_ID, $categoryList);
                                while($category = mysqli_fetch_array($categoryList)) {
                                    if(stristr($text, $category['filterText']) !== FALSE && $category['filterText'] != "_none_") {
                                        $idCategory = $category['id'];
                                        break 1;
                                    }
                                    else $idCategory = CATEGORY_ID_SHUFFLE;
                                }
                            } else $idCategory = mysqli_real_escape_string($_MS_ID, $_POST['category']);

                            $query = "INSERT INTO `product`(`category`, `text`) VALUES ('{$idCategory}', '{$text}');";
                            mysqli_query($_MS_ID, $query);

                            // если автоматическая сортировка, то добавлять товар еще и в смешанные, если его там нет
                            if($_POST['category'] == "auto" && $idCategory != CATEGORY_ID_SHUFFLE) {
                                $query = "INSERT INTO `product`(`category`, `text`) VALUES ('".CATEGORY_ID_SHUFFLE."', '{$text}');";
                                mysqli_query($_MS_ID, $query);
                            }
                            $countProducts++;
                        }

                        updateCountersCategories();
                        mysqli_query($_MS_ID, "UPDATE `main` SET `lastAdded` = NOW();");

                        if(isset($_POST['isVKFlood']) && $_POST['isVKFlood'] == TRUE)
                        {
							$url = "https://broadcast.vkforms.ru/api/v2/broadcast?token=api_24435_N1eQUYCIy05S1X1reTmJQ14D";
                            $content = json_encode(array(
                                'message' => array('message' => '
							        Привет 🖐🏻, у нас пополнение свежими логами! 🔥
                                Извини за беспокойство. 👼
								
								👉 Загляни - http://samp-products.ru 😉
								
								С уважением администрация сайта! 🍋
                                «автоматическая рассылка»'),
								'list_ids' => array(244361),  
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
                        }

                        showMessage("info", "Успешно добавлено {$countProducts} товаров в базу данных");
                    }
                }
            }
        ?>
        <div class="ibox-title"><h5>Добавление товара</h5></div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" id="formx" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Категория:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="category">
                            <option value="auto">Авто-определение</option>
                            <?php
                                $categoryList = "SELECT `id`, `name`, `filterText` FROM `category`;";
                                $categoryList = mysqli_query($_MS_ID, $categoryList);

                                while($category = mysqli_fetch_array($categoryList)) {
                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
            
                <div class="form-group">
                    <label class="col-sm-2 control-label">Список товара:</label>
                    <div class="col-sm-10 m-b">
                        <input type="file" class="form-control" name="filename" required="">
                        <span class="help-block m-b-none">Каждая строка считается как новый товар. Используйте кодировку UTF8 для файлов.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <div><label><input type="checkbox" name="isLog" value="true" checked> Убрать дату и время логов ?</label></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <div><label><input type="checkbox" name="isChancgeEncoding" value="false"> Преобразовать в <strong>UTF8</strong> ?</label></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <div><label><input type="checkbox" name="isVKFlood" value="false"> Отправлять рассылку в ВК ?</label></div>
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
                        <input name="buy" class="btn btn-primary pull-right" type="submit" value="Подтвердить">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>