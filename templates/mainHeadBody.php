<div id="header" class="row border-bottom">



   <!-- <nav id="container" class="navbar navbar-static-top" role="navigation">
    <div id="left_text" class="navbar-header pull-left">
        <strong><// ?=TITLE_DESCRIPTION?> <// ?php if(isset($_INFORMERS['titleInfo'])) echo " | <span style='color:red'>".$_INFORMERS['titleInfo']."</span>"; ?>
    </div>

     <div  id="right_text" class="navbar-header pull-right hidden-xs">
        Последнее пополнение — <?//=$_INFORMERS['lastAdded']?> МСК
    </div> 
    </nav> -->
</div>


<div id="all_body" class="wrapper wrapper-content">
	<? if($routes[0] != "account") { ?>
	    <div class="row animated fadeInDown">
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="ibox">
					<div class="ibox-content text-center">
					<i class="fa fa-shopping-basket fa-4x" aria-hidden="true"></i> <br>
						<b id="stats" class="informers_1"><?=$_INFORMERS['sellProducts']?></b><br/>
						Проданных товаров					
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="ibox">
					<div class="ibox-content text-center">
					<i class="fa fa-check-circle fa-spin fa-4x fa-fw" aria-hidden="true"></i><br>
						<b id="stats" class="informers_2"><?=$_INFORMERS['countBuyers']?></b><br/>
						Довольных покупателей				
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="ibox">
					<div class="ibox-content text-center">
					<i class="fa fa-user-circle-o fa-4x" aria-hidden="true"></i><br>
						<b id="stats"><?=mysqli_get_query("SELECT COUNT(*) FROM `users`")['COUNT(*)'] + 420?></b><br/>
						Пользователей на сайте	
					</div>
				</div>
			</div>
	    </div>
    <?
    }
    ?>