<?php 
  include_once($_SERVER['DOCUMENT_ROOT']."/main/config.php");
  include_once($_SERVER['DOCUMENT_ROOT']."/main/functions.php");
  getInformers();
  $currentUser = getUserInfo();
  $siteSettings = mysqli_get_query("SELECT * FROM `main`;");
  $offlineMode = $siteSettings['offlineMode'];
  if($_SESSION['unlock'] == 'unlock')
  	$offlineMode = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=TITLE_SITENAME?>  <?=TITLE_DESCRIPTION?></title>
	<meta name="description" content="Не знаете, где купить логи и окупиться? Мы предлагаем нашим покупателям исключительно качественные логи и аккаунты на всех крупных проектах, как Diamond Role Play, Advance Role Play, Arizona Role Play, Evolve Role Play, Grand Role Play, Samp Role Play, Luxe Role Play, Revent Role Play, Pears Project, Samp Virtual Life, Trinity Role Play! В нашем магазине имеется возможность приобретения смешанных логов, где вы находятся аккаунты совершенно разных проектов. После оплаты Вы сразу же получите свой товар, так как мы используем автоматическую систему выдачи. На сайте работает круглосуточная тех. поддержка, которая рада вам помочь!

Приятные цены, ежедневное пополнение товаром и частые скидки для наших клиентов. У каждого есть возможность получить хорошие аккаунты логов, а именно с деньгами, имуществом, занимающие лидерские посты, административные должности и высокие ранги в организациях! Мы являемся лидерами продаж данных продуктов, благодаря качеству наших товаров.">
    <meta name="keywords" content="Продажа логов, купить логи самп, самп логи, logsamp,samp products, samp-products, samp prod, logs samp, беплатные логи, купить логи аризона арп, купить логи адванс рп, m-samp, samplog, логи самп, логи samp, продажа логов самп, купить логи samp, samplog, samp log, g-prod, g prod, logi, logi samp, чекер логов, купить логи samp 0.3.7">

    <?php 
    	include_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php");
    	if($offlineMode == 0)
    		include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainHeader.php"); 
    ?>
</head>

<body class="gray-bg">
    <div id="vk_community_messages"></div> 
    <script type="text/javascript">
	    new Image().src = "//counter.yadro.ru/hit?r"+
	    escape(document.referrer)+((typeof(screen)=="undefined")?"":
	    ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
	    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
	    ";"+Math.random();
    </script>
     <?

     	if($offlineMode != 0) {
     		include_once("lockpage.php");
     		echo "</body></html>";
     		return;
     	}

     	include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainHeadBody.php");
        /** ROUTER */

        if($routes[0] == "category" && $routes[1] > 0) include_once($_SERVER['DOCUMENT_ROOT']."/templates/categoryBody.php");
        else if($routes[0] == "order" && $routes[1] > 0) include_once($_SERVER['DOCUMENT_ROOT']."/templates/orderCategoryBody.php");
        else if($routes[0] == "orderProduct" && $routes[1] > 0) include_once($_SERVER['DOCUMENT_ROOT']."/templates/orderProductBody.php");
        else if($routes[0] == "product" && $routes[1] > 0) include_once($_SERVER['DOCUMENT_ROOT']."/templates/productBody.php");

    		else if($routes[0] == "auth") include_once($_SERVER['DOCUMENT_ROOT']."/templates/auth.php");
    		else if($routes[0] == "account") include_once($_SERVER['DOCUMENT_ROOT']."/templates/account.php");

        else if($routes[0] == "faq") include_once($_SERVER['DOCUMENT_ROOT']."/templates/faq.php");
        else if($routes[0] == "rules") include_once($_SERVER['DOCUMENT_ROOT']."/templates/rules.php");

        else include_once($_SERVER['DOCUMENT_ROOT']."/templates/indexBody.php");
        /** ROUTER END */
        
        include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainFooterBody.php");
    ?>
</body>
</html>
