<div class="ibox animated fadeIn">
	<div class="ibox-content">
        <?
            $alert = mysqli_get_query('SELECT * FROM `alerts`;');
            if(strlen($alert['index_text']) > 0){
                ?>
                    <div class="alert alert-<?=$alert['index_type']?>">
                        <?=$alert['index_text']?>
                    </div>
                <?
            }
        ?>
		<p><a href="/">SAMP-PRODUCTS.RU</a> — Не знаете, где купить логи и окупиться? Мы предлагаем нашим покупателям исключительно качественные логи и аккаунты на всех крупных проектах, как Diamond Role Play, Advance Role Play, Arizona Role Play, Evolve Role Play, Grand Role Play, Samp Role Play, Luxe Role Play, Revent Role Play, Pears Project, Samp Virtual Life, Trinity Role Play! В нашем магазине имеется возможность приобретения смешанных логов, где вы находятся аккаунты совершенно с разных проектов. После оплаты Вы сразу же получите свой товар, так как мы используем автоматическую систему выдачи. На сайте работает круглосуточная тех. поддержка, которая рада вам помочь!</p>
        <p>Приятные цены, ежедневное пополнение товаром и частые скидки для наших клиентов. У каждого есть возможность получить хорошие аккаунты логов, а именно с деньгами, имуществом, занимающие лидерские посты, административные должности и высокие ранги в организациях! Мы являемся лидерами продаж данных продуктов, благодаря качеству наших товаров.</p>
	</div>
</div>

<div class="ibox animated fadeIn">
	<div class="ibox-content">
		<h1 class="text-center">Логи SAMP</h1>
		<table class="table table-bordered">
            <thead>
            	<tr>
					<th class="text-center col-md-6">Название товара</th>
					<th class="text-center col-md-1">Количество</th>
					<th class="text-center col-md-2">Цена за еденицу</th>
                    <th class="text-center col-md-2">Цена за тысячу</th>
					<th class="text-center col-sm-1"></th>
            	</tr>
            </thead>
            <tbody>
            <?php
                $CATS = "SELECT * FROM `category` WHERE `special` = 0 ORDER BY `place`;";
                $CATS = mysqli_query($_MS_ID, $CATS);
                while($category = mysqli_fetch_array($CATS, 1)) {
                    $price = $category['priceRub'] * 1000;
                    echo "
                        <tr>
                           <td id='rowShow'>{$category['name']}<c>{$category['discount']}</c></td>
                           <td id='rowShow' class='hidden-xs text-center'>{$category['count']} шт.</td> 
                           <td id='rowShow' class='text-center'><strong><green>{$category['priceRub']}</green></strong> ₽</span></td>
                           <td id='rowShow' class='text-center'><strong><green>{$price}</green></strong> ₽</span></td>
                           <td id='rowShop'><a class='btn btn-sm btn-primary' href='/category/{$category['id']}'>Купить</a></td>
                        </tr>
                    ";
                }
            ?>               
            </tbody>
        </table>
		 <center><h3 class="label label-success">Последнее пополнение — <?=$_INFORMERS['lastAdded']?> МСК</center>
 	</div>
</div>
      
  
    
<div class="ibox animated fadeIn">
	<div class="ibox-content">
        <h1 class="text-center">Остальные товары</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center col-md-6">Название товара</th>
                    <th class="text-center col-md-1">Количество</th>
                    <th class="text-center col-md-4">Цена</th>
                    <th class="text-center col-md-1"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $CATS = "SELECT * FROM `category` WHERE `special` = 1 ORDER BY `place`;";
                $CATS = mysqli_query($_MS_ID, $CATS);
                while($category = mysqli_fetch_array($CATS, 1)) {
                    echo "
                        <tr>
                           <td id='rowShow'>{$category['name']}</td> 
                           <td id='rowShow' class='hidden-xs text-center'>{$category['count']} шт.</td> 
                           <td id='rowShow' class='text-center'><strong><green>{$category['priceRub']}</green></strong> ₽</span></td>
                           <td id='rowShop'><a class='btn btn-sm btn-primary' href='/category/{$category['id']}'>Купить</a></td>
                        </tr>
                    ";
                }
            ?>               
            </tbody>
        </table>
	</div>
</div>

<div class="ibox animated fadeInUp">
	<div class="ibox-content">
		<h1 class="text-center">Отзывы покупателей</h1><br/>
		<div id="vk_comments"></div>
		<script type="text/javascript">
		VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
		</script>
	</div>
</div>