    <nav class="navbar navbar-default" style="margin-bottom: -1px;" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">SAMP-PRODUCTS</a>
        </div>
        <ul class="nav navbar-nav">
          <li <?php if($routes[0] == '') echo("class='active' style='border: 0;'"); ?>><a class="page-scroll" href="/"><i class="fa fa-cart-arrow-down"></i>Магазин логов</a></li>
          <li <?php if($routes[0] == 'faq') echo("class='active' style='border: 0;'"); ?>><a class="page-scroll" href="/faq"><i class="fa fa-question-circle"></i>FAQ</a></li>
          <li <?php if($routes[0] == 'rules') echo("class='active' style='border: 0;'"); ?>><a class="page-scroll" href="/rules"><i class="fa fa-ban"></i>Правила сайта</a></li>
          <li <?php if($routes[0] == '#') echo("class='active' style='border: 0;'"); ?>><a class="page-scroll" target="_blank" href="https://vk.com/samp_products"><i class="fa fa-money"></i>Группа ВКонтакте</a></li>
        </ul>
		<ul class="nav navbar-nav navbar-right">
		 <?php
                if(is_null($currentUser)) {
                    ?>
                        <li <?php if($routes[0] == 'auth') echo("class='active' style='border: 0;'"); ?>><a class="page-scroll" href="/auth"><i class="fa fa-gamepad"></i>Авторизироваться</a></li>
                    <?php
                    } else {
                    ?>
                        <li <?php if($routes[0] == 'account') echo("class='active' style='border: 0;'"); ?>><a class="page-scroll" href="/account"><i class="fa fa-briefcase"></i>Личный кабинет</a></li>
                    <?php
                    }
            ?>  
		</ul>
		
      </div>
    </nav>

</div>                