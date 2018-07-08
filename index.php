<?php 
  include_once($_SERVER['DOCUMENT_ROOT']."/main/config.php");
  include_once($_SERVER['DOCUMENT_ROOT']."/main/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CMS SAMP-PRODUCTS - ADMIN PANEL</title>


    <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainHeader.php"); ?>
</head>

<body class="">
    <div id="wrapper">
        <?php 
            if(checkAuth()) {
                include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainLeftMenu.php");
                echo '<div id="page-wrapper" class="gray-bg" style="min-height: 1359px;">';
                include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainHeaderBody.php");

                /** ROUTER */
                if($routes[0] == "logs" && $routes[1] == "category") {
                    if ($routes[2] == "new") include_once($_SERVER['DOCUMENT_ROOT']."/templates/categoryNewBody.php");
                    else if($routes[2] == "edit") include_once($_SERVER['DOCUMENT_ROOT']."/templates/categoryEditBody.php");
                    else if($routes[2] == "delete") include_once($_SERVER['DOCUMENT_ROOT']."/templates/categoryBody.php");
                    else include_once($_SERVER['DOCUMENT_ROOT']."/templates/categoryBody.php");
                } else if($routes[0] == "logs" && $routes[1] == "product") {
                    if($routes[2] == "add") include_once($_SERVER['DOCUMENT_ROOT']."/templates/productAddBody.php");
                    else if($routes[2] == "edit") include_once($_SERVER['DOCUMENT_ROOT']."/templates/productEditBody.php");
                    else if($routes[2] == "transfer") include_once($_SERVER['DOCUMENT_ROOT']."/templates/productTransferBody.php");
                    else if($routes[2] == "new") include_once($_SERVER['DOCUMENT_ROOT']."/templates/productNewBody.php");
                    else include_once($_SERVER['DOCUMENT_ROOT']."/templates/productBody.php");
                } else if($routes[0] == "logs" && $routes[1] == "orders") {
                    if($routes[2] == "edit") include_once($_SERVER['DOCUMENT_ROOT']."/templates/ordersEditBody.php");
                    else include_once($_SERVER['DOCUMENT_ROOT']."/templates/ordersBody.php");
                } else if($routes[0] == "logs" && $routes[1] == "reports") {
                    include_once($_SERVER['DOCUMENT_ROOT']."/templates/reportsBody.php");
                } else if($routes[0] == "users"){
                    include_once($_SERVER['DOCUMENT_ROOT']."/templates/usersBody.php");
				} else if($routes[0] == "pay"){
					include_once($_SERVER['DOCUMENT_ROOT']."/templates/payBody.php");
                } else if($routes[0] == "shares") {
                    if($routes[1] == "voucher") {
                        if($routes[2] == "add") include_once($_SERVER['DOCUMENT_ROOT']."/templates/voucherAddBody.php");
                        else include_once($_SERVER['DOCUMENT_ROOT']."/templates/voucherBody.php");
                    }
                    if($routes[1] == "promo") {
                        if($routes[2] == "add") include_once($_SERVER['DOCUMENT_ROOT']."/templates/promoAddBody.php");
                        else include_once($_SERVER['DOCUMENT_ROOT']."/templates/promoBody.php");
                    }
                } else if($routes[0] == "roulette"){
                    if($routes[1] == "settings") include_once($_SERVER['DOCUMENT_ROOT']."/templates/rouletteSettingsBody.php");
                    else if($routes[1] == "prizesType") 
                    {
                        if($routes[2] == "add") include_once($_SERVER['DOCUMENT_ROOT']."/templates/roulettePrizesTypeAddBody.php");
                        else if($routes[2] == "edit") include_once($_SERVER['DOCUMENT_ROOT']."/templates/roulettePrizesTypeEditBody.php");
                        else include_once($_SERVER['DOCUMENT_ROOT']."/templates/roulettePrizesTypeBody.php");
                    }
                    else if($routes[1] == "prizes") 
                    {
                        if($routes[2] == "add") include_once($_SERVER['DOCUMENT_ROOT']."/templates/roulettePrizesAddBody.php");
                        else if($routes[2] == "edit") include_once($_SERVER['DOCUMENT_ROOT']."/templates/roulettePrizesEditBody.php");
                        else include_once($_SERVER['DOCUMENT_ROOT']."/templates/roulettePrizesBody.php");
                    }
                    else include_once($_SERVER['DOCUMENT_ROOT']."/templates/rouletteSettingsBody.php");
                } else if($routes[0] == "news"){
                    if($routes[1] == "add") include_once($_SERVER['DOCUMENT_ROOT']."/templates/newsAddBody.php");
                    else if($routes[1] == "edit") include_once($_SERVER['DOCUMENT_ROOT']."/templates/newsEditBody.php");
                    else include_once($_SERVER['DOCUMENT_ROOT']."/templates/newsBody.php");
                } else if($routes[0] == "settings") {
                    if($routes[1] == "main") include_once($_SERVER['DOCUMENT_ROOT']."/templates/settingsBody.php");
                    if($routes[1] == "alerts") include_once($_SERVER['DOCUMENT_ROOT']."/templates/settingsAlertsBody.php");
                } else include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainPage.php");
                /** ROUTER END */

                include_once($_SERVER['DOCUMENT_ROOT']."/templates/mainFooterBody.php");
                echo '</div>';
            } else include_once($_SERVER['DOCUMENT_ROOT']."/templates/adminLogin.php");
        ?>
        
    </div>
</body>
</html>
