<?php 
  include_once($_SERVER['DOCUMENT_ROOT']."/main/config.php");
  include_once($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

  if($currentUser == null){
  	redirect('/auth');
  	return;
  }

?>

<div class="row" style="height: 100%;">

<div class="nav">
<ul class="menu-main">
 <li <?php if($routes[1] == '') echo("class=''"); ?>><a href="/account">Главная</a></li>
 <li <?php if($routes[1] == '') echo("class=''"); ?>><a href="/account/orders">Мои покупки</a></li>
 <li <?php if($routes[1] == '') echo("class=''"); ?>><a href="/account/dialogs">ID Диалогов</a></li>
 <li <?php if($routes[1] == '') echo("class=''"); ?>><a href="/account/sort">Сортировщик логов</a></li>
 <li <?php if($routes[1] == '') echo("class=''"); ?>><a href="/account/exit">Выход</a></li>
</ul>
</div>

<div class="col-md-1">
</div>

<!--<div class="col-md-2">
		<div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="visible-xs navbar-brand">Sidebar menu</span>
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
          <ul class="nav navbar-nav">
            <li </?php if($routes[1] == '') echo("class='active'"); ?>><a href="/account">Главная</a></li>
            <li </?php if($routes[1] == 'orders') echo("class='active'"); ?>><a href="/account/orders">Мои заказы</a></li>
            <li </?php if($routes[1] == 'dialogs') echo("class='active'"); ?>><a href="/account/dialogs">ID Диалогов</a></li>
            <li </?php if($routes[1] == 'sort') echo("class='active'"); ?>><a href="/account/sort">Сортировщик логов</a></li>
            <li </?php if($routes[1] == 'exit') echo("class='active'"); ?>><a href="/account/exit">Выход</a></li>
          </ul>
        </div>
      </div>	
	</div>
       
       -->

	<div class="col-md-10">

    <?php 


      if($routes[1] == '')
      	{ ?>
	        <div class="row">

	        	<div class="col-md-12">
	            	<div class="ibox">
	                	<div class="ibox-content">
			            	<div class="row">
			            		<div class="col-md-6">
				                	<div class="well" style="height: 70px;">
				                		<h4 class="text-danger">ID: <?=$currentUser['id']?> | <?=$currentUser['vkName']?></h4>
				                    </div>
				            	</div>
					            <div class="col-md-6">
					              <div class="well" style="height: 70px;">
					                <h4 class="text-success">
					                  <p class="btn-toolbar">
					                    <span class="btn-group pull-right">
					                      <button type="button" class="btn btn-success btn-sm" onclick="$('#payModal').modal('show');">Пополнить баланс</button>  
					                    </span>
					                    <span class="btn-group pull-right">
					                      <button type="button" class="btn btn-warning btn-sm" onclick="$('#voucherModal').modal('show');">Ввести купон</button>  
					                    </span>
					                    <span class="btn-group">Баланс: <?=$currentUser['balance']?> RUB.</span>
					                  </p>
					                </h4>
					              </div>
					            </div>
			            	</div>
				        </div>
				    </div>
				</div>

				<div class="row">
					<div id="toplist" class="col-md-6">
						<div class="ibox">
		                	<div class="ibox-content">
		                		<h1 class="text-center"><strong>ТОП</strong> Покупателей</h1>
								<center><h5><span class="label label-primary">Покупатели, находящиеся в топе - получают скидку в размере 10% на все товары!</span></h5></center>
	                			<hr>
	                			<hr>
		                		<ul>
		                			<? 
		                				$topRank = 10;
		                				$curentRank = 0;
		                				$list = mysqli_query($_MS_ID, "SELECT * FROM `users` ORDER BY `purchasesAmount` DESC LIMIT 10;");
		                				while ($row = mysqli_fetch_array($list)) {
		                					if($currentUser['id'] != $row['id']) 
		                					{
			                					?>
			                						<center><li><?=$row['vkName']?> - покупок на <?=$row['purchasesAmount']?> руб. </li></center>
			                					<?
		                					}else
		                					{
												?>
			                						<center><li><font color="blue"><?=$row['vkName']?></font> - покупок на <?=$row['purchasesAmount']?> руб.</li><center>
			                					<?
			                					$curentRank = $topRank;
		                					}
		                					$topRank = $topRank -1;
		                				}
		                			?>
								</ul>
								<hr>
		                		<hr>
								<h4 class="text-center">Вы сделали <span class="label label-primary"><?=$currentUser['purchasesCount']?></span> покупок на <span class="label label-primary"><?=$currentUser['purchasesAmount']?></span> руб.</h4>
								<?
									if($curentRank > 0){
										?>
											<h4 class="text-center"><span class="label label-success">За <?=(10-$curentRank+1)?> место в топе, Вы получаете скидку <?=$curentRank?>% на каждую покупку!</span></h4>
										<?
									} 
								?>
					        </div>
					    </div>
					</div>
					<!--разработка-->
					<div id="game" style="display: none;" class="col-md-6">
						<div class="ibox">
		                	<div class="ibox-content">
		                		<h1 class="text-center"><strong>Разработка</strong> </h1>
								
								
					        </div>
					    </div>
					</div>
					
<script>
function ToggleTOP(){
 	if($("#topbtn").text()=="Топ"){
	$('#toplist').css('display','block');
	$('#game').css('display','none');
	$('#topbtn').css('class','');
		$("#topbtn").text("Рулетка");
	} else {
	$('#game').css('display','block');
	$('#toplist').css('display','none');
	$('#topbtn').css;
		$("#topbtn").text("Топ");
	}
}

</script>
				<!--конец разработка-->	
				
				
					<div class="col-md-6">
		            	<div class="ibox">
		                	<div class="ibox-content" id='vkwall'>
		                		<h1 class="text-center">Новости</h1>
		                		<hr>
		                		<hr>
		                		<?php 
	                				$list = mysqli_query($_MS_ID, "SELECT * FROM `news` ORDER BY `id` DESC LIMIT 10;");
	                				while ($row = mysqli_fetch_array($list)) {
	                					?>
	                						<h3><strong class="label label-primary"><?=$row['date']?></strong></h3>
	                						<h4><?=$row['text']?></h4>
	                					<?
	                				}
		                		?>
					        </div>
					    </div>
					</div>
					
					<!-- <div class="col-md-6">
		            	<div class="ibox">
		                	<div class="ibox-content" id='vkwall'>
		                		<h1 class="text-center">Последние покупки:</h1>
		                		<hr>
		                		<hr>
								</?php 
	                				$list = mysqli_query($_MS_ID, "SELECT * FROM `users` ORDER BY `id` DESC LIMIT 10;");
	                				while ($row = mysqli_fetch_array($list)) {
	                					?>
			                			<li></?=$row['vkName']?> - приобрёл </?=$row['purchasesAmount']?> руб. </li>
			                			</?
	                				}
		                		?>
										
										
					        </div>
					    </div>
					</div>
					
				</div>
				-->

	        </div>
			</div>

	        <script type="text/javascript">
	        	function enterVoucher(){
	        		var captcha = grecaptcha.getResponse();
	        		var key = $('#voucherValue').val();
					if(captcha.length == 0){
						$("#voucherInfo").text('Ошибка, введите капчу.');
						return;
					}
					if(key.length == 0){
						$("#voucherInfo").text('Ошибка, введите купон.');
						return;
					}
					$.ajax({
					  method: "POST",
					  url: "/main/ajax/voucher.php",
					  data: { key: key, c: captcha },
					  dataType: 'text'
					}).done(function( respounce ) {
					    $("#voucherInfo").text(respounce);
					});
	        	}
	        </script>

			<div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-md">
			      <div class="modal-content">
			          <div class="modal-header">
			              <button type="button" class="close" 
			                 data-dismiss="modal">
			                     <span aria-hidden="true">&times;</span>
			                     <span class="sr-only">Close</span>
			              </button>
			              <h4 class="modal-title text-center">Ввод купона</h4>
			          </div>
			          <div class="modal-body">
			              <center>                
			                <form class="form-inline" onsubmit="enterVoucher(); return false;" action="">
			                  <div class="form-group">
			                    <label for="voucherValue">Купон:</label>
			                    <input type="input" class="form-control" id="voucherValue" placeholder="Купон"/>
			                  </div>
			                  <button class="btn btn-warning">Ввести</button>
			                </form>
			                <div class="g-recaptcha" data-sitekey="6Ld3nUQUAAAAAFs7ZABHJll0UyJbzDARV66WbY1-"></div>
			                <span id='voucherInfo'></span>
			              </center>
			          </div>
			          <div class="modal-footer"></div>
			    </div>
			  </div>
			</div>

			<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-md">
			      <div class="modal-content">
			          <div class="modal-header">
			              <button type="button" class="close" 
			                 data-dismiss="modal">
			                     <span aria-hidden="true">&times;</span>
			                     <span class="sr-only">Close</span>
			              </button>
			              <h4 class="modal-title text-center">Пополнение баланса</h4>
			          </div>
			          <div class="modal-body">
			              <center>                
			                <div class="row">
			                	<form action="http://samp-products.ru/main/freekassa/index.php" class="form-inline">
								<input name="action" value="fk_go" class="main_input" type="hidden">
								<input type="hidden" name="account" value="<?=$currentUser['id']?>">
								<div class="form-group">
			                    	<label for="voucherValue">Сумма:</label>
			                    	<input type="input" class="form-control" name='sum' id='balanceSum' placeholder="Введите сумму"/>
			                  	</div>
								<input type="hidden" name="desc" value="Пополнение баланса на сайте samp-products.ru (ID: <?=$currentUser['id']?>)">
								<button type='submit' class="btn btn-success">Продолжить оплату</button>
							</form>
			                </div>
							<div class="row" style="margin-top: 5px;">
								<button class="btn btn-default btn-xs" onclick="$('#balanceSum').val($(this).text());">10</button>
								<button class="btn btn-info btn-xs" onclick="$('#balanceSum').val($(this).text());">25</button>
								<button class="btn btn-primary btn-xs" onclick="$('#balanceSum').val($(this).text());">50</button>
								<button class="btn btn-success btn-xs" onclick="$('#balanceSum').val($(this).text());">100</button>
								<button class="btn btn-warning btn-xs" onclick="$('#balanceSum').val($(this).text());">200</button>
								<button class="btn btn-danger btn-xs" onclick="$('#balanceSum').val($(this).text());">250</button>
							</div>
							<span><a href="/rules"><i class="fa fa-check"></i> Я согласен с правилами сайта.</a></span>
			              </center>
			          </div>
			          <div class="modal-footer"></div>
			    </div>
			  </div>
			</div>
	      
        <?}

      if($routes[1] == 'orders')
      	{ ?>
      		<div class="row">
      			<div class="col-md-12">
            		<div class="ibox">
                		<div class="ibox-content">
			      			<table id='orderTable' class="footable table table-bordered" data-paging-limit="1" data-paging="true">
			      				<thead>
			      					<tr>
			      						<td class="col-md-1">ID</td>
			      						<td class="col-md-4 text-center">Название</td>
			      						<td class="col-md-1 text-center">Количество</td>
			      						<td class="col-md-2 text-center">Цена</td>
			      						<td class="col-md-1 text-center">Статус</td>
			      						<td class="col-md-3 text-center">Действие</td>
			      					</tr>
			      				</thead>
			      				<tbody>
			      					<?
			      						$categoryList = "SELECT `id`, `name` FROM `category`;";
		                                $categoryList = mysqli_query($_MS_ID, $categoryList);
		                                $cats = [];
		                                while($category = mysqli_fetch_array($categoryList)) {
		                                    $cats[$category['id']] = $category['name'];
		                                }
		                                $orders = mysqli_query($_MS_ID, "SELECT * FROM `orders` WHERE `userId` = '{$currentUser['id']}' ORDER BY `id` DESC;");
			      						while ($order = mysqli_fetch_array($orders)) {
			      						 	?>
			      						 		<tr>
			      						 			<td><?=$order['id']?></td>
			      						 			<td class="text-center"><?=$cats[$order['category']]?></td>
			      						 			<td class="text-center"><?=$order['count']?></td>
			      						 			<td class="text-center"><?=$order['price']?> руб.</td>
			      						 			<td class="text-center"><?=$order['status'] ? "<label class='label label-success'>Доставленно</label>" : "<label class='label label-warning'>В ожидании получения</label>"?></td>
			      						 			<td>
			      						 				<a class="btn btn-xs btn-info" target="_blank" href="/order/<?=$order['id']?>">Открыть</a>
			      						 				<a class="btn btn-xs btn-warning" target="_blank" href="/main/ajax/downloadOrder.php?order=<?=$order['id']?>">Скачать</a>
			      						 				<a class="btn btn-xs btn-danger" onclick="openReportModal(<?=$order['id']?>)">Жалоба</a>
			      						 			</td>
			      						 		</tr>
			      						 	<?
			      						 } 
			      					?>
			      				</tbody>
			      			</table>
			      		</div>
			      	</div>
			    </div>
      		</div>
      		<script type="text/javascript">$('#orderTable').footable();</script>

			<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-md">
			      <div class="modal-content">
			          <div class="modal-header">
			              <button type="button" class="close" 
			                 data-dismiss="modal">
			                     <span aria-hidden="true">&times;</span>
			                     <span class="sr-only">Close</span>
			              </button>
			              <h4 class="modal-title text-center">Жалоба на заказ</h4>
			          </div>
			          <div class="modal-body">
			              <center>                
			                <div class="row">
			                	<input type="hidden" id='orderReportIdValue' value="0">
								<div class="form-group">
			                    	<label>Причина жалобы:</label>
			                    	<select class="form-control" id='orderReportTypeValue'>
									  <option selected>Флуд в логах (40%+)</option>
									  <option>Логам более 2-ух дней</option>
									  <option>Некачественный товар</option>
									</select>
			                  	</div>	
								<button class="btn btn-danger" onclick="sendReportToOrder();">Отправить жалобу</button>
			                </div>
			              </center>
			          </div>
			          <div class="modal-footer"></div>
			    </div>
			  </div>
			</div>

      		<script type="text/javascript">
      			function sendReportToOrder(){
      				$.ajax({
		            	method: "POST",
		            	url: "/main/ajax/orderReport.php",
		            	dataType: 'json',
		            	data: { id: $('#orderReportIdValue').val(), type: $('#orderReportTypeValue').prop('selectedIndex') }
		            	}).done(function( respounce ) {
		              		$.notify({
								message: respounce.message
							},{
								type: respounce.type
							});
							$('#reportModal').modal('hide');
		            });
      			}

      			function openReportModal(id){
      				$('#reportModal').modal('show');
      				$('#orderReportIdValue').val(id);
      			}

      		</script>
      	<?}

      if($routes[1] == 'sort')
      	{ ?>
	      	<div class="row">
	      		<div class="col-md-12">
	            	<div class="ibox">
	                	<div class="ibox-content">
						<p><font class="text-danger">Сортировщик</font> - своеобразный бесплатный чекер логов. Данный софт поможет вам найти в ваших логах пароли , пинкоды, коды и прочее , что нужно чтобы зайти на аккаунт. <br>Для обычных пользователей есть ограничение в 2000 строк , а купив премиум подписку вы получаете возможность отсортировать неограниченное количество строк. Работает он для всех популярных проектов.</p>
						<hr />
					        <div class="row">
					          <div class="form-group">
					            <label for="loglist">Ваши логи:</label>
					            <textarea class="form-control" rows="25" id="loglist" style="resize: none; height: 350px;"></textarea>
					          </div>
					        </div>
					        <div class="row">
					          <div class="btn-toolbar">
					            <button class="btn btn-success" onclick="sendLogiData();">Отправить на сортировку</button>
					            <button class="btn btn-info" onclick="$('#sortModal').modal('show');" <? if($currentUser['vipSorting'] == 1) echo "disabled" ?>>Убрать ограничение</button>
					          </div>
					          <div class="g-recaptcha" data-sitekey="6LejwUQUAAAAAIcvvDb68DK66qQG4n2i299cbTcE" data-callback="onSubmitReCaptcha" data-size="invisible"></div>
					        </div>
					    </div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog modal-md">
			      <div class="modal-content">
			          <div class="modal-header">
			              <button type="button" class="close" 
			                 data-dismiss="modal">
			                     <span aria-hidden="true">&times;</span>
			                     <span class="sr-only">Close</span>
			              </button>
			              <h4 class="modal-title text-center">Premium подписка</h4>
			          </div>
			          <div class="modal-body">
			              <center>
			              	<p>Хотите убрать ограничение в сортировщике за 50 ₽?</p>                
			                <button class="btn btn-warning btn-block" onclick="sortByVip();">Да</button>
			                <span id='sortVipInfo'></span>
			              </center>
			          </div>
			          <div class="modal-footer"></div>
			    </div>
			  </div>
			</div>

	        <script type="text/javascript">        	

	        	var mType = 0;

	        	function onSubmitReCaptcha(token) {
	        		if(mType == 0){
					  	$.ajax({
			            	method: "POST",
			            	url: "/main/ajax/sort.php",
			            	dataType: 'text',
			            	data: { data: $('#loglist').val(), c: token }
			            	}).done(function( respounce ) {
			              	$('#loglist').val(respounce)
			            });
			            }else{
			            	$.ajax({
				            	method: "POST",
				            	url: "/main/ajax/sort.php",
				            	dataType: 'text',
				            	data: { method: 'buy', c: token }
				            	}).done(function( respounce ) {
				              	$('#sortVipInfo').text(respounce)
				            });
			            }
				}

	          	function sendLogiData(){
	          		mType = 0;
		            grecaptcha.execute();
		        }

	          	function sortByVip(){
	          		mType = 1;
	            	grecaptcha.execute();
	          	}
	        </script>
			
			<?}

      if($routes[1] == 'dialogs')
      	{ ?>
	
	
 
<div class="ibox">
<div class="ibox-content">
<div class="row">


<div class="col-md-6">

					<center>	
					<div class="oneitem">
							<br />
							<b class="h4">Samp Role Play:</b>
							<br /><br />
							id: 1 – пароль от аккаунта<br />id: 2 – пароль от аккаунта при регистрации<br />id: 21 – email при регистрации<br />id: 24 – репорт<br />id: 90 – IP ключ от аккаунта ( жертва вводит если у нее меняется IP адрес)<br />id: 151 – объявления (News)<br />id: 153 – пароль администратора (/alogin)<br />id: 208 – вопрос саппортам сервера;
						</div>
						<div class="oneitem">
							<br />
							<b class="h4">Advance Role Play:</b>
							<br /><br />
							id: 1 – пароль от аккаунта<br />id: 2 – пароль от аккаунта при регистрации<br />id: 3 – email при регистрации<br />id: 9 – диалог дома; Табличка при поднятии пикапа у дома<br />id: 80 – репорт<br />id: 86 – ввод номера телефона при входе<br />id: 88 – ключ безопасности IP<br />id: 100 – диалог бизнеса; Табличка входа в здание бизнеса<br />id: 224 - редактирование объявления (/edit)<br />id: 71 - реферал;<br />PIN - графический пинкод;
						</div>
						<div class="oneitem">
							<br />
							<b class="h4">Diamond Role Play:</b>
							<br /><br />
							id: 1 – пароль от аккаунта<br />id: 5 – дополнительный пароль от аккаунта<br />id: 3 – ключ IP безопасности (аналогично как на SAMP-RP)<br />id: 7 – email, который указывается при регистрации<br />id: 17 – пароль, который вводится при регистрации<br />id: 15 – ник того, кто пригласил; Вводится при регистрации<br />id: 192 – связь с администрацией (репорт);<br />id: 316 - смена никнейма;<br />id: 2 - код с телефона;
						</div>
					</div>
					<div class="col-md-6">
						<div class="oneitem">
							<br />
							<b class="h4">Arizona Role Play:</b>
							<br /><br />
							id: 1 – пароль от аккаунта при регистрации;<br />id: 2 - пароль от аккаунта<br />id: 991 - пин-код от банка<br />PIN - секретный код (если активирована проверка)<br />id: 211 - пароль от админ-панели<br />160 – email при регистрации<br />32 - репорт
						</div>
						<div class="oneitem">
							<br />
							<b class="h4">Grand Role Play:</b>
							<br /><br />
							id: 2 - пароль от аккаунта<br />id: 1 - пароль при регистрации<br />id: 3 - почта при регистрации<br />id: 10 - реферал;<br />PIN - секретный код (если активирована проверка)
						</div>
						<div class="oneitem">
							<br />
							<b class="h4">Samp Virtual Life:</b>
							<br /><br />
							id: 1 - пароль от аккаунта<br />[PIN] - экранный пин-код;
						</div>
						<div class="oneitem">
							<br />
							<b class="h4">Adrenaline Role Play:</b>
							<br /><br />
							id: 2 - пароль от аккаунта<br />id: 2325 - пароль проверки ip адреса (если активирована проверка)<br />id: 8374 - пароль от админ-панели;
						</div>
						<div class="oneitem">
							<br />
							<b class="h4">Как найти админку в логах?:</b>
							<br /><br />
							id: 2934 - пароль от админ-панели<br />id: 1221 - пароль от админ-панели<br />id: 153 - пароль от админ-панели<br />id: 1227 - пароль от админ-панели;
						</div>
					</div>
				</div>
			</div>
			</center>
</div>

	
			
	  <?}

      if($routes[1] == 'supergame')
      	{ ?>
	      	<div class="row">
	      		<div class="col-md-12">
	            	<div class="ibox">
	                	<div class="ibox-content">
					        <h1>Супер-Игра</h1>
							
							<p><input type="text" id="sum" placeholder="Укажите сумму, не менее 5 рублей"></p>
							
							
							
							<input type="hidden" id="sunduk1" value="1">
                            <input type="hidden" id="sunduk2" value="2">
                            <input type="hidden" id="sunduk3" value="3">
                            <input type="hidden" id="sunduk4" value="4">
                            <input type="hidden" id="sunduk5" value="5">
                            <input type="hidden" id="sunduk6" value="6">
                            <input type="hidden" id="sunduk7" value="7">
                            <input type="hidden" id="sunduk8" value="8">
							
							<p>
                            <img onclick="send_post('account', 'lol', 'sum.sunduk1')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                            <img onclick="send_post('account', 'lol', 'sum.sunduk2')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                            <img onclick="send_post('account', 'lol', 'sum.sunduk3')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                            <img onclick="send_post('account', 'lol', 'sum.sunduk4')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                            </p>


                             <p>
                            <img onclick="send_post('account', 'lol', 'sum.sunduk5')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                             <img onclick="send_post('account', 'lol', 'sum.sunduk6')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                             <img onclick="send_post('account', 'lol', 'sum.sunduk7')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                             <img onclick="send_post('account', 'lol', 'sum.sunduk8')" src="/design/img/sunduk.png" alt="Угадай" width="175" heig="160">
                             </p>




                              <div class="form">
	                         <h1>Правила игры</h1>
	                         <p>1. Укажи сумму</p>
	                         <p>2. Выбери сундук</p>
	                         <p>3. Сорви куш, и насыть админа, либо оставь админа без штанов</p>
                             </div>
							
						</div>
					</div>
				</div>
			</div>

        <?}


      if($routes[1] == 'exit'){ 
        unset($_SESSION['uId']);
        redirect('/');
      }

    ?>
	
	</div>
</div>