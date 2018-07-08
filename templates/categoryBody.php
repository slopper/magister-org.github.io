<?php

   $idCategory = mysqli_real_escape_string($_MS_ID, $routes[1]);
   $categoryInfo = "SELECT * FROM `category` WHERE `id` = '{$idCategory}';";
   $categoryInfo = mysqli_get_query($categoryInfo);

   if(is_null($categoryInfo)) showMessage("warning", "Извините, данная страница сейчас недоступна, повторите попытку позже");
   else {
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>Покупка товара</h5></div>
            <div class="ibox-content">
                <div class="results hidden animated fadeIn">
                    <div class='alert alert-warning' id="errorMsg"></div>
                    <div class="hr-line-dashed"></div>
                </div>
                <form class="form-horizontal" method="POST" id="formx" action="javascript:void(null);" onsubmit="sendOrderCategory()">
                <div class="form-group">
                        <label class="col-sm-2 control-label">Способ оплаты:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="method">
                                <option value="2">С баланса сайта</option>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Название:</label>
                        <div class="col-sm-10">
                            <div class="input-group m-b">
                                <p class="form-control-static"><?=$categoryInfo['name']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Стоимость:</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static"><?=$categoryInfo['priceRub']?> руб / шт.</p>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Количество:</label>
                        <div class="col-sm-10 m-b">
                            <input type="number" class="form-control" value="<?=$categoryInfo['minCount']?>" name="count" id="count" onchange="updatePrice(<?=$categoryInfo['priceRub']?>);" required>
                            <span class="help-block m-b-none">Минимальное количество — <?=min($categoryInfo['minCount'],$categoryInfo['count'])?> шт. Доступно всего для покупки — <?=$categoryInfo['count']?> шт.</span>
                                </p>
                                <p class="text-info"> <i class='fa fa-bolt'></i> Рекомендуемое количество не менее <?=$categoryInfo['advice']?> шт.</p>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Промокод:</label>
                        <div class="col-sm-10 m-b">
                            <input type="input" class="form-control" value="" name="promo" id="promo" placeholder="Оставьте пустым, если у вас его нет!">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Итоговая цена:</label>
                        <div class="col-sm-10">
                            <input type="text" disabled class="form-control" id="price" value="<?=$price?>">
                            <input type="hidden"" name="id" value="<?=$idCategory?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <div class="checkbox checkbox-success checkbox-inline">
                                <input type="checkbox" id="ruleCheck" value="rule" checked="checked">
                                <label for="ruleCheck">С <a href="/rules/" target="_blank">правилами</a> ознакомлен и полностью согласен.</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">                        
                        <div class="g-recaptcha col-sm-offset-2" data-sitekey="6Ld3nUQUAAAAAFs7ZABHJll0UyJbzDARV66WbY1-"></div>
                    </div>
                 
                    <div class="form-group">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4">
                            <input id="sub_button" name="buy" class="ladda-button btn btn-primary pull-right" type="submit" data-style="zoom-in" value="Подтвердить">
                            <a class="btn btn-white pull-right" href="javascript:history.back()">Отменить</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function sendOrderCategory() {
        var postData = $('#formx').serialize();
        $.ajax({
            dataType:'json',
            url:'/main/ajax/createOrderCategory.php',
            data:postData,
            type:'POST',
            success:function(data) {
                if(data.errorMsg!=null) {
                    $(".results").removeClass("hidden");
                    $("#errorMsg").html(data.errorMsg);
                    d = new Date();
                    grecaptcha.reset();
                } else {
                    window.location.href = location.protocol+'//'+location.hostname+"/order/"+data.idOrder;
                }
            }
        })
    }
</script>

<script>updatePrice(<?=$categoryInfo['priceRub']?>);</script>

<?php } ?>