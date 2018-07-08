<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header text-center">
                <div class="dropdown profile-element">
                    <span style="color: white;">SAMP-PRODUCTS</span>
                </div>
            </li>
            <div class="logo-element">
                S-P
            </div>
            <li <?php if($routes[0] == "") echo "class='active'"; ?>>
                <a href="/"><i class="fa fa-area-chart"></i> <span class="nav-label">Главная</span></a>
            </li>
            <li <?php if($routes[0] == "users") echo "class='active'"; ?>>
                <a href="/users"><i class="fa fa-male"></i> <span class="nav-label">Пользователи</span></a>
            </li>
			  <li <?php if($routes[0] == "pay") echo "class='active'"; ?>>
                <a href="/pay"><i class="fa fa-male"></i> <span class="nav-label">Логи платежей</span></a>
            </li>
			
			
            <li <?php if($routes[0] == "logs") echo "class='active'"; ?>>
                <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Магазин логов</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li <?php if($routes[1] == "category") echo "class='active'"; ?>>
                        <a href="/logs/category"><span class="nav-label">Категории</span></a>
                    </li>
                    <li <?php if($routes[1] == "product") echo "class='active'"; ?>>
                        <a href="/logs/product"><span class="nav-label">Товар</span></a>
                    </li>
                    <li <?php if($routes[1] == "orders") echo "class='active'"; ?>>
                        <a href="/logs/orders"><span class="nav-label">Заказы</span></a>
                    </li>
                    <li <?php if($routes[1] == "reports") echo "class='active'"; ?>>
                        <a href="/logs/reports"><span class="nav-label">Жалобы</span></a>
                    </li>
                </ul>
            </li>
			
			
			
            <li <?php if($routes[0] == "shares") echo "class='active'"; ?>>
                <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Акции</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li <?php if($routes[1] == "promo") echo "class='active'"; ?>>
                        <a href="/shares/voucher"><span class="nav-label">Купоны</span></a>
                        <a href="/shares/promo"><span class="nav-label">Промокоды</span></a>
                    </li>
                </ul>	
            </li>
			
			
			
			
            <li <?php if($routes[0] == "news") echo "class='active'"; ?>>
                <a href="/news"><i class="fa fa-file-audio-o"></i> <span class="nav-label">Новости сайта</span></a>
            </li>
			
			
			
            <li <?php if($routes[0] == "settings") echo "class='active'"; ?>>
                <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">Настройки сайта</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li <?php if($routes[1] == "main") echo "class='active'"; ?>>
                        <a href="/settings/main"><span class="nav-label">Основные</span></a>
                    </li>
                    <li <?php if($routes[1] == "alerts") echo "class='active'"; ?>>
                        <a href="/settings/alerts"><span class="nav-label">Оповещения</span></a>
                    </li>
                </ul>
            </li>
			
			
        </ul>

    </div>
</nav>